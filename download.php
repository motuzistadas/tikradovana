<?php
include("header.php");
if ($session->logged_in) {
    $user_id = $session->id;
    $user_info = user_info($user_id);
    $hash = $user_info["hash"];
    $view_link = 'http://'.$_SERVER['HTTP_HOST'].'?id='.$hash;

    $codeDir = $_SERVER["DOCUMENT_ROOT"].'/qrcodes/';
    $file_name = $hash.'.png';
    $absolutePath = $codeDir.$file_name;
    $relativePath = 'qrcodes/'.$file_name;
    if (file_exists($absolutePath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="'.$user_info["username"].'-share.png"');
        ob_clean();
        flush();
        readfile($relativePath);
        exit;
    }
}        
?>