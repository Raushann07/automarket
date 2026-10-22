
<?php
$projectName = "AutoMarket";
$description = "Автокөлік сату және сатып алу платформасы";

$features = [
    "Автокөліктерді қарау",
    "Автокөлік туралы хабарландыру қосу",
    "Маркасы мен бағасы бойынша іздеу",
    "Пайдаланушыны тіркеу және жүйеге кіру"
];
?>

<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $projectName ?></title>
</head>
<body>
    <h1><?= $projectName ?></h1>

    <h2><?= $description ?></h2>

    <p>
        Бұл жоба пайдаланушыларға автокөліктерді
        сатуға, сатып алуға және қажетті көлікті
        іздеуге мүмкіндік беретін веб-платформа.
    </p>

    <h3>Жобаның негізгі мүмкіндіктері:</h3>

    <ul>
        <?php foreach ($features as $feature): ?>
            <li><?= htmlspecialchars($feature) ?></li>
        <?php endforeach; ?>
    </ul>

    <p>Жоба PHP және MySQL технологиялары негізінде әзірленеді.</p>
</body>
</html>
