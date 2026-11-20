
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

$stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Қолданушы табылмады!");
}
?>

<?php include 'header.php'; ?>

<style>
.profile-section {
    min-height: 650px;
    padding: 60px 20px;
    background: #f7f7f7;
    text-align: center;
}

.profile-title {
    font-size: 34px;
    margin-bottom: 35px;
    color: #222;
}

.profile-card {
    max-width: 550px;
    margin: auto;
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.profile-avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: #ed4d3d;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    font-weight: bold;
}

.profile-card h2 {
    font-size: 25px;
    color: #222;
    margin-bottom: 30px;
}

.profile-info {
    text-align: left;
    padding: 15px 20px;
    margin-bottom: 15px;
    background: #f8f8f8;
    border-radius: 10px;
}

.profile-info span {
    display: block;
    color: #888;
    font-size: 14px;
    margin-bottom: 7px;
}

.profile-info p {
    color: #222;
    font-size: 16px;
    font-weight: 600;
    margin: 0;
    overflow-wrap: anywhere;
}

.profile-button {
    display: inline-block;
    margin-top: 20px;
    padding: 13px 30px;
    background: #ed4d3d;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

.profile-button:hover {
    background: #cc382c;
    transform: translateY(-2px);
}
</style>

<section class="profile-section">

    <h1 class="profile-title">Менің профилім</h1>

    <div class="profile-card">

        <div class="profile-avatar">
            <?= strtoupper(mb_substr($user['name'], 0, 1, 'UTF-8')) ?>
        </div>

        <h2><?= htmlspecialchars($user['name']) ?></h2>

        <div class="profile-info">
            <span>Қолданушы ID</span>
            <p><?= (int)$user['id'] ?></p>
        </div>

        <div class="profile-info">
            <span>Аты-жөні</span>
            <p><?= htmlspecialchars($user['name']) ?></p>
        </div>

        <div class="profile-info">
            <span>Email мекенжайы</span>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>

        <a href="index.php" class="profile-button">
            Басты бетке оралу
        </a>

    </div>

</section>

<?php include 'footer.php'; ?>
