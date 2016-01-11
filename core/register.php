<?php
include "../database/database.class.php";
$db = new database();
$db->connect();

$prefix = $db->getPrefix();
$sesname = $db->getSessionname();

$strSQL = sprintf("SELECT * FROM ".$prefix."user WHERE username = '%s' ", mysql_real_escape_string($_POST['username']));
$resultCheck = $db->select($strSQL,false,true);

if($resultCheck){
  print "This username alreay found in the system!";
  exit();
}

$strSQL = sprintf("SELECT * FROM ".$prefix."user WHERE email = '%s' ", mysql_real_escape_string($_POST['email']));
$resultCheck = $db->select($strSQL,false,true);
if($resultCheck){
  print "This e-mail address alreay found in the system!";
  exit();
}

$sid = randomSID();

$strSQL = sprintf("INSERT INTO ".$prefix."user VALUE ('%s','%s','%s','".date('Y-m-d')."','No','Yes','3','".$sid."')", mysql_real_escape_string($_POST['username']), mysql_real_escape_string(md5($_POST['password'])), mysql_real_escape_string($_POST['email']));
$resultInsert = $db->insert($strSQL,false,true);
// print $strSQL;
if($resultInsert){
  require_once('../libs/class.phpmailer.php');
  $mail = new PHPMailer();
  $mail->IsHTML(true);
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl";
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;
  $mail->Username = "econsult.eu@gmail.com";
  $mail->Password = "econsulteu16";
  $mail->From = "econsult.eu@gmail.com";
  $mail->FromName = "E-Consultation system";
  $mail->CharSet  = "utf-8";
  $mail->Subject  = "ข้อมูลการใช้งานระบบ RMIS [ผู้ช่วยวิจัย] ";
  $mail->Body     = "เรียนคุณ ".$_POST["username"]."&nbsp;
  <p></p>
  Username: ".$_POST["username"]."<br>
  Password: ".$_POST["password"]."<br>
  <p></p>
  กรุณาคลิกที่ link ด้านล่าง เพื่อยืนยันการเข้าใช้งานระบบ RMIS.<br>
  <p></p>
  <a href='http://medipe2.psu.ac.th/e-consult/activate.php?sid=".$sid."&uid=".$_POST["username"]."'>
  http://rmis.medicine.psu.ac.th/demo/activate_ra.php?sid=".$sid."&uid=".$_POST["username"]."<br>
  </a>
  <p></p>
  <font size='2' color='red'>*กรุณาอย่าลบอีเมล์นี้ทิ้ง เพราะท่านอาจจะต้องใช้อีกในอนาคต</font>";
  $mail->AddAddress($_POST["email"]);
  $mail->Send();

  print "Y";

}else{
  print "Can not create account!";
}
?>

<?php
function randomSID($length = 20){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
