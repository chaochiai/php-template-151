<?php 
	include 'header.html.php';
?>
<h1>Register</h1>
<form method="post">
	<h2>Personal Details</h2>
	
	<label>First name:</label></br>
	<input type="text" value="<?php if(isset($firstname)){echo $firstname; }?>" name="firstname" /></br>
	
	<label>Last name:</label></br>
	<input type="text" value="<?php if(isset($lastname)){echo $lastname; }?>" name="lastname" /></br>
	
	<label>Username:</label></br>
	<input type="text" value="<?php if(isset($username)){echo $username; }?>" name="username" /></br>
	
	<label>Email:</label></br>
	<input type="text" value="<?php if(isset($email)){echo $email; }?>" name="email" /></br>
	
	<label>Password:</label></br>
	<input type="password" value="<?php if(isset($password)){echo $password; }?>" name="password" /></br>
	
	<label>Gender:</label></br>
	<input type="radio" name="gender" value="female"> Female<br>
	<input type="radio" name="gender" value="male" checked> Male<br>
	
	<label>Weight:</label></br>
	<input type="text" value="<?php if(isset($weight)){echo $weight; }?>" name="weight" /></br>
	
	<label>Height:</label></br>
	<input type="text" value="<?php if(isset($height)){echo $height; }?>" name="height" /></br>
	
	<h2>Goal</h2>
	
	<label>Goal:</label></br>
	<input type="radio" name="Goal" value="Lose Weight"> Lose Weight<br>
	<input type="radio" name="Goal" value="Maintain Weight" checked> Maintain Weight<br>
	<input type="radio" name="Goal" value="Gain Weight"> Gain Weight<br>
	
	<label>Goal Weight:</label></br>
	<input type="text" value="<?php if(isset($goalWeight)){echo $goalWeight; }?>" name="goalWeight" /></br>
	
	<label>Calories Goal Intake per day:</label></br>
	<input type="text" value="<?php if(isset($goalCalories)){echo $goalCalories; }?>" name="goalCalories" /></br></br>
	
	<input type="submit" value="Register" name="Register" />
</form>
<?php 
	include 'footer.html.php';
?>