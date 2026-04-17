<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$cert_id = get_the_ID();
$number  = get_post_meta( $cert_id, '_cert_number', true );
$date    = get_post_meta( $cert_id, '_cert_date', true );
$expiry  = get_post_meta( $cert_id, '_cert_expiry', true );
$file    = get_post_meta( $cert_id, '_cert_file_url', true );
$user_id = get_post_meta( $cert_id, '_cert_user_id', true );

// Keamanan: Hanya pemilik sertifikat atau admin yang bisa melihat detail
if ( ! current_user_can( 'manage_options' ) && ( ! is_user_logged_in() || get_current_user_id() != $user_id ) ) {
    wp_redirect( home_url( '/sertifikasi-login/' ) );
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sertifikat | <?php the_title(); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php wp_head(); ?>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .cert-detail-container { max-width: 800px; margin: 40px auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .cert-header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .cert-header h1 { color: #0056b3; margin: 0; }
        .cert-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .info-item label { font-weight: bold; color: #666; display: block; margin-bottom: 5px; }
        .info-item span { font-size: 18px; color: #333; }
        .cert-actions { text-align: center; display: flex; gap: 15px; justify-content: center; }
        .btn-download { background: #28a745; color: white; padding: 15px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; }
        .btn-view { background: #0056b3; color: white; padding: 15px 30px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body class="dem-login-body">

<div style="max-width: 800px; margin: 0 auto; position: relative; height: 60px;">
    <a href="<?php echo home_url( '/sertifikasi-dashboard/' ); ?>" class="dem-back-to-home">
        <i data-lucide="arrow-left" style="margin-right: 8px; width: 18px;"></i> Kembali ke Dashboard
    </a>
</div>

<div class="cert-detail-container">
    <div class="cert-header">
        <h1>Detail Sertifikat</h1>
        <p>Program Sertifikasi DEM Indonesia</p>
    </div>

    <div class="cert-info-grid">
        <div class="info-item">
            <label>Nama Penerima</label>
            <span><?php the_title(); ?></span>
        </div>
        <div class="info-item">
            <label>Nomor Sertifikat</label>
            <span><?php echo esc_html( $number ); ?></span>
        </div>
        <div class="info-item">
            <label>Tanggal Terbit</label>
            <span><?php echo esc_html( $date ); ?></span>
        </div>
        <div class="info-item">
            <label>Masa Berlaku</label>
            <span><?php echo esc_html( $expiry ); ?></span>
        </div>
    </div>

    <?php if ( $file ) : ?>
        <div class="cert-actions">
            <a href="<?php echo esc_url( $file ); ?>" target="_blank" class="btn-view">Lihat Sertifikat (PDF)</a>
            <a href="<?php echo esc_url( $file ); ?>" download class="btn-download">Download Sertifikat</a>
        </div>
    <?php else : ?>
        <p style="text-align: center; color: #dc3545; font-style: italic;">File sertifikat digital belum tersedia. Silakan hubungi admin.</p>
    <?php endif; ?>
</div>

<?php wp_footer(); ?>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
