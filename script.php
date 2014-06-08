<!DOCTYPE html>
<?php
include("include/Parsedown.php");
include("include/cat_types.php");
include("include/database.php");

if(!$mysqli->connect_errno)
{
	if($stmt=$mysqli->prepare("SELECT * FROM scripts WHERE ID=?"))
	{
		$stmt->bind_param("i", $_GET['id']);
		$stmt->execute();
		//$result = $stmt->get_result();
		//$script = $result->fetch_assoc();
		$script = array();
		$stmt->bind_result($script['ID'], $script['Name'], $script['Author'], $script['Description'], $script['Date'], $script['Type'], $script['Category'], $script['Code'], $script['DL'], $script['Likes']);
		$stmt->fetch();
		$stmt->close();
	
		if($stmt = $mysqli->prepare("SELECT * FROM users WHERE Name=?"))
		{
			$stmt->bind_param("s", $script['Author']);
			$stmt->execute();
			//$result = $stmt->get_result();
			//$author = $result->fetch_assoc();
			$author = array();
			$stmt->bind_result($author['ID'], $author['Name'], $author['psswd'], $author['Email'], $author['Twitter'], $author['RegDate'], $author['ShareEmail']);
			$stmt->fetch();
			$stmt->close();
		}
	}
}

?>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php echo $script['Name'] . " by " . $author['Name']; ?></title>
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
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="landingpage.php"><b>kOS Repo</b></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="landingpage.php">Home</a></li>
						<li><a href="index.php">Scripts</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<?php echo '<div id="headerwrap" class="' . $CSSclass[$script['Category']] . '">'; ?>
			<div class="container">
				<div class="row centered">
					<div class="col-sm-12">
						<h1><?php echo $script['Name']; ?></h1>
						<h3>Created on <?php echo date_format(date_create($script['Date']), "F d, Y"); ?></h3>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row mt centered">
				<div class="col-lg-6 col-lg-offset-2 col-sm-12">
					<?php $markdown = new Parsedown();
					echo '<h3>' . nl2br($markdown->text(htmlspecialchars($script['Description']))) . '</h3>'; ?>
					<p>Downloads: <?php echo $script['DL']; ?> | Likes: <?php echo $script['Likes']; ?></p>
				</div>
				<div class="col-lg-4">
					<h3>by <b><?php echo $author['Name']; ?></b></h3>
					<h4>Joined on <?php echo date_format(date_create($author['RegDate']), "F d, Y"); ?></h4>
					<?php if($author['ShareEmail'] == 1) { ?>
						Email: <?php echo '<a href="mailto:' . $author['Email'] . '">' . $author['Email'] . '</a><br/>';
					}
					if($author['Twitter'] != "" && $author['Twitter'] != null) { ?>
						Twitter: <?php echo '<a href="https://www.twitter.com/' . $author['Twitter'] . '">@' . $author['Twitter'] . "</a><br/>";
					} ?>
				</div>
			</div>
			<div class="row mt centered">
				<?php
				// TODO: Make syntax colouring here.
				echo '<code>' . nl2br(htmlspecialchars($script['Code'])) . '</code>'; ?>
			</div>
			<hr/>
			<div class="row centered">
				<div class="col-lg-3 col-lg-offset-3 col-sm-6">
					<form class="form-inline" role="form" id="like">
						<button class="btn btn-warning btn-lg" type="submit">Like</button>
					</form>
				</div>
				<div class="col-lg-3 col-sm-6">
					<form class="form-inline" role="form" id="dl">
						<button class="btn btn-default btn-lg" type="submit">Download</button>
					</form>
				</div>
			</div>
			<hr/>
		</div>
		
		<h1></h1>
	</body>
</html>
