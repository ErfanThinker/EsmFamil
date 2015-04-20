<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row" style="text-align: right;">
    <div class="col-xs-9">
    <div class="box">
                <div class="box-header">
                  <h3 class="box-title">لیست بازی ها</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="text-align: right;">

                  <table id="example1" class="table table-bordered table-striped" style="text-align: right;">
                    <thead>
                      <tr>
                        <th>تعداد دور</th>
                        <th>حداکثر ظرفیت</th>
                        <th>تعداد بازیکنان کنونی</th>
                        <th>ایجاد شده توسط</th>
                      </tr>
                    </thead>
          
                    <tbody>
                    <?php foreach($gameList as $row){ ?>
                      <tr onclick="clickedf(<?php echo $row['gid']; ?>)">
                        <td>
                          <?php echo $row['rounds']; ?>
                        </td>
                        <td>
              <?php echo $row['maxnumofplayers']; ?>
                        </td>
                        <td>
              <?php echo $row['currentlyJoined']; ?>
                        </td>
                        <td>
              <?php echo $row['creaternickname']; ?>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    

                    <tfoot>
                      <tr>
                        <th>تعداد دور</th>
                        <th>حداکثر ظرفیت</th>
                        <th>تعداد بازیکنان کنونی</th>
                        <th>ایجاد شده توسط</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
    <div class="row">
        <div class="col-xs-6" style="float: left; direction: ltr;">
      <div class="dataTables_paginate paging_bootstrap">
        <ul class="pagination">
         <li class="prev disabled"><a href="#"> قبلی</a></li>
         <li class="active"><a href="#">۱</a></li>
         <li><a href="#">۲</a></li>
         <li><a href="#">۳</a></li>
         <li><a href="#">۴</a></li>
         <li><a href="#">بعدی</a></li>
        </ul>
       </div>
        </div>
                </div><!-- /.box -->

    </div><!-- /.col -->
  </div>
</section>      
