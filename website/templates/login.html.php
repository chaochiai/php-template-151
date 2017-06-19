<?php 
	include 'header.html.php';
?>
	<h1>Log in</h1>
	<?php 
		if(isset($_SESSION["registerCompleted"]))
		{
			echo "Thank you for choosing our website as your diet partner! You may log in with your account";			
		}
		
	?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<label>Username:</label></br>
		<input type="text" value="<?php if(isset($username)){echo  htmlspecialchars($username); }?>" name="username" /></br>
		
		<label>Password:</label></br>
		<input type="password" value="<?php if(isset($password)){echo  htmlspecialchars($password); }?>" name="password" /></br></br>

		<input type="submit" value="Log in" name="LogIn" />
	</form>
	<a href="/forgotPassword">Forgot password?</a>
<?php 
	include 'footer.html.php';
?>