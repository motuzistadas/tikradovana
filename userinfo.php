<?php
include("include/session.php");
include("include/menu.php");
if ($session->logged_in) { #TODO: imesti apsauga kad ne visi galetu perziureti profili
    ?>
    <html>
        <head>
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/>
            <title>Mano profilis</title>
        </head>
        <body>     
            <div class="container">
                <div class="content">
                    <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>              
                    <h1 align="center">PROFILIS</h1>
                    <?php
                    if (isset($_GET['user'])) {
                        $req_user = trim($_GET['user']);
                    } else {
                        $req_user = null;
                    }
                    if (!$req_user || strlen($req_user) == 0 || !preg_match("/[A-Za-z0-9]+/", $req_user) || !$database->usernameTaken($req_user)) {
                        header("Location: /");
                    }
                    $req_user_info = $database->getUserInfo($req_user);

                       echo $req_user_info['username']; 
                       echo $req_user_info['email']; 
                    ?>
                </div>
            </div><?php
            include("include/footer.php"); ?>
        </body>
    </html>
    <?php
} else {
    header("Location: /");
}
?>