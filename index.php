<?php
include("header.php");
?>
	<div class="container front" id="container">
<?php 
	



if(!$view){
   $background = background($user_id);
   $background_color = background_color($user_id);
   $color = color($user_id);
   $usr_id = $user_id;
}else{
   $background = background($view_id);
   $background_color = background_color($view_id);
   $color = color($view_id);
   $usr_id = $view_id;
}

$back_button = false;
if ($ses || $view) {

?>
<header class="user_header" style="<?=$background?>">
	<?php if(!$view){ ?>
	<div class="theme-nav">
		<div class="choose-theme bg_color" style="<?=$background_color?>">
            <a ng-click="prevTheme()" class="prev-theme"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <span>Pasirinkite temą</span>
            <a ng-click="nextTheme()" class="next-theme"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
        </div>
	</div>
	<div class="background-nav">
		<div class="choose-background bg_color" style="<?=$background_color?>">
            <a ng-click="prevBackground()" class="prev-background"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
            <span>Pasirinkite foną</span>
            <a ng-click="nextBackground()" class="next-background"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
        </div>
	</div>
	 <div class="style-save bg_color" style="<?=$background_color?>">
    	<label for="style-save"><i class="fa fa-floppy-o" aria-hidden="true"></i><span>Saugoti</span></label>
    </div>
	<?php } ?>
	<div class="title bg_color" style="<?=$background_color?>">
		<?php 
		$ttl = title($usr_id);
		$des = description($usr_id);
		$bg = user_bg($user_id);
		$clr = user_clr($user_id);
		$hdr = user_hdr($user_id);
		if($ttl){
			$title = $ttl;
		}else{
   			$title = '';
		} 
		if($des){
			$description = $des;
		}else{
   			$description = '';
		}
		if($bg){
			$bcg = $bg;
		}else{
			$bcg = '';
		}
		if($clr){
			$colr = $clr;
		}else{
			$colr = '';
		}
		if($hdr){
			$header = $hdr;
		}else{
			$header = '';
		}

		if(!$view){
		?>
		<form method="POST" class="edit-title">
			<input type="text" class="input-title" name="title" value="<?=$title?>" placeholder="pavadinimas" required>
			<input type="text" class="input-description" name="description" value="<?=$description?>" placeholder="aprašymas">
			<div class="edit-tooltip">
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</div>
			<input id="bg_iamge" type="hidden" name="background" value="<?=$bcg?>">
			<input id="bg_color" type="hidden" name="bg_color" value="<?=$colr?>">
			<input id="header_image" type="hidden" name="header_image" value="<?=$header?>">
			<input type="submit" id="style-save" value="save">
		</form>
		<?php } else{ ?>
		<div class="edit-title">
			<span><?=$title?></span>
			<span class="description"><?=$description?></span>
		</div>
		<?php } ?>
	</div>
	
</header>

<?php } ?>
<div class="content"> <?php
    if ($ses && $view) {
        $back_button = true;
        include("user_view.php");
    }elseif($view){
    	include("user_view.php");
    }elseif($ses){
    	include("include/menu.php");
        include("user_main.php");
    }else {  
        include("include/login_form.php");
    }
    ?>
    </div>
</div><?php
include("include/footer.php"); ?>
    