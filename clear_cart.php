<?php
require_once __DIR__ . '/lib/helpers.php';
start_session_once();
unset($_SESSION['cart']);
header('Location: cart.php');
