import 'package:flutter/material.dart';
import 'package:url_launcher/url_launcher.dart';

class AboutPage extends StatelessWidget {
  const AboutPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF8F9FA),
      body: CustomScrollView(
        slivers: [
          // Elegant Header with Gradient
          SliverAppBar(
            expandedHeight: 220.0,
            floating: false,
            pinned: true,
            elevation: 0,
            backgroundColor: const Color(0xFF0052CC), // Blue
            flexibleSpace: FlexibleSpaceBar(
              title: const Text(
                'Tentang DEM Indonesia',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 16,
                  color: Colors.white,
                ),
              ),
              centerTitle: true,
              background: Stack(
                fit: StackFit.expand,
                children: [
                  Container(
                    decoration: const BoxDecoration(
                      gradient: LinearGradient(
                        begin: Alignment.topCenter,
                        end: Alignment.bottomCenter,
                        colors: [
                          Color(0xFF1976D2),
                          Color(0xFF0052CC),
                        ], // Blue Gradient
                      ),
                    ),
                  ),
                  Center(
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        const SizedBox(height: 40),
                        Hero(
                          tag: 'logo',
                          child: Container(
                            padding: const EdgeInsets.all(15),
                            decoration: BoxDecoration(
                              color: Colors.white,
                              shape: BoxShape.circle,
                              boxShadow: [
                                BoxShadow(
                                  color: Colors.black.withOpacity(0.1),
                                  blurRadius: 20,
                                  spreadRadius: 5,
                                ),
                              ],
                            ),
                            child: Image.asset(
                              'assets/images/logo.png',
                              height: 70,
                              errorBuilder: (context, error, stackTrace) {
                                return const Icon(
                                  Icons.bolt,
                                  size: 60,
                                  color: Color(0xFF0052CC), // Blue
                                );
                              },
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),

          SliverToBoxAdapter(
            child: Padding(
              padding: const EdgeInsets.symmetric(
                horizontal: 20.0,
                vertical: 24.0,
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // About Section (Elegant Card)
                  _buildElegantSection(
                    title: 'Siapa Kami?',
                    content:
                        'Dewan Energi Mahasiswa Indonesia (DEM Indonesia) adalah wadah perjuangan mahasiswa se-Indonesia dalam mewujudkan kedaulatan energi yang berkeadilan melalui gerakan kolektif interdisipliner.',
                    icon: Icons.groups_outlined,
                  ),

                  const SizedBox(height: 24),

                  // Visi Section
                  _buildElegantSection(
                    title: 'Visi Kami',
                    content:
                        'Mewujudkan Kedaulatan Energi Yang Berkeadilan Melalui Gerakan Kolektif Mahasiswa Interdisipliner.',
                    icon: Icons.lightbulb_outline,
                    highlight: true,
                  ),

                  const SizedBox(height: 24),

                  // Misi Section (Modern List)
                  const Text(
                    'Misi Strategis',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF0052CC), // Blue
                    ),
                  ),
                  const SizedBox(height: 16),
                  _buildMisiCard(
                    'Pendidikan & Pelatihan',
                    'Mengembangkan kapasitas anggota melalui pelatihan, seminar, dan studi banding nasional.',
                    Icons.school_outlined,
                  ),
                  _buildMisiCard(
                    'Riset & Teknologi',
                    'Memfasilitasi riset energi terbarukan yang melibatkan mahasiswa lintas universitas.',
                    Icons.biotech_outlined,
                  ),
                  _buildMisiCard(
                    'Sinergi Nasional',
                    'Memperkuat kolaborasi antar 24 DEM daerah untuk dampak pergerakan nasional.',
                    Icons.hub_outlined,
                  ),
                  _buildMisiCard(
                    'Advokasi Kebijakan',
                    'Mendorong kebijakan energi yang berpihak pada lingkungan dan kesejahteraan rakyat.',
                    Icons.gavel_outlined,
                  ),

                  const SizedBox(height: 24),

                  // Partnership Section (Like Tiket.com "Our Partners")
                  const Text(
                    'Kemitraan Strategis',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF0052CC), // Blue
                    ),
                  ),
                  const SizedBox(height: 16),
                  Container(
                    padding: const EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: Colors.grey.withOpacity(0.1)),
                    ),
                    child: Column(
                      children: [
                        _buildPartnerItem(
                          'Kementerian ESDM RI',
                          'Dukungan kebijakan & program energi berkelanjutan.',
                        ),
                        const Divider(height: 30),
                        _buildPartnerItem(
                          'Industri Energi',
                          'Kolaborasi teknologi & transisi energi bersih.',
                        ),
                        const Divider(height: 30),
                        _buildPartnerItem(
                          'Lembaga Riset',
                          'Inovasi dan pengembangan energi masa depan.',
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 24),

                  // Website Section
                  const Text(
                    'Website Resmi',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF0052CC), // Blue
                    ),
                  ),
                  const SizedBox(height: 16),
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(20),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(20),
                      border: Border.all(color: Colors.grey.withOpacity(0.1)),
                    ),
                    child: Column(
                      children: [
                        const Text(
                          'Temukan informasi lebih lengkap dan berita terbaru mengenai kegiatan kami melalui website resmi DEM Indonesia.',
                          style: TextStyle(
                            fontSize: 14,
                            color: Colors.black87,
                            height: 1.5,
                          ),
                          textAlign: TextAlign.center,
                        ),
                        const SizedBox(height: 20),
                        ElevatedButton.icon(
                          onPressed: () async {
                            final Uri url = Uri.parse(
                              'https://demindonesia.or.id',
                            );
                            if (!await launchUrl(
                              url,
                              mode: LaunchMode.externalApplication,
                            )) {
                              throw Exception('Could not launch $url');
                            }
                          },
                          icon: const Icon(Icons.language, color: Colors.white),
                          label: const Text('Kunjungi demindonesia.or.id'),
                          style: ElevatedButton.styleFrom(
                            backgroundColor: const Color(0xFF0052CC), // Blue
                            foregroundColor: Colors.white,
                            padding: const EdgeInsets.symmetric(
                              horizontal: 24,
                              vertical: 12,
                            ),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(12),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),

                  const SizedBox(height: 40),

                  // Footer Info
                  Center(
                    child: Column(
                      children: [
                        Text(
                          '© 2026 DEM Indonesia',
                          style: TextStyle(
                            color: Colors.grey.shade600,
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                        const SizedBox(height: 4),
                        Text(
                          'Center of Excellence for Energy Movement',
                          style: TextStyle(
                            color: Colors.grey.shade500,
                            fontSize: 12,
                          ),
                        ),
                        const SizedBox(height: 40),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSectionTitle(String title) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          title,
          style: const TextStyle(
            fontSize: 22,
            fontWeight: FontWeight.bold,
            color: Color(0xFF0052CC), // Blue
          ),
        ),
        const SizedBox(height: 10),
        Container(
          width: 40,
          height: 4,
          decoration: BoxDecoration(
            color: const Color(0xFF8BC34A), // Light Green
            borderRadius: BorderRadius.circular(2),
          ),
        ),
        const SizedBox(height: 15),
      ],
    );
  }

  Widget _buildMisiItem(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Icon(
            Icons.check_circle,
            color: Color(0xFF8BC34A),
            size: 20,
          ), // Light Green
          const SizedBox(width: 12),
          Expanded(
            child: Text(
              text,
              style: const TextStyle(
                fontSize: 15,
                height: 1.4,
                color: Colors.black87,
              ),
            ),
          ),
        ],
      ),
    );
  }
}

Widget _buildElegantSection({
  required String title,
  required String content,
  required IconData icon,
  bool highlight = false,
}) {
  return Container(
    padding: const EdgeInsets.all(20),
    decoration: BoxDecoration(
      color: highlight ? const Color(0xFFE8F5E9) : Colors.white,
      borderRadius: BorderRadius.circular(20),
      boxShadow: [
        BoxShadow(
          color: Colors.black.withOpacity(0.03),
          blurRadius: 15,
          offset: const Offset(0, 5),
        ),
      ],
      border: Border.all(
        color: highlight
            ? const Color(0xFF8BC34A).withOpacity(0.1) // Light Green
            : Colors.grey.withOpacity(0.1),
      ),
    ),
    child: Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Row(
          children: [
            Icon(icon, color: const Color(0xFF0052CC), size: 24), // Blue
            const SizedBox(width: 12),
            Text(
              title,
              style: const TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.bold,
                color: Color(0xFF0052CC), // Blue
              ),
            ),
          ],
        ),
        const SizedBox(height: 12),
        Text(
          content,
          style: TextStyle(
            fontSize: 15,
            height: 1.6,
            color: Colors.black.withOpacity(0.7),
            fontWeight: highlight ? FontWeight.w500 : FontWeight.normal,
          ),
        ),
      ],
    ),
  );
}

Widget _buildMisiCard(String title, String desc, IconData icon) {
  return Container(
    margin: const EdgeInsets.only(bottom: 12),
    padding: const EdgeInsets.all(16),
    decoration: BoxDecoration(
      color: Colors.white,
      borderRadius: BorderRadius.circular(15),
      border: Border.all(color: Colors.grey.withOpacity(0.1)),
    ),
    child: Row(
      children: [
        Container(
          padding: const EdgeInsets.all(10),
          decoration: BoxDecoration(
            color: const Color(0xFF0052CC).withOpacity(0.1), // Blue
            borderRadius: BorderRadius.circular(12),
          ),
          child: Icon(icon, color: const Color(0xFF0052CC), size: 24), // Blue
        ),
        const SizedBox(width: 16),
        Expanded(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                title,
                style: const TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 15,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                desc,
                style: TextStyle(
                  color: Colors.grey.shade600,
                  fontSize: 13,
                  height: 1.4,
                ),
              ),
            ],
          ),
        ),
      ],
    ),
  );
}

Widget _buildPartnerItem(String name, String desc) {
  return Row(
    crossAxisAlignment: CrossAxisAlignment.start,
    children: [
      const Icon(
        Icons.verified_outlined,
        color: Color(0xFF8BC34A),
        size: 20,
      ), // Light Green
      const SizedBox(width: 15),
      Expanded(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              name,
              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
            ),
            const SizedBox(height: 4),
            Text(
              desc,
              style: TextStyle(color: Colors.grey.shade600, fontSize: 13),
            ),
          ],
        ),
      ),
    ],
  );
}
