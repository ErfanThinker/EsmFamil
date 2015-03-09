<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>EsmFamil Registration</title>

  <!-- <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> -->

  <link rel="stylesheet" href="../css/css/normalize.css">

    <link rel="stylesheet" href="../css/css/style.css" media="screen" type="text/css" />

</head>

<body>
 <div class="form">

      <ul class="tab-group">
        <li class="tab active"><a href="#signup">ثبت نام</a></li>
        
      </ul>

      <div class="tab-content">
        <div id="signup">   
          <h1>ثبت نام</h1>

          <form action="authentication/signIn" method="post">

          
            
	
            <!-- <div class="field-wrap">
              
            </div>
            <div class="field-wrap">
              
            </div> -->
          

          
    
    		<div class="field-wrap">
	            <label style="width: 90%;">
	              نام کاربری<span class="req">*</span>
	            </label>
            	<input type="text"required autocomplete="off" name="nickname"style="text-align: right;"/>
          	</div>



          <div class="field-wrap">
            <label style="width: 90%;">
              رمز عبور<span class="req">*</span>
            </label>
            <input type="password" required autocomplete="off"  name="password"style="text-align: right;"/>
          </div>
          
        

          <button type="submit" class="button button-block"/>ثبت</button>

          </form>

        </div>

        <div id="login">   
          <h1>وارد شوید</h1>

          

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->

  <script src='../css/js/index.js'></script>

  <script src="../css/js/jquery.js"></script>

</body>

</html>
