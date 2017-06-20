<?php
include 'header.html.php';
?>
	<h1>Reset password</h1>
	<div class="content">
	<form method="post" class="loginform">
		<input type="hidden" name="csrf" value="<?= $_SESSION["csrf"]; ?>" />
		<input type="hidden" name="email" value="<?php if(isset($email)){echo  htmlspecialchars($email); } ?>";/>
		<div class="form-group">
		    <label>New password:</label>
			<input type="password" value="<?php if(isset($newPassword)){echo  htmlspecialchars($newPassword); }?>" name="newPassword" class="form-control"/>
		 </div>
		 <div class="form-group">
			<label>Re-type password:</label>
			<input type="password" class="form-control" value="<?php if(isset($rePassword)){echo  htmlspecialchars($rePassword); }?>" name="rePassword" />
		</div>
			<input type="submit" class="btn btn-success" value="Submit" name="resetPass" />
			<a href="/" class="btn btn-danger" name="cancel">Cancel</a>
	</form>

<?php 
	include 'footer.html.php';
?>