<?php 
    require_once("../Database/connect.php");
        $id = $_POST['clubid'];
    $sql = "select * from clublist where id=$id";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../img/cnrlogo.png"/>
    <link rel="stylesheet" href="report.css"/>
    <title>ระบบลงทะเบียนกิจกรรมชุมนุมออนไลน์โรงเรียนชิโนรสวิทยาลัย</title>
    <style>
        h4{
            margin-bottom:-10px;
        }
    </style>
</head>
<body onLoad="window.print()">
    <div id="container">
        <center><br>
        <img id="logo" src="../img/cnrlogo.png" alt="logo" ><br>
        รายงานผลการลงทะเบียนกิจกรรมชุมนุม<?php echo $row['club_name'];?><br>
        ภาคเรียนที่ <?php if((date('Y-m-d') > "$year-05-01") && (date('Y-m-d') < "$year-10-01")){echo "1";}else{echo "2";}?>
        ปีการศึกษา <?php if((date('Y-m-d') < "$year-05-01")){echo date("Y")+542;}else{echo date("Y")+543;}?><br>
        <?php echo $row['club_tc']?> ครูที่ปรึกษาชุมนุม</h4>
        <br>
        <!--Table-->
        <br>
        <table style="width:70%" class="table table-hover">
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>รหัสนักเรียน</th>
        <th>ชื่อ-สกุลนักเรียน</th>
        <th>ชั้นเรียน</th>
        <th>เลขที่</th>
        <th>หมายเหตุ</th>
      </tr>
    </thead>
    <tbody>
        <?php $query= "select * from member where club_value=$id";
        $result_st = mysqli_query($conn,$query);
        $i = 0;?>
        <?php while($row_st=mysqli_fetch_array($result_st,MYSQLI_ASSOC)) { ?>
      <tr>
        <td><?=++$i;?></td>
        <td><?php echo $row_st['username'];?></td>
        <td><?php echo $row_st['name'] ?></td>
        <td><?php echo $row_st['class']."/".$row_st['room']; ?></td>
        <td><?php echo $row_st['num']?></td>
        <td></td>
      </tr>
        <?php } ?>
    </tbody>
  </table>
  <?php if($i == 0){echo "<span style='color:red';>ยังไม่มีนักเรียนลงทะเบียน</span>";} ?>
        </center>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>