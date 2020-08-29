<?php

    require "./PHPMailer/Exception.php";
    require "./PHPMailer/OAuth.php";
    require "./PHPMailer/PHPMailer.php";
    require "./PHPMailer/POP3.php";
    require "./PHPMailer/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = ['codigo_status' => null, 'descricao_status' => null];

        public function __get($atr){
            return $this->$atr;
        }

        public function __set($atr, $val){
            $this->$atr = $val;
        }

        public function mensagemValida(){
            if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
                return false;
            }

            return true;
        }
    }

    $mensagem = new Mensagem();

    //recuperando os valores dos inputs passando atributo e valor
    $mensagem->__set('para', $_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

    //print_r($mensagem);

    if(!$mensagem->mensagemValida()){
        echo 'Mensagem não é válida';
        header('Location: index.php');
    } 

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = false;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'webdevteste.teste@gmail.com';      // SMTP username
        $mail->Password = '!@#$1234';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('webdevteste.teste@gmail.com', 'Web Teste Dev Remetente');
        $mail->addAddress('webdevteste.teste@gmail.com', 'Web Teste Dev Destinatátio');     // Add a recipient
        // $mail->addAddress('ellen@example.com');               // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Ola mundo, eu sou um assunto';
        $mail->Body    = 'Ola mundo, eu sou o conteúdo deste <strong>e-mail!</strong>';
        $mail->AltBody = 'Ola mundo, eu sou o conteúdo deste e-mail!';

        $mail->send();

        $mensagem->status['codigo_status'] = 1;
        $mensagem->status['descricao_status'] = 'Mensagem enviada com sucesso';
        
    } catch (Exception $e) {

        $mensagem->status['codigo_status'] = 2;
        $mensagem->status['descricao_status'] = 'Não foi possivel enviar este e-mail '. $mail->ErrorInfo;
        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>
<body>
    
    <div class="container">
        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if($mensagem->status['codigo_status'] == 1){ ?>
                    <div class="container">
                        <h1 class='display-4 text-success'>Sucesso</h1>
                        <p><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class='btn btn-success btn-lg mt-5 text-white'>Voltar</a>
                    </div>
                <?php } ?>

                <?php if($mensagem->status['codigo_status'] == 2){ ?>
                    <div class="container">
                        <h1 class='display-4 text-danger'>Erro ao enviar o e-mail</h1>
                        <p><?= $mensagem->status['descricao_status'] ?></p>
                        <a href="index.php" class='btn btn-danger btn-lg mt-5 text-white'>Voltar</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</body>
</html>
