<?php
include 'header.html.php';
?>
<h1>Personal Information</h1>
<div class="content">
	<h2>Personal Details</h2>
	  <table class="table table-hover">
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td>First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
      </table>
	<div>First name: <?php if(isset($firstname)){echo $firstname; }?></div>
	<div>Last name: <?php if(isset($lastname)){echo $lastname; }?></div>
	<div>Username: <?php if(isset($username)){echo $username; }?></div>
	<div>Email: <?php if(isset($email)){echo $email; }?></div>
	<div>Gender: <?php if(isset($gender)){echo $gender; }?></div>
	<div>Weight: <?php if(isset($weight)){echo $weight; }?></div>
	<div>Height: <?php if(isset($height)){echo $height; }?></div>

	
	<h2>Goal</h2>
	<div>Goal: <?php if(isset($goal)){echo $goal; }?></div>
	<div>Goal Weight: <?php if(isset($goalWeight)){echo $goalWeight; }?></div>
	<div>Calories Goal Intake per day: <?php if(isset($goalCalories)){echo $goalCalories; }?></div></br>
<form method="post">
	<input type="submit" class="btn btn-primary" value="Edit" name="EditPersonalInformation" />
</form>

<div class="form-group">
	      	
	      </div>
<?php 
	include 'footer.html.php';
?>