<?php
//	error_reporting(0);
	
	//Get facebook information
	require_once('models/facebook/facebookInit.php');	

	if ($facebook->getUser()) {
		require_once('models/facebook/facebookFunctions.php');
?>
<html>

	<head>
		<title>Civiqa</title>
		<link rel="stylesheet" href="views/default/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="views/default/bootstrap/css/bootstrap-responsive.css">
	</head>

	<body>

	<div class="hidden" id="userid"><?php echo $facebook->getUser();?></div>
  
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<a class="brand" href="#">Civiqa</a>

				<div class="nav-collapse">
					
					<ul class="nav pull-right">
						<li class="dropdown">
							<a href="#" 
							class="dropdown-toggle" 
							data-toggle="dropdown"> 
							<img src="<?php echo getUserPicture();?>" style="height:28px;width:28px;margin-bottom:-10px">
							<?php echo getUserName(); ?> 
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo getLogoutUrl();?>">Logout</a></li>
							</ul>
						</li>
					</ul>

					<form class="navbar-search pull-left" action="">
						<input autocomplete="off" id="globSearch" type="text" style="height:27.5px" class="search-query span3" placeholder="Search"/>
					</form>
					<ul style="margin-top:12px;margin-left:10px" id="loadd" class="nav pull-left">
					</ul>
				</div>

			</div>
		</div>
    </div>

	<br/><br/><br/><br/>

	<div class="container">
	
		<div class="row">
			<div class="span3">
				<div class="well sidebar-nav">
					<a style="text-decoration:none;background-color:#FFFFFF" class="thumbnail" href="" name="user"label="<?php echo $facebook->getUser();?>">
						<p style="margin:15px"><?php echo getUserName();?></p>
						<img style="margin:15px;height:50px;width:50px" src="<?php echo getUserPicture(); ?>">
					</a>
					<br/>
					<ul class="nav nav-list">
						<li class="nav-header">Pages</li>
						<li class="active" name="All_News"><a href="#"><i class="icon-white icon-home"/></i>All News</a></li>
						<li class="sidebar"  name="Personal_News"><a href="#"><i class="icon-pencil"/></i>Personal News</a></li>
						<li class="sidebar" name="Messages"><a href="#"><i class="icon-book"/></i>Messages</a></li>
						<li class="sidebar" name="Associates"><a href="#"><i class="icon-user"/></i>Associates</a></li>
						<li class="nav-header">Movements</li>
						<li class="sidebar" name="Start"><a href="#">+ Start</a></li>
						<li class="sidebar" name="Top"><a href="#">- Top</a></li>
						<li class="sidebar" name="Manage"><a href="#">- Manage</a></li>
						<li class="sidebar" name="Supporting"><a href="#">- Supporting</a></li>
					</ul>
				</div><!--/.well -->
			</div><!--/span-->

			<div class="span8">
				<div class="well" id="content">
				</div>
			</div>

		</div>
	
		<br/>
		<hr/>
		<footer>
			<p>&copy; Civiqa 2012</p>
		</footer>
	</div>
<!--	<script src="controllers/js/Jquery.js"></script>
	<script src="controllers/js/History.js"></script>
	<script src="controllers/content/handleHistory.js"></script>
	<script src="controllers/content/user.js"></script>    
	<script src="controllers/navbar/dropdown.js"></script>
	<script src="controllers/navbar/collapse.js"></script>
	<script src="controllers/navbar/sidebarUpd.js"></script>
	<script src="controllers/content/contentUpd.js"></script>
	<script src="controllers/content/topBarBehavior.js"></script>
	<script src="controllers/content/commentsBehavior.js"></script>
	<script src="controllers/content/messageBehavior.js"></script>
	<script src="controllers/content/movementBehavior.js"></script>
	<script src="controllers/content/modal.js"></script>
	<script src="controllers/content/tooltip.js"></script>
	<script src="controllers/content/popover.js"></script>
	<script src="controllers/content/typeahead.js"></script>
	<script src="controllers/content/update.js"></script>  -->

<script src="controllers/js/Jquery.js"></script>
<script src="controllers/js/History.js"></script>
<script src="controllers/content/handleHistory.js"></script>
<script src="controllers/content/user.js"></script>    
<script src="controllers/navbar/dropdown.js"></script>
<script src="controllers/navbar/collapse.js"></script>
<script src="controllers/navbar/sidebarUpd.js"></script>
<script src="controllers/content/contentUpd.js"></script>
<script src="controllers/content/topBarBehavior.js"></script>
<script src="controllers/content/commentsBehavior.js"></script>
<script src="controllers/content/messageBehavior.js"></script>
<script src="controllers/content/movementBehavior.js"></script>
<script src="controllers/content/modal.js"></script>
<script src="controllers/content/tooltip.js"></script>
<script src="controllers/content/popover.js"></script>
<script src="controllers/content/typeahead.js"></script>
<script src="controllers/content/update.js"></script> 

  </body>
</html>
<?php
	}
	else {
		//Redirect home because the user is not logged in
		header("Location: ../home/FrontPage.php");
	}
?>