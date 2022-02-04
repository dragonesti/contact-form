<?php
$error_count = 0;

if (!isset($_POST['person']) || ((strlen($_POST['person'])<2)))
    {
        $response['person'] =  0;
        $error_count++;
    }
    else {
        $fullname = filter_input(INPUT_POST, "person", FILTER_SANITIZE_STRING);
        $response['person'] = $fullname;
    }

if (!isset($_POST['email']) || ((!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))))
    {
        $response['email'] = 0;
        $error_count++;
    }
    else {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $response['email'] = $email;
    }

if (!isset($_POST['message']) || ((strlen($_POST['message'])<2)))
    {
        $response['message'] =  0;
        $error_count++;
    }
    else {
        $message = filter_input(INPUT_POST, "message", FILTER_SANITIZE_STRING);
        $response['message'] = $message;
    }


if (($_POST['agree'])=="false")
    {
        $response['agree'] = 0;
        $error_count++;
    }
    else {
        $response['agree'] = 1;
    }

if (($_POST['regpot'])=="false")
    {
        $response['honeypot'] = 0;

    }
    else {
        $response['honeypot'] = 1;
        $error_count++;
    }

$tel = filter_input(INPUT_POST, "tel", FILTER_SANITIZE_STRING);
$response['Answer'] ='<div class="erorr_answer">Wypełnij poprawnie pola formularza oznaczene (*).</div>';

if ($error_count>0)
    {
        $response['errorForm'] = $error_count;
        echo json_encode($response);
    }
    else {
        $headers  = 'From: '. $email ."\r\n";
        $headers .= 'MIME-Version: 1.0'."\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $to = 'mail@mail.pl';
        $subject = 'Formularz kontaktowy ze strony www.companyname.pl';
        $body = 'Imię i Nazwisko: ' . $fullname . '<br>';
        $body .= 'Telefon: ' . $tel . '<br>';
        $body .= 'Email: ' . $email . '<br>';
        $body .= 'Wiadomość: ' . $message . '<br><br>';

        if (mail($to, $subject, $body, $headers)) {
            if (true) {
                $response['errorForm'] = 0;
                $response['Answer'] = '<div class="success_answer">Twoja wiadomość została wysłana. Odpowiemy jak tylko  bedzie to możliwe.</div>';
                echo json_encode($response);
            } else {
                $response['errorForm'] = 0;
                $response['Answer'] = 'Coś poszło nie tak spróbuj później.';
                echo json_encode($response);
            }
        }
    }
