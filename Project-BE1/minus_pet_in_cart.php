<?php
session_start();
if ($_SESSION['cart'][$_GET['id']]['quantity'] > 1) {
  $_SESSION['cart'][$_GET['id']]['quantity']--;
  header("location:cart.php?status=buy"); 
} else if ($_SESSION['cart'][$_GET['id']]['quantity'] == 1) {
  unset($_SESSION['cart'][$_GET['id']]);
  header("location:cart.php?status=buy");  
}