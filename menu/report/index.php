<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once('../../Database/connect.php');
    header('Content-Type: text/html; charset=utf-8');
    if($_POST['submit']){
    $report = $_POST['report'];
    $sql = "select * from member where username=$report";
    $query = mysqli_query($conn,$sql);
    if($query){
    $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
    $name = $row['name'];
    $class = $row['class'].' / '.$row['room'];
    $club_value = $row['club_value'];
    }
    $sql2 = "select * from clublist where id='$club_value'";
    $query2 = mysqli_query($conn,$sql2);
    if($query2){
    $row2 = mysqli_fetch_array($query2,MYSQLI_ASSOC);
    $club_name = $row2['club_name'];
    $club_id = $row2['club_id'];
    $club_tc = $row2['club_tc'];
    }
    date_default_timezone_set("Asia/Bangkok");
    $date = '<p style="font-size: 18px;"> ว/ด/ป : '.Date('d/m/Y').' เวลา : '.Date('h:i:s A').'</p>';
    $mpdf = new \Mpdf\Mpdf([
        'default_font_size' => 16,
        'default_font' => 'saraban'
    ]);
    $mpdf->SetImportUse();
    $mpdf->SetDocTemplate('../../pdf/club.pdf',true);
        $html_date = "$date";
        $html_id = "$report";
        $html_name = "$name";
        $html_class = "มัธยมศึกษาปีที่ $class";
        $html_club_name = "$club_name";
        $html_club_id = "$club_id";
        $html_club_tc = "$club_tc";

        $html_id2 = "$report";
        $html_name2 = "$name";
        $html_class2 = "มัธยมศึกษาปีที่ $class";
        $html_club_name2 = "$club_name";
        $html_club_id2 = "$club_id";
        $html_club_tc2 = "$club_tc";

        $html_name3 = "$name";
        $html_tc_name = "$club_tc";

    $mpdf->SetTitle('พิมพ์ใบยืนยัน');
    $mpdf->WriteHTML('<div style="position:absolute;top:-10px;left:300px;font-size:16px;"><b>'.$html_date.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:1075px;left:310px;font-size:16px;">กิจกรรมพัฒนาผู้เรียนโรงเรียนชิโนรสวิทยาลัย</div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:1095px;left:320px;font-size:16px;">https://cnrclub.thanawatgulati.com</div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:326px;left:250px;"><b>'.$html_id.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:260px;left:180px;"><b>'.$html_name.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:295px;left:180px;"><b>'.$html_class.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:360px;left:180px;"><b>'.$html_club_name.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:390px;left:180px;"><b>'.$html_club_id.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:420px;left:210px;"><b>'.$html_club_tc.'</b></div>');

    $mpdf->WriteHTML('<div style="position:absolute;top:810px;left:250px;"><b>'.$html_id2.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:745px;left:180px;"><b>'.$html_name2.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:780px;left:180px;"><b>'.$html_class2.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:840px;left:180px;"><b>'.$html_club_name2.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:875px;left:180px;"><b>'.$html_club_id2.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:905px;left:210px;"><b>'.$html_club_tc2.'</b></div>');

    $mpdf->WriteHTML('<div style="position:absolute;top:615px;left:525px;"><b>'.$html_name3.'</b></div>');
    $mpdf->WriteHTML('<div style="position:absolute;top:1000px;left:480px;"><b>'.$html_tc_name.'</b></div>');
    $mpdf->Output('"'.$report.'".pdf', 'I');
    }else{
        echo "<script>alert('ไม่มีการส่งค่าเข้ามา')</script>";
        header('Refresh:0;url=../../index.php');
    }
?>
<?php mysqli_clse($conn);?>