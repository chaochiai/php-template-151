<html>
	<head>
		<title>Tomato Diet Planner</title>
		<link rel="stylesheet" href="stylesheet.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
	</head>
	<body>
	<div class="container"> 
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
					<a class="navbar-brand" href="/">Home</a>
				</div>
			
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php
							if(isset($_SESSION["login"]))
							{
						?>
					<ul class="nav navbar-nav">
						<li ><a href="/today">Today <span class="sr-only">(current)</span></a></li>
						<li><a href="/yourJourney">My Journey</a></li>
					</ul>
					<?php
							}
						?>
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
					          <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login']; ?> <span class="caret"></span></a>
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