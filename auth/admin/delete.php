<?php if($_POST['delete']) {
    $id = $_POST['del'];
    echo $id;
};?>
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
        <div id="main">
            <div style="width:100%" id="right">
                <div   style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">หน้าหลัก</div>
                    <div class="panel-body">
                        <center>
                        <form action="" method="post">
                            ต้องการลบข้อมูลใช่หรือไม่ <br>
                            <input type="hidden" name="hid" value="<?php echo $id ?>">
                            <input id="submit"  style="width:30%;" type="submit" name="submit" value="yes">
                        </form>
                        <a href="add_club.php"> < ย้อนกลับ </a>
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
    session_start();
    require_once('../../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
    header('Content-Type: text/html; charset=utf-8');
    $sql = "select * from server where id=1";
    $result = mysqli_query($conn,$sql);
    if($_SESSION['status'] != "admin"){
        header("Location: ../logout.php");
    }
            if($_POST['submit']){
                $d_id = $_POST['hid'];
                $delete = "DELETE FROM clublist WHERE id='$d_id'";
                echo $delete;
                if(mysqli_query($conn,$delete)){
                echo "<script>alert('ลบสำเร็จ $d_id')</script>";
                header("Refresh:0;url=main.php");
            }
            }


?>
<?php     mysqli_close($conn);?>