<?php session_start();
$refer = "script.php?id=".$_GET['id'];

include("include/session.php");

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
	
		if($stmt = $mysqli->prepare("SELECT ID, Name, Email, Twitter, RegDate, ShareEmail, Avatar FROM users WHERE Name=?"))
		{
			$stmt->bind_param("s", $script['Author']);
			$stmt->execute();
			//$result = $stmt->get_result();
			//$author = $result->fetch_assoc();
			$author = array();
			$stmt->bind_result($author['ID'], $author['Name'], $author['Email'], $author['Twitter'], $author['RegDate'], $author['ShareEmail'], $author['Avatar']);
			$stmt->fetch();
			$stmt->close();
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

		<title><?php echo $script['Name'] . " by " . $author['Name']; ?></title>
		<meta name="description" content="">
		<meta name="author" content="SolarLiner">

		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<link rel="stylesheet" href="css_flatty/bootstrap.css" />
		<link rel="stylesheet" href="css_flatty/main.css" />
		
		<link rel="stylesheet" href="css_raimbow/obsidian.css" />
	</head>

	<body>
		<?php include("include/flatty_header.php"); ?>
		
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
					<?php if($author['Avatar'] != null) { ?>
						<img class="profile-avatar" src="<?php echo 'img/avatar/' . $author['Avatar']; ?>" alt="[Avatar]" /><?php
					} ?>
					<h3>by <a href="author.php?id=<?php echo $author['ID']; ?>"<b><?php echo $author['Name']; ?></b></a></h3>
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
				<div class="col-sm-12">
					<pre><code data-language="kos"><?php echo htmlspecialchars($script['Code']); ?></code></pre>
				</div>
			</div>
			<hr/>
			<div class="row centered">
				<div class="col-lg-3 col-lg-offset-3 col-sm-6">
					<form class="form-inline" role="form" id="like">
						<button class="btn btn-warning btn-lg" type="submit">Like</button>
					</form>
				</div>
				<div class="col-lg-3 col-sm-6">
					<form class="form-inline" role="form" action="download.php" method="get">
						<input type="hidden" name="id" value="<?php echo $script['ID']; ?>" />
						<button class="btn btn-default btn-lg" type="submit">Download</button>
					</form>
				</div>
			</div>
			<hr/>
		</div>	
		
		<script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		<!--<script src="js/vendor/smoothscroll.js" type="text/javascript" charset="utf-8"></script>-->
		<script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		
		<script src="js/rainbow.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/rainbow.linesnumbers.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/highlight_script.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript" charset="utf-8">
			function goToAnchor(anchor) {
			    document.body.scrollTop = document.documentElement.scrollTop =
			        document.getElementById(anchor).offsetTop-window.innerHeight/2;
			}
		</script>
		
		<!-- Google Analytics -->
	    <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-52015533-1', 'uphero.com');
		  ga('send', 'pageview');
		</script>
		
		<?php include("include/search.html"); ?>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    
    <!-- Google Analytics -->
    <script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-52015533-1', 'uphero.com');
	  ga('send', 'pageview');
	</script>
	
	<?php include("include/search.html"); ?>
  </body>
</html>
