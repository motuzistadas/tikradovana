<?php
if (isset($form) && isset($session) && !$session->logged_in) {
    ?>   
    <form action="process" method="POST" class="login">              
        <center style="font-size:18pt;"><b>Prisijungimas</b></center>
        <p>Vartotojo vardas:<br>
            <input class ="s1" name="user" type="text" value="<?php echo $form->value("user"); ?>"/><br>
            <?php echo $form->error("user"); ?>
        </p>
        <p>Slaptažodis:<br>
            <input class ="s1" name="pass" type="password" value="<?php echo $form->value("pass"); ?>"/><br>
            <?php echo $form->error("pass"); ?>
        </p>  
        <p>
            <input type="submit" value="Prisijungti"/><br>
        </p>
        <input type="hidden" name="sublogin" value="1"/>
        <p>
            <a href="forgotpass"><i class="fa fa-unlock" aria-hidden="true"></i> Priminti slaptažodį</a><br>           
            <a href="register"><i class="fa fa-share" aria-hidden="true"></i> Registracija</a>
        </p>     
    </form>
    <?php
}
