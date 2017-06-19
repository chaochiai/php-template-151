<?php
include 'header.html.php';
?>
	<h1>Forgot password</h1>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		You will receive an email to reset your password.
		<label>Please enter your email:</label></br>
		<input type="text" value="<?php if(isset($email)){echo  htmlspecialchars($email); }?>" name="email" /></br>
		<input type="submit" value="Enter" name="forgotPassword" />
	</form>
<?php 
	include 'footer.html.php';
?>