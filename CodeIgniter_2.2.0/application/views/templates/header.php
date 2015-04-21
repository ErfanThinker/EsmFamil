<html>
<head>
	<title><?php echo $title ?> - CodeIgniter 2 Tutorial</title>
<meta charset="UTF-8">
<!-- <link href="<?php echo $this->config->base_url();?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />   -->
<link href="<?php echo $this->config->base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />  
<link href="<?php echo $this->config->base_url();?>bootstrap/css/bootstrap-rtl.min.css" rel="stylesheet">
<link href="<?php echo $this->config->base_url();?>custom/css/custom.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url();?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  

<!-- jQuery -->
    <script src="<?php echo $this->config->base_url();?>bootstrap/js/jquery.js"></script>

</head>
<body>
<div class="container">
	<div class="page-header">
	    <!-- <h1>Example page header <small>Subtext for header</small></h1> -->
	    <nav class="navbar navbar-default navbar-inverse">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">اسم فامیل</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		      </ul>
		      <ul class="nav navbar-nav navbar-left">
		        <li><a href="<?php echo $this->config->base_url();?>index.php/registerUser">ثبت نام</a></li>
				<li><a href="<?php echo $this->config->base_url();?>index.php/login">ورود</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</div>



