
<?php
    session_start();
    require_once('../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
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

<?php
session_start();
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
    global $thai_month_arr;
    $thai_date_return.= date("j",$time);
    $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
    $thai_date_return.=" ".(date("Y",$time)+543);
    return $thai_date_return;
}
$on =  strtotime($time_on);
$off = strtotime($time_off);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500" rel="stylesheet">
    <link rel="icon" href="../img/cnrlogo.png"/>
    <title>ระบบลงทะเบียนกิจกรรมชุมนุมออนไลน์โรงเรียนชิโนรสวิทยาลัย</title>
</head>
<body>
    <div id="whipper">
        <div id="container">
            <header id="header">
                <img src="../img/banner.jpg" alt="banner">
            </header>
        <nav>
        <ul>
            <?php if(empty($_SESSION['username'])){ echo " <li><a href='../'>หน้าหลัก</a></li>";}else{echo "<li><a href='../auth/student/'>เลือกชุมนุม</a></li>";}?>
            <li><a href="search.php">ค้นหา</a></li>
            <li><a href="clublist.php">รายวิชาชุมนุม</a></li>
            <li><a href="clubstudent.php">รายชื่อห้อง</a></li>
            <li><a href="clubteacher.php">สำหรับครู</a></li>
            <li><a href="contact.php">ติดต่อ</a></li>
            <li><a href="../auth/admin/">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <div id="left">
            <span id="status">สถานะ</span>
            <p style="margin-top:20px;">กิจกรรมชุมนุม :: <?php echo $open ?></p>
            <hr style="margin-top:5px;float:left;" width="94%">
            <span style="margin-left:10px;color: green;font-weight:400;font-size:14px">เปิดลงทะเบียน</span>
            <span style="font-size:14px;font-weight:300"> :: <?php echo thai_date($on); ?></span><br>
            <span style="margin-left:10px;color: red;font-weight:400;font-size:14px">ปิดลงทะเบียน</span>
            <span style="font-size:14px;font-weight:300"> :: <?php echo thai_date($off); ?></span>
        </div>
        <div id="main">
            <div style="width: 68%;" id="right">
                <div  style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">** รายชื่อนักเรียนแต่ละห้อง **</div>
                    <div class="panel-body">
                    <?php                    
                     $class = $_POST['class']; ?>
                    <center><form  style="width:40%;"action="" method="POST">
                        กรุณาเลือกระดับชั้นเรียน
                        <select name="class" id="input" class="form-control" required="required">
                            <option <?php if($class == 0){echo "selected";}?>  value="0">-- กรุณาเลือกตัวเลือก --</option>
                            <option <?php if($class == 2){echo "selected";}?>  value="2">มัธยมศึกษาปีที่ 2</option>
                            <option <?php if($class == 3){echo "selected";}?>  value="3">มัธยมศึกษาปีที่ 3</option>
                            <option <?php if($class == 4){echo "selected";}?>  value="4">มัธยมศึกษาปีที่ 4</option>
                            <option <?php if($class == 5){echo "selected";}?>  value="5">มัธยมศึกษาปีที่ 5</option>
                            <option <?php if($class == 6){echo "selected";}?>  value="6">มัธยมศึกษาปีที่ 6</option>
                        </select>
                        <input  id="submit" style="width:200px;" type="submit" value="ตกลง" name="sub1">
                    </form>
                    </center>
                    <?php 
                    if($_POST['sub1']){ 
                        if($_POST['class'] == 0){
                            echo "<script>alert('กรุณาเลือกตัวเลือก')</script>";
                        }else{ 
                    $room = $_POST['room'];?>
                    <center><form  style="width:40%;" target="_blank" action="report_student.php" method="POST">
                        กรุณาเลือกห้องเรียน
                        <select name="room" id="input" class="form-control" required="required">
                            <option value="1"><?php echo $class."/1"?></option>
                            <option value="2"><?php echo $class."/2"?></option>
                            <option value="3"><?php echo $class."/3"?></option>
                            <option value="4"><?php echo $class."/4"?></option>
                            <option value="5"><?php echo $class."/5"?></option>
                            <option value="6"><?php echo $class."/6"?></option>
                            <option value="7"><?php echo $class."/7"?></option>
                            <option value="8"><?php echo $class."/8"?></option>
                            <option value="9"><?php echo $class."/9"?></option>
                            <option value="10"><?php echo $class."/10"?></option>
                            <option value="11"><?php echo $class."/11"?></option>
                        </select>
                        <input type="hidden" name="class" value="<?php echo $class ?>"/>
                        <input  id="submit" style="width:200px;" type="submit" value="ตกลง" name="sub2">
                    </form> 
                    <?php } } ?>        
                    </div>
                </div> 
                </div>   
            </div> 
        </div>
        <footer class="footer"><br>ระบบลงทะเบียนชุมนุมโรงเรียนชิโนรสวิทยาลัย <br> &copy; <?php echo date('Y');?> <a style="color:white;text-decoration-line: none;"href="https://thanawatgulati.com">Thanawat Gulati</a></footer>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>