<?php
session_start();
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array(
    "0"=>"",
    "1"=>"มกราคม",
    "2"=>"กุมภาพันธ์",
    "3"=>"มีนาคม",
    "4"=>"เมษายน",
    "5"=>"พฤษภาคม",
    "6"=>"มิถุนายน", 
    "7"=>"กรกฎาคม",
    "8"=>"สิงหาคม",
    "9"=>"กันยายน",
    "10"=>"ตุลาคม",
    "11"=>"พฤศจิกายน",
    "12"=>"ธันวาคม"                 
);
function thai_date($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
    $thai_date_return.= " ที่ ".date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.=" ".(date("Y",$time)+543);
    return $thai_date_return;
}
function thai_date2($time){
    global $thai_day_arr,$thai_month_arr;
    $thai_date_return.= date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.=" ".(date("Y",$time)+543);
    return $thai_date_return;
}
?>
<?php
    require_once('Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
    header('Content-Type: text/html; charset=utf-8');
    $sql = "select * from server where id=1";
    $result = mysqli_query($conn,$sql);
    if($result){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $time_on = $row['on_time'];
        $time_off = $row['off_time'];
        $notice = $row['notice'];
        if((date('Y-m-d') >= $time_on) && (date('Y-m-d') <= $time_off )){
            $open = "<span style='color: green;font-weight:400;'>เปิดลงทะเบียน</span>";
        }else{
            $open = "<span style='color: red;font-weight:400;'>ปิดลงทะเบียน</span>";
        }
        if(empty($notice)){
            $notice = "<h5 style='color:red;text-align: center;'>ยังไม่มีประกาศ</h5>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500" rel="stylesheet">
    <link rel="icon" href="img/cnrlogo.png"/>
    <title>ระบบลงทะเบียนกิจกรรมชุมนุมออนไลน์โรงเรียนชิโนรสวิทยาลัย</title>
</head>
<body>
    <div id="whipper">
        <div id="container">
            <header id="header">
                <img  src="img/banner.jpg" alt="banner">
            </header>
        <nav>
        <ul>
            <?php if(empty($_SESSION['username'])){ echo " <li><a href='#news'>หน้าหลัก</a></li>";}else{echo "<li><a href='auth/student/'>เลือกชุมนุม</a></li>";}?>
            <li><a href="menu/search.php">ค้นหา</a></li>
            <li><a href="menu/clublist.php">รายวิชาชุมนุม</a></li>
            <li><a href="menu/clubstudent.php">รายชื่อห้อง</a></li>
            <li><a href="menu/clubteacher.php">สำหรับครู</a></li>
            <li><a href="menu/contact.php">ติดต่อ</a></li>
            <li><a href="auth/admin/">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <div id="left">
            <span id="status">สถานะ</span>
            <p style="margin-top:20px;">กิจกรรมชุมนุม :: <?php echo $open ?></p>
            <hr style="margin-top:5px;float:left;" width="94%">
            <span style="margin-left:10px;color: green;font-weight:400;font-size:14px">เปิดลงทะเบียน</span>
            <span style="font-size:14px;font-weight:300"> :: <?php $eng_date1=strtotime($time_on);echo thai_date2($eng_date1); ?></span><br>
            <span style="margin-left:10px;color: red;font-weight:400;font-size:14px">ปิดลงทะเบียน</span>
            <span style="font-size:14px;font-weight:300"> :: <?php $eng_date=strtotime($time_off);echo thai_date2($eng_date);?></span>
            <span style="margin-top:20px;margin-bottom: 5px;" id="status">เข้าสู่ระบบ</span>
            <?php  if(empty($_SESSION['username'])){ echo"
            <form method='post' action='auth/login.php'>
                <span style='margin-left:10px;font-weight:400;font-size:14px'>รหัสประจำตัว นร.</span><br>
                <input type='text' name='username' style='margin-left:10px;' minlength=5 maxlength=5 id='input' placeholder='44444' required/>
                <span style='margin-left:10px;font-weight:400;font-size:14px'>รหัสประจำตัวประชาชน</span><br>
                <input name='password' type='password' style='margin-left:10px;' minlength=13 maxlength=13 id='input' placeholder='1167023040567' required/>
                <input type='submit' style='width:85%' id='submit' name='submit' value='ลงชื่อเข้าใช้'>";}else{ $uname = $_SESSION['username'];$name = $_SESSION['name']; echo "<span style='margin-left:10px;font-weight:400;font-size:14px'>รหัสประจำตัว นร. :: $uname <br> &nbsp;&nbsp;ชื่อ-สกุล :: $name </span><br><button id='submit' onclick=\"location.href='auth/logout.php'\">ออกจากระบบ</button>";}
                ?>
            </form>
            <span style="margin-top:20px;" id="status">สอบถามข้อมูล</span>
            <div style="margin-bottom:20px;width:295px;" class="fb-page"
                data-href="https://www.facebook.com/&#xe23;&#xe30;&#xe1a;&#xe1a;&#xe2a;&#xe32;&#xe23;&#xe2a;&#xe19;&#xe40;&#xe17;&#xe28;&#xe42;&#xe23;&#xe07;&#xe40;&#xe23;&#xe35;&#xe22;&#xe19;&#xe0a;&#xe34;&#xe42;&#xe19;&#xe23;&#xe2a;&#xe27;&#xe34;&#xe17;&#xe22;&#xe32;&#xe25;&#xe31;&#xe22;-1932487926836252" 
                data-tabs="timeline" data-small-header="false" data-adapt-container-width="true"data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/&#xe23;&#xe30;&#xe1a;&#xe1a;&#xe2a;&#xe32;&#xe23;&#xe2a;&#xe19;&#xe40;&#xe17;&#xe28;&#xe42;&#xe23;&#xe07;&#xe40;&#xe23;&#xe35;&#xe22;&#xe19;&#xe0a;&#xe34;&#xe42;&#xe19;&#xe23;&#xe2a;&#xe27;&#xe34;&#xe17;&#xe22;&#xe32;&#xe25;&#xe31;&#xe22;-1932487926836252"
                class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/&#xe23;&#xe30;&#xe1a;&#xe1a;&#xe2a;&#xe32;&#xe23;&#xe2a;&#xe19;&#xe40;&#xe17;&#xe28;&#xe42;&#xe23;&#xe07;&#xe40;&#xe23;&#xe35;&#xe22;&#xe19;&#xe0a;&#xe34;&#xe42;&#xe19;&#xe23;&#xe2a;&#xe27;&#xe34;&#xe17;&#xe22;&#xe32;&#xe25;&#xe31;&#xe22;-1932487926836252">
                ระบบสารสนเทศโรงเรียนชิโนรสวิทยาลัย</a></blockquote></div>
        </div>
        <div id="main">
            <div id="right">
            <div class="panel panel-default">
                    <div class="panel-heading" style="background-color:#33b5e5;color:white;">** ขอเชิญทำแบบสอบถามความพึงพอใจการใช้เว็บไซต์การลงทะเบียนชุมนุมออนไลน์ **</div>
                    <div class="panel-body">
                    <center><h5 style="font-weight: 300;">ขอเชิญนักเรียน ครู ผู้บริหาร โรงเรียนชิโนรสวิทยาลัย <br><br>
                                ทำแบบสอบถามความพึงพอใจการใช้เว็บไซต์การลงทะเบียนชุมนุมออนไลน์ <br><br>
                        ของกลุ่มงานกิจกรรมพัฒนาผู้เรียน โรงเรียนชิโนรสวิทยาลัย เพื่อการพัฒนาและปรับปรุงต่อไป</h5></center><br>
                            <span><ol style="margin-left:20px;">คลิกที่นี่เพื่อทำแบบสอบถาม :: <a style="color:#33b5e5;" target="_blank" href="https://bit.ly/2VA6DLs">แบบสอบถาม</a></ol></span><br>
                            
                    </div>
                </div> 
                <div class="panel panel-default">
                    <div class="panel-heading">** ประกาศ **</div>
                    <div class="panel-body"><center style="color:red;"><?php echo $notice;?></center></div>
                </div> 
                <div class="panel panel-default">
                    <div class="panel-heading">** กำหนดการเปิด-ปิดลงทะเบียนกิจกรรมชุมนุม **</div>
                    <div class="panel-body"><li><span style="color:green;">เปิดลงทะเบียน :: </span><?php $eng_date=strtotime($time_on); echo  thai_date($eng_date);?> เวลา : 00:00:00 น.</li><br>
                    <li><span style="color:red;">ปิดลงทะเบียน :: </span><?php $eng_date=strtotime($time_off); echo  thai_date($eng_date);?> เวลา : 00:00:00 น.</li>
                    <li><span >ปัจจุบัน :: </span><?php  $eng_date=time(); echo thai_date($eng_date);?> เวลา :: <span id="span"></span> น.
                    </div>
                </div>  
                <div class="panel panel-default">
                    <div class="panel-heading">** ประเมินการลงทะเบียน **</div>
                    <div class="panel-body">
                    <div class="table-responsive"> 
                    <?php   $sql_class = "select * from member";
                            $result_class = mysqli_query($conn,$sql_class);
                            $num = mysqli_num_rows($result_class);
                            //m2
                            $sql_m2 = "select * from member where count=0";
                            $result_m2= mysqli_query($conn,$sql_m2);
                            $num2 = mysqli_num_rows($result_m2);
                            //m3
                            $sql_m3 = "select * from member where count=1";
                            $result_m3= mysqli_query($conn,$sql_m3);
                            $num3 = mysqli_num_rows($result_m3);
                            $avg2 = ($num2*100)/($num);
                            $avg1 = ($num3*100)/($num);
                            //m2
                            $sqlm2 = "select * from member where class=2";
                            $resultm2= mysqli_query($conn,$sqlm2);
                            $numm2 = mysqli_num_rows($resultm2);
                            //m2_act
                            $sqlm2_act = "select * from member where class=2 and count=0";
                            $resultm2_act= mysqli_query($conn,$sqlm2_act);
                            $numm2_act = mysqli_num_rows($resultm2_act);
                            //m2_noact
                            $sqlm2_noact = "select * from member where class=2 and count=1";
                            $resultm2_noact= mysqli_query($conn,$sqlm2_noact);
                            $numm2_noact = mysqli_num_rows($resultm2_noact);
                            //m3
                            $sqlm3 = "select * from member where class=3";
                            $resultm3= mysqli_query($conn,$sqlm3);
                            $numm3 = mysqli_num_rows($resultm3);
                            //m3_act
                            $sqlm3_act = "select * from member where class=3 and count=0";
                            $resultm3_act= mysqli_query($conn,$sqlm3_act);
                            $numm3_act = mysqli_num_rows($resultm3_act);
                           //m3_noact
                           $sqlm3_noact = "select * from member where class=3 and count=1";
                           $resultm3_noact= mysqli_query($conn,$sqlm3_noact);
                           $numm3_noact = mysqli_num_rows($resultm3_noact);
                            //m4
                            $sqlm4 = "select * from member where class=4";
                            $resultm4= mysqli_query($conn,$sqlm4);
                            $numm4 = mysqli_num_rows($resultm4);
                            //m4_act
                            $sqlm4_act = "select * from member where class=4 and count=0";
                            $resultm4_act= mysqli_query($conn,$sqlm4_act);
                            $numm4_act = mysqli_num_rows($resultm4_act);
                           //m4_noact
                           $sqlm4_noact = "select * from member where class=4 and count=1";
                           $resultm4_noact= mysqli_query($conn,$sqlm4_noact);
                           $numm4_noact = mysqli_num_rows($resultm4_noact);
                            //m5
                            $sqlm5 = "select * from member where class=5";
                            $resultm5= mysqli_query($conn,$sqlm5);
                            $numm5 = mysqli_num_rows($resultm5);
                            //m5_act
                            $sqlm5_act = "select * from member where class=5 and count=0";
                            $resultm5_act= mysqli_query($conn,$sqlm5_act);
                            $numm5_act = mysqli_num_rows($resultm5_act);
                           //m5_noact
                           $sqlm5_noact = "select * from member where class=4 and count=1";
                           $resultm5_noact= mysqli_query($conn,$sqlm5_noact);
                           $numm5_noact = mysqli_num_rows($resultm5_noact);
                            //m6
                            $sqlm6 = "select * from member where class=6";
                            $resultm6= mysqli_query($conn,$sqlm6);
                            $numm6 = mysqli_num_rows($resultm6);
                            //m6_act
                            $sqlm6_act = "select * from member where class=6 and count=0";
                            $resultm6_act= mysqli_query($conn,$sqlm6_act);
                            $numm6_act = mysqli_num_rows($resultm6_act);
                           //m6_noact
                           $sqlm6_noact = "select * from member where class=6 and count=1";
                           $resultm6_noact= mysqli_query($conn,$sqlm6_noact);
                           $numm6_noact = mysqli_num_rows($resultm6_noact);
                    ?>
                    <ol>จำนวนนักเรียนทั้งหมด <span style="color:#47a8e5;"><?php echo "&nbsp;&nbsp;".$num."&nbsp;&nbsp;"; ?></span> คน  <br>
                    <ol>
                    ลงทะเบียนแล้ว <span style="color:green;"><?php echo "&nbsp;&nbsp;".$num2."&nbsp;&nbsp"."( ".(number_format($avg2,2))."% )" ?></span> คน
                    </ol>
                    <ol>
                    ยังไม่ลงทะเบียน <span style="color:red;"><?php echo "&nbsp;&nbsp;".$num3."&nbsp;&nbsp;"."( ".(number_format($avg1,2))."% )"; ?></span> คน
                    </ol>
                    </ol>
                    <br>  
                        <table class="table">
                        <thead>
                            <tr style="background-color: rgb(208,208,208,0.8);">
                                <th>ชั้น</th>
                                <th style="text-align:center;">จำนวน</th>
                                <th style="background-color:rgb(50,205,50,0.7);text-align:center;">ลงทะเบียน</th>
                                <th style="background-color:rgb(220,20,60,0.9);text-align:center;">ไม่ลงทะเบียน</th>
                                <th style="text-align:center;">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>มัธยมศึกษาปีที่ 2</td>
                                <td style="text-align:center;"><?php echo $numm2 ?></td>
                                <td style="background-color:rgb(50,205,50,0.4);text-align:center;"><?php echo $numm2_act ?></td>
                                <th style="background-color:rgb(220,20,60,0.4);text-align:center;"><?php echo $numm2_noact ?></>
                                <td style="text-align:center;"><?php if(($numm2_act == $numm2) && ($numm2 != "0" )){echo "<span style='color: green'>ครบแล้ว</span>";}else{ echo "-";}?></td>
                            </tr>
                            <tr>
                                 <td>มัธยมศึกษาปีที่ 3</td>
                                <td style="text-align:center;"><?php echo $numm3 ?></td>
                                <td style="background-color:rgb(50,205,50,0.4);text-align:center;"><?php echo $numm3_act ?></td>
                                <th style="background-color:rgb(220,20,60,0.4);text-align:center;"><?php echo $numm3_noact ?></td>
                                <td style="text-align:center;"><?php if(($numm3_act == $numm3)  && ($numm3 != "0")){echo "<span style='color: green'>ครบแล้ว</span>";}else{ echo "-";}?></td>
                            </tr>
                            <tr>
                                 <td >มัธยมศึกษาปีที่ 4</td>
                                <td style="text-align:center;"><?php echo $numm4 ?></td>
                                <td style="background-color:rgb(50,205,50,0.4);text-align:center;"><?php echo $numm4_act ?></td>
                                <th style="background-color:rgb(220,20,60,0.4);text-align:center;"><?php echo $numm4_noact ?></td>
                                <td style="text-align:center;"><?php if(($numm4_act == $numm4) && ($numm4 != "0")){echo "<span style='color: green'>ครบแล้ว</span>";}else{ echo "-";}?></td>
                            </tr>
                            <tr>
                                 <td>มัธยมศึกษาปีที่ 5</td>
                                <td style="text-align:center;"><?php echo $numm5 ?></td>
                                <td style="background-color:rgb(50,205,50,0.4);text-align:center;"><?php echo $numm5_act ?></td>
                                <th style="background-color:rgb(220,20,60,0.4);text-align:center;"><?php echo $numm5_noact ?></t>
                                <td style="text-align:center;"><?php if(($numm5_act == $numm5) && ($numm5 != "0")){echo "<span style='color: green'>ครบแล้ว</span>";}else{ echo "-";}?></td>
                            </tr>
                            <tr>
                                 <td>มัธยมศึกษาปีที่ 6</td>
                                <td style="text-align:center;"><?php echo $numm6 ?></td>
                                <td style="background-color:rgb(50,205,50,0.4);text-align:center;"><?php echo $numm6_act ?></td>
                                <th style="background-color:rgb(220,20,60,0.4);text-align:center;"><?php echo $numm6_noact ?></td>
                                <td style="text-align:center;"><?php if(($numm6_act == $numm6)  && ($numm6 != "0")){echo "<span style='color: green'>ครบแล้ว</span>";}else{ echo "-";}?></td>
                            </tr>
                            <tr style="background-color: rgb(208,208,208,0.8);">
                                 <td style="text-align:center;">รวม</td>
                                <td style="text-align:center;"><?php echo $num ?></td>
                                <td style="background-color:rgb(50,205,50,0.7);text-align:center;"><?php echo $num2 ?></td>
                                <th style="background-color:rgb(220,20,60,0.9);text-align:center;"><?php echo $num3 ?></td>
                                <td style=""></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                </div>
                <!-- ขั้น -->
                <div class="panel panel-default">
                    <div class="panel-heading">** คำชี้แจงในการเข้าสู่ระบบของนักเรียน ** </div>
                    <div class="panel-body"><li>รหัสนักเรียน :: ให้ใช้รหัสประจำตัวนักเรียน 5 หลัก เช่น 44444</li><br><li>รหัสประจำตัวประชาชน :: ให้ใช้รหัสประจำตัวประชาชน 13 หลัก เช่น 1167023040567</li></div>
                </div> 
                <div class="panel panel-default">
                    <div class="panel-heading">** คู่มือการใช้งาน **</div>
                    <div class="panel-body"><center><br><a href="pdf/manual.pdf "><img width="35px" src="img/save.svg"/><br>คู่มือการใช้งานนักเรียน</a><br><br><a href="pdf/manual_tc.pdf "><img width="35px" src="img/database.svg"/><br>คู่มือการใช้งานครู</a></center></div>
                </div> 
                <div style="margin-bottom:20px;" class="panel panel-default">
                    <div class="panel-heading">** คำแนะนำ **</div>
                    <div class="panel-body"><li>กรุณาใช้ Google Chrome เป็นเว็บบราวเซอร์ในการดำเนินการ</li></div>
                </div> 
                <footer class="footer"><br>ระบบลงทะเบียนชุมนุมโรงเรียนชิโนรสวิทยาลัย <br> &copy; <?php echo date('Y');?> <a style="color:white;text-decoration-line: none;"href="https://thanawatgulati.com">Thanawat Gulati</a></footer>
                 <!-- ขั้น -->
                </div>   
            </div> 
        </div>
        </div>
        
    </div>
    <script async src="script/script.js"></script>
</body>
</html>
<?php     mysqli_close($conn);?>