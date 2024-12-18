<?php
require_once('../../includes/db.php');
require_once('../../includes/auth.php');

requireLogin();

// Ambil high score dari database
$highScore = getHighScore('flappy_bird');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flappy Bird - Journey to Better Self</title>
    <link rel="stylesheet" href="../../css/style.css">
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
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.1);
        }

        .game-layout {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            max-width: 1400px;
            margin: 80px auto 2rem;
            padding: 2rem;
        }

        .game-sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .game-main {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .score-board {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .score-item {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .score-item:last-child {
            border-bottom: none;
        }

        .score-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .score-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
        }

        .game-controls {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .game-controls h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .control-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .control-list li {
            margin: 0.8rem 0;
            padding-left: 1.5rem;
            position: relative;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .control-list li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--primary-color);
        }

        #gameCanvas {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 12px;
            margin: 0 auto;
            display: block;
            background: #4dc6ff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background: var(--secondary-color);
        }

        .game-over {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(30, 41, 59, 0.95);
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            z-index: 1000;
            min-width: 300px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .game-over h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .final-score {
            font-size: 3rem;
            color: var(--primary-color);
            font-weight: bold;
            margin: 1rem 0;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }

        @media (max-width: 1024px) {
            .game-layout {
                grid-template-columns: 1fr;
            }

            .game-sidebar {
                position: static;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .game-layout {
                margin: 60px 1rem 1rem;
                padding: 1rem;
            }

            .game-sidebar {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }

            .nav-brand {
                margin: 0 auto;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-brand">
            <i class="fas fa-gamepad"></i>
            Journey to Better Self
        </div>
        <ul class="nav-links">
            <li><a href="../home.php"><i class="fas fa-home"></i> Beranda</a></li>
            <li><a href="../iq-test.php"><i class="fas fa-brain"></i> Tes IQ</a></li>
            <li><a href="../personality-game.php"><i class="fas fa-gamepad"></i> Game Kepribadian</a></li>
            <li><a href="../quotes.php"><i class="fas fa-quote-right"></i> Kebijaksanaan</a></li>
            <li><a href="flappy-bird.php"><i class="fas fa-dove"></i> Mini Games</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
        </ul>
    </nav>

    <main class="game-layout">
        <aside class="game-sidebar">
            <div class="score-board">
                <div class="score-item">
                    <div class="score-label">Skor Saat Ini</div>
                    <div class="score-value" id="currentScore">0</div>
                </div>
                <div class="score-item">
                    <div class="score-label">Skor Tertinggi</div>
                    <div class="score-value" id="highScore"><?php echo $highScore; ?></div>
                </div>
            </div>

            <div class="game-controls">
                <h3><i class="fas fa-gamepad"></i> Kontrol Game</h3>
                <ul class="control-list">
                    <li>Tekan SPASI untuk terbang ke atas</li>
                    <li>Klik mouse untuk terbang ke atas</li>
                    <li>Hindari pipa hijau</li>
                    <li>Kumpulkan poin sebanyak mungkin</li>
                </ul>
                <button class="btn" onclick="startGame()">
                    <i class="fas fa-play"></i> Mulai Game
                </button>
            </div>
        </aside>

        <section class="game-main">
            <canvas id="gameCanvas" width="320" height="480"></canvas>
        </section>
    </main>

    <div id="gameOver" class="game-over">
        <h2><i class="fas fa-trophy"></i> Game Over!</h2>
        <p>Skor Akhir:</p>
        <div class="final-score" id="finalScore">0</div>
        <div class="action-buttons">
            <button class="btn" onclick="restartGame()">
                <i class="fas fa-redo"></i> Main Lagi
            </button>
            <a href="../home.php" class="btn">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const GRAVITY = 0.5;
        const FLAP_STRENGTH = -8;
        const PIPE_SPEED = 2;
        const PIPE_SPAWN_RATE = 150;
        const PIPE_GAP = 150;

        // Load gambar burung
        const birdImg = new Image();
        birdImg.src = 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/sprites/yellowbird-midflap.png';

        // Load gambar pipa
        const pipeTopImg = new Image();
        const pipeBottomImg = new Image();
        pipeTopImg.src = 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/sprites/pipe-green.png';
        pipeBottomImg.src = 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/sprites/pipe-green.png';

        // Load gambar background
        const bgImg = new Image();
        bgImg.src = 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/sprites/background-day.png';

        // Load gambar base (ground)
        const baseImg = new Image();
        baseImg.src = 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/sprites/base.png';

        // Posisi base
        let baseX = 0;

        let bird = {
            x: 50,
            y: canvas.height / 2,
            velocity: 0,
            radius: 15,  // Ukuran burung disesuaikan
            rotation: 0,
            width: 34,   // Ukuran asli sprite burung
            height: 24
        };

        let pipes = [];
        let score = 0;
        let frameCount = 0;
        let gameActive = false;
        let highScore = <?php echo $highScore; ?>;
        let bgX = 0;

        function drawBird() {
            ctx.save();
            ctx.translate(bird.x, bird.y);
            
            // Rotasi burung berdasarkan kecepatan
            bird.rotation = Math.min(Math.PI/4, Math.max(-Math.PI/4, bird.velocity * 0.1));
            ctx.rotate(bird.rotation);
            
            // Gambar burung
            ctx.drawImage(
                birdImg, 
                -bird.width/2, 
                -bird.height/2, 
                bird.width, 
                bird.height
            );
            
            ctx.restore();
        }

        function drawPipe(pipe) {
            // Gambar pipa atas (diputar 180 derajat)
            ctx.save();
            ctx.translate(pipe.x + pipe.width/2, pipe.top);
            ctx.rotate(Math.PI);
            ctx.drawImage(pipeTopImg, -pipe.width/2, 0, pipe.width, pipe.top);
            ctx.restore();
            
            // Gambar pipa bawah
            ctx.drawImage(
                pipeBottomImg, 
                pipe.x, 
                pipe.bottom, 
                pipe.width, 
                canvas.height - pipe.bottom
            );
        }

        function drawBackground() {
            // Gambar background bergerak
            bgX -= 0.5;
            if (bgX <= -canvas.width) bgX = 0;
            
            // Gambar background berulang
            ctx.drawImage(bgImg, bgX, 0, canvas.width, canvas.height);
            ctx.drawImage(bgImg, bgX + canvas.width, 0, canvas.width, canvas.height);

            // Gambar base bergerak
            baseX -= 2;
            if (baseX <= -canvas.width) baseX = 0;
            
            const baseHeight = 100;
            const baseY = canvas.height - baseHeight;
            
            // Gambar base berulang
            ctx.drawImage(baseImg, baseX, baseY, canvas.width, baseHeight);
            ctx.drawImage(baseImg, baseX + canvas.width, baseY, canvas.width, baseHeight);
        }

        function createPipe() {
            const minHeight = 50;
            const maxHeight = canvas.height - PIPE_GAP - minHeight - 100; // Dikurangi tinggi base
            const topHeight = Math.random() * (maxHeight - minHeight) + minHeight;

            return {
                x: canvas.width,
                top: topHeight,
                bottom: topHeight + PIPE_GAP,
                width: 52, // Lebar pipa disesuaikan dengan sprite
                counted: false
            };
        }

        function checkCollision(pipe) {
            // Collision box yang lebih akurat
            const birdBox = {
                left: bird.x - bird.width/3,
                right: bird.x + bird.width/3,
                top: bird.y - bird.height/3,
                bottom: bird.y + bird.height/3
            };

            const pipeBox = {
                top: {
                    left: pipe.x,
                    right: pipe.x + pipe.width,
                    top: 0,
                    bottom: pipe.top
                },
                bottom: {
                    left: pipe.x,
                    right: pipe.x + pipe.width,
                    top: pipe.bottom,
                    bottom: canvas.height
                }
            };

            // Cek collision dengan pipa atas dan bawah
            return (
                (birdBox.right > pipeBox.top.left &&
                birdBox.left < pipeBox.top.right &&
                birdBox.top < pipeBox.top.bottom) ||
                (birdBox.right > pipeBox.bottom.left &&
                birdBox.left < pipeBox.bottom.right &&
                birdBox.bottom > pipeBox.bottom.top) ||
                // Cek collision dengan base
                birdBox.bottom > canvas.height - 100
            );
        }

        function updateGame() {
            if (!gameActive) return;

            // Update bird
            bird.velocity += GRAVITY;
            bird.y += bird.velocity;

            // Create new pipes
            if (frameCount % PIPE_SPAWN_RATE === 0) {
                pipes.push(createPipe());
            }

            // Update pipes
            for (let i = pipes.length - 1; i >= 0; i--) {
                pipes[i].x -= PIPE_SPEED;

                // Score counting with animation
                if (!pipes[i].counted && pipes[i].x + pipes[i].width < bird.x) {
                    score++;
                    document.getElementById('currentScore').textContent = score;
                    // Animasi skor bertambah
                    document.getElementById('currentScore').style.transform = 'scale(1.2)';
                    setTimeout(() => {
                        document.getElementById('currentScore').style.transform = 'scale(1)';
                    }, 200);
                    pipes[i].counted = true;
                }

                if (pipes[i].x + pipes[i].width < 0) {
                    pipes.splice(i, 1);
                }

                if (checkCollision(pipes[i])) {
                    gameOver();
                    return;
                }
            }

            if (bird.y < 0 || bird.y > canvas.height) {
                gameOver();
                return;
            }

            frameCount++;
        }

        function drawGame() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw background
            drawBackground();

            // Draw pipes
            pipes.forEach(drawPipe);

            // Draw bird
            drawBird();

            // Update game state
            updateGame();

            if (gameActive) {
                requestAnimationFrame(drawGame);
            }
        }

        function flap() {
            if (gameActive) {
                bird.velocity = FLAP_STRENGTH;
                // Efek suara ketika mengepakkan sayap
                playSound('flap');
            }
        }

        function startGame() {
            gameActive = true;
            score = 0;
            pipes = [];
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            frameCount = 0;
            document.getElementById('currentScore').textContent = '0';
            document.getElementById('gameOver').style.display = 'none';
            drawGame();
            // Efek suara ketika memulai game
            playSound('start');
        }

        function gameOver() {
            gameActive = false;
            document.getElementById('finalScore').textContent = score;
            document.getElementById('gameOver').style.display = 'block';

            // Efek suara game over
            playSound('gameover');

            if (score > highScore) {
                highScore = score;
                document.getElementById('highScore').textContent = highScore;
                
                fetch('save_score.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        game: 'flappy_bird',
                        score: score
                    })
                });
            }
        }

        function playSound(type) {
            const sounds = {
                flap: 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/audio/wing.wav',
                start: 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/audio/swoosh.wav',
                gameover: 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/audio/hit.wav',
                point: 'https://raw.githubusercontent.com/sourabhv/FlapPyBird/master/assets/audio/point.wav'
            };
            
            if (sounds[type]) {
                const audio = new Audio(sounds[type]);
                audio.play().catch(e => console.log('Audio play failed:', e));
            }
        }

        function restartGame() {
            startGame();
        }

        // Event listeners
        window.addEventListener('keydown', (e) => {
            if (e.code === 'Space' || e.code === 'Enter') {
                e.preventDefault();
                // Jika game over, restart game
                if (!gameActive && document.getElementById('gameOver').style.display === 'block') {
                    restartGame();
                    return;
                }
                // Jika game sedang berjalan, flap
                if (gameActive) {
                    flap();
                }
            }
        });

        canvas.addEventListener('click', (e) => {
            // Jika game over, restart game
            if (!gameActive && document.getElementById('gameOver').style.display === 'block') {
                restartGame();
                return;
            }
            // Jika game sedang berjalan, flap
            if (gameActive) {
                flap();
            }
        });

        // Responsif canvas
        function resizeCanvas() {
            const container = document.querySelector('.game-container');
            const maxWidth = Math.min(container.clientWidth - 40, 400);
            const scale = maxWidth / 400;
            
            canvas.style.width = maxWidth + 'px';
            canvas.style.height = (600 * scale) + 'px';
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
    </script>
</body>
</html> 