<?php
session_start();
require_once('../../Database/connect.php');
header('Content-Type: text/html; charset=utf-8');
if($_SESSION['status'] != "user"){
    header("Location: ../logout.php");
}
$username = $_SESSION['id'];
$sql = "select * from server where id=1";
$result = mysqli_query($conn,$sql);
if($result){
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $time_on = $row['on_time'];
    $time_off = $row['off_time'];
}
$sql2 = "select * from member where id=$username";
$result2 = mysqli_query($conn,$sql2);
if($result2){
    $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
}
$id = $_POST['club_hid'];
$strSQL = "SELECT * FROM clublist where id=$id";
$objQuery = mysqli_query($conn,$strSQL);
if($objQuery){
$row_club = mysqli_fetch_array($objQuery,MYSQLI_ASSOC);
$club_name = $row_club['club_name'];
$club_in = $row_club['count_in'];
}
if((date('Y-m-d') < $time_on) || (date('Y-m-d') > $time_off )){
        echo "<script>alert('หมดเวลาลงทะเบียน ตามกำหนดการ')</script>";
        header("Refresh:0;url=../logout.php");
    }else{
    if($row2['count'] == "1"){
        if($_POST['confirm']){
        $club_id = $_POST['club_hid'];
        $username = $_SESSION['id'];
        if(($row_club['count_in']) >= ($row_club['count_all'])){
            echo "<script>alert('ชุมนุมนี้เต็มแล้ว')</script>";
            header('Refresh:0;url=index.php');
        }else{
            $date = Date('Y-m-d h:i:s');
            $count_full = $club_in + 1;
            $sql_confirm = "UPDATE member SET club_value='$club_id' WHERE id=$username";
            $result_confirm = mysqli_query($conn,$sql_confirm);
            $sql_count = "UPDATE member SET count='0' WHERE id=$username";
            $result_count = mysqli_query($conn,$sql_count);
            $sql_full = "UPDATE clublist SET count_in='$count_full' WHERE id=$club_id";
            $result_full = mysqli_query($conn,$sql_full);
            $sql_full = "UPDATE member SET stamp='$date' WHERE id=$username";
            $result_full = mysqli_query($conn,$sql_full);
            echo "<script>alert('ลงทะเบียนสำเร็จ')</script>";
            header('Refresh:0;url=../../index.php');
        }
}
else{
    echo "<script>alert('ไม่มีการส่งข้อมูลเข้ามา')</script>";
    header('Refresh:0;url=../logout.php');
}
}
else{
    echo "<script>alert('คุณลงทะเบียนไปแล้ว o')</script>";
    header('Refresh:0;url=../logout.php');
}
    }
?>