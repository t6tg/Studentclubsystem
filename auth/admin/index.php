<?php
    session_start();
    require_once('../../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
    header('Content-Type: text/html; charset=utf-8');
    $sql = "select * from server where id=1";
    $result = mysqli_query($conn,$sql);
    if($_SESSION['status'] == "admin"){
        header("Location: main.php");
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
                    <div class="panel-heading">เข้าสู่ระบบผู้ดูแล</div>
                    <div class="panel-body">
                        <center>
                        <h3>เข้าสู่ระบบผู้ดูแล</h3>
                        <form method="post" action="">
                        Username : <input id="input" type="text" name="username" required/>
                        Password : <input  id="input" type="password" name="password" required/>
                        <input id="submit" type="submit" name="submit" value="เข้าสูระบบ"/>
                        </form>
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
    header('Content-Type: text/html; charset=utf-8');
    $s_user = mysqli_real_escape_string($conn,$_POST['username']);
    $s_pass= mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "select * from admin where  username=? and password=?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$s_user,$s_pass);
    mysqli_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);
    if($result_user->num_rows == 1){
    session_start();
    $row_user = mysqli_fetch_array($result_user,MYSQLI_ASSOC);
    $_SESSION['status'] = $row_user['status'];
    session_write_close();
    header("Location: main.php");
    mysqli_close($conn);
    }
    else{
    echo "<script>alert('กรุณาตรวจสอบผู้ใช้และรหัสผ่านใหม่อีกครั้ง');</script>";
    header("Refresh:0; url= ../logout.php");
    }
}
?>
<?php     mysqli_close($conn);?>