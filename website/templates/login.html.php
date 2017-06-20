<?php 
	include 'header.html.php';
?>
	<h1>Log in</h1>
	<div class="content">
	<?php 
		if(isset($_SESSION["registerCompleted"]))
		{
			echo "Thank you for choosing our website as your diet partner! You may log in with your account";			
		}
		
	?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		
		
		<div class="form-group">
		    <label>Username:</label>
			<input type="text" value="<?php if(isset($username)){echo  htmlspecialchars($username); }?>" name="username" class="form-control"/>
		 </div>
		 <div class="form-group">
			<label>Password:</label>
			<input type="password" class="form-control" value="<?php if(isset($password)){echo  htmlspecialchars($password); }?>" name="password" />
		</div>
			<input type="submit" class="btn btn-success" value="Log in" name="LogIn" />
			<a href="/" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<div class="forgotPassword">
		<a href="/forgotPassword">Forgot password?</a>
	</div>
	
<?php 
	include 'footer.html.php';
?>