<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title >esmFamil</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="<?php echo $this->config->base_url();?>css/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="<?php echo $this->config->base_url();?>css/css/HamidGharb.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo $this->config->base_url();?>css/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo $this->config->base_url();?>css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-green sidebar-collapse">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
           !<b>اسم فامیل</b>
           بازی کن
        </a>


        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	  <img src="<?php echo $this->config->base_url();?>css/img/Hamid.jpg" class="user-image" alt="User Image"/>
	  <span class="hidden-xs">کاربر گرامی</span>
	</a>
	<ul class="dropdown-menu">
	  <!-- User image -->
	  <li class="user-header">
	    <img src="<?php echo $this->config->base_url();?>css/img/Hamid.jpg" class="img-circle" alt="User Image" />
	    <p>
	       کاربر گرامی آقا/خانم
	      <small>تاریخ عضویت از تاریخ</small>
	    </p>
	  </li>
	  <!-- Menu Body -->
	  <li class="user-body">
	    <div class="col-xs-4 text-center">
	      <a href="#">دوستان</a>
	    </div>
	    <div class="col-xs-4 text-center">
	      <a href="#">همبازیان</a>
	    </div>
	    <div class="col-xs-4 text-center">
	      <a href="#">امتیازات</a>
	    </div>
	  </li>
	  <!-- Menu Footer-->
	  <li class="user-footer">
	    <div class="pull-left">
	      <a href="#" class="btn btn-default btn-flat">اطلاعات شخصی</a>
	    </div>
	    <div class="pull-right">
	      <a href="#" class="btn btn-default btn-flat">خروج</a>
	    </div>
	  </li>
	</ul>
      </li>
      <!-- Messages: style can be found in dropdown.less-->
      <li class="dropdown messages-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	  <i class="fa fa-envelope-o"></i>
	  <span class="label label-success">4</span>
	</a>
	<ul class="dropdown-menu">
	  <li class="header text-right">.شما ۴  عدد پیروزی داشته اید</li>
	  <li>
	    <!-- inner menu: contains the actual data -->
	    <ul class="menu">
	      <li><!-- start message -->
		<a href="#">
		  <div class="pull-right">
		    <img src="<?php echo $this->config->base_url();?>css/img/Hamid10.jpg" class="img-circle" alt="User Image"/>
		  </div>
		  <h4 class="text-right">
		    آقای قلی خان 
		    
		    <small><i class="fa fa-clock-o">دقیقه پیش ۵</i></small>
		  </h4>
		  <p class="pull-right">.کم آوردی کندلوز بخور</p>
		</a>
	      </li><!-- end message -->
	      <li><!-- start message -->
		<a href="#">
		  <div class="pull-right">
		    <img src="<?php echo $this->config->base_url();?>css/img/Hamid2.jpg" class="img-circle" alt="User Image"/>
		  </div>
		  <h4 class="text-right">
		    آقای جمال خان 
		    
		    <small><i class="fa fa-clock-o">دقیقه پیش ۴</i></small>
		  </h4>
		  <p class="pull-right">.کم آوردی کندلوز بخور</p>
		</a>
	      </li><!-- end message -->
	      
	      <li><!-- start message -->
		<a href="#">
		  <div class="pull-right">
		    <img src="<?php echo $this->config->base_url();?>css/img/Hamid4.jpg" class="img-circle" alt="User Image"/>
		  </div>
		  <h4 class="text-right">
		    آقای تقی خان 
		    
		    <small><i class="fa fa-clock-o">دقیقه پیش ۳</i></small>
		  </h4>
		  <p class="pull-right">.کم آوردی کندلوز بخور</p>
		</a>
	      </li><!-- end message -->
	      <li><!-- start message -->
		<a href="#">
		  <div class="pull-right">
		    <img src="<?php echo $this->config->base_url();?>css/img/Hamid10.jpg" class="img-circle" alt="User Image"/>
		  </div>
		  <h4 class="text-right">
		    آقای قلی خان 
		    
		    <small><i class="fa fa-clock-o">دقیقه پیش ۲</i></small>
		  </h4>
		  <p class="pull-right">.کم آوردی کندلوز بخور</p>
		</a>
	      </li><!-- end message -->
	    </ul>
	  </li>
	  <li class="footer"><a href="#">لیست تمامی پیروزی ها</a></li>
	</ul>
      </li>
      <!-- Notifications: style can be found in dropdown.less -->
      <li class="dropdown notifications-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	  <i class="fa fa-bell-o"></i>
	  <span class="label label-warning">10</span>
	</a>
	<ul class="dropdown-menu">
	  <li class="header">You have 10 notifications</li>
	  <li>
	    <!-- inner menu: contains the actual data -->
	    <ul class="menu">
	      <li>
		<a href="#">
		  <i class="fa fa-users text-aqua"></i> 5 new members joined today
		</a>
	      </li>
	      <li>
		<a href="#">
		  <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
		</a>
	      </li>
	      <li>
		<a href="#">
		  <i class="fa fa-users text-red"></i> 5 new members joined
		</a>
	      </li>

	      <li>
		<a href="#">
		  <i class="fa fa-shopping-cart text-green"></i> 25 sales made
		</a>
	      </li>
	      <li>
		<a href="#">
		  <i class="fa fa-user text-red"></i> You changed your username
		</a>
	      </li>
	    </ul>
	  </li>
	  <li class="footer"><a href="#">View all</a></li>
	</ul>
      </li>
      <!-- Tasks: style can be found in dropdown.less -->
      <li class="dropdown tasks-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	  <i class="fa fa-flag-o"></i>
	  <span class="label label-danger">9</span>
	</a>
	<ul class="dropdown-menu">
	  <li class="header">You have 9 tasks</li>
	  <li>
	    <!-- inner menu: contains the actual data -->
	    <ul class="menu">
	      <li><!-- Task item -->
		<a href="#">
		  <h3>
		    Design some buttons
		    <small class="pull-right">20%</small>
		  </h3>
		  <div class="progress xs">
		    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
		      <span class="sr-only">20% Complete</span>
		    </div>
		  </div>
		</a>
	      </li><!-- end task item -->
	      <li><!-- Task item -->
		<a href="#">
		  <h3>
		    Create a nice theme
		    <small class="pull-right">40%</small>
		  </h3>
		  <div class="progress xs">
		    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
		      <span class="sr-only">40% Complete</span>
		    </div>
		  </div>
		</a>
	      </li><!-- end task item -->
	      <li><!-- Task item -->
		<a href="#">
		  <h3>
		    Some task I need to do
		    <small class="pull-right">60%</small>
		  </h3>
		  <div class="progress xs">
		    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
		      <span class="sr-only">60% Complete</span>
		    </div>
		  </div>
		</a>
	      </li><!-- end task item -->
	      <li><!-- Task item -->
		<a href="#">
		  <h3>
		    Make beautiful transitions
		    <small class="pull-right">80%</small>
		  </h3>
		  <div class="progress xs">
		    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
		      <span class="sr-only">80% Complete</span>
		    </div>
		  </div>
		</a>
	      </li><!-- end task item -->
	    </ul>
	  </li>
	  <li class="footer">
	    <a href="#">View all tasks</a>
	  </li>
	</ul>
      </li>
    </ul>
  </div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-right image">
      <img src="<?php echo $this->config->base_url();?>css/img/Hamid2.jpg" class="img-circle" alt="User Image" />
    </div>
    <div class="pull-right info">
      <p>کاربر گرامی</p>

      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" style="direction: rtl; text-align: right;" placeholder="جستجو  بازی ..."/>
      <span class="input-group-btn">
	<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
      </span>
    </div>
  </form>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" style="direction: rtl;">
    <li class="header">جعبه ابزار</li>
    <li class="active treeview">
      <a href="#">
	<i class="fa fa-dashboard"></i> <span>مدیریت پیغام</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
	<li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> مشاهد پیام ها</a></li>
	<li><a href="index2.html"><i class="fa fa-circle-o"></i> ارسال پیام</a></li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
	<i class="fa fa-files-o"></i> <span> استراتژی بازی</span> <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
	<li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> شروع به بازی</a></li>
	<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> شرکت در بازی</a></li>
      </ul>
    </li>
  </ul>
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

