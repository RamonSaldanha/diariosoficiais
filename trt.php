<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

class Diario
{
  public function download () {

    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => "https://dejt.jt.jus.br/cadernos/Diario_J_21.pdf",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false
    ]);
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      date_default_timezone_set('America/Sao_Paulo');
      $date = getDate();
      $filename = "diario-{$date['mday']}-{$date['mon']}-{$date['year']}.pdf";
      $fp = fopen($filename, "w");
      $this->enviar_email($filename);
      fwrite($fp, $response);
    }

  }

  public function enviar_email ( $filename ) {

    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = "smtp.umbler.com";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'ing.mattioli@gmcapitalinvest.com';
    $mail->Password = 'Admin.GMCapital2020';
    
    //Recipients
    $mail->setFrom('ing.mattioli@gmcapitalinvest.com', 'GMCapitalinvest');
    $mail->addAddress('ramonsaldanhaa@gmail.com', 'Contato através do site');     // Add a recipient
    
    // Define que o e-mail será enviado como HTML | True
    $mail->IsHTML(true);
    
    // Charset da mensagem (opcional)
    $mail->CharSet = 'UTF-8';
    
    // Assunto da mensagem
    $mail->Subject = "Diário oficial";
    
    // Conteúdo no corpo da mensagem
    $mail->Body = "Diário oficial: <a href='http://gmcapitalinvest.com/teste/{$filename}'>diario</a>";
    
    // Conteúdo no corpo da mensagem(texto plano)
    $mail->AltBody = 'Conteudo da mensagem em texto plano';
    
    //Envio da Mensagem
    $enviado = $mail->Send();
    
    $mail->ClearAllRecipients();
    
    if ($enviado) {
       echo "E-mail enviado com sucesso!";
    } else {
       echo "Não foi possível enviar o e-mail. ";
       echo "Motivo do erro: " . $mail->ErrorInfo;
    }
    
  }

}

$diario = new Diario();
$diario->download();