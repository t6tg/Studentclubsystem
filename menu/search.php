
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
            <li><a href="#">ค้นหา</a></li>
            <li><a href="clublist.php">รายวิชาชุมนุม</a></li>
            <li><a href="clubstudent.php">รายชื่อห้อง</a></li>
            <li><a href="clubteacher.php">สำหรับครู</a></li>
            <li><a href="contact.php">ติดต่อ</a></li>
            <li><a href="../auth/admin/">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <div id="main">
            <div style="width: 100%;" id="right">
                <div   style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">** ค้นหา **</div>
                    <div class="panel-body">
                    <form action="" method="post">
                        <input type="text" palceholder="กรุณากรอกคำค้นหา" style="width:70%;" name="search" required/> <input type="submit" name="submit" style="width:20%;color:white;background-color:#47a8e5" value="Search"/>
                    </form>
                    <li style="margin-top:20px;">ข้อมูลที่สามารถค้นหาได้คือ รหัสประจำตัวประชาชน, รหัสนักเรียน, ชื่อ หรือ นามสกุล</li>
                    </div>
                </div> 
                <?php if($_POST['submit']) { 
                    $strSQL = "SELECT * FROM member WHERE (name LIKE '%".$_POST["search"]."%' or username LIKE '%".$_POST["search"]."%' or password LIKE '%".$_POST["search"]."%')";
                    $objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); ?>
                <br><table class='table table-striped'>
                <thead>
                <tr>
                <th scope='col'>รหัสนักเรียน</th>
                <th scope='col'>ชื่อ - สกุล</th>
                <th scope='col'>ชั้น</th>
                <th scope='col'>เลขที่</th>
                <th scope='col'>สถานะลงทะเบียน</th>
                <th scope='col'>พิมพ์ใบยืนยัน</th>
                </tr>
                </thead>
                <tbody>
                <?php
	            while($objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC))
                { ?>
                <tr>
                <td><?php echo $objResult["username"];?></td>
                <td><?php echo $objResult["name"];?></td>
                <td><?php echo $objResult["class"]."/".$objResult["room"];?></td>
                <td><?php echo $objResult["num"];?></td>
                <td><?php if(empty($objResult['club_value'])){
                    echo "<img style='width:20px;' src='../img/error.svg'/>";}
                    else{echo "<img style='width:20px;' src='../img/checked.svg'/>";} ?></td>
                <td>
                <?php if(empty($objResult['club_value'])){ }else{?>
                <form method="post" target="_blank" action="report/index.php">
                <input style='width:20px;' name='report' type="hidden" value="<?php echo $objResult["username"];?>"/>
                <input style="margin-top:-8px;width:100px;height:30px;color:white;background-color:#33b5e5;border: none;"  name='submit' type="submit" value="พิมพ์ใบยืนยัน"/>
                </form>
                <?php } ?>
                </td>
                    </tr>
                <?php } ?>
                </tbody>
                </table><br>
                <center><button id='submit' style='width:30%;margin-bottom:20px;' onclick="location.href='search.php'">ย้อนกลับ</button></center>
                <?php } ?>
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