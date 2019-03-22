<?php
    session_start();
    require_once('../../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
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
                    <div class="panel-heading">ค้นหา</div>
                    <div class="panel-body">
                        <center>
                        <form action="" method="post">
                        <input type="text" palceholder="กรุณากรอกคพค้นหา" style="width:70%;" name="search" required/> <input type="submit" name="submit" style="width:20%;color:white;background-color:#47a8e5" value="Search"/>
                    </form>
                    <li style="margin-top:20px;">ข้อมูลที่สามารถค้นหาได้คือ รหัสประจำตัวประชาชน, รหัสนักเรียน, ชื่อ หรือ นามสกุล</li>
                    </div>
                </div> 
                <?php if($_POST['submit']) { 
                    $strSQL = "SELECT * FROM member WHERE (name LIKE '%".$_POST["search"]."%' or username LIKE '%".$_POST["search"]."%' or password LIKE '%".$_POST["search"]."%')";
                    $objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); ?>
                <br>
                <!--table-->
                <table class='table table-striped'>
                <thead>
                <tr>
                <th scope='col'>รหัสนักเรียน</th>
                <th scope='col'>ชื่อ - สกุล</th>
                <th scope='col'>ชั้น</th>
                <th scope='col'>เลขที่</th>
                <th scope='col'>สถานะลงทะเบียน</th>
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
                <td><?php echo $objResult["username"];?></td>
                <td><?php $s_id = $objResult['id'];
                    echo "<form action='' method='post'><input type='hidden' name='hid' value='$s_id'><input type='submit' name='edit' value='แก้ไขข้อมูล'></form>";
                } ?></td>
                </tr>
                </tbody>
                </table>
                <center><button id='submit' style='width:30%;margin-bottom:20px;' onclick="location.href='edit_profile.php'">ย้อนกลับ</button></center>
                <?php } ?>
                                <!--form-->
                                <?php 
                     $s_id = $_POST['hid'];
                    $query = "select * from member where id=$s_id";
                    $result = mysqli_query($conn,$query);
                    $result2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
                     if($_POST['edit']){ ?>
                     <form action="" method="post">
                   <center> รหัสนักเรียน : <input type="text" value="<?php echo $result2['username'];?>" name="username" required/>
                    ชื่อ-สกุล : <input type="text" value="<?php echo $result2['name'];?>" name="name" required/><br><br>
                    เลขที่ : <input  value="<?php echo $result2['num'];?>" type="text" name="num" required/>
                    รหัสประชาชน : <input type="text"  value="<?php echo $result2['password'];?>" name="password" required/> 
                    ชั้น : <input  value="<?php echo $result2['class'];?>" type="text" name="sclass" required/><br><br>
                    ห้อง : <input value="<?php echo $result2['room'];?>" type="text" name="room" required/>
                    <input value="<?php echo $result2['id'];?>" type="hidden" name="hid" required/>
                    <br><input id="submit" style="width:30%;"type="submit" name="confirm" value="แก้ไขข้อมูล"/></center>
                    </form>
                     <?php }?>
                        <br>
                <hr>
                        <center><button  style="margin-bottom:10px;width:30%;" id="submit" onclick="location.href='main.php'" >กลับหน้าหลัก</button> 
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
                        if($_POST['confirm']){
                        $sql_db =  "UPDATE member SET username='".$_POST[username]."',password='".$_POST[password]."',num='".$_POST[num]."',class='".$_POST[sclass]."',room='".$_POST[room]."',name='".$_POST[name]."' WHERE id='".$_POST['hid']."'";
                        echo $sql_db;
                        $result_sql = mysqli_query($conn,$sql_db);
                        if($result_sql){
                        echo "<script>alert('บันทึกสำเร็จ')</script>";
                        header("Refresh:0;url=main.php");
                     }
                 }  ?>
<?php  mysqli_close($conn);?>