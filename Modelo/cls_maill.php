<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

 require 'class/class.phpmailer.php';

class Maill extends PHPMailer
{
    public function MailSent()
    {
        parent::__construct();

        function __get($atributo)
        {
            if (isset($this->{$atributo})) {
                return $this->{$atributo};
            }

            return ''; //"No hay nada... -_-";
        }

        function __set($atributo, $valor)
        {
            if (isset($this->{$atributo})) {
                $this->{$atributo} = $valor;
            }
            //echo "No Existe {$atributo}... :'(";
        }
    }

    public function sentEmail($name, $email, $subject, $message)
    {
        $data = [];

        $this->IsSMTP();        //Sets Mailer to send message using SMTP
        //$this->SMTPDebug = 2;
        //$this->Debugoutput = 'html';
        $this->Host = 'smtp.gmail.com';
        $this->Port = '465';
        $this->SMTPAuth = true;
        $this->Username = 'jjmarquez@bon.com.do';
        $this->Password = 'JMC1995c249/.';
        $this->SMTPSecure = 'ssl';
        $this->From = 'Encuestabon@bon.com.do';
        $this->FromName = 'Sistema BonEncuesta';
        $this->AddAddress($email); //Adds a "To" address
    //$mail->AddCC($_POST["email"], $_POST["name"]); //Adds a "Cc" address
    $this->WordWrap = 50;       //Sets word wrapping on the body of the message to a given number of characters
    $this->IsHTML(true);       //Sets message type to HTML
    $this->Subject = $subject;    //Sets the Subject of the message
    $this->Body = $message;    //An HTML or plain text message body
    if ($this->Send()) {
        $data['success'] = true;
        $data['message'] = 'Success!';
    } else {
        $data['success'] = false;
        $data['message'] = 'error: " . $this->ErrorInfo;';
    }

        return $data;
    }
}
