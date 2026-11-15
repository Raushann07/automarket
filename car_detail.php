
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    die("Автокөлік табылмады!");
}

$userId = (int)($_SESSION['user_id'] ?? 0);
$ownerId = (int)$car['user_id'];

$isOwner = ($userId > 0 && $userId === $ownerId);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автокөлік туралы - AutoMarket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="search-section">
    <div class="car-card" style="max-width:750px; margin:30px auto; padding:25px;">

        <?php if (!empty($car['image'])): ?>
            <img
                src="<?= htmlspecialchars($car['image']) ?>"
                alt="Автокөлік суреті"
                style="width:100%; max-height:400px; object-fit:cover;"
            >
        <?php endif; ?>

        <div class="car-info">

            <h2>
                <?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?>
            </h2>

            <p>Шыққан жылы: <?= (int)$car['year'] ?></p>

            <p>Бағасы:
                <strong>
                    <?= number_format((float)$car['price'], 0, '.', ' ') ?> ₸
                </strong>
            </p>

            <p>Қала: <?= htmlspecialchars($car['city']) ?></p>

            <p>Сипаттамасы:
                <?= nl2br(htmlspecialchars($car['description'] ?? 'Ақпарат жоқ')) ?>
            </p>

            <p style="color:gray; font-size:13px;">
                Кірген қолданушы ID: <?= $userId ?> |
                Көлік иесінің ID: <?= $ownerId ?>
            </p>

            
<?php if ($isOwner): ?>

    <a href="edit_car.php?id=<?= (int)$car['id'] ?>"
       class="hero-button">
        Өзгерту
    </a>

    <form action="delete_car.php" method="POST"
          onsubmit="return confirm('Бұл автокөлікті өшіргіңіз келе ме?');"
          style="display:inline;">

        <input type="hidden" name="id"
               value="<?= (int)$car['id'] ?>">

        <button type="submit" class="hero-button"
                style="background:#dc3545; border:none; cursor:pointer;">
            Өшіру
        </button>
    </form>

<?php endif; ?>


            <a href="index.php" class="hero-button">
                Басты бетке қайту
            </a>

        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
