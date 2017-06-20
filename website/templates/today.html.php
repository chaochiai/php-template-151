<?php
include 'header.html.php';
$today = date("F j, Y");

?>

<h1>Today</h1>
<h2><?php echo $today.", ". $weightLeft . "  kilos left!"; ?></h2>
<div>
	<div class="inline">
		Calories:
		<?php if($caloriesTaken == false){ echo 0; }else{ echo $caloriesTaken; }  ?>
	</div>
	
	<div class="progressbar">
		<div class="progress">
		  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" 
		  aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($caloriesPercentage == false){ echo 0 . "%"; }else{ echo $caloriesPercentage . "%";  }  ?>">
		    <span class="sr-only">80% Complete (danger)</span>
		  </div>
		</div>
	</div>
	
	<div class="inlinetwo"><?php echo $maximumCalories; ?></div>
	<br class="clearBoth" />
</div>
<div class="content">
<fieldset>
	<legend>Breakfast</legend>
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Breakfast"){
		?>

		<table class="table table-hover">
		<tbody>
		<tr>
        	<td class="tdr"><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></td>
			<td>
				<form method="post" class="todayForm">
					<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
					<input type="hidden" value="<?php echo $meal["id"];?>" name="mriD"/>
					<input class="btn btn-danger" type="submit" value="delete" name="deleteMRecord" />
			</td>
		</tr>
		</tbody>
	</form>
		</table>

	<?php } } } ?>
	<?php if(!isset($addRecordMealB) ){?>
	<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="add" name="add"/>
		<input class="btn btn-primary" type="submit" value="add" name="addRecordMealB" />
	</form>
	<?php }else{?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="Breakfast" name="recordMealType"/>
		<div class="form-group">
			<label>Food name:</label>
			<input class="form-control" type="text" value="<?php if(isset($foodname)){echo htmlentities($foodname); }?>" name="foodname" />
		</div>
		<div class="form-group">
			<label>Calories:</label>
			<input class="form-control" type="text" value="<?php if(isset($calories2)){echo htmlentities($calories2); }?>" name="caloriesf" />
		</div>
		<input class="btn btn-success"  type="submit" value="record" name="recordMeal" />
		<a href="/today" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Lunch</legend>
	
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Lunch"){
		?>
		<table class="table table-hover">
		<tbody>
		<tr>
        	<td class="tdr">

		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p></td>
		<td>
		<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="<?php echo $meal["id"];?>" name="mriD"/>
		<input class="btn btn-danger" type="submit" value="delete" name="deleteMRecord" />
	</td>
		</tr>
		</tbody>
	</form>
	</table>

	<?php } } } ?>
	<?php if(!isset($addRecordMealL)){?>
	<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="add" name="add"/>
		<input type="submit" class="btn btn-primary" value="add" name="addRecordMealL" />
	</form>
	<?php }else{?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="Lunch" name="recordMealType"/>
		<div class="form-group">
			<label>Food name:</label>
			<input class="form-control" type="text" value="<?php if(isset($foodname)){echo htmlspecialchars($foodname); }?>" name="foodname" />
		</div>
		<div class="form-group">
			<label>Calories:</label>
			<input class="form-control" type="text" value="<?php if(isset($calories2)){echo htmlspecialchars($calories2); }?>" name="caloriesf" />
		</div>
		<input class="btn btn-success" type="submit" value="record" name="recordMeal" />
		<a href="/today" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Dinner</legend>
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Dinner"){
		?>
		<table class="table table-hover">
		<tbody>
		<tr>
        	<td class="tdr">

		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p></td>
		<td><form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="<?php echo $meal["id"];?>" name="mriD"/>
		<input class="btn btn-danger" type="submit" value="delete" name="deleteMRecord" />
	</td>
		</tr>
		</tbody>
	</form>
</table>
	<?php } } } ?>
	<?php if(!isset($addRecordMealD)){?>
	<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="add" name="add"/>
		<input class="btn btn-primary" type="submit" value="add" name="addRecordMealD" />
	</form>
	<?php }else{?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="Dinner" name="recordMealType"/>
		<div class="form-group">
			<label>Food name:</label></br>
			<input class="form-control" type="text" value="<?php if(isset($foodname)){echo htmlspecialchars($foodname); }?>" name="foodname" />
		</div>
		<div class="form-group">
			<label>Calories:</label></br>
			<input class="form-control" type="text" value="<?php if(isset($calories2)){echo htmlspecialchars($calories2); }?>" name="caloriesf" />
		</div>
		<input class="btn btn-success" type="submit" value="record" name="recordMeal" />
		<a href="/today" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Snack</legend>
		<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Snack"){
		?>
	<table class="table table-hover">
		<tbody>
		<tr>
        	<td class="tdr">
		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p></td>
		<td><form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="<?php echo $meal["id"];?>" name="mriD"/>
		<input class="btn btn-danger" type="submit" value="delete" name="deleteMRecord" />
	</td>
		</tr>
		</tbody>
	</form>
	</table>
	<?php } } } ?>
	<?php if(!isset($addRecordMealS)){?>
	<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="add" name="add"/>
		<input type="submit" class="btn btn-primary" value="add" name="addRecordMealS" />
	</form>
	<?php }else{?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" value="Snack" name="recordMealType"/>
		<div class="form-group">
			<label>Food name:</label>
			<input class="form-control" type="text" value="<?php if(isset($foodname)){echo htmlspecialchars($foodname); }?>" name="foodname" />
		</div>
		<div class="form-group">
			<label>Calories:</label>
			<input class="form-control" type="text" value="<?php if(isset($calories2)){echo htmlspecialchars($calories2); }?>" name="caloriesf" />
		</div>
		<input type="submit" class="btn btn-success"  value="record" name="recordMeal" />
		<a href="/today" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<?php }?>
</fieldset>
<h2><?php echo "Your weight today is $weightToday";  ?></h2>
	<?php if(!isset($addWeight)){?>
	<form method="post" class="todayForm">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input class="btn btn-primary" type="submit" value="edit" name="addWeight" />
	</form>
	<?php }else{?>
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<div class="form-group">
			<label>Weight:</label>
			<input class="form-control" type="text" value="<?php if(isset($weight)){echo htmlspecialchars($weight); }?>" name="weight" />
		</div>
		<input type="submit" class="btn btn-success" value="record" name="recordWeight" />
		<a href="/today" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
<?php }?>
<?php 
	include 'footer.html.php';
?>