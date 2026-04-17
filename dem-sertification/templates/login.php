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
    <title>Login | DEM Indonesia Sertification</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'dem-login-body' ); ?>>

    <div class="dem-login-container">
        <a href="<?php echo home_url( '/sertifikasi/' ); ?>" class="dem-back-to-home">
            <i data-lucide="arrow-left" style="margin-right: 8px; width: 16px;"></i> Kembali ke Beranda
        </a>

        <div class="dem-login-card">
        <div class="dem-login-header">
            <img src="<?php echo DEM_SERTIFICATION_URL; ?>assets/images/logo.png" alt="DEM Indonesia Logo" class="dem-logo">
            <h1>DEM Indonesia</h1>
            <p>Sertification Portal</p>
        </div>

        <?php if ( isset( $_GET['login'] ) && $_GET['login'] == 'failed' ) : ?>
            <div class="dem-alert dem-alert-danger">
                Login gagal. Silakan periksa kembali username dan password Anda.
            </div>
        <?php endif; ?>

        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" class="dem-login-form">
            <input type="hidden" name="action" value="dem_login">
            <?php wp_nonce_field( 'dem_login_action', 'dem_login_nonce' ); ?>

            <div class="dem-form-group">
                <label for="user_login">Username atau Email</label>
                <input type="text" name="log" id="user_login" class="dem-input" placeholder="Masukkan username" required>
            </div>

            <div class="dem-form-group">
                <label for="user_pass">Password</label>
                <input type="password" name="pwd" id="user_pass" class="dem-input" placeholder="Masukkan password" required>
            </div>

            <div class="dem-form-options">
                <label class="dem-remember-me">
                    <input type="checkbox" name="rememberme" value="forever"> Ingat Saya
                </label>
                <a href="<?php echo wp_lostpassword_url(); ?>" class="dem-forgot-password">Lupa Password?</a>
            </div>

            <button type="submit" class="dem-btn-login">MASUK</button>
        </form>

        <div class="dem-login-footer">
            <p>&copy; <?php echo date( 'Y' ); ?> DEM Indonesia. All rights reserved.</p>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
<script>
    lucide.createIcons();
</script>
</body>
</html>
