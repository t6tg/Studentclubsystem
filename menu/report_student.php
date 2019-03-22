<?php 
    require_once("../Database/connect.php");
    $year = date('Y');
    $class = $_POST['class'];
    $room = $_POST['room'];
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
        โรงเรียนชิโนรสวิทยาลัย<br>
        รายงานผลการลงทะเบียนกิจกรรมชุมนุม นักเรียนชั้นมัธยมศึกษาปีที่ <?php echo $class."/".$room;?><br>
        ภาคเรียนที่ <?php if((date('Y-m-d') > "$year-05-01") && (date('Y-m-d') < "$year-10-01")){echo "1";}else{echo "2";}?>
        ปีการศึกษา <?php if((date('Y-m-d') < "$year-05-01")){echo date("Y")+542;}else{echo date("Y")+543;}?><br>
        <br>
        <!--Table-->
        <br>
        <table style="width:70%" class="table table-hover">
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>รหัสนักเรียน</th>
        <th>ชื่อ-สกุลนักเรียน</th>
        <th>ชุมนุมที่ลงทะเบียน</th>
        <th>ครูที่ปรึกษาชุมนุม</th>
        <th>หมายเหตุ</th>
      </tr>
    </thead>
    <tbody>
        <?php $query= "select * from member  where class=$class and room=$room order by num ASC ";
        $result_st = mysqli_query($conn,$query);?>
        <?php while($row_st=mysqli_fetch_array($result_st,MYSQLI_ASSOC)) {
            $value =$row_st['club_value'];
            $sql = "select * from clublist where id=$value";
            $result = mysqli_query($conn,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC); ?>
      <tr>
        <td><?php echo $row_st['num'];?></td>
        <td><?php echo $row_st['username'];?></td>
        <td><?php echo $row_st['name'] ?></td>
        <td><?php if($row_st['count'] != "0"){ echo "<span style='color:red'>ยังไม่ลงทะเบียน</span>";}else{echo $row['club_name'];}?></td>
        <td><?php if($row_st['count'] != "0"){ echo "<span style='color:red'>ยังไม่ลงทะเบียน</span>";}else{echo "ครู".$row['club_tc'];}?></td>
        <td></td>
      </tr>
        <?php } ?>
    </tbody>
  </table>
        </center>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>