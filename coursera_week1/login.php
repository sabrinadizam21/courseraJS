<?php
session_start();
require_once "pdo.php";
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
if (isset($_POST['pass']) && isset($_POST['email'])) {
    $check = hash('md5', $salt . $_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sabrina Diza M</title>
</head>
<body>
	<h1>Please Log In</h1>
	<?php
    if (isset($_SESSION['error'])) {
        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    ?>
	<form method="POST" action="login.php">
		<label><b>Email</b></label>
		<input type="email" name="email" id="email">
		<br><br>
		<label><b>Password</b></label>
		<input type="password" name="pass" id="id_1723">
		<br><br>
		<input type="submit" onclick="return doValidate();" value="Log In">
		<input type="submit" name="cancel" value="Cancel">
	</form>
	<p>For a password hint, view source and find an account and password hint in the HTML comments.</p>
	<!--Hint: The password is the four character sound a cat makes (all lower case) followed by 123.-->

	<script type="text/javascript">
		function doValidate() {
	        console.log('Validating...');
	        try {
	        	addr = document.getElementById('email').value;
	            pw = document.getElementById('id_1723').value;
	            console.log("Validating password="+pw);
				if (addr == null || addr == "" || pw == null || pw == "") {
	                alert("Both fields must be filled out");
	                return false;
	            }
	            if (addr.indexOf('@') == -1){
	            	alert("Invalid Email addres");
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