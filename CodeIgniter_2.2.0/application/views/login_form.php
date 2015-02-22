<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>CodePen - Sign-Up/Login Form</title>

  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="css/normalize.css">

    <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />

</head>

<body>

  <div class="form">

      <ul class="tab-group">
        <li class="tab active"><a href="#signup">ثبت نام</a></li>
        <li class="tab"><a href="#login">ورود</a></li>
      </ul>

      <div class="tab-content">
        <div id="signup">   
          <h1>ثبت نام</h1>

          <form action="/" method="post">

          <div class="top-row ">
            <div class="field-wrap ">
              <label>
                نام و نام خانوادگی<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" />
            </div>

            <div class="field-wrap">
              <label>
                سن(حداقل ۸)<span class="req">*</span>
              </label>
              <input type="number" min="8" required autocomplete="off" />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              پست الکترونیکی<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off"/>
          </div>
		
		<div class="field-wrap">
            <label>
              نام کاربری<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off"/>
          </div>



          <div class="field-wrap">
            <label>
              رمز عبور<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"/>
          </div>
          
	  <div class="field-wrap">
            <label>
              تکرار رمز عبور<span class="req">*</span>
            </label>
            <input type="repassword"required autocomplete="off"/>
          </div>

          <button type="submit" class="button button-block"/>ثبت</button>

          </form>

        </div>

        <div id="login">   
          <h1>وارد شوید</h1>

          <form action="/" method="post">

            <div class="field-wrap">
            <label>
              پست الکترونیکی<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>
              رمز ورود<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"/>
          </div>

          <p class="forgot"><a href="#">رمز خود را فراموش کرده اید؟</a></p>

          <button class="button button-block"/>ورود</button>

          </form>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->

  <script src='js/jquery.js'></script>

  <script src="js/index.js"></script>

</body>

</html>
