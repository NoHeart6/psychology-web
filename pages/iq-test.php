<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireLogin();

// Array pertanyaan IQ dengan format CSAT
$questions = [
    // 10 Soal Matematika
    [
        'category' => 'Matematika',
        'question' => 'Jika 3x + 5 = 20, maka nilai x adalah:',
        'options' => ['3', '5', '7', '15'],
        'correct' => 1,
        'explanation' => '3x + 5 = 20 → 3x = 15 → x = 5'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Hasil dari 15% dari 200 adalah:',
        'options' => ['20', '25', '30', '35'],
        'correct' => 2,
        'explanation' => '15% dari 200 = (15/100) × 200 = 30'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Jika harga sebuah barang naik 20% kemudian turun 20%, maka harga akhir dibanding harga awal adalah:',
        'options' => ['Sama', 'Turun 4%', 'Naik 4%', 'Turun 40%'],
        'correct' => 1,
        'explanation' => 'Misalkan harga awal 100, naik 20% jadi 120, turun 20% dari 120 = 96, berarti turun 4%'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Dalam sebuah barisan: 2, 6, 12, 20, 30, ..., angka berikutnya adalah:',
        'options' => ['40', '42', '45', '48'],
        'correct' => 1,
        'explanation' => 'Selisih berturut-turut: +4, +6, +8, +10, +12, sehingga 30 + 12 = 42'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Jika 2^3 = 8, maka 2^5 adalah:',
        'options' => ['16', '24', '32', '64'],
        'correct' => 2,
        'explanation' => '2^5 = 2^3 × 2^2 = 8 × 4 = 32'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Rata-rata dari 15, 20, 25, 30, 35 adalah:',
        'options' => ['20', '25', '30', '35'],
        'correct' => 1,
        'explanation' => '(15 + 20 + 25 + 30 + 35) ÷ 5 = 125 ÷ 5 = 25'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Faktor prima dari 36 adalah:',
        'options' => ['2 × 2 × 3 × 3', '2 × 3 × 6', '3 × 3 × 4', '2 × 2 × 9'],
        'correct' => 0,
        'explanation' => '36 = 2 × 2 × 3 × 3 = 2² × 3²'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Jika 5:x = 20:80, maka x adalah:',
        'options' => ['15', '20', '25', '30'],
        'correct' => 1,
        'explanation' => '5/x = 20/80 → 5 × 80 = 20x → 400 = 20x → x = 20'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Akar kuadrat dari 144 adalah:',
        'options' => ['10', '11', '12', '13'],
        'correct' => 2,
        'explanation' => '12 × 12 = 144, maka √144 = 12'
    ],
    [
        'category' => 'Matematika',
        'question' => 'Keliling persegi dengan luas 36 cm² adalah:',
        'options' => ['20 cm', '24 cm', '28 cm', '32 cm'],
        'correct' => 1,
        'explanation' => 'Luas = sisi², 36 = s², s = 6, keliling = 4s = 24 cm'
    ],

    // 10 Soal Penalaran Kognitif
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Jika semua A adalah B, dan semua B adalah C, maka:',
        'options' => [
            'Semua A adalah C',
            'Beberapa A bukan C',
            'Semua C adalah A',
            'Tidak ada hubungan antara A dan C'
        ],
        'correct' => 0,
        'explanation' => 'Jika A ⊆ B dan B ⊆ C, maka A ⊆ C (transitif)'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Dalam sebuah kode: MEJA = NFKB, maka BUKU =',
        'options' => ['CVLV', 'CJLV', 'CVLJ', 'CJLJ'],
        'correct' => 0,
        'explanation' => 'Setiap huruf digeser 1 huruf ke depan: B→C, U→V, K→L, U→V'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Jika tidak hujan maka Alan pergi ke toko. Alan tidak pergi ke toko. Maka:',
        'options' => [
            'Pasti hujan',
            'Tidak hujan',
            'Mungkin hujan',
            'Tidak ada hubungan'
        ],
        'correct' => 0,
        'explanation' => 'Ini adalah modus tollens: jika p→q dan ¬q, maka ¬p'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Urutan yang tepat: 1.Makan 2.Kenyang 3.Lapar 4.Masak adalah:',
        'options' => [
            '3,4,1,2',
            '3,1,2,4',
            '4,1,2,3',
            '1,2,3,4'
        ],
        'correct' => 0,
        'explanation' => 'Urutan logis: Lapar→Masak→Makan→Kenyang'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Jika MERAH = 13514, maka DARAH =',
        'options' => ['41514', '45124', '41524', '45154'],
        'correct' => 0,
        'explanation' => 'M=1, E=3, R=5, A=1, H=4, maka D=4, A=1, R=5, A=1, H=4'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Semua guru adalah pintar. Beberapa orang pintar adalah kaya. Kesimpulan yang tepat:',
        'options' => [
            'Beberapa guru mungkin kaya',
            'Semua guru pasti kaya',
            'Tidak ada guru yang kaya',
            'Semua orang kaya adalah guru'
        ],
        'correct' => 0,
        'explanation' => 'Dari premis yang ada, hanya dapat disimpulkan bahwa beberapa guru mungkin kaya'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Pola: 2,5,11,23,47,... Angka selanjutnya adalah:',
        'options' => ['85', '89', '95', '99'],
        'correct' => 2,
        'explanation' => 'Setiap angka dikali 2 lalu ditambah 1: 2×2+1=5, 5×2+1=11, 11×2+1=23, 23×2+1=47, 47×2+1=95'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Jika hari ini Selasa, maka 100 hari lagi adalah hari:',
        'options' => ['Senin', 'Selasa', 'Rabu', 'Kamis'],
        'correct' => 1,
        'explanation' => '100 ÷ 7 = 14 sisa 2, berarti setelah 100 hari akan maju 2 hari dari Selasa yaitu Kamis'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Ana lebih tinggi dari Budi. Budi lebih tinggi dari Cici. Deni lebih pendek dari Cici. Siapa yang paling tinggi?',
        'options' => ['Ana', 'Budi', 'Cici', 'Deni'],
        'correct' => 0,
        'explanation' => 'Ana > Budi > Cici > Deni, maka Ana yang paling tinggi'
    ],
    [
        'category' => 'Penalaran Kognitif',
        'question' => 'Jika A+B=C, B+C=D, dan A=3, B=4, maka D=',
        'options' => ['11', '14', '18', '22'],
        'correct' => 1,
        'explanation' => 'A+B=C → 3+4=7=C, B+C=D → 4+7=11=D'
    ],

    // 10 Soal Penalaran Umum
    [
        'category' => 'Penalaran Umum',
        'question' => 'Mengapa pesawat komersial biasanya dicat warna putih?',
        'options' => [
            'Untuk memantulkan panas dan mengurangi biaya pendinginan',
            'Karena cat putih paling murah',
            'Agar terlihat lebih besar',
            'Untuk alasan estetika saja'
        ],
        'correct' => 0,
        'explanation' => 'Warna putih memantulkan panas, membantu menjaga suhu kabin dan mengurangi biaya pendinginan'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Kenapa daun pohon berwarna hijau?',
        'options' => [
            'Karena mengandung klorofil untuk fotosintesis',
            'Untuk menarik serangga',
            'Untuk kamuflase dari predator',
            'Karena pengaruh sinar matahari'
        ],
        'correct' => 0,
        'explanation' => 'Daun berwarna hijau karena mengandung klorofil yang diperlukan untuk proses fotosintesis'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Mengapa air laut rasanya asin?',
        'options' => [
            'Karena mengandung garam mineral',
            'Karena pencemaran',
            'Karena suhu air yang tinggi',
            'Karena pengaruh ikan laut'
        ],
        'correct' => 0,
        'explanation' => 'Air laut mengandung berbagai mineral terlarut, terutama natrium klorida (garam)'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Apa yang terjadi jika semua lebah di dunia punah?',
        'options' => [
            'Krisis pangan global karena gagalnya penyerbukan tanaman',
            'Udara menjadi lebih bersih',
            'Tidak ada dampak signifikan',
            'Produksi madu berhenti'
        ],
        'correct' => 0,
        'explanation' => 'Lebah berperan vital dalam penyerbukan tanaman pangan, kepunahannya akan menyebabkan krisis pangan'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Mengapa es mengapung di air?',
        'options' => [
            'Karena densitas es lebih rendah dari air',
            'Karena es lebih ringan',
            'Karena pengaruh suhu',
            'Karena tekanan air'
        ],
        'correct' => 0,
        'explanation' => 'Es mengapung karena densitasnya lebih rendah dari air, akibat struktur molekul yang lebih renggang'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Apa yang menyebabkan gempa bumi?',
        'options' => [
            'Pergerakan lempeng tektonik',
            'Rotasi bumi',
            'Gravitasi bulan',
            'Aktivitas manusia'
        ],
        'correct' => 0,
        'explanation' => 'Gempa bumi terutama disebabkan oleh pergerakan lempeng tektonik di kerak bumi'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Mengapa burung bermigrasi?',
        'options' => [
            'Mencari tempat yang lebih hangat dan makanan',
            'Menghindari predator',
            'Mencari pasangan',
            'Karena instink saja'
        ],
        'correct' => 0,
        'explanation' => 'Burung bermigrasi untuk mencari tempat dengan suhu yang lebih sesuai dan ketersediaan makanan yang lebih baik'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Apa fungsi utama ozon di atmosfer?',
        'options' => [
            'Melindungi dari radiasi UV',
            'Mengatur suhu bumi',
            'Menyediakan oksigen',
            'Mencegah hujan'
        ],
        'correct' => 0,
        'explanation' => 'Lapisan ozon berfungsi melindungi bumi dari radiasi ultraviolet berbahaya dari matahari'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Mengapa darah berwarna merah?',
        'options' => [
            'Karena kandungan hemoglobin',
            'Karena oksigen',
            'Karena zat besi',
            'Karena sel darah merah'
        ],
        'correct' => 0,
        'explanation' => 'Darah berwarna merah karena kandungan hemoglobin yang mengandung zat besi'
    ],
    [
        'category' => 'Penalaran Umum',
        'question' => 'Apa yang menyebabkan pelangi?',
        'options' => [
            'Pembiasan cahaya oleh titik air di udara',
            'Refleksi awan',
            'Efek atmosfer',
            'Pantulan matahari'
        ],
        'correct' => 0,
        'explanation' => 'Pelangi terbentuk karena pembiasan (dispersi) cahaya matahari oleh titik-titik air di udara'
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    $results = [];
    
    foreach ($_POST as $key => $answer) {
        if (strpos($key, 'q') === 0) {
            $questionIndex = substr($key, 1);
            $isCorrect = ($answer == $questions[$questionIndex]['correct']);
            $score += $isCorrect ? 1 : 0;
            
            $results[] = [
                'question' => $questions[$questionIndex]['question'],
                'userAnswer' => $answer,
                'correctAnswer' => $questions[$questionIndex]['correct'],
                'explanation' => $questions[$questionIndex]['explanation'],
                'isCorrect' => $isCorrect
            ];
        }
    }
    
    // Simpan hasil ke session untuk ditampilkan di halaman hasil
    $_SESSION['iq_results'] = $results;
    $_SESSION['iq_score'] = $score;
    
    // Simpan ke database
    saveIQResult($_SESSION['user_id'], $score);
    
    header('Location: iq-result.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes IQ - Journey to Better Self</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #5C6BC0;
            --accent-color: #7E57C2;
            --success-color: #4CAF50;
            --warning-color: #FFC107;
            --danger-color: #FF5252;
            --text-color: #333;
            --light-bg: #f5f7fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, var(--light-bg) 0%, #ffffff 100%);
            color: var(--text-color);
        }

        nav {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-brand i {
            font-size: 1.8rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .test-container {
            max-width: 900px;
            margin: 100px auto 2rem;
            padding: 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.5s ease-out;
        }

        .instructions {
            background: linear-gradient(to right, rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }

        .instructions::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }

        .instructions h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
            position: relative;
        }

        .instructions ul {
            list-style-type: none;
            padding: 0;
            position: relative;
        }

        .instructions li {
            margin: 1rem 0;
            padding-left: 2rem;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .instructions li::before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: var(--primary-color);
            position: absolute;
            left: 0;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
            animation-delay: calc(var(--i) * 0.1s);
        }

        .timer {
            position: fixed;
            top: 80px;
            right: 20px;
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: slideLeft 0.5s ease-out;
        }

        .timer-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .timer-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            font-family: 'Courier New', monospace;
        }

        .timer.warning .timer-value {
            color: var(--warning-color);
            animation: pulse 1s infinite;
        }

        .timer.danger .timer-value {
            color: var(--danger-color);
            animation: pulse 0.5s infinite;
        }

        .progress-container {
            width: 100%;
            margin: 2rem 0;
            position: relative;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        .progress {
            height: 100%;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            width: 0%;
            transition: width 0.3s ease;
            position: relative;
        }

        .progress-label {
            position: absolute;
            top: -25px;
            right: 0;
            font-size: 0.9rem;
            color: var(--primary-color);
        }

        .question-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeIn 0.5s ease-out;
        }

        .question-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .category-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .category-label i {
            font-size: 1rem;
        }

        .question-text {
            font-size: 1.2rem;
            color: var(--text-color);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-weight: 500;
        }

        .options-grid {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .option-wrapper {
            position: relative;
        }

        .option-label {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-label:hover {
            border-color: var(--primary-color);
            background: var(--light-bg);
            transform: translateX(5px);
        }

        input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        input[type="radio"] + .option-label::before {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #e9ecef;
            border-radius: 50%;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        input[type="radio"]:checked + .option-label {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-color: transparent;
            transform: translateX(5px);
        }

        input[type="radio"]:checked + .option-label::before {
            background: white;
            border-color: white;
            box-shadow: inset 0 0 0 4px var(--primary-color);
        }

        .submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            width: 100%;
            justify-content: center;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .submit-btn:hover::after {
            left: 100%;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideLeft {
            from { transform: translateX(20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .test-container {
                margin: 80px 1rem 1rem;
                padding: 1rem;
            }

            .timer {
                position: sticky;
                top: 80px;
                right: auto;
                width: calc(100% - 2rem);
                margin: 1rem auto;
                flex-direction: row;
                justify-content: space-between;
            }

            .question-text {
                font-size: 1.1rem;
            }

            .option-label {
                padding: 0.8rem 1rem;
            }

            .category-label {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <i class="fas fa-compass"></i>
            Journey to Better Self
        </div>
        <ul class="nav-links">
            <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="iq-test.php"><i class="fas fa-brain"></i> IQ Test</a></li>
            <li><a href="personality-game.php"><i class="fas fa-gamepad"></i> Personality Game</a></li>
            <li><a href="quotes.php"><i class="fas fa-quote-right"></i> Wisdom</a></li>
            <li><a href="games/flappy-bird.php"><i class="fas fa-dove"></i> Mini Games</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <main>
        <div class="test-container">
            <div class="instructions">
                <h3><i class="fas fa-info-circle"></i> Petunjuk Pengerjaan</h3>
                <ul>
                    <li style="--i:1"><i class="fas fa-check-circle"></i> Tes ini terdiri dari <?php echo count($questions); ?> soal</li>
                    <li style="--i:2"><i class="fas fa-clock"></i> Waktu pengerjaan adalah 30 menit</li>
                    <li style="--i:3"><i class="fas fa-balance-scale"></i> Setiap soal memiliki bobot nilai yang sama</li>
                    <li style="--i:4"><i class="fas fa-bullseye"></i> Pilih jawaban yang paling tepat</li>
                    <li style="--i:5"><i class="fas fa-chart-line"></i> Hasil akan ditampilkan setelah semua soal dijawab</li>
                </ul>
            </div>

            <div class="timer">
                <div class="timer-label">Sisa Waktu</div>
                <div class="timer-value" id="timer">30:00</div>
            </div>

            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress" id="progress"></div>
                </div>
                <div class="progress-label">0/<?php echo count($questions); ?> Soal</div>
            </div>

            <form method="POST" id="testForm">
                <?php foreach ($questions as $index => $q): ?>
                <div class="question-card">
                    <div class="category-label">
                        <?php 
                        $icon = '';
                        switch($q['category']) {
                            case 'Matematika':
                                $icon = 'calculator';
                                break;
                            case 'Penalaran Kognitif':
                                $icon = 'brain';
                                break;
                            case 'Penalaran Umum':
                                $icon = 'lightbulb';
                                break;
                        }
                        ?>
                        <i class="fas fa-<?php echo $icon; ?>"></i>
                        <?php echo $q['category']; ?>
                    </div>
                    <div class="question-text"><?php echo ($index + 1) . ". " . $q['question']; ?></div>
                    
                    <div class="options-grid">
                        <?php foreach ($q['options'] as $optIndex => $option): ?>
                        <div class="option-wrapper">
                            <input type="radio" 
                                   name="q<?php echo $index; ?>" 
                                   id="q<?php echo $index; ?>_<?php echo $optIndex; ?>"
                                   value="<?php echo $optIndex; ?>" 
                                   required>
                            <label class="option-label" 
                                   for="q<?php echo $index; ?>_<?php echo $optIndex; ?>">
                                <?php echo chr(65 + $optIndex) . ". " . $option; ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Selesai dan Lihat Hasil
                </button>
            </form>
        </div>
    </main>

    <script>
        // Timer functionality
        let timeLeft = 30 * 60; // 30 menit dalam detik
        const timerDisplay = document.getElementById('timer');
        const timerContainer = document.querySelector('.timer');
        
        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Tambahkan warning class saat waktu < 5 menit
            if (timeLeft <= 300 && timeLeft > 60) {
                timerContainer.classList.add('warning');
            }
            // Tambahkan danger class saat waktu < 1 menit
            if (timeLeft <= 60) {
                timerContainer.classList.remove('warning');
                timerContainer.classList.add('danger');
            }
            
            if (timeLeft === 0) {
                document.getElementById('testForm').submit();
            } else {
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }
        
        updateTimer();

        // Progress bar functionality
        const form = document.getElementById('testForm');
        const progress = document.getElementById('progress');
        const progressLabel = document.querySelector('.progress-label');
        const totalQuestions = <?php echo count($questions); ?>;
        
        function updateProgress() {
            const answered = form.querySelectorAll('input[type="radio"]:checked').length;
            const percentage = (answered / totalQuestions) * 100;
            progress.style.width = percentage + '%';
            progressLabel.textContent = `${answered}/${totalQuestions} Soal`;
        }
        
        form.addEventListener('change', updateProgress);
        
        // Konfirmasi sebelum meninggalkan halaman
        window.addEventListener('beforeunload', (e) => {
            const answered = form.querySelectorAll('input[type="radio"]:checked').length;
            if (answered > 0 && answered < totalQuestions) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        // Smooth scroll to next question after answering
        const questionCards = document.querySelectorAll('.question-card');
        form.addEventListener('change', (e) => {
            if (e.target.type === 'radio') {
                const currentCard = e.target.closest('.question-card');
                const nextCard = currentCard.nextElementSibling;
                if (nextCard && nextCard.classList.contains('question-card')) {
                    nextCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    </script>
</body>
</html> 