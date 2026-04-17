<?php
/**
 * Plugin Name: DEM Indonesia Sertification
 * Plugin URI: https://demindonesia.or.id
 * Description: Sistem sertifikasi khusus untuk DEM Indonesia.
 * Version: 1.0.0
 * Author: Trae AI
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'DEM_SERTIFICATION_PATH', plugin_dir_path( __FILE__ ) );
define( 'DEM_SERTIFICATION_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register Custom Pages
 */
function dem_sertification_register_pages() {
    add_rewrite_rule( '^sertifikasi/?$', 'index.php?dem_sertification_landing=1', 'top' );
    add_rewrite_rule( '^sertifikasi-login/?$', 'index.php?dem_sertification_login=1', 'top' );
    add_rewrite_rule( '^sertifikasi-register/?$', 'index.php?dem_sertification_register=1', 'top' );
    add_rewrite_rule( '^sertifikasi-dashboard/?$', 'index.php?dem_sertification_dashboard=1', 'top' );
}
add_action( 'init', 'dem_sertification_register_pages' );

function dem_sertification_query_vars( $vars ) {
    $vars[] = 'dem_sertification_landing';
    $vars[] = 'dem_sertification_login';
    $vars[] = 'dem_sertification_register';
    $vars[] = 'dem_sertification_dashboard';
    return $vars;
}
add_filter( 'query_vars', 'dem_sertification_query_vars' );

function dem_sertification_template_redirect() {
    if ( get_query_var( 'dem_sertification_landing' ) ) {
        include DEM_SERTIFICATION_PATH . 'templates/landing.php';
        exit;
    }

    if ( get_query_var( 'dem_sertification_login' ) ) {
        include DEM_SERTIFICATION_PATH . 'templates/login.php';
        exit;
    }

    if ( get_query_var( 'dem_sertification_register' ) ) {
        include DEM_SERTIFICATION_PATH . 'templates/register.php';
        exit;
    }

    if ( is_singular( 'certificate' ) ) {
        include DEM_SERTIFICATION_PATH . 'templates/certificate-detail.php';
        exit;
    }

    if ( get_query_var( 'dem_sertification_dashboard' ) ) {
        if ( ! is_user_logged_in() ) {
            wp_redirect( home_url( '/sertifikasi-login/' ) );
            exit;
        }
        include DEM_SERTIFICATION_PATH . 'templates/dashboard.php';
        exit;
    }
}
add_action( 'template_redirect', 'dem_sertification_template_redirect' );

/**
 * Enqueue Styles
 */
