<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireLogin();

if (!isset($_SESSION['iq_score'])) {
    header('Location: iq-test.php');
    exit;
}

$rawScore = $_SESSION['iq_score'];
unset($_SESSION['iq_score']); // Clear the score from session after showing

// Perhitungan skor IQ yang lebih akurat
// Menggunakan kurva normal dengan mean 100 dan standar deviasi 15
// Raw score dari 0-30 akan dikonversi ke skor IQ 55-145
function calculateIQ($rawScore) {
    $totalQuestions = 30;
    $mean = $totalQuestions / 2; // 15 adalah tengah dari 0-30
    $maxDeviation = 3; // 3 standar deviasi untuk range 55-145
    
    // Menghitung z-score
    $zScore = ($rawScore - $mean) / ($totalQuestions / (2 * $maxDeviation));
    
    // Mengkonversi z-score ke skor IQ
    $iqScore = 100 + ($zScore * 15);
    
    // Membatasi skor minimum 55 dan maksimum 145
    return max(55, min(145, round($iqScore)));
}

$iq = calculateIQ($rawScore);

// Fungsi untuk menghitung persentil berdasarkan skor IQ
function calculatePercentile($iq) {
    // Menggunakan tabel persentil yang disederhanakan
    // Berdasarkan distribusi normal standar
    $percentiles = [
        145 => 99.9,
        140 => 99.6,
        135 => 99.0,
        130 => 98.0,
        125 => 95.0,
        120 => 90.0,
        115 => 84.0,
        110 => 75.0,
        105 => 63.0,
        100 => 50.0,
        95 => 37.0,
        90 => 25.0,
        85 => 16.0,
        80 => 10.0,
        75 => 5.0,
        70 => 2.0,
        65 => 1.0,
        60 => 0.4,
        55 => 0.1
    ];
    
    // Mencari dua nilai terdekat dalam tabel
    $keys = array_keys($percentiles);
    $closest = null;
    $closestDiff = PHP_FLOAT_MAX;
    
    foreach ($keys as $key) {
        $diff = abs($key - $iq);
        if ($diff < $closestDiff) {
            $closestDiff = $diff;
            $closest = $key;
        }
    }
    
    // Jika nilai tepat ada di tabel
    if ($closest == $iq) {
        return $percentiles[$closest];
    }
    
    // Interpolasi linear antara dua nilai terdekat
    $index = array_search($closest, $keys);
    if ($iq > $closest && $index > 0) {
        $lower = $closest;
        $upper = $keys[$index - 1];
    } else if ($iq < $closest && $index < count($keys) - 1) {
        $lower = $keys[$index + 1];
        $upper = $closest;
    } else {
        return $percentiles[$closest];
    }
    
    $lowerPercentile = $percentiles[$lower];
    $upperPercentile = $percentiles[$upper];
    
    // Interpolasi linear
    $ratio = ($iq - $lower) / ($upper - $lower);
    $percentile = $lowerPercentile + $ratio * ($upperPercentile - $lowerPercentile);
    
    return round($percentile, 1);
}

$percentile = calculatePercentile($iq);

// Fungsi untuk mendapatkan kategori IQ
function getIQCategory($iq) {
    if ($iq >= 130) return ["Sangat Tinggi", "var(--success-color)"];
    if ($iq >= 120) return ["Tinggi", "var(--primary-color)"];
    if ($iq >= 110) return ["Di Atas Rata-rata", "var(--secondary-color)"];
    if ($iq >= 90) return ["Rata-rata", "var(--accent-color)"];
    if ($iq >= 80) return ["Di Bawah Rata-rata", "var(--warning-color)"];
    return ["Perlu Pengembangan", "var(--danger-color)"];
}

$category = getIQCategory($iq);

