<div id="center-block">

<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row" style="text-align: right;" >
    <div class="col-xs-9" align="center">
    <div class="box">
                <div class="box-header" >
                  <h3 class="box-title" >لیست بازی ها</h3>
                </div><!-- /.box-header -->
                <div class="box-body" style="text-align: right;">

                  <table id="example1" class="table table-bordered table-striped" style="text-align: right;">
                    <thead>
                      <tr>
                        <th>تعداد دور</th>
                        <th>حداکثر ظرفیت</th>
                        <th>تعداد بازیکنان کنونی</th>
                        <th>ایجاد شده توسط</th>
                        <th></th>
                      </tr>
                    </thead>
          
                    <tbody id="ajax-tbody">
                    <?php foreach($gameList as $row){ ?>
                      <tr >
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
                        <td>
              <a onclick="clickedf(<?php echo $row['gid']; ?>)"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                    

                    <!-- <tfoot>
                      <tr>
                        <th>تعداد دور</th>
                        <th>حداکثر ظرفیت</th>
                        <th>تعداد بازیکنان کنونی</th>
                        <th>ایجاد شده توسط</th>
                      </tr>
                    </tfoot> -->
                  </table>
                </div><!-- /.box-body -->
    <!-- <div class="row">
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
                </div> -->

    </div><!-- /.col -->
  </div>
</section>      

</div>

<script type="text/javascript">
//some thing alaki
      //refresh list every 10 sec
      setInterval(function(){
        $.ajax({url: "<?php echo $this->config->base_url();?>index.php/refreshListOfGames", success: function(result){
            //alert("gameList refreshed");
            $("#ajax-tbody").html(result);
        }});  
      }, 10000);

    function clickedf($gid){
      //alert($gid);
      post('addPlayerToGame', {gid: $gid});
    }

    function post(path, params, method) {
        method = method || "post"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
             }
        }

        document.body.appendChild(form);
        form.submit();
    }
    </script>

