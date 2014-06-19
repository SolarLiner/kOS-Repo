<?php //$active_session = (isset($active_session)?$active_session:false);
if(!isset($active_session))
{
	$active_session = false;
}
 ?>

<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">kOS Repo</a>
            <a class="navbar-brand" href="#search" style="color: #3498db;"><i class="glyphicon glyphicon-search"></i></a>
        </div>
		<div class="navbar-collapse collapse" id="navbar-collapse">
			<ul class="nav navbar-nav navbar-right"><?php
				if(!$active_session) { ?>
				<li><a href="register.php">Register</a></li>
				<li><a href="login.php?refer=<?php echo $refer; ?>">Log in</a></li><?php
				} else { ?>
				<li class="header-text"><a href="author.php?id=<?php echo $_SESSION['ID']; ?>">Welcome, <?php echo $_SESSION['Name']; ?></a></li>
				<li><a href="logout.php">Log out</a></li><?php
				} ?>
			</ul>
		</div>
	</div>
</div>