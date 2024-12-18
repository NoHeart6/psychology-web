<?php
require_once('../includes/db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi
    $errors = [];
    
    if (strlen($password) < 8) {
        $errors[] = "Password harus minimal 8 karakter";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Password tidak cocok";
    }
    
    // Cek email sudah terdaftar
    $existing_user = $users->findOne(['email' => $email]);
    if ($existing_user) {
        $errors[] = "Email sudah terdaftar";
    }
    
    if (empty($errors)) {
        try {
            $result = $users->insertOne([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ]);
            
            if ($result->getInsertedCount() > 0) {
                $_SESSION['user_id'] = (string)$result->getInsertedId();
                $_SESSION['user_name'] = $name;
                header('Location: home.php');
                exit;
            }
        } catch (Exception $e) {
            $errors[] = "Terjadi kesalahan. Silakan coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Journey to Better Self</title>
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

        .error-list {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            color: #ff6b6b;
        }

        .error-list ul {
            margin: 0;
            padding-left: 1.5rem;
            list-style-type: none;
        }

        .error-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .error-list li::before {
            content: "\f071";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            color: #ff6b6b;
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

        .password-requirements {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .password-requirements ul {
            margin: 0.5rem 0 0;
            padding-left: 1.5rem;
        }

        .password-requirements li {
            margin: 0.3rem 0;
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
                <h1>Mulai Perjalananmu</h1>
                <p>Daftar untuk memulai perjalanan pengembangan dirimu</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" required 
                           placeholder="Masukkan nama lengkap anda"
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" required
                           placeholder="Masukkan email anda"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required
                           placeholder="Masukkan password anda">
                </div>

                <div class="password-requirements">
                    <i class="fas fa-info-circle"></i> Persyaratan Password:
                    <ul>
                        <li>Minimal 8 karakter</li>
                        <li>Kombinasi huruf dan angka</li>
                        <li>Minimal satu huruf kapital</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirm_password" name="confirm_password" required
                           placeholder="Masukkan ulang password anda">
                </div>

                <button type="submit" class="btn">
                    <i class="fas fa-user-plus"></i>
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-links">
                <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
            </div>
        </div>
    </main>
</body>
</html> 