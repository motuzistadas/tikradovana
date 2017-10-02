<?php
include("header.php");
?>
 <div class="container main">
    <div class="content">       
           <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
               <div class="center">      
            <?php
            if (isset($_SESSION['forgotpass'])) {
                if ($_SESSION['forgotpass']) {
                    ?><p>Naujas slaptažodis nusiųstas <br> su nurodytu vartotoju susietu elektroniniu paštu. <br><br></p><?php
                } else {
                    ?><h1>Klaida</h1>
                    <p>Įvyko klaida siunčiant slaptažodį.<br>
                    <a href=\"/\"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></p><?php
                }
                unset($_SESSION['forgotpass']);
            } else { ?>
             
                Naujas slaptažodis bus nusiųstas su <br> Jūsų paskyra susietu el. pašto adresu.<br><br>
                Įveskite vartotojo vardą:<br>
                <?php
                echo $form->error("user");
                ?>
                <form action="process" method="POST" >
                    <input type="text" name="user" maxlength="30" value="<? echo $form->value("user"); ?>">
                    <input type="hidden" name="subforgot" value="1"><br><br>
                    <input type="submit" value="Siųsti">
                </form>
        <?php } ?>
          </div> 
     </div>
</div><?php
include("include/footer.php"); ?>
    