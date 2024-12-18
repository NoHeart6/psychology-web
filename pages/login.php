<?php
require_once('../includes/db.php');
require_once('../includes/auth.php');

requireGuest();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    try {
        $user = $users->findOne(['email' => $email]);
        
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = (string)$user->_id;
            $_SESSION['user_name'] = $user->name;
            header('Location: home.php');
            exit;
        } else {
            $error = "Email atau password salah";
        }
    } catch (Exception $e) {
        $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Journey to Better Self</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: rgba(15, 23, 42, 0.95);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
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
            background: rgba(255, 255, 255, 0.1);
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .auth-container {
            background: rgba(30, 41, 59, 0.8);
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            position: relative;
            z-index: 1;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }

        .form-group i {
            position: absolute;
            left: 1rem;
            top: 2.3rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.1);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: #ff6b6b;
            padding: 0.8rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(220, 53, 69, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, #4A90E2, #5C6BC0);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            background: linear-gradient(45deg, #5C6BC0, #4A90E2);
            transform: translateY(-1px);
        }

        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .auth-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .auth-links a:hover {
            color: #5C6BC0;
        }

        .background-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: linear-gradient(45deg, rgba(74, 144, 226, 0.1), rgba(92, 107, 192, 0.1));
            border-radius: 50%;
            animation: float 20s infinite;
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 50%;
            right: -100px;
            animation-delay: -5s;
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: -75px;
            right: 10%;
            animation-delay: -10s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -50px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .nav-brand {
                margin: 0 auto;
            }

            .auth-container {
                padding: 2rem;
            }

            .auth-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php" class="nav-brand">
            <i class="fas fa-road"></i>
            Journey to Better Self
        </a>
        <ul class="nav-links">
            <li><a href="home.php"><i class="fas fa-home"></i> Beranda</a></li>
            <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Masuk</a></li>
            <li><a href="register.php"><i class="fas fa-user-plus"></i> Daftar</a></li>
        </ul>
    </nav>

    <main>
        <div class="background-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="auth-container">
            <div class="auth-header">
                <h1>Selamat Datang Kembali</h1>
                <p>Masuk untuk melanjutkan perjalanan pengembangan dirimu</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Masukkan email anda" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Masukkan password anda" required>
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk
                </button>
            </form>

            <div class="auth-links">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        </div>
    </main>
</body>
</html> 