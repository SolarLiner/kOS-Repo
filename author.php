<?php session_start();
$refer = "author.php?id=".$_GET['id'];

include("include/session.php");
include("include/Parsedown.php");
include("include/cat_types.php");
include("include/database.php");

$markdown = new Parsedown();

if(!$mysqli->connect_errno)
{
	if($stmt=$mysqli->prepare("SELECT * FROM users WHERE ID=?"))
	{
		$stmt->bind_param("i", $_GET['id']);
		$stmt->execute();
		//$result = $stmt->get_result();
		//$author = $result->fetch_assoc();
		$author = array();
		$stmt->bind_result($author['ID'], $author['Name'], $author['psswd'], $author['Email'], $author['Twitter'], $author['RegDate'], $author['ShareEmail'], $author['Avatar'], $author['Biography']);
		$stmt->fetch();
		$stmt->close();
		
		if($stmt = $mysqli->prepare("SELECT ID, Name, Type, Category, Description FROM scripts WHERE Author=?"))
		{
			$stmt->bind_param("s", $author['Name']);
			$stmt->execute();
			
			$script = array();
			$stmt->bind_result($script['ID'], $script['Name'], $script['Type'], $script['Category'], $script['Description']);
		}
	}
}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php echo $author['Name']. "'s profile"; ?></title>
		<meta name="description" content="<?php echo $author['Biography']; ?>">
		<meta name="author" content="SolarLiner">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link rel="stylesheet" href="css_flatty/bootstrap.css" />
		<link rel="stylesheet" href="css_flatty/main.css" />
	</head>

	<body>
		<?php include("include/flatty_header.php"); ?>
		
		<div id="headerwrap">
			<div class="row centered">
				<div class="col-sm-12">
					<h1><?php echo $author['Name']; ?></h1>
					<h3>Joined on <?php echo date_format(date_create($author['RegDate']), "F d, Y"); ?></h3>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="col-sm-12 col-lg-6 col-lg-offset-3">
				<?php if($author['Avatar'] != null) { ?>
					<img class="profile-avatar-big" src="<?php echo 'img/avatar/' . $author['Avatar']; ?>" alt="[Avatar]" /><?php
				} ?>
				<?php if($author['ShareEmail'] == 1) { ?>
					<h4>Email: <?php echo '<a href="mailto:' . $author['Email'] . '">' . $author['Email'] . '</a></h4>';
				}
				if($author['Twitter'] != "" && $author['Twitter'] != null) { ?>
					<h4>Twitter: <?php echo '<a href="https://www.twitter.com/' . $author['Twitter'] . '">@' . $author['Twitter'] . "</a></h4>";
				} ?><br/>
				<blockquote><?php echo nl2br($markdown->text(htmlspecialchars($author['Biography']))); ?></blockquote>
			</div>
		</div>
		<HR/>
		<div class="container">
			<center><h3>Scripts from <?php echo $author['Name']; ?></h3></center>
			<?php
			while($stmt->fetch())
			{ ?>
				<div class="col-sm-12 col-lg-6">
					<h4><a href="<?php echo 'script.php?id=' . $script['ID']; ?>"><b><?php echo $script['Name']; ?></b></a></h4>
					<blockquote><?php echo nl2br($markdown->text(htmlspecialchars($script['Description']))); ?></blockquote>
					<ul class="list-unstyled">
						<li>Category: <b><?php echo $category[$script['Category']]; ?></b></li>
						<li>Type: <b><?php echo $type[$script['Type']]; ?></b></li>
					</ul>
				</div>
				<?php
			} ?>
		</div>
		
		<!-- Google Analytics -->
	    <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-52015533-1', 'uphero.com');
		  ga('send', 'pageview');
		</script>
	</body>
</html>
