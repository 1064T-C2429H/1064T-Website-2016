<html>
	<head>
		<?php include'assets/head.php';?>
	</head>
	<body>
		<?php include 'assets/nav.php';?>
		<div class="container">
			<?php
				if(Session::exists('complete')){
					echo Session::flash('complete');
				}
				if(Session::exists('error')){
					echo Session::flash('error');
				}
				if(Session::exists('info')){
					echo Session::flash('info');
				}
				if($user->isLoggedIn()){
					
				}else{
					echo '<div class="alert alert-info">You need to <a class="alert-link" href="/login">login</a> or <a class="alert-link" href="/register">sign up</a> to get the full features of this page</div>';
				}
			?>
			<div class="jumbotron">
				<h1>1064 &bull; Home</h1>
			</div>
			<div class="row">
				<div class="col-md-9">
					
				</div>
				<div class="col-md-3">
					<h1><strong>Twitter</strong></h1> <br>
					<a class="twitter-timeline" data-height="500" data-theme="light" href="https://twitter.com/OPS_NorthRobot">Tweets by OPS_NorthRobot</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
				</div>
			</div>
		</div>
		<?php include 'assets/foot.php';?>
	</body>
</html>