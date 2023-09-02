<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $url = $_GET['url'];

    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        header('HTTP/1.0 400 Bad Request');
        exit();
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        echo $response;
    } else {
        header('HTTP/1.0 ' . $httpCode . ' ' . http_response_code($httpCode));
    }
} else {
    header('HTTP/1.0 405 Method Not Allowed');
}
?>
