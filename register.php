<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Register Yourself!</title>
		<meta name="description" content="">
		<meta name="author" content="SolarLiner">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link rel="stylesheet" href="css_flatty/bootstrap.css" />
		<link rel="stylesheet" href="css_flatty/main.css" />
		
	</head>

	<body>
		<?php include("include/flatty_header.html"); ?>
		
	<div id="headerwrap">
		<h1>Become the programmer you've always wanted to be.</h1>
		<h3>Manually sending rockets? Pfff, too manly.<br/>
			Using an autopilot? Nah, who needs autopilots anyway?<br/>
			Creating your OWN program to launch your rocket? Yeah, that's the way to do it!
		</h3>
	</div>
	<div class="container">
		<div class="col-sm-12, col-lg-6 col-lg-offset-3">
			<h3>NASA, JAXA, SpaceX; all use custom autopilots.</h3>
			<h1>Be one of them. Be like them. Register yourself NOW!</h1>
			<h3>Now 100% more registrable and FREE!</h3>
		</div>
	</div>
	<div class="containter">
		<div class="col-sm-12 col-lg-8 col-lg-offset-2">
			<form class="form-horizontal">
				<fieldset>
				
				<!-- Form Name -->
				<legend>Register Yourself!</legend>
				
				<!-- Text input-->
				<div class="control-group">
				  <label class="control-label" for="name">Username</label>
				  <div class="controls">
				    <input id="name" name="name" placeholder="theAwesomeScripter" class="input-xlarge" required="" type="text">
				    <p class="help-block">Choose anything that isn't already in use.</p>
				  </div>
				</div>
				
				<!-- Password input-->
				<div class="control-group">
				  <label class="control-label" for="psswd">Password</label>
				  <div class="controls">
				    <input id="psswd" name="psswd" placeholder="don't tell anyody about it!" class="input-xlarge" required="" type="password">
				    <p class="help-block">help</p>
				  </div>
				</div>
				
				<!-- Button Drop Down -->
				<div class="control-group">
				  <label class="control-label" for="email">Email</label>
				  <div class="controls">
				    <div class="input-append">
				      <input id="email" name="email" class="input-xlarge" placeholder="something@someplace.com" type="text">
				      <div class="btn-group">
				        <button class="btn dropdown-toggle" data-toggle="dropdown">
				          Availability
				          <span class="caret"></span>
				        </button>
				        <ul class="dropdown-menu">
				          <li><a href="#">Public</a></li>
				          <li><a href="#">Private</a></li>
				        </ul>
				      </div>
				    </div>
				  </div>
				</div>
				
				<!-- Prepended text-->
				<div class="control-group">
				  <label class="control-label" for="twitter">Twitter Name</label>
				  <div class="controls">
				    <div class="input-prepend">
				      <span class="add-on">@</span>
				      <input id="twitter" name="twitter" class="input-large" placeholder="MyFancyTwitterAccount" type="text">
				    </div>
				    <p class="help-block">Not required. Will be displayed on your scripts and profile page.</p>
				  </div>
				</div>
				
				<!-- Textarea -->
				<div class="control-group">
				  <label class="control-label" for="biography">Biography</label>
				  <div class="controls">                     
				    <textarea id="biography" name="biography">Tell about yourself. Just a tiny bit. Please :)</textarea>
				  </div>
				</div>
				
				<!-- File Button --> 
				<div class="control-group">
				  <label class="control-label" for="avatar">Avatar</label>
				  <div class="controls">
				    <input id="avatar" name="avatar" class="input-file" type="file">
				  </div>
				</div>
				
				<!-- Button (Double) -->
				<div class="control-group">
				  <label class="control-label" for="ok"></label>
				  <div class="controls">
				    <button id="ok" name="ok" class="btn btn-primary">Submit</button>
				    <button id="cancel" name="cancel" class="btn btn-danger">Cancel</button>
				  </div>
				</div>
				
				</fieldset>
			</form>
		</div>
	</div>