function dem_sertification_enqueue_scripts() {
    if ( get_query_var( 'dem_sertification_landing' ) ) {
        wp_enqueue_style( 'dem-sertification-landing', DEM_SERTIFICATION_URL . 'assets/css/landing.css', array(), '1.0.0' );
    }
    if ( get_query_var( 'dem_sertification_login' ) ) {
        wp_enqueue_style( 'dem-sertification-login', DEM_SERTIFICATION_URL . 'assets/css/login.css', array(), '1.0.0' );
    }
    if ( get_query_var( 'dem_sertification_register' ) ) {
        wp_enqueue_style( 'dem-sertification-register', DEM_SERTIFICATION_URL . 'assets/css/login.css', array(), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'dem_sertification_enqueue_scripts' );

/**
 * Handle Login Form Submission
 */
function dem_sertification_handle_login() {
    if ( isset( $_POST['dem_login_nonce'] ) && wp_verify_nonce( $_POST['dem_login_nonce'], 'dem_login_action' ) ) {
        $creds = array(
            'user_login'    => $_POST['log'],
            'user_password' => $_POST['pwd'],
            'remember'      => isset( $_POST['rememberme'] ) ? true : false,
        );

        $user = wp_signon( $creds, false );

        if ( is_wp_error( $user ) ) {
            wp_redirect( home_url( '/sertifikasi-login/?login=failed' ) );
            exit;
        } else {
            wp_redirect( home_url( '/sertifikasi-dashboard/' ) ); // Will create this later
            exit;
        }
    }
}
add_action( 'admin_post_nopriv_dem_login', 'dem_sertification_handle_login' );
add_action( 'admin_post_dem_login', 'dem_sertification_handle_login' );

/**
 * Handle Registration Form Submission
 */
function dem_sertification_handle_registration() {
    if ( isset( $_POST['dem_register_nonce'] ) && wp_verify_nonce( $_POST['dem_register_nonce'], 'dem_register_action' ) ) {
        $user_login = sanitize_user( $_POST['user_login'] );
        $user_email = sanitize_email( $_POST['user_email'] );
        $user_pass  = $_POST['user_pass'];
        $full_name  = sanitize_text_field( $_POST['full_name'] );

        if ( empty( $user_login ) || empty( $user_email ) || empty( $user_pass ) ) {
            wp_redirect( home_url( '/sertifikasi-register/?reg_error=empty' ) );
            exit;
        }

        if ( username_exists( $user_login ) ) {
            wp_redirect( home_url( '/sertifikasi-register/?reg_error=user_exists' ) );
            exit;
        }

        if ( email_exists( $user_email ) ) {
            wp_redirect( home_url( '/sertifikasi-register/?reg_error=email_exists' ) );
            exit;
        }

        $user_id = wp_create_user( $user_login, $user_pass, $user_email );

        if ( ! is_wp_error( $user_id ) ) {
            // Update display name with full name
            wp_update_user( array(
                'ID'           => $user_id,
                'display_name' => $full_name,
                'first_name'   => $full_name
            ) );

            // Auto login after registration
            wp_set_current_user( $user_id );
            wp_set_auth_cookie( $user_id );
            
            wp_redirect( home_url( '/sertifikasi-dashboard/?reg=success' ) );
            exit;
        } else {
            wp_redirect( home_url( '/sertifikasi-register/?reg_error=failed' ) );
            exit;
        }
    }
}
/**
 * Register Certificate Custom Post Type
 */
function dem_sertification_register_cpt() {
    $labels = array(
        'name'               => 'Certificates',
        'singular_name'      => 'Certificate',
        'menu_name'          => 'Sertifikasi',
        'add_new'            => 'Tambah Baru',
        'add_new_item'       => 'Tambah Sertifikat Baru',
        'edit_item'          => 'Edit Sertifikat',
        'new_item'           => 'Sertifikat Baru',
        'view_item'          => 'Lihat Sertifikat',
        'search_items'       => 'Cari Sertifikat',
        'not_found'          => 'Sertifikat tidak ditemukan',
        'not_found_in_trash' => 'Tidak ada sertifikat di tempat sampah',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'certificate' ),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'           => 'dashicons-awards',
    );

    register_post_type( 'certificate', $args );
}
add_action( 'init', 'dem_sertification_register_cpt' );

/**
 * Add Meta Boxes for Certificate Data
 */
function dem_sertification_add_meta_boxes() {
    add_meta_box(
        'dem_certificate_details',
        'Detail Sertifikat',
        'dem_sertification_render_meta_box',
        'certificate',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'dem_sertification_add_meta_boxes' );

function dem_sertification_render_meta_box( $post ) {
    $cert_number = get_post_meta( $post->ID, '_cert_number', true );
    $cert_date   = get_post_meta( $post->ID, '_cert_date', true );
    $cert_expiry = get_post_meta( $post->ID, '_cert_expiry', true );
    $user_id     = get_post_meta( $post->ID, '_cert_user_id', true );
    $cert_file   = get_post_meta( $post->ID, '_cert_file_url', true );

    wp_nonce_field( 'dem_cert_meta_box_nonce', 'dem_cert_meta_box_nonce_field' );
    ?>
    <p>
        <label for="cert_number">Nomor Sertifikat:</label><br>
        <input type="text" name="cert_number" id="cert_number" value="<?php echo esc_attr( $cert_number ); ?>" style="width:100%;">
    </p>
    <p>
        <label for="cert_date">Tanggal Terbit:</label><br>
        <input type="date" name="cert_date" id="cert_date" value="<?php echo esc_attr( $cert_date ); ?>" style="width:100%;">
    </p>
    <p>
        <label for="cert_expiry">Tanggal Kadaluarsa:</label><br>
        <input type="date" name="cert_expiry" id="cert_expiry" value="<?php echo esc_attr( $cert_expiry ); ?>" style="width:100%;">
    </p>
    <p>
        <label for="cert_user_id">Assign ke User ID:</label><br>
        <input type="number" name="cert_user_id" id="cert_user_id" value="<?php echo esc_attr( $user_id ); ?>" style="width:100%;">
        <small>ID User WordPress yang memiliki sertifikat ini.</small>
    </p>
    <p>
        <label for="cert_file_url">URL File Sertifikat (PDF):</label><br>
        <input type="text" name="cert_file_url" id="cert_file_url" value="<?php echo esc_url( $cert_file ); ?>" style="width:100%;">
        <small>Masukkan URL file PDF sertifikat yang sudah diunggah ke Media Library.</small>
    </p>
    <?php
}

function dem_sertification_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['dem_cert_meta_box_nonce_field'] ) || ! wp_verify_nonce( $_POST['dem_cert_meta_box_nonce_field'], 'dem_cert_meta_box_nonce' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['cert_number'] ) ) {
        update_post_meta( $post_id, '_cert_number', sanitize_text_field( $_POST['cert_number'] ) );
    }
    if ( isset( $_POST['cert_date'] ) ) {
        update_post_meta( $post_id, '_cert_date', sanitize_text_field( $_POST['cert_date'] ) );
    }
    if ( isset( $_POST['cert_expiry'] ) ) {
        update_post_meta( $post_id, '_cert_expiry', sanitize_text_field( $_POST['cert_expiry'] ) );
    }
    if ( isset( $_POST['cert_user_id'] ) ) {
        update_post_meta( $post_id, '_cert_user_id', sanitize_text_field( $_POST['cert_user_id'] ) );
    }
    if ( isset( $_POST['cert_file_url'] ) ) {
        update_post_meta( $post_id, '_cert_file_url', esc_url_raw( $_POST['cert_file_url'] ) );
    }
}
add_action( 'save_post', 'dem_sertification_save_meta_box_data' );