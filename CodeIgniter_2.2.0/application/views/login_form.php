<!DOCTYPE html>
<html>

<head>

  <meta charset="UTF-8">

  <title>EsmFamil Registration</title>

  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>

  <link rel="stylesheet" href="../../css/css/normalize.css">

    <link rel="stylesheet" href="../../css/css/style.css" media="screen" type="text/css" />

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
              <label style="width: 90%;">
                نام و نام خانوادگی<span class="req">(اختیاری)</span>
              </label>
              <input type="text" required autocomplete="on" name="name" style="text-align: right;"/>
            </div>
          </div>

            <div class="field-wrap">
              <div class "field-wrap date"> 
                <label style="width: 90%;">
                  سال تولد<span class="req ">*(بالای ۱۳۵۰)</span>
                </label style="width: 90%;">
                <input type="number" min="1350" required autocomplete="off" name="byear"style="text-align: right; direction: rtl;"/>
              </div>
            </div>
    
            <div class="field-wrap">
	  <div class "field-wrap date"> 
              <label style="width: 90%;">
                ماه<span class="req ">*(بین ۱ الی ۱۲)</span>
              </label>
              <input type="number" min="1" max="12" required autocomplete="off" name="bmonth"style="text-align: right; direction: rtl;"/>
              </div>
         </div>    
	<div class="field-wrap">
              <div class "field-wrap date"> 
              <label style="width: 90%;">
                روز<span class="req ">*(بین ۱ الی ۳۱)</span>
              </label>
              <input type="number" min="1" max="31" required autocomplete="off" name="bday"style="text-align: right; direction: rtl;"/>
              </div>
            </div>
            <!-- <div class="field-wrap">
              
            </div>
            <div class="field-wrap">
              
            </div> -->
          

          <div class="field-wrap">
            <label style="width: 90%;">
              پست الکترونیکی<span class="req">*(انگلیسی)</span>
            </label>
            <input type="email"required autocomplete="off" name="email"style="text-align: right;"/>
          </div>
    
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
          
        <div class="field-wrap">
            <label style="width: 90%;">
              تکرار رمز عبور<span class="req">*</span>
            </label style="width: 90%;">
            <input type="password" required autocomplete="off"style="text-align: right;"/>
          </div>
          <div class="field-wrap">
            <label style="width: 90%;">
              عبارت موجود در کادر را وارد کنید:<span class="req">*</span>
            </label>
            <input cid ="<?php $cid?>" type="text"required autocomplete="off" name="captcha"style="text-align: right;"/>
          </div>

          <button type="submit" class="button button-block"/>ثبت</button>

          </form>

        </div>

        <div id="login">   
          <h1>وارد شوید</h1>

          <form action="/" method="post">

            <div class="field-wrap">
            <label style="width: 90%;">
              پست الکترونیکی<span class="req">*(انگلیسی)</span>
            </label>
            <input type="email"required autocomplete="off"style="text-align: right;"/>
          </div>

          <div class="field-wrap">
            <label style="width: 90%;">
              رمز ورود<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"style="text-align: right;"/>
          </div>


          <!-- <div class="field-wrap">
            <label style="width: 90%;">
              عبارت موجود در کادر<span class="req">*</span>
            </label>
            <input type="text"required autocomplete="off" name="captcha"style="text-align: right;"/>
          </div> -->

          <p class="forgot"><a href="#">رمز خود را فراموش کرده اید؟</a></p>

          <button class="button button-block"/>ورود</button>

          </form>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->

  <script src='../../css/js/index.js'></script>

  <script src="../../css/js/jquery.js"></script>

</body>

</html>
