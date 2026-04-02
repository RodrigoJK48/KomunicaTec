<?php
require_once __DIR__ . '/../includes/auth.php';
logout();
header('Location: /komunicatec/index.php'); // ou /komunicatec/view/login.php
exit;
