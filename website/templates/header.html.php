<html>
	<head>
		<title>Log in Form</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<link rel="stylesheet" href="stylesheet.css" />
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Brand</a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="active"><a href="/today">Today <span class="sr-only">(current)</span></a></li>
						<li><a href="#">Link</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<?php
							if(!isset($_SESSION["login"]))
							{
						?>
						
						<li><a href="/login">Log in</a></li>
						<li><a href="/register">Register</a></li>
						
						<?php
							}
						?>
						<?php
							if(isset($_SESSION["login"]))
							{
						?>
						<li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login']; ?> <span class="caret"></span></a>
					          <ul class="dropdown-menu">
						            <li><a href="/personalInformation">My Account</a></li>
						            <li><a href="/logout">Logout</a></li>
					          </ul>
				        </li>
						<?php
						}
						?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>