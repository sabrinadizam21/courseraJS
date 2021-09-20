<?php
session_start();
require_once "pdo.php";

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sabrina Diza M</title>
</head>
<body>
	<h1>Profile information</h1>
	<p>First Name : <?php echo($row['first_name']); ?></p>
	<p>Last Name : <?php echo($row['last_name']); ?></p>
	<p>Email : <?php echo($row['email']); ?></p>
	<p>Headline : </p>
	<p><?php echo($row['headline']); ?></p>
	<p>Summary : </p>
	<p><?php echo($row['summary']); ?></p>
	<a href="index.php">Done</a>
</body>
</html>