<!-- Content Header (Page header) -->
<section class="content-header" style="text-align: center;">
  <h1>
    </br>
    </br>
    <small>و رویداد ها</small>
آخرین اخبار
  </h1>
    </br>
    </br>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row" style="text-align: right;">
    <div class="col-md-9">
        <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">ایجاد بازی</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label >نام بازی</label>
                      <input type="text" class="form-control" name="gname" placeholder="نام بازی را وارد کنید">
                    </div>
                    <div class="form-group">
                      <label>حداکثر تعداد بازیکنان</label>
                      <input type="number" class="form-control" name="maxPlayer" placeholder="حداکثر تعداد بازیکنان را وارد کنید">
                    </div>
                    <div class="form-group">
                      <label>تعداد دورهای بازی</label>
                      <input type="number" class="form-control" name="maxPlayer" placeholder="تعداد دروه های بازی را وارد کنید">
                      <p class="help-block">/: یعنی تعداد دوره های بازی </p>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">ایجاد</button>
                  </div>
                </form>
                





    </div><!-- /.col -->
  </div>
</section>      

</div>

<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2015 <a href="">esmFamil.ir</a>.</strong> All rights reserved.
      
</footer>

    <!-- jQuery 2.1.3 -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- jQuery UI 1.11.2 -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/jQuery/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo $this->config->base_url();?>css/js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo $this->config->base_url();?>css/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo $this->config->base_url();?>css/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?php echo $this->config->base_url();?>css/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo $this->config->base_url();?>css/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="<?php echo $this->config->base_url();?>css/js/app.min.js" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo $this->config->base_url();?>css/js/pages/dashboard.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo $this->config->base_url();?>css/js/demo.js" type="text/javascript"></script>
  </body>
</html>
