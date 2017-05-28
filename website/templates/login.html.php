<?php 
	include 'header.html.php';
?>
	<h1>Log in</h1>
	<?php 
		if(isset($_SESSION["registerCompleted"]))
		{
			echo "Thank you for choosing our website as your diet partner! You may now log in with your account";			
		}
	?>
	<form method="post" class="loginform">
		<label>Username:</label></br>
		<input type="text" name="username" /></br>
		
		<label>Password:</label></br>
		<input type="password" name="password" /></br></br>

		<input type="submit" value="Log in" name="LogIn" />
	</form>

<?php 
	include 'footer.html.php';
?>