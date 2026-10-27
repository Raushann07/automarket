
<?php
$cars = [
    [
        "name" => "Toyota Camry 70",
        "year" => 2021,
        "price" => 14500000,
        "city" => "Алматы",
        "image" => "https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=800&q=80"
    ],
    [
        "name" => "Mercedes-Benz E-Class",
        "year" => 2020,
        "price" => 18900000,
        "city" => "Астана",
        "image" => "https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800&q=80"
    ],
    [
        "name" => "BMW 5 Series",
        "year" => 2022,
        "price" => 22000000,
        "city" => "Алматы",
        "image" => "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=800&q=80"
    ]
];
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoMarket — Автокөлік нарығы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="header">
    <a href="index.php" class="logo">Auto<span>Market</span></a>

    <nav>
        <a href="index.php">Басты бет</a>
        <a href="#cars">Автокөліктер</a>
        <a href="login.php">Кіру</a>
        <a href="register.php" class="register-btn">Тіркелу</a>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <p class="subtitle">СЕНІМДІ АВТОКӨЛІК НАРЫҒЫ</p>
        <h1>Өзіңе лайық көлікті<br>оңай тап</h1>
        <p class="description">
            Автокөліктерді салыстыр, хабарландыруларды қара
            және өз көлігіңді тиімді сат.
        </p>

        <a href="#cars" class="main-btn">Көліктерді қарау</a>
    </div>
</section>

<section class="search-section">
    <h2>Өзіңе лайық көлікті ізде</h2>

    <div class="search-box">
        <input type="text" id="searchInput"
               placeholder="Көлік маркасын енгіз...">

        <select id="yearFilter">
            <option value="">Барлық жыл</option>
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
        </select>

        <button id="searchBtn">Іздеу</button>
    </div>
</section>

<main class="cars-section" id="cars">
    <div class="section-heading">
        <div>
            <p class="subtitle">БІЗДІҢ ҰСЫНЫСТАР</p>
            <h2>Таңдаулы автокөліктер</h2>
        </div>

        <a href="login.php" class="sell-btn">+ Көлік сату</a>
    </div>

    <div class="cars-grid" id="carsGrid">
        <?php foreach ($cars as $car): ?>
            <article class="car-card"
                     data-name="<?= htmlspecialchars($car['name']) ?>"
                     data-year="<?= $car['year'] ?>">

                <img src="<?= htmlspecialchars($car['image']) ?>"
                     alt="<?= htmlspecialchars($car['name']) ?>">

                <div class="car-info">
                    <p class="car-year"><?= $car['year'] ?> жыл</p>

                    <h3><?= htmlspecialchars($car['name']) ?></h3>

                    <p class="car-city">
                        <?= htmlspecialchars($car['city']) ?>
                    </p>

                    <div class="car-bottom">
                        <strong>
                            <?= number_format($car['price'], 0, '.', ' ') ?> ₸
                        </strong>

                        <a href="car_detail.php">Толығырақ →</a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <p id="emptyMessage" class="empty-message" hidden>
        Іздеу бойынша автокөлік табылмады.
    </p>
</main>

<footer class="footer">
    <a href="index.php" class="logo">Auto<span>Market</span></a>
    <p>© 2026 AutoMarket. Автокөлік нарығы.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
