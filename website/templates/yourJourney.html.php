<?php
include 'header.html.php';
$today = date("F j, Y");
?>

<h1>Your Journey</h1>
<h2>Weight Goal Overview</h2>
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
