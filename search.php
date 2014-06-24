<?php session_start();
$refer = "search.php";

include("include/session.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="favicon.ico">

		<title>Search results</title>

		<!-- Bootstrap core CSS -->
		<link href="css_gp/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="css_gp/styles.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body><?php
	include("include/gplus_header.php");
	include ("include/Parsedown.php");
	include ("include/cat_types.php");
	include ("include/database.php");
	
	include("include/gplus_header.php"); ?>
	<div id="subnav" class="navbar navbar-default">
		<div class="col-lg-12">
			<?php include("include/gplus_header_home.php"); ?>
		</div>
	</div>
	<div id="main" class="container">
	<?php
	include("include/BrowserAndOS.php");
	
	$safe_os = preg_match('/\b(windows|mac|linux|ubuntu)\b.*/', strtolower(getOS()));
	$name = getBrowser();
	$compatible_browser = ($name == "Firefox" OR $name == "Chrome" OR $name == "Internet Explorer");
	
	if(isset($_GET['q'])) // Display results
	{
		//$docoded = trim(htmlspecialchars_decode($_GET['q']));
		$decoded = $_GET['q'];
		 
		if($stmt=$mysqli->prepare("SELECT ID, Name, Author, Description, Date, Type, Category, DL, Likes FROM scripts WHERE Name LIKE CONCAT('%', ?, '%') OR Description LIKE CONCAT('%', ?, '%')"))
		{
			$stmt->bind_param("ss", $decoded, $decoded);
			$stmt->execute();
			$stmt->store_result();
			$row = array();
			$stmt->bind_result($row['ID'], $row['Name'], $row['Author'], $row['Description'], $row['Date'], $row['Type'], $row['Category'], $row['DL'], $row['Likes']);
			 ?>
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3>Searching for &quot;<b><?php echo $decoded; ?></b>&quot;: </h3>
					</div>
					<div class="panel-body">
						<p>The search returned <?php echo $stmt->num_rows . ' result' . ($stmt->num_rows==1?'':'s'); ?>.</p>
					</div><?php if($safe_os==1 AND $compatible_browser) {
						if($name == "Firefox") $link = 'http://www-archive.mozilla.org/docs/end-user/keywords.html';
						elseif($name == "Chrome") $link = 'https://support.google.com/chrome/answer/95653?hl=en';
						elseif($name == "Internet Explorer") $link = 'http://www.enhanceie.com/ie/searchbuilder.asp';
						?>
					<div class="panel-footer">
						<p>Did you know you can search for scripts directly in <b><?php echo $name; ?></b> ? <a href="<?php echo $link; ?>" target="_blank">Find out how!</a></p>
					</div><?php
					} ?>
				</div>
			</div>
			<?php
			while($stmt->fetch())
			{
				?><div class="col-sm-12 col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php
							echo '<h4>' . $row['Name'] . "</h4>";
							echo "on " . date_format(date_create($row['Date']), "F d, Y");
							?>
						</div>
						<div class="panel-body">
							<?php
							$markdown = new Parsedown();
							echo nl2br($markdown->text(htmlspecialchars($row['Description'])));
							?>
						</div>
						<div class="panel-footer">
							<?php
							if($stmt2=$mysqli->prepare("SELECT ID FROM users WHERE Name=?"))
							{
								$stmt2->bind_param("s", $row['Author']);
								$stmt2->execute();
								$stmt2->bind_result($authorID);
								$stmt2->fetch();
								$stmt2->close();
							} ?>
							<ul class="list-unstyled">
								<li>Author: <?php echo '<a href="author.php?id='.$authorID.'">' . $row['Author'] . '</a>'; ?></li>
								<li>Category: <b><?php echo $category[$row['Category']]; ?></b></li>
								<li>Type: <b><?php echo $type[$row['Type']]; ?></b></li>
								<li>Downloads: <?php echo $row['DL']; ?> |
									Likes: <?php echo $row['Likes']; ?></li>
								<li><?php echo '<a href="script.php?id=' . $row['ID'] . '">View</a>'; ?></li>
							</ul>
						</div>
					</div>
				</div><?php
			}

			$stmt->close();
			?>
		</body><?php
		}
	else 
	{ ?>
		<div class="col-md-12">		
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3>Whoops!</h3>
				</div>
				<div class="panel-body">
					<p>There was a problem with the search. Sorry <i class="glyphicon glyphicon-thumbs-down"></i><br/></p>
				</div>
				<div class="panel-footer">
					<p>A few hypertrained secret monkeys were dispatched to investigate. Give them or the admin this code: <?php echo $mysqli->errno; ?></p>
				</div>
			</div>
		</div>
		<?php
	}
	}
	
	else // Display complete search
	{ ?>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Search</h3>
				</div>
				<div class="panel-body">
					<form class="navbar-form pull-left" action="search.php" method="get">
						<div class="input-group">
							<input id="q" class="form-control" type="text" name="q" placeholder="Search" />
							<div class="input-group-btn">
			                	<button class="btn btn-default btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			                </div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
	} ?>
	
	</div>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
    
    <?php include("include/ga.php"); ?>
	
	<?php include("include/search.html"); ?>
  </body>
</html>