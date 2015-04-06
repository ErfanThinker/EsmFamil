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