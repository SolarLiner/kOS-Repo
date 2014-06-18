<?php $active_session = (isset($active_session)?$active_session:false); ?>

<nav class="navbar navbar-fixed-top header">
	<div class="col-lg-12">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">kOS Repo</a>
			<a class="navbar-brand" href="#search" ><i class="glyphicon glyphicon-search"></i></a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse1">
				<i class="glyphicon glyphicon-th-large"></i>
			</button>
		</div>
		<div id="navbar-collapse1" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right"><?php
			if($active_session) { ?>
				<li><a href="register.php">Register</a></li>
				<li><a href="login.php?refer=<?php echo $refer; ?>">Log in</a></li><?php
			} else { ?>
				<li>Welcome, <?php echo $_SESSION['Name']; ?></li>
				<li><a href="logout.php">Log out</a></li><?php
			} ?>
			</ul>
		</div>
	</div>
</nav>