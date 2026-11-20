
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION['user_id'];

if (empty($_SESSION['favorites_token'])) {
    $_SESSION['favorites_token'] = bin2hex(random_bytes(32));
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['csrf_token'] ?? '';

    if (
        !isset($_SESSION['favorites_token']) ||
        !hash_equals($_SESSION['favorites_token'], $token)
    ) {
        die("Қауіпсіздік қатесі!");
    }

    $carId = (int)($_POST['car_id'] ?? 0);

    if ($carId > 0) {
        $stmt = $pdo->prepare(
            "DELETE FROM favorites WHERE user_id = ? AND car_id = ?"
        );
        $stmt->execute([$userId, $carId]);

        $message = "Көлік таңдаулылардан өшірілді.";
    }
}

$sql = "SELECT c.*
        FROM favorites f
        INNER JOIN cars c ON f.car_id = c.id
        WHERE f.user_id = ?
        ORDER BY c.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$userId]);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таңдаулылар | AutoMarket</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .favorites-section {
            padding: 45px 7%;
            min-height: 500px;
        }

        .favorites-section h1 {
            margin-bottom: 25px;
            color: #343a29;
        }

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .favorite-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 18px #0000000d;
        }

        .favorite-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .favorite-info {
            padding: 20px;
        }

        .favorite-info h3 {
            margin-bottom: 10px;
        }

        .favorite-price {
            color: #697343;
            font-weight: bold;
            margin: 15px 0;
        }

        .favorite-info a,
        .favorite-info button {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 7px;
            background: #697343;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            margin: 4px 3px 0 0;
        }

        .favorite-info button {
            background: #858d5c;
        }

        .empty-favorites {
            padding: 35px;
            background: white;
            border-radius: 12px;
            text-align: center;
        }

        .empty-favorites a {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 20px;
            background: #697343;
            color: white;
            border-radius: 7px;
        }

        .message {
            margin-bottom: 20px;
            padding: 12px;
            background: #e8ebdc;
            border-radius: 7px;
        }

        @media (max-width: 800px) {
            .favorites-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 550px) {
            .favorites-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<section class="favorites-section">

    <h1>Таңдаулы автокөліктер</h1>

    <?php if ($message !== ""): ?>
        <div class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (count($cars) > 0): ?>

        <div class="favorites-grid">

            <?php foreach ($cars as $car): ?>

                <div class="favorite-card">

                    <?php
                    $image = $car['image'] ?? '';
                    $validImage = filter_var($image, FILTER_VALIDATE_URL)
                        && in_array(parse_url($image, PHP_URL_SCHEME), ['http', 'https']);
                    ?>

                    <?php if ($validImage): ?>
                        <img
                            src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Автокөлік"
                        >
                    <?php endif; ?>

                    <div class="favorite-info">

                        <h3>
                            <?= htmlspecialchars($car['brand'] . ' ' . $car['model'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p>
                            Жылы: <?= (int)$car['year'] ?>
                        </p>

                        <p>
                            Қала: <?= htmlspecialchars($car['city'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <p class="favorite-price">
                            <?= number_format((float)$car['price'], 0, '.', ' ') ?> ₸
                        </p>

                        <a href="car_detail.php?id=<?= (int)$car['id'] ?>">
                            Толығырақ
                        </a>

                        <form method="POST" action="favorites.php" style="display:inline;">
                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?= htmlspecialchars($_SESSION['favorites_token'], ENT_QUOTES, 'UTF-8') ?>"
                            >

                            <input
                                type="hidden"
                                name="car_id"
                                value="<?= (int)$car['id'] ?>"
                            >

                            <button type="submit">
                                Таңдаулылардан өшіру
                            </button>
                        </form>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty-favorites">
            <h3>Таңдаулы автокөліктер әзірге жоқ</h3>
            <p>Ұнаған көліктеріңізді таңдаулыларға қосыңыз.</p>
            <a href="index.php#cars">Автокөліктерді көру</a>
        </div>

    <?php endif; ?>

</section>

<?php include 'footer.php'; ?>

</body>
</html>
