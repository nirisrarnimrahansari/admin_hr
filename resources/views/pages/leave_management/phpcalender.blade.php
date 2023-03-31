<?php  


   $eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : 0;
   $time    = time();
   $numDay  = date('d', $time);
   $numMonth = !empty($_REQUEST['month'] ) ? $_REQUEST['month'] : date('m', $time) ;
   $strMonth = date('F', mktime(0, 0, 0, $numMonth, 10));
   $numYear = !empty($_REQUEST['year'] ) ? $_REQUEST['year'] : date('Y', $time);
   $firstDay = mktime(0,0,0,$numMonth,1,$numYear);
   $daysInMonth = cal_days_in_month(0, $numMonth, $numYear);
   $dayOfWeek = date('w', $firstDay);
   /* Define varibles for calendar end */
   
   //current month first day
   $start_month_date = date('Y-m-d',strtotime( $numYear.'-'.$numMonth.'-01' ));
   //current month last day
   $end_month_date = date('Y-m-d',strtotime( $numYear.'-'.$numMonth.'-'.$daysInMonth ));
   
   ?>
<!-- partial -->
<div class="main-panel">
   <div class="container-fluid">
      <div class="card-body">
         <!-- calender -->
         <div class="wrapper">
            <h3 class="text-center text-primary"><?php echo $strMonth." ".$numYear; ?></h3>
            <table class="table ">
               <thead>
                  <tr>
                     <th abbr="Sunday" scope="col" class="bg-danger " title="Sunday" style="font-weight: bold;">S</th>
                     <th abbr="Monday" scope="col" title="Monday" style="font-weight: bold;">M</th>
                     <th abbr="Tuesday" scope="col" title="Tuesday" style="font-weight: bold;">T</th>
                     <th abbr="Wednesday" scope="col" title="Wednesday" style="font-weight: bold;">W</th>
                     <th abbr="Thursday" scope="col" title="Thursday" style="font-weight: bold;">T</th>
                     <th abbr="Friday" scope="col" title="Friday" style="font-weight: bold;">F</th>
                     <th abbr="Saturday" scope="col" title="Saturday" style="font-weight: bold;">S</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
            <?php
            if(0 != $dayOfWeek) { echo('<td colspan="'.$dayOfWeek.'"> </td>'); }
                     // print_r($dayOfWeek); 5 for friday month k 1st week m konsa day h
               for($i=1;$i<=$daysInMonth;$i++) {
                        if($i == $numDay && date('m', $time) == $numMonth) { echo('<td id="today" class="current date-picker">'); 
                        } else { echo("<td class='date-picker'>"); }
                        $text_color = "";
                        if ( !empty($d_rows_array) ) {
                           foreach( $d_rows_array as $d_row) {
                              if( intval( $i ) === intval( date( 'd', strtotime( $d_row['date'] ) ) ) ){
                                 $text_color = "text-warning";
                                 ?>
                                 <span class="badge badge-warning"><?php echo $d_row['name']; ?> </span> 
                                 <?php  
                              }  
                           }
                        }
                        if ( !empty($l_rows_array) ) {
                           foreach( $l_rows_array as $l_row) {
                              if( intval( $i ) === intval( date( 'd', strtotime( $l_row['leave_date'] ) ) ) ){
                                 if( "Leave" == $l_row['leave_type'] ){
                                    $badge_class = 'badge-pink fs-3 fw-bolder';
                                    $text_color = 'text-pink';
                                 }elseif( "Half Leave" == $l_row['leave_type'] ){
                                    $badge_class = 'badge-info fs-3 fw-bolder';
                                    $text_color = 'text-info';
                                 }elseif( "Overtime" == $l_row['leave_type'] ){
                                    $badge_class = 'badge-success fs-3 fw-bolder';
                                    $text_color = 'text-success';
                                 }elseif( "Unapproved Leave" == $l_row['leave_type'] ){
                                    $badge_class = 'badge-primary fs-3 fw-bolder';
                                    $text_color = 'text-primary';
                                 }elseif( "Unapproved Half day" == $l_row['leave_type'] ){
                                    $badge_class = 'badge-secondary fs-3 fw-bolder';
                                    $text_color = 'text-secondary';
                                 }
                                 ?>
                                <form action="" method="POST" id="leave-status-form-<?php echo $i; ?>"> 
                                   <input type="hidden" name="leave_id" value="<?php echo $l_row['id']; ?>">
                                   <span class="badge <?php echo $badge_class; ?>">
                                   <select class="form-control" onChange="change_leave_status('#leave-status-form-<?php echo $i; ?>')" id="leave_type" name="leave_type">
                                       <option <?php echo "Leave" == $l_row['leave_type'] ? "selected":""; ?>>Leave</option>
                                       <option <?php echo "Half Leave" == $l_row['leave_type'] ? "selected":""; ?>>Half Leave</option>
                                       <option <?php echo "Overtime" == $l_row['leave_type'] ? "selected":""; ?>>Overtime</option>
                                       <option <?php echo "Unapproved Leave" == $l_row['leave_type'] ? "selected":""; ?>>Unapproved Leave</option>
                                       <option <?php echo "Unapproved Half day" == $l_row['leave_type'] ? "selected":""; ?>>Unapproved Half day</option>
                                    </select>
                                 </span> 
                                </form> <?php  
                              }  
                           }
                        }
                        echo "<br/><span class='".$text_color."'>".$i."</span>";
                        echo("</td>");
                        if(date('w', mktime(0,0,0,$numMonth, $i, $numYear)) == 6) {
                           echo("</tr><tr>");
                        }
                     }
                     ?>
                  </tr>
               </tbody>
            </table>
            <div class="btn-group">
               <a href='<?php echo $siteurl."pages/leave-management/calender.php?eid=".$eid."&month="; 
               echo 1 < $numMonth ? intval($numMonth)-1 ."&year=".$numYear : 12 ."&year=".intval( $numYear ) - 1;?>' class="btn btn-primary"><< Prev</a>
               <a href="<?php echo $siteurl.'pages/leave-management/calender.php?eid='.$eid.'&month='; echo 12 > $numMonth ? intval($numMonth)+1 . '&year='.$numYear : 1 .'&year='.intval( $numYear ) + 1;?>" class="btn btn-secondary">Next >></a>
            </div>
         </div>
      </div>
   </div>
   <!-- content-wrapper ends -->
   <!-- partial -->
   <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
