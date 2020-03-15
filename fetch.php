<?php

$url = isset($_GET["url"]) ? $_GET["url"] : null;
if ($url) {
    $content = curl_init();
    curl_setopt($content, CURLOPT_URL, $url);
    $response = curl_exec($content);
    if (curl_errno($content)) {
        $error_msg = curl_error($content);
    } else {
        echo $response;
    }
    curl_close($content);

    if (isset($error_msg)) {
        // TODO - Handle cURL error accordingly
        echo $error_msg;
    }
}

