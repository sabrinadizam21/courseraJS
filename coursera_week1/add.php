<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
require_once "pdo.php";

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email'])
    && isset($_POST['headline']) && isset($_POST['summary'])) {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 ||
        strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All values are required';
        header("Location: add.php");
        return;
    } else {
        $stmt = $pdo->prepare('INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES (:uid, :fn, :ln, :em, :he, :su)');
        $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary'])
        );
        $_SESSION['success'] = "Record added.";
        header("Location: index.php");
        return;
    }

}
else{
    $_SESSION['fail']="All values are required";
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sabrina Diza M</title>
</head>
<body>
	<h1>Adding Profile for UMSI</h1>
	<form method="POST">
		<label><b>First Name</b></label>
		<input id="txt" type="text" name="first_name">
		<br><br>
		<label><b>Last Name</b></label>
		<input id="txt" type="text" name="last_name">
		<br><br>
		<label><b>Email</b></label>
		<input id="email" type="email" name="email">
		<br><br>
		<label><b>Headline</b></label>
		<input id="txt" type="text" name="headline">
		<br><br>
		<label><b>Summary</b></label> <br>
		<textarea id="txt" name="summary" rows="5" cols="50"> </textarea>
		<br><br>
		<input type="submit" onclick="return doValidate()" value="Add">
		<input type="submit" name="cancel" value="Cancel">
	</form>
<script type="text/javascript">
	function doValidate() {
		console.log('Validating...');
		try {
			addr = document.getElementById('email').value;
			txt = document.getElementById('id_1723').value;
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