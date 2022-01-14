<?php
if (!isset($_GET['var'])) {
    die("false");
}
if (!isset($_GET['value'])) {
    die("false");
}

session_start();
$_SESSION['variabile'][$_GET['var']] = $_GET['value'];
die("true");
?>