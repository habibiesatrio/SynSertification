<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi | DEM Indonesia Sertification</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'dem-login-body' ); ?>>

    <a href="<?php echo home_url( '/sertifikasi-login/' ); ?>" class="dem-back-to-home">
        <i data-lucide="arrow-left" style="margin-right: 8px; width: 18px;"></i> Kembali ke Login
    </a>

    <div class="dem-login-container">
        <div class="dem-login-card">
            <div class="dem-login-header">
                <img src="<?php echo DEM_SERTIFICATION_URL; ?>assets/images/logo.png" alt="DEM Indonesia Logo"
                    class="dem-logo">
                <h1>Registrasi Akun</h1>
                <p>Portal Sertifikasi DEM Indonesia</p>
            </div>

            <?php 
        if ( isset( $_GET['reg_error'] ) ) {
            $error_msg = 'Terjadi kesalahan saat registrasi.';
            if ( $_GET['reg_error'] == 'empty' ) $error_msg = 'Semua field harus diisi.';
            if ( $_GET['reg_error'] == 'email_exists' ) $error_msg = 'Email sudah terdaftar.';
            if ( $_GET['reg_error'] == 'user_exists' ) $error_msg = 'Username sudah digunakan.';
            echo '<div class="dem-alert dem-alert-danger">' . esc_html( $error_msg ) . '</div>';
        }
        ?>

            <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="dem-login-form">
                <input type="hidden" name="action" value="dem_register">
                <?php wp_nonce_field( 'dem_register_action', 'dem_register_nonce' ); ?>

                <div class="dem-form-group">
                    <label for="reg_full_name">Nama Lengkap</label>
                    <input type="text" name="full_name" id="reg_full_name" class="dem-input"
                        placeholder="Nama sesuai KTP/Sertifikat" required>
                </div>

                <div class="dem-form-group">
                    <label for="reg_user_login">Username</label>
                    <input type="text" name="user_login" id="reg_user_login" class="dem-input"
                        placeholder="Pilih username" required>
                </div>

                <div class="dem-form-group">
                    <label for="reg_user_email">Email</label>
                    <input type="email" name="user_email" id="reg_user_email" class="dem-input"
                        placeholder="nama@email.com" required>
                </div>

                <div class="dem-form-group">
                    <label for="reg_user_pass">Password</label>
                    <input type="password" name="user_pass" id="reg_user_pass" class="dem-input"
                        placeholder="Minimal 8 karakter" required>
                </div>

                <button type="submit" class="dem-btn-login">DAFTAR SEKARANG</button>
            </form>

            <div class="dem-login-footer">
                <p>Sudah punya akun? <a href="<?php echo home_url( '/sertifikasi-login/' ); ?>"
                        style="color: var(--primary-color); font-weight: bold;">Login di sini</a></p>
                <p style="margin-top: 20px;">&copy; <?php echo date( 'Y' ); ?> DEM Indonesia. All rights reserved.</p>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>