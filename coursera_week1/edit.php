<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['first_name']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
    && isset($_POST['headline'])) {
    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Bad Email';
    } else {
        $sql = "UPDATE Profile SET first_name = :first_name, last_name = :last_name,email=:email,headline=:headline,summary=:summary
            WHERE profile_id = :profile_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':headline' => $_POST['headline'],
                ':summary' => $_POST['summary'],
                ':profile_id' => $_GET['profile_id'])
        );
        $_SESSION['success'] = 'Record updated';
        header('Location: index.php');
        return;
    }
}

if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
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
	<h1>Editing Profile for UMSI</h1>
	<form method="POST">
		<label><b>First Name</b></label>
		<input id="txt" type="text" name="first_name" value="<?php echo $row['first_name'] ?>" />
		<br><br>
		<label><b>Last Name</b></label>
		<input id="txt" type="text" name="last_name" value="<?php echo $row['last_name'] ?>" />
		<br><br>
		<label><b>Email</b></label>
		<input  id="email" type="email" name="email" value="<?php echo $row['email'] ?>" />
		<br><br>
		<label><b>Headline</b></label>
		<input id="txt" type="text" name="headline" value="<?php echo $row['headline'] ?>" />
		<br><br>
		<label><b>Summary</b></label>
		<input id="txt" type="textarea" name="summary" value="<?php echo $row['summary'] ?>" />
		<br><br>
		<input type="submit" onclick="return doValidate();" value="Save">
		<input type="submit" name="cancel" value="Cancel">
	</form>
<script type="text/javascript">
	function doValidate() {
		console.log('Validating...');
		try {
			addr = document.getElementById('email').value;
			txt = document.getElementById('txt').value;
			if (addr == null || addr == "" || txt == null || txt == "") {
				alert("All fields are required");
				return false;
			}
			if (addr.indexOf('@') == -1){
				alert("Email address must contain @");
			}
			return true;
		} catch(e) {
			return false;
		}
		return false;
	}
</script>
</body>
</html>