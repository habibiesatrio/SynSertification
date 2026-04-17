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
    <title>Sertifikasi | DEM Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'dem-landing-body' ); ?>>

<header class="dem-landing-header">
    <div class="container">
        <nav class="dem-navbar">
            <div class="dem-logo-container">
                <img src="<?php echo DEM_SERTIFICATION_URL; ?>assets/images/logo.png" alt="DEM Indonesia Logo" class="dem-logo">
                <span class="dem-brand">DEM Indonesia</span>
            </div>
            <div class="dem-nav-links">
                <a href="<?php echo home_url( '/sertifikasi-login/' ); ?>" class="dem-btn dem-btn-outline">Login Portal</a>
            </div>
        </nav>
    </div>
</header>

<section class="dem-hero-section">
    <div class="container">
        <div class="dem-hero-content">
            <h1>Program Sertifikasi <br><span>DEM Indonesia</span></h1>
            <p>Meningkatkan kompetensi dan profesionalisme di sektor energi untuk masa depan Indonesia yang lebih baik.</p>
            <div class="dem-hero-btns">
                <a href="<?php echo home_url( '/sertifikasi-login/' ); ?>" class="dem-btn dem-btn-primary">Daftar Sekarang</a>
                <a href="#verify" class="dem-btn dem-btn-secondary">Verifikasi Sertifikat</a>
            </div>
        </div>
    </div>
</section>

