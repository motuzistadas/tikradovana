<?php
include("header.php");
include("include/menu.php");
if ($session->logged_in) {
    $user_id = $session->id;
    $background_color = background_color($user_id);
    $bgg = bgg($user_id);
    ?>
    <div class="container">
        <div class="content">  
            <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            <h3 style="<?=$background_color?>" align="center" class="main_heading">Duomenų keitimas</h3> <?php
            if (isset($_SESSION['useredit'])) {
                unset($_SESSION['useredit']);
                ?><p class="success_message"><b><?=$session->username?></b>, Jūsų duomenys buvo sėkmingai atnaujinti.<br><br><?php
            }else{ 
                if ($form->value("email") == "") {
                    $email = $session->userinfo['email'];
                }else{
                    $email = $form->value("email");
                } ?>
                <form action="process" method="POST" class="form">
                    <p>Dabartinis slaptažodis:<br>
                        <input type="password" name="curpass" maxlength="30" size="25" value="<?php echo $form->value("curpass"); ?>">
                        <br><?=$form->error("curpass")?></p>
                    <p>Naujas slaptažodis:<br>
                        <input type="password" name="newpass" maxlength="30" size="25" value="<?php echo $form->value("newpass"); ?>">
                        <br><?=$form->error("newpass")?></p>
                    <p>El. paštas:<br>
                        <input type="text" name="email" maxlength="30" size="25" value="<?=$email?>" required>
                        <br><?php echo $form->error("email"); ?></p>
                        <input type="hidden" name="subedit" value="1">
                        <input style="<?=$background_color?>" type="submit" value="Atnaujinti">
                </form> <?php
            } ?>
        </div>
    </div>
    <?php
    include("include/footer.php");
} else {
    header("Location: /");
}
?>