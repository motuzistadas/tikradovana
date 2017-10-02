<?php

class Mailer {

    function sendWelcome($user, $email, $pass) {
        $headers = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">\r\n";
        $headers .= "Content-type: text; charset=UTF-8\r\n";
        $subject = "TikraDovana - Registracija";
        $body = $user . ",\n\n"
                . "Sveiki! Jūs užsiregistravote į TikraDovana.lt svetainę"
                . "su duomenimis:\n\n"
                . "Vartotojo vardas: " . $user . "\n"
                . "Slaptažodis: " . $pass . "\n\n";
        return mail($email, $subject, $body, $headers);
    }

    function sendNewPass($user, $email, $pass) {
        $headers = "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDR . ">\r\n";
        $headers .= "Content-type: text; charset=UTF-8\r\n";
        $subject = "TikraDovana - Naujas slaptažodis";
        $body = $user . ",\n\n"
                . "Jūsų naujas slaptažodis:\n\n"
                . "Vartotojo vardas: " . $user . "\n"
                . "Naujas slaptažodis: " . $pass . "\n\n";
        return mail($email, $subject, $body, $headers);
    }

}

$mailer = new Mailer;
?>
