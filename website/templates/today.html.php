<?php
include 'header.html.php';
//, g:i a
$today = date("F j, Y");
?>
<h1><?php echo $today; ?></h1>
<h2><?php echo $weightLeft . "  kilos left!"; ?></h2>
<fieldset>
	<legend>Breakfast</legend>
	<?php if(!isset($_POST['addRecordMeal'])){?>
	<form method="post" class="todayForm">
		<input type="hidden" value="add" name="add"/>
		<input type="submit" value="add" name="addRecordMeal" />
	</form>
	<?php }else{?>
	<form method="post" class="todayForm">
		<input type="hidden" value="Breakfast" name="recordMealType"/>
		<div>
			<label>Food name:</label></br>
			<input type="text" name="foodname" /></br>
		</div>
		<div>
			<label>Calories:</label></br>
			<input type="text" name="calories" /></br>
		</div>
		<input type="submit" value="record" name="recordMeal" />
	</form>
	<?php }?>
</fieldset>

<?php 
	include 'footer.html.php';
?>