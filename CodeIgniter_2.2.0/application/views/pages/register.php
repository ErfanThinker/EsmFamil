<div id="center-block" style="width:50%;">
<form action="registerUser" method="post">
    <div class="box-header">
      <h3 class="box-title">فرم ثبت نام</h3>
    </div>
    <br>
  <div class="form-group ">
    <label for="exampleInputName">نام</label>
    <input type="text" class="form-control" name="name" id="exampleInputName" placeholder="نام">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">آدرس ایمیل</label>
    <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="ایمیل">
  </div>


  <div class ="form-group field-wrap date">
    <label for="year">تاریخ تولد</label> <br>
              سال
                <select name="byear" id="year" class="form-control" style="width:100px;display:inline-flex;">
                        <option value="1330" >1330</option>
                        <option value="1331" >1331</option>
                        <option value="1332" >1332</option>
                        <option value="1333" >1333</option>
                        <option value="1334" >1334</option>
                        <option value="1335" >1335</option>
                        <option value="1336" >1336</option>
                        <option value="1337" >1337</option>
                        <option value="1338" >1338</option>
                        <option value="1339" >1339</option>
                        <option value="1340">1340</option>
                        <option value="1341">1341</option>
                        <option value="1342">1342</option>
                        <option value="1343">1343</option>
                        <option value="1344">1344</option>
                        <option value="1345">1345</option>
                        <option value="1346">1346</option>
                        <option value="1347">1347</option>
                        <option value="1348">1348</option>
                        <option value="1349">1349</option>
                        <option value="1350">1350</option>
                        <option value="1351">1351</option>
                        <option value="1352">1352</option>
                        <option value="1353">1353</option>
                        <option value="1354">1354</option>
                        <option value="1355">1355</option>
                        <option value="1356">1356</option>
                        <option value="1357">1357</option>
                        <option value="1358">1358</option>
                        <option value="1359">1359</option>
                        <option value="1360">1360</option>
                        <option value="1361">1361</option>
                        <option value="1362">1362</option>
                        <option value="1363">1363</option>
                        <option value="1364">1364</option>
                        <option value="1365">1365</option>
                        <option value="1366">1366</option>
                        <option value="1367">1367</option>
                        <option value="1368">1368</option>
                        <option value="1369">1369</option>
                        <option value="1370">1370</option>
                        <option value="1371">1371</option>
                        <option value="1372">1372</option>
                        <option value="1373">1373</option>
                        <option value="1374">1374</option>
                        <option value="1375">1375</option>
                        <option value="1376">1376</option>
                        <option value="1377">1377</option>
                        <option value="1378">1378</option>
                        <option value="1379">1379</option>
                        <option value="1380">1380</option>
                        <option value="1381">1381</option>
                        <option value="1382">1382</option>
                        <option value="1383">1383</option>
                        <option value="1384">1384</option>
                        <option value="1385">1385</option>
                    </select>

         ماه
                <select name="bmonth" id="month" class="form-control" style="width:100px;display:inline-flex;">
                        <option value="1" >فروردین</option>
                        <option value="2">اردیبهشت</option>
                        <option value="3">خرداد</option>
                        <option value="4">تیر</option>
                        <option value="5">مرداد</option>
                        <option value="6">شهریور</option>
                        <option value="7">مهر</option>
                        <option value="8">آبان</option>
                        <option value="9">آذر</option>
                        <option value="10">دی</option>
                        <option value="11">بهمن</option>
                        <option value="12">اسفند</option>
                    </select>

         روز
                <select name="bday" id="day" class="form-control" style="width:100px;display:inline-flex;">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
               
           </select>
  </div>
 
  <div class="form-group">
    <label for="captcha"> عبارت موجود در کادر را وارد کنید:</label>
    <input type="text" class="form-control" id="captcha" placeholder=""/>
  </div>

  <div class="form-group">
    <label for="exampleInputNickName">نام کاربری</label>
    <input type="text" class="form-control" name="nickname" id="exampleInputNickName" placeholder="نام کاربری">
  </div>

  <div class="form-group ">
    <label for="exampleInputPassword1">گذر واژه</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="گذر واژه">
  </div>



  
  <button type="submit" class="btn btn-default" style="">ارسال</button>
</form>
</div>