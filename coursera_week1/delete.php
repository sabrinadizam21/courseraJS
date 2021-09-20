<?php
session_start();
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
require_once "pdo.php";
if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    echo 23132;
    $sql = "DELETE FROM Profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}
if ( ! isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}
$stmt = $pdo->prepare("SELECT first_name, last_name FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile id';
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sabrina Diza M</title>
</head>
<body>
	<h1>Deleteing Profile</h1>
	<p>First Name : <?php echo($row['first_name']); ?> </p>
	<p>Last Name : <?php echo($row['last_name']); ?> </p>
	<form method="POST">
		<input type="hidden" name="profile_id" value="<?php echo $_GET['profile_id'] ?>">
		<input type="submit" onclick="return confirm('Delete this profile?')" value="Delete" name="delete">
		<input type="submit" name="cancel" value="Cancel">
	</form>
<script type="text/javascript">
    function ConfirmDelete() {
        if (confirm('Delete this profile?')) {
            location.name = 'delete';
        }
    }
</script>
</body>
</html>