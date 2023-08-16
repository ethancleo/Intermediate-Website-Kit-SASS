<?php
require '../../../../private_html/key.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    $subject = 'Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage: $message";

    $apiKey = ELASTIC_EMAIL_API_KEY;
    $accountEmail = 'ethan@waldheimdigital.com';

    $post = array(
        'from' => 'tlfwebsite@waldheimstrategies.com',
        'fromName' => 'Touchstone Law Firm',
        'apikey' => $apiKey,
        'subject' => $subject,
        'to' => $accountEmail,
        'bodyHtml' => nl2br($body),
        'bodyText' => $body,
    );

    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => 'https://api.elasticemail.com/v2/email/send',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_SSL_VERIFYPEER => false
    ));

    $result = curl_exec($ch);
    curl_close($ch);

    // You may want to handle the response here

    header("Location: /thank-you"); // Redirect to a thank-you page
    exit;
}
?>