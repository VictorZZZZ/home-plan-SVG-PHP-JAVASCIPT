<?php
session_start();
$_SESSION['formStarted'] = true;
require_once "vendor/ZVV/Secure.php";
$secure = new Secure();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Develop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/tooltipster.bundle.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="css/lightbox.css" type="text/css" media="all" />

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/tooltipster.bundle.min.js"></script>
</head>
<body>

<!--ZVV Code-->

<?php
include_once 'floors_piece.php';
?>

<!--ZVV Code-->

<script src="js/bootstrap.min.js"></script>
<script src="js/lightbox.js"></script>
</body>
</html>