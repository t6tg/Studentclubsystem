<?php
    session_start();
    require_once('../../Database/connect.php');
    date_default_timezone_set("Asia/Bangkok");
    header('Content-Type: text/html; charset=utf-8');
    $sql = "select * from server where id=1";
    $result = mysqli_query($conn,$sql);
    if($result){
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $time_on = $row['on_time'];
        $time_off = $row['off_time'];
        if((date('Y-m-d') >= $time_on) && (date('Y-m-d') <= $time_off )){
            $open = "<span style='color: green;font-weight:400;'>เปิดลงทะเบียน</span>";
        }else{
            $open = "<span style='color: red;font-weight:400;'>ปิดลงทะเบียน</span>";
        }
    }
    if($_SESSION['status'] != "user"){
        header("Location: ../logout.php");
    }
    if((date('Y-m-d') < $time_on) || (date('Y-m-d') > $time_off )){
        echo "<script>alert('ขณะนี้ระบบปิดอยู่ ไม่สามารถเข้าสู่ระบบได้')</script>";
        header("Refresh:0;url=../logout.php");
    }
    $username = $_SESSION['id'];
    $sql2 = "select * from member where id=$username";
    $result2 = mysqli_query($conn,$sql2);
    if($result2){
        $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
        $count = $row2['count'];
        $club_name =$row2['club_value'];
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
                    <div class="panel-heading">ลงทะเบียนชุมนุม</div>
                    <div class="panel-body">
                        <center>
                            <?php echo "<h3>".$_SESSION['name']."</h3>"?>
                            <?php if($count == "0"){
                                $sql_name = "select * from clublist where id=$club_name";
                                $result_name = mysqli_query($conn,$sql_name);
                                $row_name = mysqli_fetch_array($result_name,MYSQLI_ASSOC);
                            }
                                ?>
                            <?php if($count == "0"){echo "<h4>ผลการลงทะเบียน : ".$row_name['club_name']."</h4>";}?>
                            <button  style="margin-bottom:31px;width:30%;" id="submit" onclick="location.href='../logout.php'" >ออกจากระบบ</button>
                            <br><span style="color:red;">** นักเรียนมีสิทธิเลือกได้เพียง 1 ครั้งเท่านั้น **</span>
                            <?php 
                $strSQL = "SELECT * FROM clublist";
                $objQuery = mysqli_query($conn,$strSQL) or die ("Error Query [".$strSQL."]"); ?>
                <br><table class='table table-striped'>
                    <thead>
                        <tr>
                            <th scope='col'>รหัสชุมนุม</th>
                <th scope='col'>ชื่อชุมนุม</th>
                <th scope='col'>ครูที่ปรึกษา</th>
                <th scope='col'>ห้อง</th>
                <th scope='col'>จำนวนที่ลง / จำนวนที่รับ</th>
                <th scope='col'>หมายเหตุ</th>
                <th scope='col'>ลงทะเบียน</th>
                </tr>
                </thead>
                <tbody>
                <?php
	            while($objResult = mysqli_fetch_array($objQuery,MYSQLI_ASSOC))
                { $id = $objResult['id']?>
                <tr>
                <td><?php echo $objResult["club_id"];?></td>
                <td><?php echo $objResult["club_name"];?></td>
                <td><?php echo $objResult["club_tc"];?></td>
                <td><?php echo $objResult["club_class"];?></td>
                <td><?php echo $objResult["count_in"]."  /  ".$objResult["count_all"];?></td>
                <td style="color:red;"><?php if(($objResult['count_in']) >= ($objResult['count_all'])){echo "เต็มแล้ว";}else{echo "";}?></td>
                <td style="color:red;"><?php if(($objResult['count_in']) >= ($objResult['count_all'])){echo "";}
                if($row2['count'] == "0"){
                    echo "ลงทะเบียนแล้ว";
                }
                elseif(($objResult['count_in']) < ($objResult['count_all'])){ echo "
                <form action='send_data.php' method='post'><input type='hidden' name='id' value='$id'/><input style='width:100%;background-color:#47a8e5;color:white;'  value='ลงทะเบียน' type='submit' name='club_name'/></form>";}?></td>
                </tr>
                <?php } ?>
                </tbody>
                </table>
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
<?php     mysqli_close($conn);?>