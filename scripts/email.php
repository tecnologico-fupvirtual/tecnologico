<?php
  //************************************************************
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
function enviarEmailSMTPCerrarPQR($correo,$nombre) {
    include('config.php');
    
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true); 
    
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = $hostmail;               // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $usermail;        // SMTP username
    $mail->Password = $passmail;   // SMTP password
    $mail->SMTPSecure = "ssl";                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = $portmail;                 // TCP port to connect to

    $mail->setFrom($instmail, $nommail);
    $mail->addAddress($correo, $nombre);                // Add a recipient
    $mail->addAddress($instmail, 'Calidad');            // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->CharSet = "UTF-8";
    $asunto = "PQR Cerrada";
    $asunto = "=?UTF-8?B?" . base64_encode($asunto) . "=?=";
    $mail->Subject = mb_convert_encoding($asunto, 'UTF-8', 'ISO-8859-1');
    $mail->Body = "<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta name=\"viewport\" content=\"width=device-width\" />
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>Eliteadmin Responsive web app kit</title>
</head>
<body style=\"margin:0px; background: #f8f8f8; \">
<div width=\"100%\" style=\"background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;\">
  <div style=\"max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px\">
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%; margin-bottom: 20px\">
      <tbody>
        <tr>
          <td style=\"vertical-align: top; padding-bottom:30px;\" align=\"center\"><a href=\"http://eliteadmin.themedesigner.in\" target=\"_blank\"><img src=\"../plugins/images/eliteadmin-logo-dark.png\" alt=\"Eliteadmin Responsive web app kit\" style=\"border:none\"><br/>
            <img src=\"../plugins/images/eliteadmin-text-dark.png\" alt=\"Eliteadmin Responsive web app kit\" style=\"border:none\"></a> </td>
        </tr>
      </tbody>
    </table>
    <div style=\"padding: 40px; background: #fff;\">
      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">
        <tbody>
          <tr>
            <td><b>Dear Sir/Madam/Customer,</b>
              <p>This is to inform you that, Your account with Elite Admin has been created successfully. Log it for more details.</p>
              <a href=\"javascript: void(0);\" style=\"display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #00c0c8; border-radius: 60px; text-decoration:none;\"> Call to action button </a>
              <p>This email template can be used for Create Account, Change Password, Login Information and other informational things.</p>
              <b>- Thanks (Elite team)</b> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div style=\"text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px\">
      <p> Powered by Themedesigner.in <br>
        <a href=\"javascript: void(0);\" style=\"color: #b2b2b5; text-decoration: underline;\">Unsubscribe</a> </p>
    </div>
  </div>
</div>
</body>
</html>";

    if (!$mail->send()) {
        echo "Message could not be sent.";
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

//************************************************************
?>