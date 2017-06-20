<?php
include 'header.html.php';
?>
	<h1>Forgot password</h1>
	<div class="content">
	<?php if(!isset($con)){?>
	<form method="post" >
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		An email will be sent to you.
		</br>
		<div class="form-group">
			<label>Please enter your email:</label>
			<input class="form-control" type="text" value="<?php if(isset($email)){echo  htmlspecialchars($email); }?>" name="email" />
		</div>
		<input class="btn btn-success" type="submit" value="Enter" name="forgotPassword" />
		<a href="/" class="btn btn-danger" name="cancel">Cancel</a>
	</form>
	<?php }else{?>
	<div class="text">
		Thank you, an email has been sent to you.
	</div>
	<?php }?>
<?php 
	include 'footer.html.php';
?>