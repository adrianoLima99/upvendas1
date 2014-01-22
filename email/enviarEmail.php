<?php

// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require("PHPMailer/class.phpmailer.php");
function email($AddAddress,$nomeCliente,$assunto,$mensagem){
// Inicia a classe PHPMailer
$mail = new PHPMailer();

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Port = 587;
$mail->Host = "smtp.upgradese.srv.br"; // Endereço do servidor SMTP

$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
$mail->Username = 'contato@upgradese.srv.br'; // Usuário do servidor SMTP
$mail->Password = 'contato2013'; // Senha do servidor SMTP

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->From = "contato@upvendasbrasil.com.br"; // Seu e-mail
$mail->setFrom('contato@upgradese.srv.br','Upgrade Solu&ccedil;&otilde;es');
$mail->addReplyTo('contato@upgradese.srv.br','Upgrade Solu&ccedil;&otilde;es');
//$mail->setAddReplyTo('contato@upgradese.srv.br','Upgrade Soluções');
//$mail->FromName = "Upgrade Solucoes"; // Seu nome

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->AddAddress($AddAddress, $nomeCliente);
//$mail->AddAddress('ciclano@site.net');
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->Subject = $assunto; // Assunto da mensagem
$mail->Body = $mensagem;
$mail->AltBody = $mensagem;

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");&nbsp; // Insere um anexo

// Envia o e-mail
$enviado = $mail->Send();

// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

// Exibe uma mensagem de resultado
if(!$enviado) {
 $mail->ErrorInfo;
}
}
?>
