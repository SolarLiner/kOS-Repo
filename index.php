<?php session_start();
$refer = "index.php";

include("include/database.php");
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

    <title>kOS Repository</title>

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
	<?php
	include("include/Parsedown.php");
	include("include/cat_types.php");
	
	$query="SELECT * FROM scripts ORDER BY Date DESC";

	$nav = '<li';
	
	if(isset($_GET['mode']))
	{
		if($_GET['mode']=="top")
		{
			$query="SELECT * FROM scripts ORDER BY Likes DESC";
			
			$nav .= '><a href="index.php">New</a></li>';
			$nav .= '<li class="active"><a href="index.php?mode=top">Top Rated</a></li>';
			$nav .= '<li><a href="index.php?mode=dwl">Most Downloaded</a></li>';
			$nav .= '<li><a href="index.php?mode=ris">Rising</a></li>';
		}
		elseif($_GET['mode']=="dwl")
		{
			$query="SELECT * FROM scripts ORDER BY DL DESC";
			
			$nav .= '><a href="index.php">New</a></li>';
			$nav .= '<li><a href="index.php?mode=top">Top Rated</a></li>';
			$nav .= '<li class="active"><a href="index.php?mode=dwl">Most Downloaded</a></li>';
			$nav .= '<li><a href="index.php?mode=ris">Rising</a></li>';
		}
		else {
			$nav .= ' class="active"><a href="index.php">New</a></li>';
			$nav .= '<li><a href="index.php?mode=top">Top Rated</a></li>';
			$nav .= '<li><a href="index.php?mode=dwl">Most Downloaded</a></li>';
			$nav .= '<li><a href="index.php?mode=ris">Rising</a></li>';
		}		
	}
	else {
		$nav .= ' class="active"><a href="index.php">New</a></li>';
		$nav .= '<li><a href="index.php?mode=top">Top Rated</a></li>';
		$nav .= '<li><a href="index.php?mode=dwl">Most Downloaded</a></li>';
		$nav .= '<li><a href="index.php?mode=ris">Rising</a></li>';
	}
	?>
  <body>
  	<?php include("include/gplus_header.php"); ?>
  	<div id="subnav" class="navbar navbar-default">
		<div class="col-lg-12">
			<?php include("include/gplus_header_home.php"); ?>
			<div class="collapse navbar-collapse" id="navbar-collapse2">
		        <ul class="nav navbar-nav navbar-right">
					<?php echo $nav; ?>
		        </ul>
	        </div>
		</div>
	</div>
	<div id="main" class="container">
		<?php if(isset($_GET['refer']))
		{ ?>			
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-success">
						<div class="panel-heading">
							<?php if($_GET['refer'] == "logout") { ?>
								<h3>You have been successfully deconnected!</h3><?php
							} elseif($_GET['refer'] == "login") { ?>
								<h3>You have successfully been logged in!</h3><?php
							} ?>			
						</div>
						<div class="panel-body">
							<?php if($_GET['refer'] == "logout") { ?>
								<p>You have been deconnected from the site. Good bye sir!</p><?php
							} elseif($_GET['refer'] == "login") { ?>
								<p>You have been successfully logged in, <b><?php echo $_SESSION['Name']; ?></b> !</p><?php
							} ?>
						</div>
					</div>				
				</div>
			</div><?php
			} ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-primary panel-danger">
					<div class="panel-heading"><h4>This site is in construction!</h4></div>
					<div class="panel-body">
						This site is in construction and may be subject to bugs. Don't worry about your scripts, database is saved each week.
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php
			if(!$mysqli->connect_errno)
			{
				if($result=$mysqli->query($query))
				{
					while($row=$result->fetch_assoc())
					{
						?>
						<div class="col-sm-12 col-md-6">
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
									if($stmt=$mysqli->prepare("SELECT ID FROM users WHERE Name=?"))
									{
										$stmt->bind_param("s", $row['Author']);
										$stmt->execute();
										$stmt->bind_result($authorID);
										$stmt->fetch();
										$stmt->close();
									} ?>
									<ul class="list-unstyled">
										<li>Author: <?php echo '<a href="author.php?id='.$authorID.'">' . $row['Author'] . '</a>'; ?></li>
										<li>Category: <b><?php echo $category[$row['Category']]; ?></b></li>
										<li>Type: <b><?php echo $type[$row['Type']]; ?></b></li>
										<li>Downloads: <?php echo $row['DL']; ?></li>
										<li><?php echo '<a href="script.php?id=' . $row['ID'] . '">View</a>'; ?></li>
									</ul>
								</div>
							</div>
						</div>
					<?php
					}
					$result->close();
				}
				else
				{ ?>
					<div class="col-sm-12">
						<div class="panel panel-danger">
							<div class="panel-heading"><h4>An error occured</h4></div>
							<div class="panel-body">
								We could not load results from the database. Please come back later.
							</div>
						</div>
					</div>
				<?php
				}
			}
			else
			{
				?>
				<div class="col-sm-12">
					<div class="panel panel-primary panel-danger">
						<div class="panel-heading"><h4>An error occured</h4></div>
						<div class="panel-body">
							An error occured while trying to load the scripts. Please refresh later or contact the admin.<br/>
							<?php echo "Error: " . $mysqli->connect_error; ?>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
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