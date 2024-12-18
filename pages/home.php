<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journey to Better Self - Home</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #5C6BC0;
            --accent-color: #7E57C2;
            --text-color: #333;
            --light-bg: #f5f7fa;
            --success-color: #4CAF50;
            --warning-color: #FFC107;
            --danger-color: #FF5252;
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

        .hamburger {
            display: none;
            cursor: pointer;
            color: white;
            font-size: 1.5rem;
        }

        main {
            margin-top: 80px;
            padding: 2rem;
        }

        .hero {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            border-radius: 20px;
            margin-bottom: 3rem;
            animation: fadeIn 1s ease-out;
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
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .hero p {
            font-size: 1.2rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin: 3rem auto;
            max-width: 1200px;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 1rem;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            padding: 2rem 0;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        }

        .feature-card h3 {
            color: var(--primary-color);
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        .feature-card i {
            font-size: 3rem;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            margin-top: 1rem;
            font-weight: 500;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn i {
            font-size: 1rem;
            background: none;
            -webkit-text-fill-color: white;
        }

        footer {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            margin-top: 3rem;
            position: relative;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .footer-section h4 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .footer-section a:hover {
            opacity: 0.8;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-3px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: var(--primary-color);
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .features {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
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
        <div class="hamburger">
            <i class="fas fa-bars"></i>
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
            <h1>Temukan Versi Terbaik Dirimu</h1>
            <p>Selamat datang di perjalanan penemuan diri. Di sini, kamu akan menemukan berbagai cara untuk memahami dan mengembangkan dirimu menjadi lebih baik.</p>
        </section>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number">1,234+</div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">5,678</div>
                <div class="stat-label">Tes IQ Selesai</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3,456</div>
                <div class="stat-label">Game Dimainkan</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">98%</div>
                <div class="stat-label">Kepuasan Pengguna</div>
            </div>
        </div>

        <section class="features">
            <div class="feature-card">
                <i class="fas fa-brain"></i>
                <h3>IQ Test</h3>
                <p>Uji kemampuan kognitifmu dengan tes IQ yang telah tervalidasi. Dapatkan analisis mendalam tentang kekuatan dan area pengembangan dirimu.</p>
                <a href="iq-test.php" class="btn">Mulai Test <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card">
                <i class="fas fa-gamepad"></i>
                <h3>Personality Game</h3>
                <p>Jelajahi kepribadianmu melalui permainan naratif yang menarik. Temukan tipe kepribadianmu dengan cara yang menyenangkan.</p>
                <a href="personality-game.php" class="btn">Main Sekarang <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card">
                <i class="fas fa-quote-right"></i>
                <h3>Wisdom from The Alchemist</h3>
                <p>Temukan kebijaksanaan hidup melalui kutipan-kutipan inspiratif dari novel terkenal The Alchemist.</p>
                <a href="quotes.php" class="btn">Baca Quotes <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="feature-card">
                <i class="fas fa-dove"></i>
                <h3>Flappy Bird Game</h3>
                <p>Latih fokus dan refleksmu dengan game Flappy Bird yang menyenangkan. Tantang dirimu untuk mencapai skor tertinggi!</p>
                <a href="games/flappy-bird.php" class="btn">Main Game <i class="fas fa-arrow-right"></i></a>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>Tentang Kami</h4>
                <p>Journey to Better Self adalah platform pengembangan diri yang membantu Anda menemukan potensi terbaik dalam diri.</p>
            </div>
            <div class="footer-section">
                <h4>Links</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Ikuti Kami</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <p style="margin-top: 2rem;">&copy; 2024 Journey to Better Self. All rights reserved.</p>
    </footer>

    <script>
        // Hamburger menu functionality
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Animate stats on scroll
        const stats = document.querySelectorAll('.stat-number');
        const animateStats = () => {
            stats.forEach(stat => {
                const value = parseInt(stat.textContent);
                let current = 0;
                const increment = value / 50;
                const updateCount = () => {
                    if(current < value) {
                        current += increment;
                        stat.textContent = Math.ceil(current) + (stat.textContent.includes('%') ? '%' : '+');
                        setTimeout(updateCount, 20);
                    } else {
                        stat.textContent = value + (stat.textContent.includes('%') ? '%' : '+');
                    }
                }
                updateCount();
            });
        }

        // Run animation when stats are in view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting) {
                    animateStats();
                    observer.unobserve(entry.target);
                }
            });
        });

        document.querySelector('.stats-container').querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html> 