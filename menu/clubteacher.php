
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
            <li><a href="#">สำหรับครู</a></li>
            <li><a href="contact.php">ติดต่อ</a></li>
            <li><a href="../auth/admin/">ผู้ดูแลระบบ</a></li>
        </ul>
        </nav>
        <div id="main">
            <div style="width: 100%;" id="right">
                <div  style="margin-bottom:20px;"  class="panel panel-default">
                    <div class="panel-heading">** รายละเอียดชุมนุมที่เปิดรับ **</div>
                    <div class="panel-body">
                <?php 
                $strSQL = "SELECT * FROM clublist";
                $objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); ?>
                <table class='table table-striped'>
                <thead>
                <tr>
                <th scope='col'>รหัสชุมนุม</th>
                <th scope='col'>ชื่อชุมนุม</th>
                <th scope='col'>ครูที่ปรึกษา</th>
                <th scope='col'>ห้อง</th>
                <th scope='col'>จำนวนที่รับ</th>
                <th scope='col'>หมายเหตุ</th>
                <th scope='col'>พิมพ์ใบ</th>
                </tr>
                </thead>
                <tbody>
                <?php
	            while($objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC))
                { ?>
                <tr>
                <td><?php echo $objResult["club_id"];?></td>
                <td><?php echo $objResult["club_name"];?></td>
                <td><?php echo $objResult["club_tc"];?></td>
                <td><?php echo $objResult["club_class"];?></td>
                <td><?php echo $objResult["count_all"];?></td>
                <td style="color:red;"><?php if(($objResult['count_in']) >= ($objResult['count_all'])){echo "เต็มแล้ว";}?></td>
                <td><form method="post" action="report.php">
                <input type="hidden" name="clubid" value="<?php echo $objResult['id']?>"/>
                <input width="30px" type="image" name="submit" src="../img/file.svg"></form></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
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