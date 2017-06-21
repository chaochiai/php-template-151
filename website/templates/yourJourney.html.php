<?php
include 'header.html.php';
$today = date("F j, Y");
?>

<h1>My Journey</h1>
<div class="content">
<h2>Weight Goal Overview</h2>
<div class="maintain">
<?php if(isset($weightMaintained) OR isset($weightGained) OR isset($weightLostNo)){ ?>
  	<?php if(isset($weightMaintained)){ ?>
  		<div>You didn't gain or lose any weight! Keep it up!</div>
  	<?php } else if(isset($weightGained)){?>
  		<div>You gained weight! You should lose <?php echo $weightGained . " kg"; ?>.</div>
  	<?php } elseif(isset($weightLostNo)){?>
  		<div>You lost weight! You should gain <?php echo $weightLostNo . " kg"; ?>.</div>
  	<?php }?>
  	</div>
  	<?php } else{ ?>

<canvas id="monthlyAmountChart" width="400" height="400"></canvas>
	<script type="text/javascript">
		var monthlyAmountCtx = document.getElementById("monthlyAmountChart").getContext("2d");
		var data = [{
        	value: <?php echo $weightLostOrGain; ?>,
			color:"#333333",
			highlight: "#262626",
			label: "Weight Lost/Gain - depending on your goal"
		},
    	{
	        value: <?php echo $weightLeft; ?>,
	        color: "#dddddd",
	        highlight: "#f2f2f2",
	        label: "Weight Left"
	    }];
	    var options = {
	      animateScale: true
	    };
	    var monthlyAmountChart = new Chart(monthlyAmountCtx).Pie(data,options);
  	</script>
  	<?php } ?>
 <h2>Weight and Calories History - Last 10 entries</h2>
 <?php if(isset($overviews)){
 	if($overviews != false){?>     
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Date</th>
        <th>Taken calories</th>
        <th>Weight</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach($overviews as $overview){?>
      <tr>
        <td><?php echo $overview["date"]; ?></td>
        <td><?php echo $overview["calories"]; ?></td>
        <td><?php echo $overview["weight"]; ?></td>
      </tr>
      <?php }?>
    </tbody>
 <?php } else{?>
	<div class="maintain">No entries have been entered yet.</div>
<?php }}?> 

<?php 
	include 'footer.html.php';
?>  	
