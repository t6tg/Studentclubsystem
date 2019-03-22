<?php
    require('../Database/connect.php');
    header('Content-Type: text/html; charset=utf-8');
    $s_user = mysqli_real_escape_string($conn,$_POST['username']);
    $s_pass= mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "select * from member where  username=? and password=?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"ss",$s_user,$s_pass);
    mysqli_execute($stmt);
    $result_user = mysqli_stmt_get_result($stmt);

    //server
        $query = "select * from server where id=1";
        $result = mysqli_query($conn,$query);
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $on = $row['on_time'];
            $off = $row['off_time'];
        }
    //end-sever
if((date('Y-m-d') >= $on) && (date('Y-m-d') <= $off )){
    if($result_user->num_rows == 1){
    session_start();
    $row_user = mysqli_fetch_array($result_user,MYSQLI_ASSOC);
    $_SESSION['username'] = $row_user['username'];
    $_SESSION['status'] = $row_user['u_status'];
    $_SESSION['id'] = $row_user['id'];
    $_SESSION['name'] = $row_user['name'];
    $_SESSION['class'] = $row_user['class'];
    $_SESSION['room'] = $row_user['room'];
    session_write_close();
    header("Location: student/index.php");
    mysqli_close($conn);
    }
    else{
    echo "<script>alert('กรุณาตรวจสอบผู้ใช้และรหัสผ่านใหม่อีกครั้ง');</script>";
    header("Refresh:0; url= logout.php");
    }
    }
else{
        echo "<script>alert('ขณะนี้ไม่อยู่ในการลงทะเบียนลงทะเบียนตั้งแต่.$on. ถึง .$off.');</script>";
        header("Refresh:0; url= logout.php");
}

?>