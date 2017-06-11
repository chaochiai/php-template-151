<?php
include 'header.html.php';
$today = date("F j, Y");
?>
<h1><?php echo $today; ?></h1>
<h2><?php echo $weightLeft . "  kilos left!"; ?></h2>
<fieldset>
	<legend>Breakfast</legend>
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
<?php 
	include 'footer.html.php';
?>