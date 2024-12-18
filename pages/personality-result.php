<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireLogin();

if (!isset($_SESSION['personality_type'])) {
    header('Location: personality-game.php');
    exit;
}

$personality_type = $_SESSION['personality_type'];
$choices = $_SESSION['personality_choices'] ?? [];
unset($_SESSION['personality_type'], $_SESSION['personality_choices']);

// Deskripsi kepribadian
$personality_descriptions = [
    'ISTJ' => 'Si Perfeksionis yang Logis - Anda adalah orang yang sangat terorganisir, bertanggung jawab, dan berorientasi pada detail.',
    'ISFJ' => 'Si Pelindung yang Setia - Anda adalah orang yang penuh perhatian, teliti, dan sangat peduli pada orang lain.',
    'INFJ' => 'Si Idealis yang Bijaksana - Anda memiliki visi yang kuat dan intuisi yang tajam dalam memahami orang lain.',
    'INTJ' => 'Si Pemikir Strategis - Anda adalah perencana yang hebat dengan pemikiran analitis yang kuat.',
    'ISTP' => 'Si Pengamat yang Praktis - Anda adalah problem solver yang handal dengan kemampuan teknis yang baik.',
    'ISFP' => 'Si Seniman yang Fleksibel - Anda memiliki jiwa artistik dan sangat menghargai keindahan.',
    'INFP' => 'Si Mediator yang Idealis - Anda memiliki nilai-nilai kuat dan sangat kreatif dalam mengekspresikan ide.',
    'INTP' => 'Si Arsitek Pemikiran - Anda adalah pemikir logis yang inovatif dan suka menganalisis konsep kompleks.',
    'ESTP' => 'Si Penggerak yang Dinamis - Anda adalah orang yang energetik dan sangat baik dalam menangani situasi darurat.',
    'ESFP' => 'Si Penghibur yang Spontan - Anda adalah orang yang ceria dan sangat baik dalam membuat orang lain bahagia.',
    'ENFP' => 'Si Inspirator yang Antusias - Anda adalah orang yang kreatif dan selalu penuh dengan ide-ide baru.',
    'ENTP' => 'Si Inovator yang Cerdas - Anda adalah pemikir cepat yang suka mendebat ide-ide baru.',
    'ESTJ' => 'Si Eksekutif yang Efisien - Anda adalah pemimpin alami yang sangat terorganisir dan tegas.',
    'ESFJ' => 'Si Pemberi yang Harmonis - Anda sangat peduli pada kesejahteraan orang lain dan harmoni sosial.',
    'ENFJ' => 'Si Mentor yang Karismatik - Anda adalah pemimpin inspiratif yang sangat baik dalam memotivasi orang lain.',
    'ENTJ' => 'Si Komandan yang Tegas - Anda adalah pemimpin alami dengan kemampuan strategis yang kuat.'
];

// Rekomendasi pengembangan diri
$development_tips = [
    'I' => [
        'Cobalah untuk lebih terlibat dalam diskusi kelompok kecil',
        'Latih kemampuan berbicara di depan umum secara bertahap',
        'Jadwalkan waktu sendiri untuk memulihkan energi'
    ],
    'E' => [
        'Praktikkan mendengarkan aktif',
        'Luangkan waktu untuk refleksi diri',
        'Seimbangkan aktivitas sosial dengan waktu pribadi'
    ],
    'S' => [
        'Cobalah pendekatan baru dalam menyelesaikan masalah',
        'Latih kreativitas melalui aktivitas seni',
        'Eksplorasi ide-ide abstrak melalui diskusi'
    ],
    'N' => [
        'Perhatikan detail praktis dalam perencanaan',
        'Terapkan ide-ide ke dalam tindakan konkret',
        'Seimbangkan visi dengan realitas'
    ],
    'T' => [
        'Praktikkan empati dalam komunikasi',
        'Pertimbangkan dampak emosional keputusan',
        'Dengarkan perasaan orang lain'
    ],
    'F' => [
        'Latih pengambilan keputusan objektif',
        'Gunakan logika dalam analisis situasi',
        'Seimbangkan perasaan dengan fakta'
    ],
    'J' => [
        'Belajar lebih fleksibel dengan perubahan',
        'Terima ketidakpastian sebagai bagian hidup',
        'Sisakan ruang untuk spontanitas'
    ],
    'P' => [
        'Tetapkan deadline pribadi',
        'Buat struktur untuk proyek penting',
        'Praktikkan manajemen waktu'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Personality Game - Journey to Better Self</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .result-card {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .personality-type {
            font-size: 3rem;
            color: var(--primary-color);
            text-align: center;
            margin: 1rem 0;
        }

        .description {
            margin: 1.5rem 0;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            line-height: 1.6;
        }

        .tips-section {
            margin-top: 2rem;
        }

        .tips-list {
            list-style-type: none;
            padding: 0;
        }

        .tips-list li {
            margin: 1rem 0;
            padding: 1rem;
            background: #fff;
            border-left: 4px solid var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .action-buttons .btn {
            min-width: 150px;
        }

        .trait-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .trait-card {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 5px;
            text-align: center;
        }

        .trait-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">Journey to Better Self</div>
        <ul class="nav-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="iq-test.php">IQ Test</a></li>
            <li><a href="personality-game.php">Personality Game</a></li>
            <li><a href="quotes.php">Wisdom</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <main>
        <section class="hero">
            <h1>Hasil Personality Game Anda</h1>
            <p>Temukan insight mendalam tentang kepribadian Anda.</p>
        </section>

        <div class="result-card">
            <h2>Tipe Kepribadian Anda</h2>
            <div class="personality-type"><?php echo $personality_type; ?></div>
            
            <div class="description">
                <p><?php echo $personality_descriptions[$personality_type] ?? 'Tipe kepribadian yang unik'; ?></p>
            </div>

            <div class="trait-breakdown">
                <?php foreach (str_split($personality_type) as $trait): ?>
                <div class="trait-card">
                    <div class="trait-title">
                        <?php
                        switch($trait) {
                            case 'I': echo 'Introvert'; break;
                            case 'E': echo 'Extrovert'; break;
                            case 'S': echo 'Sensing'; break;
                            case 'N': echo 'Intuitive'; break;
                            case 'T': echo 'Thinking'; break;
                            case 'F': echo 'Feeling'; break;
                            case 'J': echo 'Judging'; break;
                            case 'P': echo 'Perceiving'; break;
                        }
                        ?>
                    </div>
                    <ul class="tips-list">
                        <?php foreach ($development_tips[$trait] as $tip): ?>
                            <li><?php echo $tip; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="action-buttons">
                <a href="personality-game.php" class="btn">Coba Lagi</a>
                <a href="home.php" class="btn">Kembali ke Home</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Journey to Better Self. All rights reserved.</p>
    </footer>
</body>
</html> 