// Fungsi untuk mendapatkan interpretasi detail
function getInterpretation($iq) {
    if ($iq >= 130) {
        return "Luar biasa! Anda memiliki kemampuan kognitif yang sangat tinggi (Gifted). Ini menunjukkan kemampuan yang istimewa dalam:
                <ul>
                    <li>Pemecahan masalah kompleks</li>
                    <li>Penalaran abstrak tingkat tinggi</li>
                    <li>Pemahaman konsep yang mendalam</li>
                    <li>Kreativitas dan inovasi</li>
                </ul>";
    }
    if ($iq >= 120) {
        return "Sangat bagus! Anda memiliki kemampuan kognitif yang tinggi. Kelebihan Anda termasuk:
                <ul>
                    <li>Analisis yang tajam</li>
                    <li>Pembelajaran yang cepat</li>
                    <li>Pemikiran strategis</li>
                    <li>Pemecahan masalah yang efektif</li>
                </ul>";
    }
    if ($iq >= 110) {
        return "Bagus! Anda memiliki kemampuan kognitif di atas rata-rata. Keunggulan Anda meliputi:
                <ul>
                    <li>Pemahaman yang baik</li>
                    <li>Kemampuan analitis yang solid</li>
                    <li>Pengambilan keputusan yang baik</li>
                    <li>Adaptasi yang cepat</li>
                </ul>";
    }
    if ($iq >= 90) {
        return "Baik! Anda memiliki kemampuan kognitif rata-rata. Ini menunjukkan:
                <ul>
                    <li>Pemahaman yang seimbang</li>
                    <li>Kemampuan belajar yang normal</li>
                    <li>Penalaran praktis yang baik</li>
                    <li>Potensi pengembangan yang positif</li>
                </ul>";
    }
    if ($iq >= 80) {
        return "Anda memiliki ruang untuk berkembang. Fokus pada pengembangan:
                <ul>
                    <li>Strategi pembelajaran yang efektif</li>
                    <li>Latihan pemecahan masalah</li>
                    <li>Peningkatan fokus dan konsentrasi</li>
                    <li>Pengembangan pola pikir analitis</li>
                </ul>";
    }
    return "Setiap orang memiliki kecerdasan yang unik. Skor IQ hanyalah salah satu indikator. Rekomendasi untuk Anda:
            <ul>
                <li>Temukan gaya belajar yang sesuai</li>
                <li>Fokus pada kekuatan personal</li>
                <li>Kembangkan multiple intelligence</li>
                <li>Latihan rutin dan konsisten</li>
            </ul>";
}

$interpretation = getInterpretation($iq);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil IQ Test - Journey to Better Self</title>
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
            min-height: 100vh;
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

        main {
            padding-top: 80px;
        }

        .hero {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
        }

        .hero p {
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .result-card {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            animation: slideUp 0.5s ease-out;
            position: relative;
            overflow: hidden;
        }

        .result-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        .score-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 2rem auto;
        }

        .score-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(
                <?php echo $category[1]; ?> calc(<?php echo ($iq - 55) / (145 - 55) * 360 ?>deg),
                #f0f0f0 0deg
            );
            position: relative;
            animation: fillCircle 1s ease-out;
        }

        .score-circle::before {
            content: '';
            position: absolute;
            width: 80%;
            height: 80%;
            background: white;
            border-radius: 50%;
            top: 10%;
            left: 10%;
        }

        .score {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            font-weight: bold;
            color: <?php echo $category[1]; ?>;
            animation: countUp 2s ease-out;
        }

        .score-label {
            font-size: 1.2rem;
            color: #666;
            margin-top: 1rem;
        }

        .interpretation {
            margin: 2rem 0;
            padding: 2rem;
            background: linear-gradient(to right, rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            border-radius: 15px;
            position: relative;
        }

        .interpretation::before {
            content: '\f0eb';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .score-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .detail-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
        }

        .detail-icon {
            font-size: 2rem;
            color: <?php echo $category[1]; ?>;
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--text-color);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            min-width: 180px;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .btn.secondary {
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        footer {
            text-align: center;
            padding: 2rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            margin-top: 3rem;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fillCircle {
            from { transform: rotate(-90deg); }
            to { transform: rotate(0deg); }
        }

        @keyframes countUp {
            from { opacity: 0; transform: translate(-50%, -30%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .result-card {
                margin: 1rem;
                padding: 1.5rem;
            }

            .score-details {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .hero h1 {
                font-size: 2rem;
            }
        }

        .interpretation ul {
            text-align: left;
            margin: 1rem 0;
            padding-left: 2rem;
        }

        .interpretation li {
            margin: 0.5rem 0;
            position: relative;
        }

        .interpretation li::before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: var(--primary-color);
            position: absolute;
            left: -1.5rem;
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
        <section class="hero">
            <h1><i class="fas fa-award"></i> Hasil Tes IQ Anda</h1>
            <p>Selamat! Anda telah menyelesaikan tes IQ. Berikut adalah hasil analisis kemampuan kognitif Anda.</p>
        </section>

        <div class="result-card">
            <h2>Skor IQ Anda</h2>
            
            <div class="score-container">
                <div class="score-circle"></div>
                <div class="score"><?php echo $iq; ?></div>
            </div>
            <div class="score-label">Skor IQ</div>
            
            <div class="score-details">
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="detail-label">Persentil</div>
                    <div class="detail-value"><?php echo $percentile; ?>%</div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value"><?php echo $category[0]; ?></div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="detail-label">Jawaban Benar</div>
                    <div class="detail-value"><?php echo $rawScore; ?> dari 30</div>
                </div>
            </div>
            
            <div class="interpretation">
                <?php echo $interpretation; ?>
            </div>

            <div class="action-buttons">
                <a href="iq-test.php" class="btn">
                    <i class="fas fa-redo"></i>
                    Coba Lagi
                </a>
                <a href="home.php" class="btn secondary">
                    <i class="fas fa-home"></i>
                    Kembali ke Home
                </a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Journey to Better Self. All rights reserved.</p>
    </footer>
</body>
</html> 