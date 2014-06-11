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
		
		<script type="text/javascript" charset="utf-8">
			function returnToHome()
			{
				window.location.href="index.php";
			}
		</script>
		
	</head>

	<body>
		<?php include("include/flatty_header.html"); ?>
		
		<div id="headerwrap" class="registration">
			<div class="col-lg-6 col-lg-offset-3 col-sm-12">
				<h1>Become the programmer you've always wanted to be.</h1>
			</div>
		</div>
		<div class="container">
			<div class="col-sm-12, col-lg-8 col-lg-offset-2">
				<h3>Manually sending rockets? Pfff, too manly.<br/>
					Using an autopilot? Nah, who needs autopilots anyway?<br/>
					Creating your OWN program to launch your rocket? Yeah, that's the way to do it!
				</h3><br/>
				<h3>NASA, JAXA, SpaceX; all use custom autopilots.</h3>
				<h1>Be one of them. Be like them. Register yourself NOW!</h1>
				<h3>Now 100% more registrable and FREE!</h3>
			</div>
		</div>
		<div class="container">
			<div class="col-sm-12 col-lg-8 col-lg-offset-2">
				<form class="form-horizontal" action="regconf.php" method="post" enctype="multipart/form-data">
					<fieldset>
					
					<!-- Form Name -->
					<legend>Register Yourself!</legend>
					
					<!-- Text input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="name">Username</label>  
					  <div class="col-md-5">
					  <input id="name" name="name" placeholder="theAwesomeScripter" class="form-control input-md" required="" type="text">
					  <span class="help-block">Choose wisely, this will be your one and only attempt!</span>  
					  </div>
					</div>
					
					<!-- Password input-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="psswd">Password</label>
					  <div class="col-md-5">
					    <input id="psswd" name="psswd" placeholder="Don't tell anyone about it!" class="form-control input-md" required="" type="password">
					    <span class="help-block">Remember these characters like a sir!</span>
					  </div>
					</div>
					
					<!-- Prepended checkbox -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="email">Email</label>
					  <div class="col-md-5">
					    <div class="input-group">
					      <span class="input-group-addon">     
					          <input type="checkbox" name="sharemail" value="yes" />     
					      </span>
					      <input id="email" name="email" class="form-control" placeholder="someone@someplace.com" type="text">
					    </div>
					    <p class="help-block">Not required. Check the box if you want your email to be publicly available. This site will not use it for anything else. Promised.</p>
					  </div>
					</div>
					
					<!-- Prepended text-->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="twitter">Twitter name</label>
					  <div class="col-md-5">
					    <div class="input-group">
					      <span class="input-group-addon">@</span>
					      <input id="twitter" name="twitter" class="form-control" placeholder="theAwesomeTwitter" type="text">
					    </div>
					    <p class="help-block">Not required. Will be displayed on your scripts and profile page.</p>
					  </div>
					</div>
					
					<!-- Textarea -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="biography">Description</label>
					  <div class="col-md-4">                     
					    <textarea class="form-control" id="biography" name="biography"></textarea>
					    <p class="help-block">Please tell us about you. A little. Please. :) You can use Markdown for that.</p>
					  </div>
					</div>
					
					<!-- File Button --> 
					<div class="form-group">
					  <label class="col-md-4 control-label" for="avatar">Avatar</label>
					  <div class="col-md-4">
					    <input id="avatar" name="avatar" class="input-file" type="file">
					    <p class="help-block">Max <b>4 Mo</b>. JPG, PNG, GIF images accepted.</p>
					  </div>
					</div>
					
					<!-- Button (Double) -->
					<div class="form-group">
					  <label class="col-md-4 control-label" for="confirm"></label>
					  <div class="col-md-8">
					    <button type="submit" id="confirm" name="confirm" class="btn btn-primary">Submit</button>
					    <button id="cancel" name="cancel" class="btn btn-danger" onclick="returnToHome()">Cancel</button>
					  </div>
					</div>
					
					</fieldset>
				</form>
			</div>
		</div>
	</body>
</html>
