<?php
session_start();
if ($_SESSION['cart'][$_GET['id']]['quantity'] < 100) {
  $_SESSION['cart'][$_GET['id']]['quantity']++;
  header("location:cart.php?status=buy");
}