<?php
    session_start();
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
        <div id="main">
            <div style="width:100%" id="right">
                <div   style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">เซิฟเวอร์</div>
                    <div class="panel-body">
                        <center>
                        <form method="post" action="">
                            วันเปิดระบบ : <input type="date" name="timeon" value="<?php echo $row['on_time'];?>"/> 
                            วันปิดระบบ : <input type="date" name="timeoff" value="<?php echo $row['off_time'];?>" /><br><br>
                            ประกาศ : <textarea type="text" name="problem" placeholder="ไม่มีประกาศ"><?php echo $row['notice'];?></textarea>
                            <br><input id="submit" style="width:30%;"type="submit" name="submit" value="บันทึกข้อมูล"/>
                        </form>
                        <br>
                        <hr>
                        <button  style="margin-bottom:10px;width:30%;" id="submit" onclick="location.href='main.php'" >กลับหน้าหลัก</button>
                        </center>
                    </div>
                    <!---->

                </div> 
        </div>
        <footer class="footer"><br><br>ระบบลงทะเบียนชุมนุมโรงเรียนชิโนรสวิทยาลัย <br> &copy; <?php echo date('Y');?> <a style="color:white;text-decoration-line: none;"href="https://thanawatgulati.com">Thanawat Gulati</a></footer>
        </div>
    </div>
    <script src="script/script.js"></script>
</body>
</html>
<?php 
    if($_POST['submit']){
        $problem = $_POST['problem'];
        $on = $_POST['timeon'];
        $off = $_POST['timeoff'];
        $sql_server = "UPDATE server SET on_time='$on',off_time='$off',notice='$problem' WHERE id=1";
        $result_server = mysqli_query($conn,$sql_server);
        if($result_server){
            echo "<script>alert('บันทึกสำเร็จ')</script>";
            header("Refresh:0;url=server.php");
        }
    }
?>
<?php     mysqli_close($conn);?>