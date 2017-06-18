<?php
include 'header.html.php';
$today = date("F j, Y");
?>
<h1><?php echo $today; ?></h1>
<h2><?php echo $weightLeft . "  kilos left!"; ?></h2>
<div>
	Calories:
	<div><?php if($caloriesTaken == false){ echo 0; }else{ echo $caloriesTaken; }  ?></div>
	<div class="progressbar">
		<div class="progress">
		  <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" 
		  aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php if($caloriesPercentage == false){ echo 0 . "%"; }else{ echo $caloriesPercentage . "%";  }  ?>">
		    <span class="sr-only">80% Complete (danger)</span>
		  </div>
		</div>
	</div>
	
	<div><?php echo $maximumCalories; ?></div>
</div>

<fieldset>
	<legend>Breakfast</legend>
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Breakfast"){
		?>
	<div>
		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p>
		<form method="post" class="todayForm">
		<input type="hidden" value="<?php echo $meal["id"];?>" name="mriD"/>
		<input type="submit" value="delete" name="deleteMRecord" />
	</form>
	</div>
	<?php } } } ?>
	<?php if(!isset($_POST['addRecordMealB'])){?>
	<form method="post" class="todayForm">
		<input type="hidden" value="add" name="add"/>
		<input type="submit" value="add" name="addRecordMealB" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<input type="hidden" value="Breakfast" name="recordMealType"/>
		<div>l
			<label>Food name:</label></br>
			<input type="text" value="<?php if(isset($foodname)){echo $foodname; }?>" name="foodname" /></br>
		</div>
		<div>
			<label>Calories:</label></br>
			<input type="text" value="<?php if(isset($calories)){echo $calories; }?>" name="calories" /></br>
		</div>
		<input type="submit" value="record" name="recordMeal" />
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Lunch</legend>
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Lunch"){
		?>
	<div>
		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p>
	</div>
	<?php } } } ?>
	<?php if(!isset($_POST['addRecordMealL'])){?>
	<form method="post" class="todayForm">
		<input type="hidden" value="add" name="add"/>
		<input type="submit" value="add" name="addRecordMealL" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<input type="hidden" value="Lunch" name="recordMealType"/>
		<div>
			<label>Food name:</label></br>
			<input type="text" value="<?php if(isset($foodname)){echo $foodname; }?>" name="foodname" /></br>
		</div>
		<div>
			<label>Calories:</label></br>
			<input type="text" value="<?php if(isset($calories)){echo $calories; }?>" name="calories" /></br>
		</div>
		<input type="submit" value="record" name="recordMeal" />
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Dinner</legend>
	<?php if($meals != 0){
		foreach ($meals as $meal){
			if($meal["mealType"] == "Dinner"){
		?>
	<div>
		<p><?php echo $meal["Name"] . " " .$meal["Calories"] ; ?></p>
	</div>
	<?php } } } ?>
	<?php if(!isset($_POST['addRecordMealD'])){?>
	<form method="post" class="todayForm">
		<input type="hidden" value="add" name="add"/>
		<input type="submit" value="add" name="addRecordMealD" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<input type="hidden" value="Dinner" name="recordMealType"/>
		<div>
			<label>Food name:</label></br>
			<input type="text" value="<?php if(isset($foodname)){echo $foodname; }?>" name="foodname" /></br>
		</div>
		<div>
			<label>Calories:</label></br>
			<input type="text" value="<?php if(isset($calories)){echo $calories; }?>" name="calories" /></br>
		</div>
		<input type="submit" value="record" name="recordMeal" />
	</form>
	<?php }?>
</fieldset>
<fieldset>
	<legend>Snack</legend>
	<?php if(!isset($_POST['addRecordMealS'])){?>
	<form method="post" class="todayForm">
		<input type="hidden" value="add" name="add"/>
		<input type="submit" value="add" name="addRecordMealS" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<input type="hidden" value="Snack" name="recordMealType"/>
		<div>
			<label>Food name:</label></br>
			<input type="text" value="<?php if(isset($foodname)){echo $foodname; }?>" name="foodname" /></br>
		</div>
		<div>
			<label>Calories:</label></br>
			<input type="text" value="<?php if(isset($calories)){echo $calories; }?>" name="calories" /></br>
		</div>
		<input type="submit" value="record" name="recordMeal" />
	</form>
	<?php }?>
</fieldset>
<h2><?php echo "Your weight today is $weightToday";  ?></h2>
	<?php if(!isset($_POST['addWeight'])){?>
	<form method="post" class="todayForm">
		<input type="submit" value="edit" name="addWeight" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<div>
			<label>Weight:</label></br>
			<input type="text" name="weight" /></br>
		</div>
		<input type="submit" value="record" name="recordWeight" />
	</form>
<?php }?>
<?php 
	include 'footer.html.php';
?>