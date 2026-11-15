
<?php
session_start();

require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brand = trim($_POST["brand"] ?? "");
    $model = trim($_POST["model"] ?? "");
    $year = (int)($_POST["year"] ?? 0);
    $price = (float)($_POST["price"] ?? 0);
    $city = trim($_POST["city"] ?? "");
    $image = trim($_POST["image"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($brand === "" || $model === "" || $city === "") {
        $message = "Барлық міндетті өрістерді толтырыңыз.";
    } elseif ($year < 1990 || $year > 2026) {
        $message = "Шыққан жылын дұрыс енгізіңіз.";
    } elseif ($price <= 0) {
        $message = "Бағасын дұрыс енгізіңіз.";
    } else {
        $sql = "INSERT INTO cars
                (user_id, brand, model, year, price, city, image, description)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $_SESSION['user_id'],
            $brand,
            $model,
            $year,
            $price,
            $city,
            $image,
            $description
        ]);

        $message = "Автокөлік сәтті қосылды!";
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автокөлік қосу - AutoMarket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="search-section">
    <h2>Жаңа автокөлік қосу</h2>

    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" class="search-box" style="flex-direction: column; max-width: 600px;">

        <input type="text" name="brand" placeholder="Маркасы (мысалы, Toyota)" required>

        <input type="text" name="model" placeholder="Моделі (мысалы, Camry 70)" required>

        <input type="number" name="year" placeholder="Шыққан жылы" min="1990" max="2026" required>

        <input type="number" name="price" placeholder="Бағасы (теңге)" min="1" required>

        <input type="text" name="city" placeholder="Қала" required>

        <input type="text" name="image" placeholder="Сурет сілтемесі">

        <textarea name="description" placeholder="Автокөлік туралы сипаттама" rows="5"></textarea>

        <button type="submit">Автокөлікті қосу</button>

    </form>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
