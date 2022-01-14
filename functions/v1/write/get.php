<?php
session_start();
if (!isset($_SESSION['out']['lines_out_set']) || $_SESSION['out']['lines_out_set'] == false) {
    die("Eroare");
}

foreach ($_SESSION['out']['lines'] as $line) {
    echo "$line\r\n";
}

die();
?>