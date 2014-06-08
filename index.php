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
	include("include/database.php");
	
	$query="SELECT * FROM scripts ORDER BY Date DESC";
	
	if(isset($_GET['mode']))
	{
		if($_GET['mode']=="top")
		{
			$query="SELECT * FROM scripts ORDER BY Likes DESC";
		}
		else if($_GET['mode']=="dwl")
		{
			$query="SELECT * FROM scripts ORDER BY DL DESC";
		}
	}
	?>
  <body>
  	<header class="col-sm-12">
  		<h1>kOS Repository</h1>
  		<h3>This might hold an useful script for you</h3>
  	</header>
	<nav id="navbar-collapse2" class="collapse navbar-collapse">
		<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="index.php">New</a></li>
			<li><a href="index.php?mode=top">Top Rated</a></li>
			<li><a href="index.php?mode=dwl">Most Downloaded</a></li>
			<li><a href="index.php?mode=ris">Rising</a></li>
		</ul>
	</nav>
	<div id="main" class="container">
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
									<ul class="list-unstyled">
										<li>Author: <?php echo '<a href="author.php?id=42">' . $row['Author'] . '</a>'; ?></li>
										<li>Category: <b><?php echo $category[$row['Category']]; ?></b></li>
										<li>Type: <b><?php echo $type[$row['Type']]; ?></b></li>
										<li>Downloads: <?php echo $row['DL']; ?> |
											Likes: <?php echo $row['Likes']; ?></li>
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
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>