<?php require __DIR__.'/config/db.php'; require __DIR__.'/includes/helpers.php';
session_unset();
session_destroy();
redirect('/hotel_booking/index.php');
?>
