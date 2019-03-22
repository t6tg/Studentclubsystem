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
                    <div class="panel-heading">เพิ่มชุมนุม</div>
                    <div class="panel-body">
                        <center>
                        <form method="post" action="">
                            รหัสชุมนุม : <input type="text" name="club_id" required/>
                            ชื่อชุมนุม : <input type="text" name="club_name" required/><br><br>
                            ห้อง : <input type="text" name="club_class" required /> 
                            ชื่อครูที่ปรึกษา : <input type="text" name="club_tc"required/>
                            จำนวนที่รับ : <input type="text" name="count_all"required/>
                            <br><input id="submit" style="width:30%;"type="submit" name="submit" value="เพิ่มข้อมูล"required/>
                        </form>
                        <br>
                        <?php 
                echo "<hr><h3>รายชื่อชุมนุม</h3>";
                $strSQL = "SELECT * FROM clublist";
                $objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); ?>
                <br><table class='table table-striped'>
                <thead>
                <tr>
                <th scope='col'>รหัสชุมนุม</th>
                <th scope='col'>ชื่อชุมนุม</th>
                <th scope='col'>ครูที่ปรึกษา</th>
                <th scope='col'>ห้อง</th>
                <th scope='col'>จำนวนที่รับ</th>
                <th scope='col'>ลบ</th>
                <th scope='col'>หมายเหตุ</th>
                </tr>
                </thead>
                <tbody>
                <?php
	            while($objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC))
                { $id = $objResult["id"] 
                    ?>
                <tr>
                <td><?php echo $objResult["club_id"];?></td>
                <td><?php echo $objResult["club_name"];?></td>
                <td><?php echo $objResult["club_tc"];?></td>
                <td><?php echo $objResult["club_class"];?></td>
                <td><?php echo $objResult["count_all"];?></td>
                <td>
                <form method="post" action="delete.php">
                <input type="hidden" name="del" value="<?php echo $objResult["id"];?>">
                <input type="submit" style="background-color:red;" name="delete" value="ลบข้อมูล">
                </form>
                </td>
                <td>
                <form method="post" action="edit_club.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="confirm" value="แก้ไขข้อมูล">
                </form>
                </td>
                </tr>
                <?php } ?>
                </tbody>
                </table>   
                <hr>
                        <button  style="margin-bottom:10px;width:30%;" id="submit" onclick="location.href='main.php'" >กลับหน้าหลัก</button> 
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
        $c_id = $_POST['club_id'];
        $check = "select * from clublist where club_id='$c_id'";
        $result1 = mysqli_query($conn,$check);
        $num=mysqli_num_rows($result1); 
        if($num > 0)   		
        {
            echo "<script>alert('ข้อมูลซ้ำ')</script>";
            header("Location:add_club.php");
    }else{
        $sql_club = "INSERT INTO clublist(club_id,club_name,club_tc,club_class,count_all) VALUES ('".$_POST[club_id]."','".$_POST[club_name]."','".$_POST[club_tc]."'
        ,'".$_POST[club_class]."','".$_POST[count_all]."') ";
        $result_club = mysqli_query($conn,$sql_club);
        if($result_club){
            echo "<script>alert('บันทึกสำเร็จ')</script>";
            header("Location:add_club.php");
        }
    }
}
?>
<?php  mysqli_close($conn);?>