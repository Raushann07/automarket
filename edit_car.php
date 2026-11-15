
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Автокөлік табылмады немесе оны өзгертуге рұқсатыңыз жоқ!");
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
        $sql = "UPDATE cars
                SET brand = ?, model = ?, year = ?, price = ?,
                    city = ?, image = ?, description = ?
                WHERE id = ? AND user_id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $brand, $model, $year, $price,
            $city, $image, $description,
            $id, $_SESSION['user_id']
        ]);

        header("Location: car_detail.php?id=" . $id);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автокөлікті өзгерту - AutoMarket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="search-section">
    <h2>Автокөлік мәліметтерін өзгерту</h2>

    <?php if ($message !== ""): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" class="search-box"
          style="flex-direction: column; max-width: 600px;">

        <input type="text" name="brand"
               value="<?= htmlspecialchars($car['brand']) ?>"
               placeholder="Маркасы" required>

        <input type="text" name="model"
               value="<?= htmlspecialchars($car['model']) ?>"
               placeholder="Моделі" required>

        <input type="number" name="year"
               value="<?= (int)$car['year'] ?>"
               min="1990" max="2026" required>

        <input type="number" name="price"
               value="<?= htmlspecialchars((string)$car['price']) ?>"
               min="1" required>

        <input type="text" name="city"
               value="<?= htmlspecialchars($car['city']) ?>"
               placeholder="Қала" required>

        <input type="text" name="image"
               value="<?= htmlspecialchars($car['image'] ?? '') ?>"
               placeholder="Сурет сілтемесі">

        <textarea name="description" rows="5"
                  placeholder="Сипаттамасы"><?= htmlspecialchars($car['description'] ?? '') ?></textarea>

        <button type="submit">Өзгерістерді сақтау</button>
    </form>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
