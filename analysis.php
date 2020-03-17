<?php
$url = isset($_GET["url"]) ? $_GET["url"] : null;
if ($url) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_SSL_VERIFYPEER => false
    ));
    $resp = curl_exec($curl);
    curl_close($curl);
    if ($resp === FALSE) {
        echo "Curl Error !";
    } else {
        // find all couple tag: <script></script> that include string "client"
        preg_match('/<script+.+src="+.+\/client+.*><\/script>/', $resp, $matches);
        if (sizeof($matches)) {
            foreach ($matches as $element) {
                preg_match('/".*"/', $element, $matches_1);
                if (sizeof($matches_1)) {
                    foreach ($matches_1 as $itemUrl) {
                        $itemUrl = str_replace('"', '', $itemUrl);
                        if ($itemUrl[0] === '/') {
                            $itemUrl = substr($itemUrl, 1);
                        }
                        if (strpos($itemUrl, "script") !== false) {
                            // case: a number of adjacent script tags -> continue filter
                            preg_match('/src=\/client+.+\.+js/', $itemUrl, $matches_2);
                            if (sizeof($matches_2)) {
                                foreach ($matches_2 as $subItemUrl) {
                                    $subItemUrl = str_replace('src=', '', $subItemUrl);
                                    if ($subItemUrl[0] === '/') {
                                        $subItemUrl = substr($subItemUrl, 1);
                                    }
                                    $curl_1 = curl_init();
                                    curl_setopt_array($curl_1, array(
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => $url . $subItemUrl,
                                        CURLOPT_SSL_VERIFYPEER => false
                                    ));
                                    $resp_1 = curl_exec($curl_1);
                                    curl_close($curl_1);
                                    if ($resp_1 === FALSE) {
                                        echo "Curl Error !";
                                    } else {
                                        if (strpos($resp_1, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_1, "browserpersistence") !== false) {
                                            echo "true";
                                        } else {
                                            echo "false";
                                        }
                                    }
                                }
                            }
                        } else {
                            // case: all script tags are seperate
                            $curl_2 = curl_init();
                            curl_setopt_array($curl_2, array(
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_URL => $url . $itemUrl,
                                CURLOPT_SSL_VERIFYPEER => false
                            ));
                            $resp_2 = curl_exec($curl_2);
                            curl_close($curl_2);
                            if ($resp_2 === FALSE) {
                                echo "Curl Error !";
                            } else {
                                if (strpos($resp_2, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_2, "browserpersistence") !== false) {
                                    echo "true";
                                }
                            }
                        }
                    }
                }
            }
        } else {
            echo "false";
        }
    }
}

?>