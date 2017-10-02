<?php
include("header.php");
if ($session->logged_in) {
    header("Location: /");
} else { ?>
    
     <div class="container main">
        <div class="content">
            <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>             
            <?php
            if (isset($_SESSION['regsuccess'])) {
                if ($_SESSION['regsuccess']) {
                    ?>
                    <div class="register">
                        <p>Ačiū, <b><?=$_SESSION['reguname']?></b>, Jūs sėkmingai užsiregistravote<br> Galite <a href="/">prisijungti</a>.</p>
                    </div>
                    <?php
                }
                else {
                    ?><p>Atsiprašome, įvyko klaida!<br> Vartotojo - <b><?=$_SESSION['reguname']?></b>, registracija nebuvo sėkmingai baigta.<br>Bandykite dar kartą.</p><?php
                }
                unset($_SESSION['regsuccess']);
                unset($_SESSION['reguname']);
            }else {
                ?>
                <div align="center">
                    <form action="process" method="POST" class="login">              
                        <center style="font-size:18pt;"><b>Registracija</b></center>
                        <p>Vartotojo vardas<br>
                            <input class ="s1" name="user" type="text" size="15"
                                   value="<?php echo $form->value("user"); ?>"/><br><?php echo $form->error("user"); ?>
                        </p>
                        <p>Slaptažodis<br>
                            <input class ="s1" name="pass" type="password" size="15"
                                   value="<?php echo $form->value("pass"); ?>"/><br><?php echo $form->error("pass"); ?>
                        </p>  
                        <p>El. paštas<br>
                            <input class ="s1" name="email" type="text" size="15"
                                   value="<?php echo $form->value("email"); ?>"/><br><?php echo $form->error("email"); ?>
                        </p>  
                        <p>
                            <input type="hidden" name="subjoin" value="1">
                            <input type="submit" value="Registruotis">
                        </p>
                    </form>
                </div>
                    <?php
            } ?>
        </div>
    </div><?php
    include("include/footer.php"); 
}
?>
