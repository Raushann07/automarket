
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Сессия мәліметтерін тазалау
$_SESSION = [];

// Cookie жою
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Сессияны аяқтау
session_destroy();

// Кіру бетіне өту
header("Location: login.php");
exit;
