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
  	<!--<header class="col-sm-12">
  		<h1>kOS Repository</h1>
  		<h3>This might hold an useful script for you</h3>
  	</header>-->
  	<nav class="navbar navbar-fixed-top header">
  		<div class="col-lg-12">
  			<div class="navbar-header">
  				<a class="navbar-brand" href="/">kOS Repo</a>
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse1">
					<i class="glyphicon glyphicon-search"></i>
				</button>
  			</div>
  			<div id="navbar-collapse1" class="collapse navbar-collapse">
  				<form class="navbar-form pull-left">
  					<div class="input-group" style="max-width: 512px;">
  						<input id="srch-term" class="form-control" type="text" name="srch-term" placeholder="Search" />
  						<div class="input-group-btn">
		                	<button class="btn btn-default btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
		                </div>
  					</div>
  				</form>
  				<ul class="nav navbar-nav navbar-right">
  					<li><a href="register.php">Register</a></li>
  					<li><a href="login.php">Log in</a></li>
  					<li><a href="#search">Search</a></li>
  				</ul>
  			</div>
  		</div>
  	</nav>
  	
	<div id="subnav" class="navbar navbar-default">
		<div class="col-lg-12">
			<div class="navbar-header">
				<a href="#" style="margin-left:15px;" class="navbar-btn btn btn-default btn-plus dropdown-toggle" data-toggle="dropdown">
					<i class="glyphicon glyphicon-home" style="color:#dd1111;"></i> Home <small><i class="glyphicon glyphicon-chevron-down down-anim"></i></small>
				</a>
				<ul class="nav dropdown-menu">
					<li><a href="author.php?id=4"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
					<li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log out</a></li>
					<li><a href="uplodad.php"><i class="glyphicon glyphicon-arrow-up"></i> Upload</a></li>
				</ul>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse2">
		        <ul class="nav navbar-nav navbar-right">
					<?php echo $nav; ?>
		        </ul>
	        </div>
		</div>
	</div>
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
	
	<!-- Full Screen Search -->
	<div id="search">
	<button type="button" class="close">&times;</button>
		<form action="search.php" method="get">
			<input type="search" value="" placeholder="type keyword(s) here" />
			<button type="submit" class="btn btn-primary">Search</button>
		</form>
	</div>
	<script type="text/javascript" charset="utf-8">
$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
});
	</script>
  </body>
</html>