# Journey to Better Self - Website Pengembangan Diri

Sebuah platform web interaktif yang dirancang untuk membantu pengguna dalam perjalanan pengembangan diri mereka melalui berbagai fitur menarik dan edukatif.

## Fitur Utama

1. **Tes IQ**
   - Evaluasi kemampuan kognitif
   - Pertanyaan-pertanyaan tervalidasi
   - Hasil analisis yang detail

2. **Personality Game**
   - Game interaktif berbasis narasi
   - Analisis kepribadian berdasarkan pilihan
   - Hasil personality type (I/E, T/F, J/P)

3. **Wisdom Quotes**
   - Kutipan inspiratif dari buku The Alchemist
   - Konteks dan penjelasan mendalam
   - Update quotes secara dinamis

4. **Sistem Autentikasi**
   - Register dengan validasi
   - Login aman dengan session
   - Proteksi data pengguna

5. **Mini Games**
   - Flappy Bird untuk melatih fokus dan refleks
   - Sistem high score
   - Tracking progress pemain

## Teknologi yang Digunakan

- PHP 8.2
- MongoDB 7.0
- HTML5 Canvas
- CSS3
- JavaScript (ES6+)
- Composer 2.0+

## Persyaratan Sistem

- Web Server (Apache/Nginx/Laragon)
- PHP 8.2 atau lebih tinggi
- MongoDB 7.0 atau lebih tinggi
- PHP MongoDB Extension 1.16+
- Git
- Composer 2.0+
- Browser modern dengan dukungan HTML5 Canvas
- Extension PHP yang diperlukan:
  - mongodb
  - curl
  - fileinfo
  - gd
  - intl
  - mbstring
  - openssl
  - pdo_mysql
  - zip

## Instalasi

1. Clone repositori ini:
   ```bash
   git clone https://github.com/username/journey-to-better-self.git
   ```

2. Masuk ke direktori proyek:
   ```bash
   cd journey-to-better-self
   ```

3. Install dependensi menggunakan Composer:
   ```bash
   composer install
   ```

4. Konfigurasi MongoDB:
   - Pastikan MongoDB server berjalan
   - Sesuaikan koneksi database di `includes/db.php` jika diperlukan
   - Pastikan PHP MongoDB extension sudah terinstal dan aktif

5. Jalankan migrasi database:
   ```bash
   php database/migrate.php up    # Membuat struktur database
   php database/migrate.php down  # Menghapus struktur database
   php database/migrate.php refresh # Menyegarkan database
   ```

6. Jalankan web server lokal:
   ```bash
   php -S localhost:8000
   ```

7. Buka browser dan akses:
   ```
   http://localhost:8000
   ```

## Struktur Database

Database: `psychology_web`

Collections:
- `users`: Menyimpan data pengguna
  - Indexes: email (unique), created_at
  - Validasi: email, password, role

- `iq_results`: Menyimpan hasil tes IQ
  - Indexes: user_id, date
  - Validasi: score, completion_time

- `personality_results`: Menyimpan hasil personality game
  - Indexes: user_id, personality_type, date
  - Validasi: choices, analysis

- `quotes`: Menyimpan kutipan-kutipan The Alchemist
  - Indexes: author, source
  - Data awal: Kutipan-kutipan pilihan

- `game_scores`: Menyimpan skor game
  - Indexes: user_id, game, score, date
  - Validasi: player_name, game_type

## Migrasi Database

Sistem migrasi database menggunakan pendekatan berbasis class dengan fitur:

1. **Versioning**
   - Migrasi berurutan dengan prefix angka
   - Tracking status migrasi

2. **Operasi**
   - `up()`: Membuat struktur baru
   - `down()`: Membatalkan perubahan
   - `refresh`: Membangun ulang database

3. **Validasi**
   - Schema validation
   - Index optimization
   - Data seeding

## Game Features

1. **Flappy Bird**
   - Kontrol: Spasi atau klik mouse
   - Sistem scoring berbasis jarak
   - Leaderboard global
   - Tingkat kesulitan progresif
   - Animasi smooth
   - Collision detection akurat

## Keamanan

1. **Autentikasi**
   - Password hashing dengan algoritma modern
   - Session management
   - CSRF protection

2. **Database**
   - Validasi input
   - Prepared statements
   - Index optimization

3. **Frontend**
   - XSS prevention
   - Input sanitization
   - Secure headers

## Kontribusi

1. Fork repositori
2. Buat branch fitur baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -am 'Menambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE)

## Kontak

Jika Anda memiliki pertanyaan atau saran, silakan hubungi kami di:
- Email: contact@journeytobetterself.com
- Website: www.journeytobetterself.com

## Pengembangan Selanjutnya

- [ ] Sistem rekomendasi konten personal
- [ ] Integrasi dengan API motivasi eksternal
- [ ] Fitur jurnal refleksi diri
- [ ] Sistem achievement dan rewards
- [ ] Komunitas dan forum diskusi
- [ ] Dashboard admin
- [ ] Analisis data pengguna
- [ ] API integration
- [ ] Progressive Web App (PWA)
- [ ] Multi-language support
- [ ] Tambahan mini games baru
- [ ] Mode multiplayer untuk games
- [ ] Sistem reward dan achievement untuk games

## Pengembangan Terbaru (Update 2024)

- [x] Visual Novel Game dengan Astrit
  - Multiple endings (6 different endings)
  - Point system (Intelligence, Manners, Patience)
  - Dynamic character interactions
  - Branching storylines
  - Real physics and science concepts integration
  - Romantic academic storyline

- [x] IQ Test Format CSAT
  - 30 soal dengan 3 kategori
  - Matematika dan logika
  - Penalaran kognitif
  - Penalaran umum
  - Timer system
  - Detailed result analysis

- [x] Flappy Bird Game Enhancement
  - Space/Enter key for restart
  - High score system
  - Smooth animations
  - Mobile responsive controls

- [x] UI/UX Improvements
  - Modern gradient backgrounds
  - Responsive layouts
  - Interactive animations
  - Better navigation flow
  - Enhanced visual feedback
  - Mobile-first approach

- [x] Authentication System
  - Session management
  - Secure login/logout
  - User progress tracking
  - Profile customization
  - Data persistence

## Rencana Update Mendatang (2024)

- [ ] Personality Game Expansion
  - Tambahan karakter baru
  - Side stories dan sub-plots
  - Mini games dalam visual novel
  - Achievement system
  - Gallery mode untuk CG art
  - Music dan sound effects

- [ ] Enhanced Learning Features
  - Tutorial fisika interaktif
  - Simulasi eksperimen
  - Quiz challenges
  - Study group system
  - Progress tracking
  - Learning analytics

- [ ] Social Features
  - Profile customization
  - Friend system
  - Chat feature
  - Group study rooms
  - Score comparisons
  - Achievement sharing