<section id="verify" class="dem-verify-section">
    <div class="container">
        <div class="dem-verify-card">
            <h2>Verifikasi Sertifikat</h2>
            <p>Masukkan nomor sertifikat Anda untuk memeriksa keabsahan.</p>
            <form action="<?php echo home_url( '/sertifikasi/' ); ?>#verify" method="get" class="dem-verify-form">
                <input type="text" name="cert_no" placeholder="Contoh: DEM/2026/001" value="<?php echo isset($_GET['cert_no']) ? esc_attr($_GET['cert_no']) : ''; ?>" required>
                <button type="submit" class="dem-btn dem-btn-primary">Cek Sekarang</button>
            </form>

            <?php 
            if ( isset( $_GET['cert_no'] ) ) {
                $cert_no = sanitize_text_field( $_GET['cert_no'] );
                $args = array(
                    'post_type'  => 'certificate',
                    'meta_query' => array(
                        array(
                            'key'     => '_cert_number',
                            'value'   => $cert_no,
                            'compare' => '='
                        )
                    )
                );
                $query = new WP_Query( $args );

                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $date = get_post_meta( get_the_ID(), '_cert_date', true );
                        $expiry = get_post_meta( get_the_ID(), '_cert_expiry', true );
                        ?>
                        <div class="dem-alert dem-alert-success">
                            <strong>Sertifikat Valid!</strong><br>
                            Nama: <?php the_title(); ?><br>
                            Nomor: <?php echo esc_html( $cert_no ); ?><br>
                            Tanggal Terbit: <?php echo esc_html( $date ); ?><br>
                            Berlaku Hingga: <?php echo esc_html( $expiry ); ?>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    echo '<div class="dem-alert dem-alert-danger">Sertifikat tidak ditemukan atau tidak valid.</div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="dem-stats-section">
    <div class="container">
        <div class="dem-stats-grid">
            <div class="stat-item">
                <h3>5.000+</h3>
                <p>Profesional Tersertifikasi</p>
            </div>
            <div class="stat-item">
                <h3>150+</h3>
                <p>Mitra Industri</p>
            </div>
            <div class="stat-item">
                <h3>12+</h3>
                <p>Program Spesialisasi</p>
            </div>
            <div class="stat-item">
                <h3>98%</h3>
                <p>Tingkat Kepuasan Alumni</p>
            </div>
        </div>
    </div>
</section>

<section id="about" class="dem-features-section">
    <div class="container">
        <div class="section-title">
            <h2>Mengapa Sertifikasi DEM?</h2>
            <p>Kami memberikan standar kualifikasi terbaik untuk profesional di bidang energi.</p>
        </div>
        <div class="dem-features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i data-lucide="graduation-cap"></i></div>
                <h3>Kurikulum Standar</h3>
                <p>Materi sertifikasi disusun berdasarkan kebutuhan industri energi terbarukan terkini.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i data-lucide="award"></i></div>
                <h3>Pengakuan Nasional</h3>
                <p>Sertifikat yang diakui secara resmi oleh berbagai institusi energi di Indonesia.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i data-lucide="users"></i></div>
                <h3>Jaringan Luas</h3>
                <p>Bergabunglah dengan ekosistem profesional energi terbesar di Indonesia.</p>
            </div>
        </div>
    </div>
</section>

<section id="process" class="dem-process-section">
    <div class="container">
        <div class="section-title">
            <h2>Alur Sertifikasi</h2>
            <p>Langkah mudah untuk mendapatkan pengakuan profesional Anda.</p>
        </div>
        <div class="dem-timeline">
            <div class="timeline-item">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Pendaftaran</h3>
                    <p>Buat akun di portal sertifikasi dan lengkapi profil profesional Anda.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">2</div>
                <div class="timeline-content">
                    <h3>Pemilihan Program</h3>
                    <p>Pilih skema sertifikasi yang sesuai dengan kompetensi dan bidang kerja Anda.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Pelatihan & Ujian</h3>
                    <p>Ikuti sesi pelatihan intensif dan selesaikan ujian asesmen kompetensi.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-number">4</div>
                <div class="timeline-content">
                    <h3>Penerbitan Sertifikat</h3>
                    <p>Dapatkan sertifikat digital dan fisik yang diakui secara nasional.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="programs" class="dem-features-section">
    <div class="container">
        <div class="section-title">
            <h2>Program Unggulan</h2>
            <p>Berbagai pilihan spesialisasi untuk mengakselerasi karir Anda.</p>
        </div>
        <div class="dem-programs-grid">
            <div class="program-card">
                <div class="program-tag">Paling Populer</div>
                <h3>Ahli Energi Terbarukan</h3>
                <p>Sertifikasi komprehensif untuk instalasi dan manajemen sistem PLTS, PLTA, dan PLTB.</p>
            </div>
            <div class="program-card">
                <div class="program-tag">Industri</div>
                <h3>Audit Energi Industri</h3>
                <p>Pelatihan dan sertifikasi untuk melakukan efisiensi energi pada sistem manufaktur.</p>
            </div>
            <div class="program-card">
                <div class="program-tag">Manajerial</div>
                <h3>Manajer Energi Madya</h3>
                <p>Kepemimpinan strategis dalam pengelolaan sumber daya energi perusahaan.</p>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="dem-faq-section">
    <div class="container">
        <div class="section-title">
            <h2>Pertanyaan Umum (FAQ)</h2>
            <p>Segala hal yang perlu Anda ketahui tentang sertifikasi DEM Indonesia.</p>
        </div>
        <div class="dem-faq-list">
            <div class="faq-item">
                <h3>Berapa lama masa berlaku sertifikat?</h3>
                <p>Rata-rata sertifikat berlaku selama 3 tahun dan dapat diperpanjang melalui proses resertifikasi.</p>
            </div>
            <div class="faq-item">
                <h3>Apakah sertifikasi ini diakui secara internasional?</h3>
                <p>Ya, kurikulum kami disesuaikan dengan standar internasional dan diakui oleh mitra kami di luar negeri.</p>
            </div>
            <div class="faq-item">
                <h3>Bagaimana jika saya gagal dalam ujian?</h3>
                <p>Peserta diberikan kesempatan untuk mengikuti ujian remedial sebanyak satu kali dalam periode 6 bulan.</p>
            </div>
        </div>
    </div>
</section>

<script>
    lucide.createIcons();
</script>

<footer class="dem-landing-footer">
    <div class="container">
        <p>&copy; <?php echo date( 'Y' ); ?> DEM Indonesia. All rights reserved.</p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
