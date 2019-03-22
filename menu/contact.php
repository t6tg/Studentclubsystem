
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
            <li><a href="search.php">ค้นหา</a></li>
            <li><a href="clublist.php">รายวิชาชุมนุม</a></li>
            <li><a href="clubstudent.php">รายชื่อห้อง</a></li>
            <li><a href="clubteacher.php">สำหรับครู</a></li>
            <li><a href="#">ติดต่อ</a></li>
            <li><a href="../auth/admin/">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <div id="main">
            <div style="width: 100%;" id="right">
                <div style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">ติดต่อปัญหา และ ขอคำแนะนำ</div>
                    <div class="panel-body">
                    <ol>
                        <li>ครู ...................</li><br>
                        <li>ครู ...................</li><br>
                        <li>ครู ...................</li><br>
                    </ol>
                    <div style="margin-left: 20px;">
                        <h5>หากเข้าสู่ระบบไม่ได้ให้ติดต่อที่</h5>
                        <li >ห้องกิจกรรมพัฒนาผู้เรียน</li><br>
                    </div>
                    </div>
                </div> 
                </div>   
            </div> 
            <footer class="footer"><br>ระบบลงทะเบียนชุมนุมโรงเรียนชิโนรสวิทยาลัย <br> &copy; <?php echo date('Y');?> <a style="color:white;text-decoration-line: none;"href="https://thanawatgulati.com">Thanawat Gulati</a></footer>
        </div>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>