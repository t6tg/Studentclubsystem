<?php
    session_start();
    $c_id = $_POST['id'];
    require_once('../../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
    header('Content-Type: text/html; charset=utf-8');
    $sql = "select * from server where id=1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($_SESSION['status'] != "admin"){
        header("Location: ../logout.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500" rel="stylesheet">
    <link rel="icon" href="../../img/cnrlogo.png"/>
    <title>ระบบลงทะเบียนกิจกรรมชุมนุมออนไลน์โรงเรียนชิโนรสวิทยาลัย</title>
</head>
<body>
    <div id="whipper">
        <div id="container">
            <header id="header">
                <img src="../../img/banner.jpg" alt="banner">
            </header>
        <nav>
        <ul>
            <li><a href="../../">หน้าหลัก</a></li>
            <li><a href="../../menu/search.php">ค้นหา</a></li>
            <li><a href="../../menu/clublist.php">รายวิชาชุมนุม</a></li>
            <li><a href="../../menu/clubteacher.php">สำหรับครู</a></li>
            <li><a href="../../menu/contact.php">ติดต่อ</a></li>
            <li><a href="../admin">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <?php 
                $strSQL = "SELECT * FROM clublist where id=$c_id";
                $objQuery = mysqli_query($conn,$strSQL); 
                $row_club = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
                ?>
        <div id="main">
            <div style="width:100%" id="right">
                <div   style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">แก้ไขชุมนุม</div>
                    <div class="panel-body">
                        <center>
                        <form method="post" action="">
                            รหัสชุมนุม : <input type="text" value="<?php echo $row_club['club_id'];?>" name="club_id" required/>
                            ชื่อชุมนุม : <input type="text" value="<?php echo $row_club['club_name'];?>" name="club_name" required/><br><br>
                            ห้อง : <input type="text"  value="<?php echo $row_club['club_class'];?>" name="club_class" required/> 
                            ชื่อครูที่ปรึกษา : <input  value="<?php echo $row_club['club_tc'];?>" type="text" name="club_tc" required/>
                            จำนวนที่รับ : <input value="<?php echo $row_club['count_all'];?>" type="text" name="count_all" required/>
                            <input value="<?php echo $row_club['id'];?>" type="hidden" name="hid" required/>
                            <br><input id="submit" style="width:30%;"type="submit" name="submit" value="แก้ไขข้อมูล"/>
                        </form>
                        <br>
                <hr>
                        <button  style="margin-bottom:10px;width:30%;" id="submit" onclick="location.href='add_club.php'" >ย้อนกลับ</button> 
                    </center>
                    </div>
                    <!---->

                </div> 
        </div>
        <footer class="footer"><br>ระบบลงทะเบียนชุมนุมโรงเรียนชิโนรสวิทยาลัย <br> &copy; <?php echo date('Y');?> <a style="color:white;text-decoration-line: none;"href="https://thanawatgulati.com">Thanawat Gulati</a></footer>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>
</html>
<?php 
    if($_POST['submit']){
        $hid = $_POST['hid'];
        $name = $_POST['club_name'];
        $tc = $_POST['club_tc'];
        $cid = $_POST['club_id'];
        $class = $_POST['club_class'];
        $count = $_POST['count_all'];
        $sql_club = "UPDATE clublist SET club_id='$cid',club_name='$name',club_tc='$tc',club_class='$class',count_all='$count' WHERE id=$hid";
        $result_club = mysqli_query($conn,$sql_club);
        echo $sql_club;
        if($result_club){
            echo "<script>alert('บันทึกสำเร็จ')</script>";
            header("Location:add_club.php");
        }
    }
?>
<?php  mysqli_close($conn);?>