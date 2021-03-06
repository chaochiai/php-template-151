<?php
include 'header.html.php';
?>
<h1>Personal Information</h1>
<div class="content">
	<div class="validation">
	<?php 	 if (isset($_SESSION["errorDeleteAccount"])) {
						echo $_SESSION['errorDeleteAccount'];
						unset($_SESSION['errorDeleteAccount']);
					}?>
	</div>
	<h2>Personal Details</h2>
	  <table class="table table-hover">
	      <tr>
	      	<td class="tdrp">First name:</td>
	        <td><?php if(isset($firstname)){echo $firstname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Last name:</td>
	        <td><?php if(isset($lastname)){echo $lastname; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Username:</td>
	        <td><?php if(isset($username)){echo $username; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Email:</td>
	        <td><?php if(isset($email)){echo $email; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Gender:</td>
	        <td><?php if(isset($gender)){echo $gender; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Weight:</td>
	        <td><?php if(isset($weight)){echo $weight; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Height:</td>
	        <td><?php if(isset($height)){echo $height; }?></td> 	  
	      </tr>
      </table>

	<h2>Goal</h2>
	<table class="table table-hover">
	      <tr>
	      	<td class="tdrp">Goal:</td>
	        <td><?php if(isset($goal)){echo $goal; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Goal Weight:</td>
	        <td><?php if(isset($goalWeight)){echo $goalWeight; }?></td> 	  
	      </tr>
	      <tr>
	      	<td class="tdrp">Calories Goal Intake per day:</td>
	        <td><?php if(isset($goalCalories)){echo $goalCalories; }?></td> 	  
	      </tr>
      </table>
<div>
	<a href="/editAccount" class="btn btn-primary" name="edit">Edit</a>
	<a onclick="confirmDeleteAccount()" class="btn btn-primary" name="delete">Delete</a>

	<form method="post" class="loginform"  id="deleteForm">
	</form>
</div>
<script>
 	function confirmDeleteAccount() {
 	    var dialog = confirm("Your account and all of your data will be deleted. Do you really want to delete your account?");
 	    if (dialog == true) {
 			setTimeout("submitForm()");
 	    }
 	}
 
 	function submitForm() {	
 		var form = document.getElementById("deleteForm");
 		form.submit();
 	}
 </script>
<?php 
	include 'footer.html.php';
?>