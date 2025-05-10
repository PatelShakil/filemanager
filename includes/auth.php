<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}
?>
