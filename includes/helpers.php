<?php
function is_logged_in() { return isset($_SESSION['user_id']); }
function require_login() { if (!is_logged_in()) { $r = urlencode($_SERVER['REQUEST_URI']); header("Location: /hotel_booking/login.php?redirect=$r"); exit; } }
function h($s) { return htmlspecialchars(($s !== null ? $s : ''), ENT_QUOTES, 'UTF-8'); }
function redirect($path) { header("Location: $path"); exit; }
function post($key, $default='') { return isset($_POST[$key]) ? $_POST[$key] : $default; }
function get($key, $default='') { return isset($_GET[$key]) ? $_GET[$key] : $default; }
function nights_between($in, $out) { $a = new DateTime($in); $b = new DateTime($out); $i = $a->diff($b)->days; return max(1, $i); }
?>
