<?php
$url = isset($_GET["url"]) ? $_GET["url"] : null;
if (substr($url, -1) !== '/') {
    $url .= '/';
}
$ispwaStudio = false;
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
        // curl error
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
                                    $curl_2 = curl_init();
                                    curl_setopt_array($curl_2, array(
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => $url . $subItemUrl,
                                        CURLOPT_SSL_VERIFYPEER => false
                                    ));
                                    $resp_2 = curl_exec($curl_2);
                                    curl_close($curl_2);
                                    if ($resp_2 === FALSE) {
                                        // curl error
                                    } else {
                                        if (strpos($resp_2, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_2, "browserpersistence") !== false || strpos($resp_2, "NODE_ENV") !== false) {
                                            $ispwaStudio = true;
                                        }
                                    }
                                }
                            }
                            if (!$ispwaStudio) {
                                preg_match('/src=\/client+\.+js/', $itemUrl, $matches_3);
                                if (sizeof($matches_3)) {
                                    foreach ($matches_3 as $subItemUrl3) {
                                        $subItemUrl3 = str_replace('src=', '', $subItemUrl3);
                                        if ($subItemUrl3[0] === '/') {
                                            $subItemUrl3 = substr($subItemUrl3, 1);
                                        }
                                        $curl_3 = curl_init();
                                        curl_setopt_array($curl_3, array(
                                            CURLOPT_RETURNTRANSFER => 1,
                                            CURLOPT_URL => $url . $subItemUrl3,
                                            CURLOPT_SSL_VERIFYPEER => false
                                        ));
                                        $resp_3 = curl_exec($curl_3);
                                        curl_close($curl_3);
                                        if ($resp_3 === FALSE) {
                                            // curl error
                                        } else {
                                            if (strpos($resp_3, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_3, "browserpersistence") !== false || strpos($resp_3, "NODE_ENV") !== false) {
                                                $ispwaStudio = true;
                                            }
                                        }
                                    }
                                }
                            }

                            if (!$ispwaStudio) {
                                preg_match('/src=+.[^\s]+\/client+.+\.+js/', $itemUrl, $matches_4);
                                if (sizeof($matches_4)) {
                                    foreach ($matches_4 as $subItemUrl4) {
                                        $subItemUrl4 = str_replace('src=', '', $subItemUrl4);
                                        if ($subItemUrl4[0] === '/') {
                                            $subItemUrl4 = substr($subItemUrl4, 1);
                                        }
                                        $curl_4 = curl_init();
                                        curl_setopt_array($curl_4, array(
                                            CURLOPT_RETURNTRANSFER => 1,
                                            CURLOPT_URL => $url . $subItemUrl4,
                                            CURLOPT_SSL_VERIFYPEER => false
                                        ));
                                        $resp_4 = curl_exec($curl_4);
                                        curl_close($curl_4);
                                        if ($resp_4 === FALSE) {
                                            // curl error
                                        } else {
                                            if (strpos($resp_4, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_4, "browserpersistence") !== false || strpos($resp_4, "NODE_ENV") !== false) {
                                                $ispwaStudio = true;
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            // case: all script tags are seperate
                            $curl_5 = curl_init();
                            curl_setopt_array($curl_5, array(
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_URL => $url . $itemUrl,
                                CURLOPT_SSL_VERIFYPEER => false
                            ));
                            $resp_5 = curl_exec($curl_5);
                            curl_close($curl_5);
                            if ($resp_5 === FALSE) {
                                // curl error
                            } else {
                                if (strpos($resp_5, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_5, "browserpersistence") !== false || strpos($resp_5, "NODE_ENV") !== false) {
                                    $ispwaStudio = true;
                                }
                            }

                            if (!$ispwaStudio) {
                                // if url has some backslash
                                if (substr_count($url, '/') > 2) {
                                    if (strpos($url, 'https://') !== false) {
                                        $sliceUrl = substr($url, 8);
                                        $mainUrl = substr($sliceUrl, 0, 12);
                                    }
                                    $curl_6 = curl_init();
                                    curl_setopt_array($curl_6, array(
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => 'https://' . $mainUrl . $itemUrl,
                                        CURLOPT_SSL_VERIFYPEER => false
                                    ));
                                    $resp_6 = curl_exec($curl_6);
                                    curl_close($curl_6);
                                    if ($resp_6 === FALSE) {
                                        // curl error
                                    } else {
                                        if (strpos($resp_6, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_6, "browserpersistence") !== false || strpos($resp_6, "NODE_ENV") !== false) {
                                            $ispwaStudio = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            // curl error
        }
    }
}

if ($ispwaStudio) {
    echo 'true';
} else {
    echo 'false';
}
?>
