<?php 
include("include/database.php");
include("include/form.php");
include("include/functions.php");
include("include/mailer.php");
include("include/session.php"); 

?>
<!DOCTYPE html>
<html>
    <head>
    	<link href="include/styles.css?v=65" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="include/font-awesome/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Cambay|Itim|Jaldi|Ubuntu" rel="stylesheet"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script type="text/javascript" src="include/scripts.js"></script>
		<script type="text/javascript" src="include/jscolor/jscolor.js"></script>
        <meta property="og:url"                content="http://www.tikradovana.lt" />
        <meta property="og:type"               content="website" />
        <meta property="og:title"              content="TikraDovana.lt" />
        <meta property="og:description"        content="Nežinai ką padovanoti? Sužinok mano norus!" />
        <meta property="og:image"              content="/pictures/facebook_image.jpg" />
        <meta http-equiv="X-UA-Compatible" content="text/html; charset=utf-8"/>
        <title>Tikra Dovana</title>
        <?php 
        if ($session->logged_in || isset($_GET['id'])) {
            if($session->logged_in && isset($_GET['id'])){
                $user_id = $session->id;
                $bgg = bgg($user_id);
                $clr = clr($user_id);
                $ses = true;
                $user = PDO("SELECT id FROM users WHERE hash=:hash LIMIT 1", 'r', array(":hash" => $_GET['id']));
                if(!empty($user)){
                    $view_id = $user["id"];
                    $view = true;
                    $style = $user["id"];
                }else{
                    $view = false;
                    page_redirect('/user_not_found');
                }
            }elseif(isset($_GET['id'])){
                $user = PDO("SELECT id FROM users WHERE hash=:hash LIMIT 1", 'r', array(":hash" => $_GET['id']));
                if(!empty($user)){
                    $view_id = $user["id"];
                    $bgg = bgg($view_id);
                     $clr = clr($view_id);
                    $view = true;
                    $style = $user["id"];
                }else{
                    $view = false;
                    page_redirect('/user_not_found');
                }
            }else{
                $user_id = $session->id;
                $ses = true;
                $style = $user_id;
                $bgg = bgg($user_id);
                $clr = clr($user_id);
            }
            ?>
            <style type="text/css">
                body {
                    <?=$bgg?>
                }
                .my_interests_list label, .popular_interests_list label {
                    border: 2px solid <?=$clr?>;
                }
                .my_interests_list input:checked + label, .popular_interests_list input:checked + label{
                    border: solid 2px <?=$clr?>;
                    background-color: <?=$clr?>;
                }
                label.radio_image > input:checked + img {
                    border: 3px solid <?=$clr?>;
                }
                .my_dislikes_list label, .popular_dislikes_list label {
                    border: 2px solid <?=$clr?>;
                }
                .my_dislikes_list input:checked + label, .popular_dislikes_list input:checked + label{
                    border: solid 2px <?=$clr?>;
                    background-color: <?=$clr?>;
                }
                input[type=range]::-webkit-slider-thumb{
                    background: <?=$clr?>;
                }
                input[type=range]::-moz-range-thumb{
                    background: <?=$clr?>;
                }
                input[type=range]::-ms-thumb{
                    background: <?=$clr?>;
                }
                label.radio_image > input:checked + span{
                    background-color: <?=$clr?>;
                }
                .sizes-list p label{
                    border: 2px solid <?=$clr?>;
                }
                .sizes-list p label > input:checked + span { 
                    background-color: <?=$clr?>;
                }
                .radio_image {
                    border: 2px solid <?=$clr?>;
                }
            </style>
          <?php
        }else{
            $ses = false;
            ?>
            <style type="text/css">
                body{
                    background: url(/pictures/front_image.jpeg);
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center center;
                }
            </style>
            <?php
        }
    ?>
    </head>
    <body>
     
