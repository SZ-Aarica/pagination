<?php
session_start(); // شروع session

// تمام متغیرهای session را پاک کنید
$_SESSION = array();

// اگر session با کوکی ذخیره شده است، کوکی را نیز پاک کنید
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

// در نهایت session را نابود کنید
session_destroy();

// هدایت کاربر به صفحه اصلی یا صفحه ورود
header("Location: index.php");
exit;
