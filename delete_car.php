
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$userId = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare(
    "DELETE FROM cars WHERE id = ? AND user_id = ?"
);

$stmt->execute([$id, $userId]);

header("Location: index.php");
exit;
?>
