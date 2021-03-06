<?php
$url = isset($_GET["url"]) ? $_GET["url"] : null;
$ispwaStudio = false;
// Normal case
$parseUrl = parse_url($url);
if (!$ispwaStudio) {
    if (isset($parseUrl['path'])) {
        if ($parseUrl['path'] !== '/') {
            // if url is: https://abc.com/xyz/def/...  -> check at: https://abc.com/
            $ispwaStudio = checkPwaStudio(str_replace($parseUrl['path'], '/', $url));
        }
    }
}

if (!$ispwaStudio) {
    // last character or url must be '/'
    if (substr($url, -1) !== '/') {
        $ispwaStudio = checkPwaStudio($url . '/');
    } else {
        $ispwaStudio = checkPwaStudio($url);
    }
}

// Add www into base url
if (!$ispwaStudio && strpos($url, 'www') === false) {
    // in case:  url is not contain 'www' -> add 'www'
    $parseUrl = parse_url(urlContainWww($url));
    if (!$ispwaStudio) {
        if (isset($parseUrl['path'])) {
            if ($parseUrl['path'] !== '/') {
                // if url is: https://abc.com/xyz/def/...  -> check at: https://abc.com/
                $ispwaStudio = checkPwaStudio(str_replace($parseUrl['path'], '/', urlContainWww($url)));
            }
        }
    }

    if (!$ispwaStudio) {
        // last character or url must be '/'
        if (substr(urlContainWww($url), -1) !== '/') {
            $ispwaStudio = checkPwaStudio(urlContainWww($url) . '/');
        } else {
            $ispwaStudio = checkPwaStudio(urlContainWww($url));
        }
    }
}



if ($ispwaStudio) {
    echo 'true';
} else {
    echo 'false';
}

function checkPwaStudio($url)
{
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
            preg_match_all('/<script[^>]*>(.*?)<\/script[^>]*>/', $resp, $matches);
            if (sizeof($matches)) {
                foreach ($matches as $item) {
                    if (sizeof($item)) {
                        foreach ($item as $subItem) {
                            if (isset($subItem)) {
                                preg_match('/client/', $subItem, $matches_1);
                                if (sizeof($matches_1)) {
                                    $subItemUrl = preg_replace('/<script.*src="/', '', $subItem);
                                    $subItemUrl = preg_replace('/"><\/script>/', '', $subItemUrl);
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
                                        // curl error
                                    } else {
                                        if (strpos($resp_1, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_1, "browserpersistence") !== false || strpos($resp_1, "NODE_ENV") !== false) {
                                            $ispwaStudio = true;
                                            break;
                                        }
                                    }
                                    if (!$ispwaStudio) {
                                        $parseUrl = parse_url($url);
                                        if (isset($parseUrl['path'])) {
                                            if ($parseUrl['path'] !== '/') {
                                                $curl_2 = curl_init();
                                                curl_setopt_array($curl_2, array(
                                                    CURLOPT_RETURNTRANSFER => 1,
                                                    CURLOPT_URL => str_replace($parseUrl['path'], '/', $url) . $subItemUrl,
                                                    CURLOPT_SSL_VERIFYPEER => false
                                                ));
                                                $resp_2 = curl_exec($curl_2);
                                                curl_close($curl_2);
                                                if ($resp_2 === FALSE) {
                                                    // curl error
                                                } else {
                                                    if (strpos($resp_2, "M2_VENIA_BROWSER_PERSISTENCE") !== false || strpos($resp_2, "browserpersistence") !== false || strpos($resp_2, "NODE_ENV") !== false) {
                                                        $ispwaStudio = true;
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($ispwaStudio) {
                        break;
                    }
                }
            } else {
                // curl error
            }
        }
    }
    return $ispwaStudio;
}

function urlContainWww($url)
{
    $newUrl = null;
    // url is: https://... or http://...
    if (strpos($url, 'www') === false) {
        if (strpos($url, 'https') !== false) {
            $newUrl = str_replace('https://', 'https://www.', $url);
        } else {
            $newUrl = str_replace('http://', 'http://www.', $url);
        }
    }
    return $newUrl;
}
