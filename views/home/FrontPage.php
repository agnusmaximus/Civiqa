<html>
  <head>
    <title>Civiqa</title>
    <link rel="stylesheet" href="views/default/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="views/default/bootstrap/css/bootstrap-responsive.css">
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#" id="reset">Civiqa</a>
          <div class="nav-collapse">
	    <ul class="nav">
	      <li class="active"><a href="#" id="home">Home</a></li>
	      <li><a href="#" id="about">About</a></li>
	    </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div style="margin:100px">
    </div>
     
    <div class="container">
      <div class="hero-unit" id="front">
	<p><a class="btn btn-primary" id="learn">Learn More</a></p>
	<br/>
	<div style="text-align:center">
	  <h1>Civiqa</h1>
	  <br/>
	  <p>Civiqa allows you to share your opinions and ideas</p>
	  <br/>
	  <p><a href="<?php echo $loginUrl?>" class="btn btn-large" id="login"><b>Login through Facebook</b></a></p>
	</div>
      </div>
      <div id="aboutLearn" style="text-align:center">
	<div class="hero-unit">
	  <h1>Civiqa</h1>
	  <br/>
	  <img src="views/home/graphics/wave.png" width="50px" height="50px">
	  <br/>
	  <p><h2>Share Your Opinions</h2></p>
	  <p style="text-align:center;margin-right:250px;margin-left:250px">Ever
	  feel like you want to express your opinions? Creating a Movement
	  on Civiqa will allow you to broadcast what you feel to the people
	  you know</p><br/>
	  <img src="views/home/graphics/discver.jpeg" width="50px" height="50px">
	  <br/>
	  <p><h2>See What Other People Feel</h2></p>
	  <p style="text-align:center;margin-right:250px;margin-left:250px">Discover
	  other people\'s opinions. You may even learn something new about
	  your closest friends</p><br/>
	  <img src="views/home/graphics/compete.png" width="50px" height="50px">
	  <br/>
	  <p><h2>What Makes Civiqa Different</h2></p>
	  <p style="text-align:center;margin-right:250px;margin-left:250px">
	    Civiqa tries to be a combination of Reddit and Facebook,
	    incorporating an element of competition that is absent from
	    many social networks
	  </p>
	</div>
	<div class="row">
	  <div class="span4">
	    <img src="views/home/graphics/fb.png" width="50px" height="50px">
	    <br/>
	    <h2>Facebook Integration</h2>
	    <p>Civiqa is integrated within Facebook so friends will
	    automatically be registered for users</p>
	  </div> 
	  <div class="span4">
	    <img src="views/home/graphics/about.png" width="50px" height="50px">
	    <br/>
	    <h2>About</h2>
	    <p>Civiqa is developed by Max Lam. Special Thanks to Jeffrey Zhang</p>
	  </div>
	  <div class="span4">
	    <img src="views/home/graphics/contact.jpeg" width="60px" height="60px">
	    <br/>
	    <h2>Contact</h2>
	    <p>For contact, please email to: agnusmaximus@civiqa.com</p>
	  </div>
	</div>
      </div>
      <br/>
      <hr/>
      <footer>
	<p>&copy; Civiqa 2012</p>
      </footer>
    </div>
	<!-- <script src="../../controllers/js/Jquery.js"></script> -->
    <!-- <script src="../../controllers/home/behavior.js"></script> -->
	<script src="controllers/js/Jquery.js"></script>
	<script src="controllers/home/behavior.js"></script>
   </body>
</html>
