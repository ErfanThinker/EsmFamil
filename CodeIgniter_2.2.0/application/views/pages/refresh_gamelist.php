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