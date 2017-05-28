<?php 
	include 'header.html.php';
?>
<h1>Register</h1>
<form method="post">
	<h2>Personal Details</h2>
	
	<label>First name:</label></br>
	<input type="text" name="firstname" /></br>
	
	<label>Last name:</label></br>
	<input type="text" name="lastname" /></br>
	
	<label>Username:</label></br>
	<input type="text" name="username" /></br>
	
	<label>Email:</label></br>
	<input type="text" name="email" /></br>
	
	<label>Password:</label></br>
	<input type="password" name="password" /></br>
	
	<label>Gender:</label></br>
	<input type="radio" name="gender" value="female"> Female<br>
	<input type="radio" name="gender" value="male" checked> Male<br>
	
	<label>Weight:</label></br>
	<input type="text" name="weight" /></br>
	
	<label>Height:</label></br>
	<input type="text" name="height" /></br>
	
	<h2>Goal</h2>
	
	<label>Goal Weight:</label></br>
	<input type="text" name="goalWeight" /></br></br>
	
	<input type="submit" value="Register" name="Register" />
</form>
<?php 
	include 'footer.html.php';
?>