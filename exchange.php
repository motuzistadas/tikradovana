<?php
include("header.php");
include("include/menu.php");
if ($session->logged_in) {
	$user_id = $session->id;
	$background_color = background_color($user_id);
	$bgg = bgg($user_id);
	$show_err = false;
	$clr = clr($user_id); ?>

<div class="container">
    <div class="content"> 
        <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
         <form method="POST" class="form" enctype="multipart/form-data">
         	<span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-users" aria-hidden="true"></i><p>Susikurkite grupę, kurioje keisitės dovanėlėmis!</p></span>
            <div class="gift-list">
            	
            </div>
        	<input type="submit" style="<?=$background_color?>" value="Saugoti">
        </form>
    </div>
</div><?php
include("include/footer.php"); ?>  
        
    <?php 
} else {
    header("Location: /");
}
?>