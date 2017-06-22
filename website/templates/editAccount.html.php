<?php
include 'header.html.php';
?>
<h1>Edit Account</h1>
<div class="content">
<form method="post" class="form">
<div class="validation">
<?php 	 if (isset($_SESSION["empFieldsVal"])) {
					echo $_SESSION['empFieldsVal'];
					unset($_SESSION['empFieldsVal']);
				}if (isset($_SESSION["intFieldsVal"])) {
					echo $_SESSION['intFieldsVal'];
					unset($_SESSION['intFieldsVal']);
				}?>
</div>

	<div class="form-group">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<h2>Personal Details</h2>
	</div>
	
	<div class="form-group">
	<label>First name:</label>
	<input class="form-control" type="text" value="<?php if(isset($firstname)){echo  htmlspecialchars($firstname); }?>" name="firstname" />
	</div>
	
	<div class="form-group">
	<label>Last name:</label>
	<input class="form-control" type="text" value="<?php if(isset($lastname)){echo  htmlspecialchars($lastname); }?>" name="lastname" />
	</div>
	
	<div class="form-group">
	<label>Username:</label>
	<input class="form-control" type="text" value="<?php if(isset($username)){echo  htmlspecialchars($username); }?>" name="username" />
	</div>
	
	<div class="form-group">
	<label>Email:</label>
	<input class="form-control" type="text" value="<?php if(isset($email)){echo  htmlspecialchars($email); }?>" name="email" />
	</div>
	
	<div class="form-group">
	<label>Gender:</label>
	<div>
		<input  type="radio" name="gender" value="female" <?php if(isset($gender)){ if($gender === "female"){ echo "checked";} } ?>> Female
	</div>
	<div>
		<input  type="radio" name="gender" value="male" <?php if(isset($gender)){ if($gender === "male"){ echo "checked";} }?> > Male
	</div>
	
	</div>
	
	<div class="form-group">
	<label>Weight (kg):</label>
	<input class="form-control" type="text" value="<?php if(isset($weight)){echo  htmlspecialchars($weight); }?>" name="weight" />
	</div>
	
	<div class="form-group">
	<label>Height (cm):</label>
	
	<input class="form-control" type="text" value="<?php if(isset($height)){echo  htmlspecialchars($height); }?>" name="height" />
	</div>
	
	<h2>Goal</h2>
	
	<div class="form-group">
	<label>Goal:</label>
	<div>
		<input type="radio" name="Goal" value="Lose Weight" <?php if(isset($Goal)){ if($Goal === "Lose Weight"){ echo "checked";} }?>> Lose Weight
	</div>
	<div>
		<input  type="radio" name="Goal" value="Maintain Weight" <?php if(isset($Goal)){ if($Goal === "Maintain Weight"){ echo "checked";} }?>> Maintain Weight
	</div>
	<div>
		<input  type="radio" name="Goal" value="Gain Weight" <?php if(isset($Goal)){ if($Goal === "Gain Weight"){ echo "checked";} }?>> Gain Weight
	</div>
	</div>
	
	<div class="form-group">
	<label>Goal Weight (kg):</label>
	<input class="form-control" type="text" value="<?php if(isset($goalWeight)){echo  htmlspecialchars($goalWeight); }?>" name="goalWeight" />
	</div>
	
	
	<div class="form-group">
	<label>Calories Goal Intake per day:</label>
	<input class="form-control" type="text" value="<?php if(isset($goalCalories)){echo  htmlspecialchars($goalCalories); }?>" name="goalCalories" />
	</div>
	
	<input type="submit" class="btn btn-success" value="Save" name="save" />
	<a href="/personalInformation" class="btn btn-danger" name="cancel">Cancel</a>
</form>
<script>
	var rad = document.getElementsByName('Goal');
	for(var i = 0; i < rad.length; i++) {
	    rad[i].onclick = function() {
		    if (this.checked == true)
		    {
		    	var inputDate = document.getElementsByName('goalWeight');
		    	inputDate[0].disabled = this.value == "Maintain Weight";
		    	if(inputDate[0].disabled){
		    		inputDate[0].value = "Goal weight is the same as your weight now."; 
			    }else{
			    	inputDate[0].value ="";
				    }
		    	   
		    }
	    };
	}
</script>
<?php 
	include 'footer.html.php';
?>