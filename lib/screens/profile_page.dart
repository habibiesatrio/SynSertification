import 'package:flutter/material.dart';

class ProfilePage extends StatelessWidget {
  final VoidCallback? onBackToHome;
  const ProfilePage({super.key, this.onBackToHome});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F5F5),
      body: SingleChildScrollView(
        child: Column(
          children: [
            // Header Profile
            Container(
              padding: const EdgeInsets.fromLTRB(24, 60, 24, 30),
              decoration: const BoxDecoration(
                color: Color(0xFF0052CC), // Blue
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(30),
                  bottomRight: Radius.circular(30),
                ),
              ),
              child: Column(
                children: [
                  if (onBackToHome != null)
                    Align(
                      alignment: Alignment.topLeft,
                      child: IconButton(
                        icon: const Icon(Icons.arrow_back, color: Colors.white),
                        onPressed: onBackToHome,
                      ),
                    ),
                  const CircleAvatar(
                    radius: 50,
                    backgroundColor: Colors.white,
                    child: Icon(
                      Icons.person,
                      size: 60,
                      color: Color(0xFF0052CC),
                    ), // Blue
                  ),
                  const SizedBox(height: 15),
                  const Text(
                    'Nama Pengguna',
                    style: TextStyle(
                      fontSize: 22,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                  const Text(
                    'user@email.com',
                    style: TextStyle(fontSize: 14, color: Colors.white70),
                  ),
                  const SizedBox(height: 20),
                  Container(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 16,
                      vertical: 8,
                    ),
                    decoration: BoxDecoration(
                      color: Colors.white.withOpacity(0.2),
                      borderRadius: BorderRadius.circular(20),
                    ),
                    child: Row(
                      mainAxisSize: MainAxisSize.min,
                      children: const [
                        Icon(Icons.business, color: Colors.white, size: 18),
                        SizedBox(width: 8),
                        Text(
                          'Asal Instansi: Universitas Indonesia',
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 20),

            // Menu Items
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24.0),
              child: Column(
                children: [
                  _buildProfileMenu(
                    icon: Icons.edit_outlined,
                    title: 'Edit Profil',
                    onTap: () {},
                  ),
                  _buildProfileMenu(
                    icon: Icons.history_outlined,
                    title: 'Riwayat Sertifikasi',
                    onTap: () {},
                  ),
                  _buildProfileMenu(
                    icon: Icons.settings_outlined,
                    title: 'Pengaturan',
                    onTap: () {},
                  ),
                  _buildProfileMenu(
                    icon: Icons.help_outline,
                    title: 'Bantuan',
                    onTap: () {},
                  ),
                  const SizedBox(height: 20),
                  _buildProfileMenu(
                    icon: Icons.logout,
                    title: 'Keluar',
                    titleColor: Colors.red,
                    iconColor: Colors.red,
                    onTap: () {
                      // Navigate back to Login
                      Navigator.of(
                        context,
                      ).pushNamedAndRemoveUntil('/', (route) => false);
                    },
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildProfileMenu({
    required IconData icon,
    required String title,
    required VoidCallback onTap,
    Color? titleColor,
    Color? iconColor,
  }) {
    return Container(
      margin: const EdgeInsets.only(bottom: 15),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.05),
            blurRadius: 10,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: ListTile(
        leading: Icon(
          icon,
          color: iconColor ?? const Color(0xFF0052CC),
        ), // Blue
        title: Text(
          title,
          style: TextStyle(
            fontWeight: FontWeight.w500,
            color: titleColor ?? Colors.black87,
          ),
        ),
        trailing: const Icon(Icons.chevron_right, color: Colors.grey),
        onTap: onTap,
      ),
    );
  }
}
