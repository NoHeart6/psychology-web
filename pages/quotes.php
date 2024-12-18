<?php
require_once('../includes/db.php');
session_start();

// Array quotes dari The Alchemist dalam bahasa Indonesia
$alchemist_quotes = [
    [
        'quote' => 'Ketika kamu menginginkan sesuatu, seluruh alam semesta bersatu untuk membantumu mencapainya.',
        'context' => 'Santiago belajar bahwa impian dan keinginan kita memiliki kekuatan untuk menggerakkan alam semesta.',
        'icon' => 'fas fa-universe'
    ],
    [
        'quote' => 'Kemungkinan sebuah mimpi menjadi kenyataan itulah yang membuat hidup menjadi menarik.',
        'context' => 'Tentang bagaimana harapan dan mimpi memberi makna pada kehidupan kita.',
        'icon' => 'fas fa-star'
    ],
    [
        'quote' => 'Rahasia kehidupan adalah jatuh tujuh kali dan bangkit delapan kali.',
        'context' => 'Pentingnya ketahanan dan resiliensi dalam menghadapi tantangan hidup.',
        'icon' => 'fas fa-arrows-up'
    ],
    [
        'quote' => 'Semua orang sepertinya memiliki ide yang jelas tentang bagaimana orang lain harus menjalani hidupnya, tapi tidak dengan hidupnya sendiri.',
        'context' => 'Refleksi tentang bagaimana kita sering lebih mudah menilai orang lain daripada diri sendiri.',
        'icon' => 'fas fa-people-arrows'
    ],
    [
        'quote' => 'Ingatlah bahwa di mana hatimu berada, di sanalah kamu akan menemukan hartamu.',
        'context' => 'Mengikuti kata hati dan passion kita akan menuntun pada kebahagiaan sejati.',
        'icon' => 'fas fa-heart'
    ]
];

