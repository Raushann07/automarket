
<?php
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($name === "" || $email === "" ||
        $password === "" || $confirm === "") {
        $message = "Барлық өрісті толтырыңыз.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Email мекенжайын дұрыс енгізіңіз.";
    } elseif (strlen($password) < 8) {
        $message = "Құпиясөз кемінде 8 таңба болуы керек.";
    } elseif ($password !== $confirm) {
        $message = "Құпиясөздер сәйкес келмейді.";
    } else {
        $message = "Форма сәтті толтырылды!";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тіркелу | AutoMarket</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #202938;
        }

        header {
            background: white;
            padding: 22px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            text-decoration: none;
            color: #202938;
        }

        .logo span {
            color: #ed4d3d;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #202938;
        }

        .container {
            max-width: 500px;
            margin: 45px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px #0000000d;
        }

        h1 {
            margin-bottom: 10px;
        }

        .intro {
            color: #788394;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 17px;
            font-weight: bold;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-top: 8px;
            border: 1px solid #dfe3e9;
            border-radius: 7px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 25px;
            border: none;
            border-radius: 7px;
            background: #ed4d3d;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #d93d30;
        }

        .message {
            padding: 12px;
            background: #fff0ec;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .bottom {
            text-align: center;
            margin-top: 22px;
            font-size: 14px;
        }

        .bottom a {
            color: #ed4d3d;
            text-decoration: none;
            font-weight: bold;
        }

        footer {
            background: #151b26;
            color: white;
            padding: 22px;
            text-align: center;
        }
    </style>
</head>

<body>

<header>
    <a href="index.php" class="logo">
        Auto<span>Market</span>
    </a>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="index.php#cars">Автокөліктер</a>
        <a href="login.php">Кіру</a>
    </nav>
</header>

<div class="container">
    <h1>Тіркелу</h1>

    <p class="intro">
        AutoMarket платформасына тіркеліп,
        өзіңізге қажетті автокөлікті табыңыз.
    </p>

    <?php if ($message !== ""): ?>
        <div class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label>Аты-жөніңіз</label>
        <input
            type="text"
            name="name"
            placeholder="Атыңызды енгізіңіз"
            required
            minlength="2"
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            placeholder="name@example.com"
            required
        >

        <label>Құпиясөз</label>
        <input
            type="password"
            name="password"
            placeholder="Кемінде 8 таңба"
            minlength="8"
            required
        >

        <label>Құпиясөзді қайталаңыз</label>
        <input
            type="password"
            name="confirm_password"
            placeholder="Құпиясөзді қайталаңыз"
            minlength="8"
            required
        >

        <button type="submit">Тіркелу</button>
    </form>

    <p class="bottom">
        Аккаунтыңыз бар ма?
        <a href="login.php">Жүйеге кіру</a>
    </p>
</div>

<footer>
    © 2026 AutoMarket. Оқу жобасы.
</footer>

</body>
</html>
