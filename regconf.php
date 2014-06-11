<html lang="en">
	<head>
		<meta charset="utf-8">
		
		<?php
		include("include/database.php");
		
		$reg_successful=false;
		if(isset($_POST['name']) AND isset($_POST['psswd']))
		{
			$reg_successful=true;
			if(isset($_FILES['avatar']))
			{
				if($_FILES['avatar']['error'] == 0)
				{
					$pathInfo = pathinfo($_FILES['avatar']['name']);
					$reg_succssful = in_array($pathInfo['extension'], array("jpg", "png", "gif"));
				}
			}
		}
		
		if($reg_successful)
		{
			if(isset($_POST['sharemail']) AND $_POST['sharemail'] === "Yes")
			{
				$sharemail=1;
			}
			else 
			{
				$sharemail = 0;
			}
				
			$MD5 = md5($_POST['psswd'] . "@kosrepo"); // Append custom string for more security
			
			$pathInfo = pathinfo($_FILES['avatar']['name']);
			$extension = $pathInfo['extension'];
			$avatar_path = 'img/avatar/' . $_POST['name'] . '.' . $extension;
			
			$date = date("Y-m-d");
			
			$stmt=$mysqli->prepare("INSERT INTO users(ID, Name, PassWdMD5, Email, Twitter, RegDate, ShareEmail, Avatar, Description) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssiss",
							  $_POST['name'],
							  $MD5, 
							  $_POST['email'],
							  $_POST['Twitter'],
							  $date,
							  $sharemail,
							  $avatar_path,
							  $_POST['biography']);	
			$stmt->execute();
			$stmt->close();
			
			move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path);
		}
		
		?>

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
			function returnToHome() {
				window.location.href = "index.php";
			}
		</script>

	</head>

	<body>
		<?php include("include/flatty_header.html"); ?>
		
		<div id="headerwrap" class="registration">
			<div class="col-lg-6 col-lg-offset-3 col-sm-12">
				<?php if($reg_successful) { ?>
				<h1>You're now ready to script to a whole new level!</h1><?php
				}
				else { ?>
				<h1>D'oh! You're not completely OKay...</h1><?php
				} ?>
			</div>
		</div>
		<div class="container">
			<div class="col-sm-12, col-lg-8 col-lg-offset-2">
				<?php if($reg_successful) { ?>
					<h3>Alright! You're in for a new scripting experience!</h3>
					<p>You can now participate to the global work by adding your own scripts to the community, or comment to existing ones.<br/>
						By registering you made a huge step towards better kOS scripts.</p>
					<h4>We hugely recommend you to take on the <b><a href="http://kerbal.curseforge.com/shareables/220669-win-kos-integrated-development-editor">kOS IDE</a></b> as it will soon come
						with an intgrated submission form to be able to upload, update and download scripts on the go.</h4>
					<hr/>
					<h3><a href="index.php">Return home</a></h3>
					<?php
				}
				else { ?>
					<h3>You're missing on some information!</h3>
					<h4>The following information was not correctly provided:</h4><?php
					// TODO: Conditional show of the errors
					if(!isset($_POST['name']))
					{ ?>
						<p class="danger">You didn't give a <b>username</b> :(</p><?php
					}
					else
					{
						$stmt=$mysqli->prepare("SELECT COUNT FROM users WHERE Name=?");
						$stmt->bind_param("s", $_POST['name']);
						$stmt->execute();
						$stmt->bind_result($Count);
						$stmt->fetch();
						$stmt->close();
						
						if($Count != 0)
						{ ?>
							<p class="danger">The username <b><?php echo htmlspecialchars($_POST['name']); ?></b> is already taken.</p> <?php
						}
					}
					
					if(!isset($_POST['psswd']))
					{ ?>
						<p class="danger">You didn't give a password !</p> <?php
					}
				}
				
				if(isset($_FILES['avatar']))
				{
					if($_FILES['avatar']['size'] >= 4096*1024) // 4 096 Kb
					{ ?>
						<p class="danger">Your avatar size is too big.</p> <?php
					}
					$pathInfo = pathinfo($_FILES['avatar']['name']);
					if(!in_array($pathInfo['extension'], array("jpg", "png", "gif")))
					{ ?>
						<p class="danger">You did not send a valid file.</p> <?php
					}
				} ?>
			</div>
		</div>
	</body>
</html>