// Ambil quote acak
$random_quote = $alchemist_quotes[array_rand($alchemist_quotes)];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijaksanaan - Journey to Better Self</title>
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
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(74, 144, 226, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(92, 107, 192, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        nav {
            background: rgba(15, 23, 42, 0.95);
            padding: 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            background: linear-gradient(45deg, rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(45deg, rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transition: 0.5s;
        }

        .nav-links a:hover::before {
            left: 100%;
        }

        .nav-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.2);
        }

        .hero {
            text-align: center;
            padding: 10rem 2rem 6rem;
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), 
                       url('https://images.unsplash.com/photo-1519681393784-d120267933ba') center/cover no-repeat fixed;
            position: relative;
            margin-bottom: 3rem;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, 
                rgba(74, 144, 226, 0.1) 0%, 
                transparent 50%,
                rgba(92, 107, 192, 0.1) 100%);
            animation: gradientMove 10s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            position: relative;
        }

        .hero p {
            color: rgba(255,255,255,0.9);
            max-width: 700px;
            margin: 0 auto;
            font-size: 1.2rem;
            line-height: 1.8;
            position: relative;
        }

        .quotes-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
        }

        .quote-card {
            background: rgba(30, 41, 59, 0.8);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .quote-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg,
                transparent,
                rgba(74, 144, 226, 0.05),
                transparent
            );
            transform: translateX(-100%);
            transition: 0.5s;
        }

        .quote-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
        }

        .quote-card:hover::before {
            transform: translateX(100%);
        }

        .quote-icon {
            position: absolute;
            top: 2rem;
            right: 2rem;
            font-size: 3rem;
            color: rgba(74, 144, 226, 0.2);
            transform: rotate(-10deg);
            transition: all 0.3s ease;
        }

        .quote-card:hover .quote-icon {
            transform: rotate(0deg) scale(1.1);
            color: rgba(74, 144, 226, 0.3);
        }

        .quote-text {
            font-size: 2rem;
            font-weight: 300;
            color: white;
            margin-bottom: 2rem;
            line-height: 1.6;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .quote-context {
            color: rgba(255,255,255,0.8);
            line-height: 1.8;
            font-size: 1.2rem;
            border-left: 4px solid var(--primary-color);
            padding-left: 1.5rem;
            margin-top: 2rem;
            background: linear-gradient(90deg,
                rgba(74, 144, 226, 0.1),
                transparent
            );
            padding: 1.5rem;
            border-radius: 0 10px 10px 0;
        }

        .quote-source {
            text-align: right;
            font-style: italic;
            color: rgba(255,255,255,0.6);
            margin-top: 2rem;
            font-size: 1rem;
            position: relative;
            padding-top: 1rem;
        }

        .quote-source::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-color));
        }

        .refresh-btn {
            display: flex;
            margin: 3rem auto;
            padding: 1rem 2.5rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            align-items: center;
            gap: 0.8rem;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }

        .refresh-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .refresh-btn:hover::before {
            left: 100%;
        }

        .refresh-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .refresh-btn:active {
            transform: translateY(-1px);
        }

        footer {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(15, 23, 42, 0.95);
            color: rgba(255,255,255,0.8);
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(to right,
                transparent,
                var(--primary-color),
                transparent
            );
        }

        @media (max-width: 768px) {
            .hero {
                padding: 8rem 1rem 4rem;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .quotes-container {
                padding: 1rem;
            }

            .quote-card {
                padding: 2rem;
            }

            .quote-text {
                font-size: 1.6rem;
            }

            .quote-context {
                font-size: 1.1rem;
            }

            .nav-links {
                display: none;
            }

            .nav-brand {
                margin: 0 auto;
            }
        }

        @media (min-width: 769px) {
            .quote-card {
                transform: perspective(1000px) rotateX(0deg);
                transition: transform 0.5s ease;
            }

            .quote-card:hover {
                transform: perspective(1000px) rotateX(2deg) translateY(-5px);
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <i class="fas fa-book-open"></i>
            Journey to Better Self
        </div>
        <ul class="nav-links">
            <li><a href="home.php"><i class="fas fa-home"></i> Beranda</a></li>
            <li><a href="iq-test.php"><i class="fas fa-brain"></i> Tes IQ</a></li>
            <li><a href="personality-game.php"><i class="fas fa-gamepad"></i> Game Kepribadian</a></li>
            <li><a href="quotes.php"><i class="fas fa-quote-right"></i> Kebijaksanaan</a></li>
            <li><a href="games/flappy-bird.php"><i class="fas fa-dove"></i> Mini Games</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </nav>

    <main>
        <section class="hero">
            <h1>Kebijaksanaan dari The Alchemist</h1>
            <p>Temukan pencerahan dan inspirasi melalui kutipan-kutipan penuh makna dari novel The Alchemist karya Paulo Coelho.</p>
        </section>

        <div class="quotes-container">
            <div class="quote-card">
                <i class="quote-icon <?php echo $random_quote['icon']; ?>"></i>
                <div class="quote-text">
                    <?php echo $random_quote['quote']; ?>
                </div>
                <div class="quote-context">
                    <?php echo $random_quote['context']; ?>
                </div>
                <div class="quote-source">- Paulo Coelho, The Alchemist</div>
            </div>

            <form method="POST">
                <button type="submit" class="refresh-btn">
                    <i class="fas fa-sync-alt"></i>
                    Kutipan Lainnya
                </button>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Journey to Better Self. Hak Cipta Dilindungi.</p>
    </footer>

    <script>
        // Efek parallax sederhana untuk hero section
        window.addEventListener('scroll', function() {
            const hero = document.querySelector('.hero');
            const scrolled = window.pageYOffset;
            hero.style.backgroundPositionY = (scrolled * 0.5) + 'px';
        });

        // Animasi smooth untuk refresh button
        document.querySelector('.refresh-btn').addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    </script>
</body>
</html> 