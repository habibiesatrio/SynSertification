import 'package:flutter/material.dart';
import 'about_page.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: CustomScrollView(
        slivers: [
          // Header with Greeting and Search
          SliverToBoxAdapter(
            child: Container(
              padding: const EdgeInsets.fromLTRB(20, 60, 20, 20),
              decoration: const BoxDecoration(
                color: Color(0xFF0052CC), // Blue
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(25),
                  bottomRight: Radius.circular(25),
                ),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: const [
                          Text(
                            'Halo, Admin!',
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Text(
                            'Mau belajar apa hari ini?',
                            style: TextStyle(
                              color: Colors.white70,
                              fontSize: 14,
                            ),
                          ),
                        ],
                      ),
                      const CircleAvatar(
                        backgroundColor: Colors.white24,
                        child: Icon(
                          Icons.notifications_none,
                          color: Colors.white,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 20),
                  // Search Bar Like Grab/Tiket
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 15),
                    height: 45,
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(30),
                    ),
                    child: Row(
                      children: const [
                        Icon(Icons.search, color: Colors.grey),
                        SizedBox(width: 10),
                        Text(
                          'Cari pelatihan atau sertifikasi...',
                          style: TextStyle(color: Colors.grey, fontSize: 14),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),

          // Banner Carousel Section
          SliverToBoxAdapter(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Padding(
                  padding: EdgeInsets.fromLTRB(20, 20, 20, 10),
                  child: Text(
                    'Promo & Info Terbaru',
                    style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                  ),
                ),
                SizedBox(
                  height: 150,
                  child: PageView(
                    controller: PageController(viewportFraction: 0.9),
                    children: [
                      _buildBannerCard(
                        'Diskon Sertifikasi 20%',
                        'Berlaku hingga 30 April 2026',
                        Colors.blue.shade700,
                      ),
                      _buildBannerCard(
                        'Workshop Energi Baru',
                        'Daftar sekarang, kuota terbatas!',
                        Colors.orange.shade700,
                      ),
                      _buildBannerCard(
                        'Lulus Sertifikasi?',
                        'Dapatkan merchandise menarik!',
                        Colors.purple.shade700,
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          // Main Services Grid (Like Grab/Tiket.com)
          SliverPadding(
            padding: const EdgeInsets.all(20),
            sliver: SliverGrid(
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 4,
                mainAxisSpacing: 20,
                crossAxisSpacing: 10,
                childAspectRatio: 0.8,
              ),
              delegate: SliverChildListDelegate([
                _buildServiceIcon(
                  context,
                  'Sertifikasi',
                  Icons.card_membership,
                  Colors.blue,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'e-Learning',
                  Icons.play_circle_outline,
                  Colors.green,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'Helpdesk',
                  Icons.headset_mic_outlined,
                  Colors.teal,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'About',
                  Icons.info_outline,
                  Colors.purple,
                  () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => const AboutPage(),
                      ),
                    );
                  },
                ),
                _buildServiceIcon(
                  context,
                  'Webinar',
                  Icons.video_camera_back_outlined,
                  Colors.red,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'Artikel',
                  Icons.newspaper_outlined,
                  Colors.orange,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'Event',
                  Icons.event_note_outlined,
                  Colors.indigo,
                  () {},
                ),
                _buildServiceIcon(
                  context,
                  'Lainnya',
                  Icons.grid_view_outlined,
                  Colors.grey,
                  () {},
                ),
              ]),
            ),
          ),

          // News / Recommended Section
          const SliverToBoxAdapter(
            child: Padding(
              padding: EdgeInsets.symmetric(horizontal: 20, vertical: 10),
              child: Text(
                'Rekomendasi Pelatihan',
                style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
              ),
            ),
          ),
          SliverList(
            delegate: SliverChildBuilderDelegate((context, index) {
              return _buildNewsCard(
                'Sertifikasi Ahli Energi Muda ${index + 1}',
                'Oleh Dewan Energi Mahasiswa Indonesia',
                'Mulai dari Rp 500.000',
                'assets/images/logo.png',
              );
            }, childCount: 3),
          ),

          // Legal Section
          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.all(20),
              child: Column(
                children: [
                  _buildLegalItem(
                    Icons.description_outlined,
                    'Terms of Service',
                  ),
                  const SizedBox(height: 10),
                  _buildLegalItem(Icons.privacy_tip_outlined, 'Privacy Policy'),
                  const SizedBox(height: 30),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBannerCard(String title, String subtitle, Color color) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 5),
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: color.withOpacity(0.3),
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Text(
            title,
            style: const TextStyle(
              color: Colors.white,
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 5),
          Text(
            subtitle,
            style: const TextStyle(color: Colors.white70, fontSize: 12),
          ),
          const SizedBox(height: 10),
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 5),
            decoration: BoxDecoration(
              color: Colors.white24,
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Text(
              'Lihat Detail',
              style: TextStyle(
                color: Colors.white,
                fontSize: 10,
                fontWeight: FontWeight.bold,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildServiceIcon(
    BuildContext context,
    String label,
    IconData icon,
    Color color,
    VoidCallback onTap,
  ) {
    return GestureDetector(
      onTap: onTap,
      child: Column(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(15),
            ),
            child: Icon(icon, color: color, size: 28),
          ),
          const SizedBox(height: 8),
          Text(
            label,
            textAlign: TextAlign.center,
            style: const TextStyle(fontSize: 11, fontWeight: FontWeight.w500),
          ),
        ],
      ),
    );
  }

  Widget _buildNewsCard(
    String title,
    String provider,
    String price,
    String img,
  ) {
    return Container(
      margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 8),
      padding: const EdgeInsets.all(12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(15),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: Colors.grey.shade100,
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(Icons.school, color: Colors.green.shade700, size: 40),
          ),
          const SizedBox(width: 15),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 14,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  provider,
                  style: const TextStyle(color: Colors.grey, fontSize: 12),
                ),
                const SizedBox(height: 8),
                Text(
                  price,
                  style: const TextStyle(
                    color: Color(0xFF0052CC), // Blue
                    fontWeight: FontWeight.bold,
                    fontSize: 14,
                  ),
                ),
              ],
            ),
          ),
          const Icon(Icons.arrow_forward_ios, size: 14, color: Colors.grey),
        ],
      ),
    );
  }

  Widget _buildLegalItem(IconData icon, String title) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 15, vertical: 12),
      decoration: BoxDecoration(
        color: Colors.grey.shade50,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        children: [
          Icon(icon, size: 20, color: Colors.grey),
          const SizedBox(width: 15),
          Text(
            title,
            style: const TextStyle(fontSize: 14, color: Colors.black87),
          ),
          const Spacer(),
          const Icon(Icons.chevron_right, size: 20, color: Colors.grey),
        ],
      ),
    );
  }
}
