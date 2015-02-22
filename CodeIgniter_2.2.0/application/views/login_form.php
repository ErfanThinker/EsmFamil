<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>EsmFamil Registration</title>

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

          <form action="registerUser" method="post">

          <div class="req">
            <div class="field-wrap ">
              <label>
                نام و نام خانوادگی<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name="name"/>
            </div>
          </div>

            <!-- <div class="field-wrap">
              <label>
                سن(حداقل ۸)<span class="req">*</span>
              </label>
              <input type="number" min="8" required autocomplete="off" />
            </div> -->
            <div class="field-wrap">
              <div class "field-wrap date"> 
                <label>
                  سال تولد<span class="req ">*</span>
                </label>
                <input type="number" min="1350" required autocomplete="off" name="byear"/>
              </div>
              <div class "field-wrap date"> 
              <label>
                ماه<span class="req ">*</span>
              </label>
              <input type="number" min="1" max="12" required autocomplete="off" name="bmonth"/>
              </div>
              <div class "field-wrap date"> 
              <label>
                روز<span class="req ">*</span>
              </label>
              <input type="number" min="1" max="31" required autocomplete="off" name="bday"/>
              </div>
            </div>
            <!-- <div class="field-wrap">
              
            </div>
            <div class="field-wrap">
              
            </div> -->
          

          <div class="field-wrap">
            <label>
              پست الکترونیکی<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="email"/>
          </div>
    
    <div class="field-wrap">
            <label>
              نام کاربری<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="nickname"/>
          </div>



          <div class="field-wrap">
            <label>
              رمز عبور<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"  name="password"/>
          </div>
          
        <div class="field-wrap">
            <label>
              تکرار رمز عبور<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"/>
          </div>
          <div class="field-wrap">
            <label>
              عبارت موجود در کادر را وارد کنید:<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="captcha"/>
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


          <!-- <div class="field-wrap">
            <label>
              عبارت موجود در کادر<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="captcha"/>
          </div> -->

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
