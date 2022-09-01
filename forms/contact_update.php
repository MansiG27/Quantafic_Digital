<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 

// Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true); 
try {
  //Server settings
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
  $mail->isSMTP();                                            // Send using SMTP
  $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
  $mail->Username   = 'your@email.com';                       // SMTP username
  $mail->Password   = 'your smtp password';                     // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  $mail->from_name = $_POST['name'];
  $mail->from_email = $_POST['email'];
  $mail->subject = $_POST['subject'];
  $mail->msg = $_POST['msg'];
  $mail->mobile = $_POST['mobile'];

  //Recipients Details
  $mail->setFrom('tersepratham0493@gmail.com');
  $mail->addAddress($mail->from_email); 
  $mail->addReplyTo('tersepratham0493@gmail.com', 'Information');
  // $mail->addCC('cc@example.com');
  // $mail->addBCC('bcc@example.com');

   // Content
   $mail->isHTML(true);                                  // Set email format to HTML
   $mail->Subject =  $mail->subject;
   $mail->Body    =  "<html>
      <head>
        <title>New message from website contact form</title>
      </head>
      <body>
        <p> Hii $mail->from_name,</p>
        <p>Mobile: $mail->mobile,</p
        <p>Thank you for Contacting Us!</p>
      </body>
      </html>";
    //   $mail->AltBody = 'Thank you for contacting us.';

    $data = [];
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load("log_mail.xlsx");
    
    $worksheet = $spreadsheet->getActiveSheet();
    // Get the highest row number and column letter referenced in the worksheet
    $highestRow = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
    // Increment the highest column letter
    $highestColumn++;
    $count=0;
    for ($row = 1; $row <= $highestRow; ++$row) {
      if (($worksheet->getCell('A' . $row)->getValue() == $mail->from_email)!== FALSE)
      {  
        echo $count++;
      } 
      
    }
      
      if($count<=3){
              if($mail->send())
              {
                  // $d1->getActiveSheet()->setCellValueByColumnAndRow('A' . $row,"=COUNTIF(A:$row,'<>0')");
              $response = [
              'status' => $worksheet->getCell('C' . $row)->getDataType() ,
              'msg' =>  $count
              ];
              logMail($mail->from_email,$mail->subject,1);
              Excel_logMail($mail->from_email,1);
              }
          }  
        else{
          // $sheet->getActiveSheet()->setCellValue('A'.$numRow, $birthday);
          // $value = $worksheet->getCell('C' . $row)->getValue();
          // $InvDate= phpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
          $response = [
            'status' =>  $worksheet->getCell('C'.$row)->getValue(),
            'msg' => 'hii'+$count
            ];
        }
       
       
   
     
} catch (Exception $e) {
  echo "Message could not be sent.";  
}

function logMail($from_email, $subject, $success=1)
{
    $pathLog = 'logMail.txt';
    $logContent = file_get_contents($pathLog);
    $logContent .= date('Y-m-d H:i:s');
    $logContent .= "\t";
    $logContent .= "Email ".($success ? 'sent' : 'FAILED!')."\n";
    $logContent .= "To: $from_email\n";
    $logContent .= "Subject: $subject\n";
    $logContent .= "\n\n";
    file_put_contents($pathLog, $logContent);
}
function Excel_logMail($from_email,$success=1)
{
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
$spreadsheet = $reader->load('log_mail.xlsx');
$sheet = $spreadsheet->getActiveSheet();
$last_row = (int) $sheet->getHighestRow();
$new_row = $last_row+1;

$sheet->setCellValue('A'.$new_row, $from_email);
$sheet->setCellValue('B'.$new_row, $success);
$sheet->setCellValue('C'.$new_row, date('Y-m-d'));

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('log_mail.xlsx');
}
function ReadExcel($from_email){
 
}
echo json_encode($response);exit
?>
