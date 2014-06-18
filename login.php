<?php
session_start();


/*
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}




if(isset($_POST['name']) AND isset($_POST['password'])) // connect directly
{
	include("include/database.php");
	
	if(validEmail($_POST['name'])) $query = "SELECT ID, Name, PssWdMD5, SSID FROM users WHERE Email = ?";
	else $query = "SELECT ID, Name, PssWdMD5 FROM users WHERE Name = ?";
	
	if($stmt=$mysqli->prepare($query))
	{
		$stmt->bind_param("s", $_POST['name']);
		$stmt->execute();
		
		$result = array();
		$stmt->bind_result($result['ID'], $result['Name'], $result['PsswdMD5'], $result['SSID']);
		$stmt->fetch();
		$stmt->close();
		
		if(MD5($_POST['password'] . "@kosrepo") == $result['PsswdMD5'])
		{
			$_SESSION['ID'] = $result['ID'];
			$_SESSION['Name'] = $result['Name'];
			
			if(isset($_POST['remember']))
			{
				if($_POST['remember'] == "Yes")
				{
					setcookie("SSID", $_POST['SSID'], time()+60*60*24*30);
				}	
			}
			
			header("Refresh: 0;url=".$_GET['refer']."?refer=login");
		}
		else { // Wrong password, showing back login 
			header("Refresh: 0;url=login.php?error=psswd&refer=".$_GET['refer']."&name=".$_POST['name']);
		}
	}
	else {
		header("Refresh: 0;url=login.php?refer=".$_GET['refer']."&error=sql&name=".$_POST['name']);
	}
}
else // Showing login page
{ ?>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<?php if(isset($_GET['name'])) { ?>
		<title>Logging as <?php echo $_GET['name']; ?></title><?php
		
		} else { ?>
		<title>Logging in</title><?php
		} ?>
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
		<div id="headerwrap" class="login">
			<div class="container">
				<div class="row centered">
					<div class="col-lg-12">
						<h1>Logging in <?php if(isset($_GET['name'])) echo 'as '.$_GET['name']; ?></h1>
					</div>
				</div>
			</div>
		</div>
		<?php if(isset($_GET['error'])) { ?>
			<div class="container">
				<div class="row mt centered">
					<div class="col-lg-6 col-lg-offset-2 col-sm-12">
						<h1>Whoops ...</h1>
						<h3>There was a problem while trying to connect you to the site.</h3>
						<?php
						if($_GET['error'] == "sql")
						{
							echo "<h3>We couldn't connect you to the database. Please try again later or contact the admin.</h3>";
						}elseif($_GET['error'] == "psswd")
						{
							echo "<h3>It seems that you have not entered the right password. Please try again.</h3>";							
						} ?>
					</div>
				</div>
			</div>
			
		<?php } ?>
		<div class="container">
			<div class="row mt">
				<div class="col-lg-6 col-lg-offset-2 col-sm-12">
					<form class="form-horizontal">
						<fieldset>

							<!-- Form Name -->
							<legend>
								Login
							</legend>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="name">Username/Email</label>
								<div class="col-md-5">
									<input id="name" name="name" placeholder="theAwesomeScripter" class="form-control input-md" required="" type="text" <?php if(isset($_GET['name'])) echo 'value="'.$_GET['name'].'" '; ?>>
									<span class="help-block">Input your username or email here.</span>
								</div>
							</div>

							<!-- Password input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="password">Password</label>
								<div class="col-md-5">
									<input id="password" name="password" placeholder="••••••••••••" class="form-control input-md" required="" type="password">
									<span class="help-block">Input your password here.</span>
								</div>
							</div>

							<!-- Multiple Checkboxes -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="remember"></label>
								<div class="col-md-4">
									<div class="checkbox">
										<label for="remember-0">
											<input name="remember" id="remember" value="Yes" type="checkbox">
											Remember me </label>
									</div>
								</div>
							</div>

							<!-- Button -->
							<div class="form-group">
								<label class="col-md-4 control-label" for="submit"></label>
								<div class="col-md-4">
									<button id="submit" name="submit" class="btn btn-primary">
										Login
									</button>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>


<?php
}
?>