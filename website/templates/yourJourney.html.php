<?php
include 'header.html.php';
$today = date("F j, Y");
?>

<h1>Your Journey</h1>
<h2>Weight Goal Overview</h2>

<?php if(isset($data["weightMaintained"]) OR isset($data["weightGained"]) OR isset($data["weightLostNo"])){ ?>
  	<?php if(isset($data["weightMaintained"])){ ?>
  		<div>You didn't gain or lose any weight! Keep it up!</div>
  	<?php } else if(set($data["weightGained"])){?>
  		<div>You gained Weight! You should lose <?php echo $data["weightGained"]; ?>.</div>
  	<?php } elseif(set($data["weightLostNo"])){?>
  		<div>You lost Weight! You should gain <?php echo $data["weightLostNo"]; ?>.</div>
  	<?php }?>
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
 <h2>Weight and Calories History</h2>
 <?php if(isset($overviews)){ ?>
           
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
  </table>

<?php } else{echo "No entries have been entered yet.";}?>

<?php 
	include 'footer.html.php';
?>  	
