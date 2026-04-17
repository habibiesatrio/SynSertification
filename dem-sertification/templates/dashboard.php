<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$current_user = wp_get_current_user();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | DEM Indonesia Sertification</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php wp_head(); ?>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .dashboard-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        h1 { color: #0056b3; }
        .logout-link { color: #dc3545; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body class="dem-login-body">
    <a href="<?php echo home_url( '/sertifikasi/' ); ?>" class="dem-back-to-home">
        <i data-lucide="arrow-left" style="margin-right: 8px; width: 18px;"></i> Kembali ke Beranda
    </a>
    <div class="dashboard-card">
        <h1>Selamat Datang, <?php echo esc_html( $current_user->display_name ); ?>!</h1>
        <p>Anda telah berhasil masuk ke Portal Sertifikasi DEM Indonesia.</p>
        
        <h2 style="margin-top: 40px; color: #333;">Sertifikat Anda</h2>
        <div class="certificate-list">
            <?php 
            $args = array(
                'post_type'  => 'certificate',
                'meta_query' => array(
                    array(
                        'key'     => '_cert_user_id',
                        'value'   => $current_user->ID,
                        'compare' => '='
                    )
                )
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) : ?>
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                            <th style="padding: 12px; text-align: left;">Sertifikat</th>
                            <th style="padding: 12px; text-align: left;">Nomor</th>
                            <th style="padding: 12px; text-align: left;">Berlaku Hingga</th>
                            <th style="padding: 12px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ( $query->have_posts() ) : $query->the_post(); 
                            $number = get_post_meta( get_the_ID(), '_cert_number', true );
                            $expiry = get_post_meta( get_the_ID(), '_cert_expiry', true );
                        ?>
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <td style="padding: 12px;"><?php the_title(); ?></td>
                            <td style="padding: 12px;"><?php echo esc_html( $number ); ?></td>
                            <td style="padding: 12px;"><?php echo esc_html( $expiry ); ?></td>
                            <td style="padding: 12px; text-align: center;">
                                <a href="<?php the_permalink(); ?>" class="dem-btn dem-btn-primary" style="padding: 5px 10px; font-size: 12px;">Lihat Detail</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div style="padding: 20px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 6px; margin-top: 20px;">
                    Belum ada sertifikat yang terdaftar atas nama Anda.
                </div>
            <?php endif; wp_reset_postdata(); ?>
        </div>

        <hr style="margin-top: 40px;">
        <p><a href="<?php echo wp_logout_url( home_url( '/sertifikasi-login/' ) ); ?>" class="logout-link">Keluar</a></p>
    </div>
    <?php wp_footer(); ?>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
