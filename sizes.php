<?php
include("header.php");
include("include/menu.php");
if ($session->logged_in) {
	$user_id = $session->id;
	$background = background($user_id);
    $background_color = background_color($user_id);
    $color = color($user_id);
    $clr = clr($user_id);
	$edit = false;
	$bgg = bgg($user_id);

	$is_edit = PDO("SELECT * FROM user_sizes WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($is_edit)){

		$edit = true;
		if($is_edit['height'] !== '0'){
			$e_height = $is_edit['height'];
			$height_checked = '';
		}else{
			$e_height = '170';
			$height_checked = ' checked';
		}
		if($is_edit['weight'] !== '0'){
			$e_weight = $is_edit['weight'];
			$weight_checked = '';
		}else{
			$e_weight = '65';
			$weight_checked = ' checked';
		}
		if($is_edit['top_id'] !== '0'){
			$e_top = $is_edit['top_id'];
			$top_checked = '';
		}else{
			$e_top = '4';
			$top_checked = ' checked';
		}
		if($is_edit['pants_id'] !== '0'){
			$e_pants = $is_edit['pants_id'];
			$pants_checked = '';
		}else{
			$e_pants = '40';
			$pants_checked = ' checked';
		}
		if($is_edit['shoe'] !== '0'){
			$e_shoe = $is_edit['shoe'];
			$shoe_checked = '';
		}else{
			$e_shoe = '40';
			$shoe_checked = ' checked';
		}
		if($is_edit['ring'] !== ''){
			$e_ring = $is_edit['ring'];
			$ring_checked = '';
		}else{
			$e_ring = '14';
			$ring_checked = ' checked';
		}
	}

	if(isset($_POST['height'])){
		if($_POST['hide-height']){
			$height = '';
		}else{
			$height = $_POST['height'];
		}

		if($_POST['hide-weight']){
			$weight = '';
		}else{
			$weight = $_POST['weight'];
		}

		if($_POST['hide-top']){
			$top = '';
		}else{
			$top = $_POST['top'];
		}

		if($_POST['hide-pants']){
			$pants = '';
		}else{
			$pants = $_POST['pants'];
		}

		if($_POST['hide-shoe']){
			$shoe = '';
		}else{
			$shoe = $_POST['shoe'];
		}

		if($_POST['hide-ring']){
			$ring = '';
		}else{
			$ring = $_POST['ring'];
		}

		if(!$edit){
			  $db = database();
		      $pdo = $db->prepare(
		         "INSERT INTO user_sizes (
		            user_id,
		            height,
		            weight,
		            top_id,
		            pants_id,
		            shoe,
		            ring
		         ) VALUES (
		            :user_id,
		            :height,
		            :weight,
		            :top,
		            :pants,
		            :shoe,
		            :ring
		         )"
		      );
		      $pdo->execute(array(
		         ":user_id" => $user_id,
		         ":height" => $height,
		         ":weight" => $weight,
		         ":top" => $top,
		         ":pants" => $pants,
		         ":shoe" => $shoe,
		         ":ring" => $ring,
		         ));
		      page_redirect('/');
		}else{
			 $db = database();
	         $pdo = $db->prepare(
	            "UPDATE user_sizes SET 
	               height = :height,
	               weight = :weight,
	               top_id = :top,
	               pants_id = :pants,
	               shoe = :shoe,
	               ring = :ring
	            WHERE user_id=:user_id"
	         );
	         $pdo->execute(array(
	            ":height" => $height,
	            ":weight" => $weight,
	            ":top" => $top,
	            ":pants" => $pants,
	            ":shoe" => $shoe,
	            ":ring" => $ring,
	            ":user_id" => $user_id
	            ));
	         page_redirect('/');
		}

	}

    ?>
    
    <div class="container">
        <div class="content"> 
        	<a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        	<form method="POST" class="form">
             	<span class="main_icons bg_color" style="<?=$background_color?>"><img src="pictures/human_icon.png"><p>Pasidalinkite savo fizine informacija!</p></span>
             	<div class="human_image">
             		<img src="pictures/human.png">
             	</div>
             	<?php if(!$edit){ ?>
                <div class="sizes-list">
					<p>Ūgis, cm <label><input class="chbox" type="checkbox" name="hide-height"><span>nerodyti</span></label></p>
					<input id="height" type="range" name="height" min="50" max="230" value="170"><span class="height">170</span>
					<p>Svoris, kg <label><input class="chbox" type="checkbox" name="hide-weight"><span>nerodyti</span></label></p>
					<input id="weight" type="range" name="weight" min="1" max="200" value="65"><span class="weight">65</span>
					<p>Viršutiniai drabužiai <label><input class="chbox" type="checkbox" name="hide-top"><span>nerodyti</span></label></p>
					<?php 
					$top_sizes = PDO("SELECT * FROM top_sizes", 'a', null);
					foreach ($top_sizes as $size) { ?>
						<label class="radio_image">
						  <input type="radio" name="top" value="<?=$size['id']?>" <?php if($size['id'] == '4') echo " checked";?>/>
						   <span><?=$size['size']?></span>
						</label>
					<?php } ?>
					
					<p>Kelnės <label><input class="chbox" type="checkbox" name="hide-pants"><span>nerodyti</span></label></p>
					<?php 
					$pants_sizes = PDO("SELECT * FROM pants_sizes", 'a', null);
					foreach ($pants_sizes as $size) { ?>
						<label class="radio_image">
						  <input type="radio" name="pants" value="<?=$size['id']?>" <?php if($size['id'] == '40') echo " checked";?>/>
						  <span><?=$size['size']?></span>
						</label>
					<?php } ?>
					<p>Batų dydis <label><input class="chbox" type="checkbox" name="hide-shoe"><span>nerodyti</span></label></p>
					<input id="shoe" type="range" name="shoe" min="10" max="55" value="40" step="1"><span class="shoe">40</span>
					<p>Žiedo dydis <label><input class="chbox" type="checkbox" name="hide-ring"><span>nerodyti</span></label></p>
					<input id="ring" type="range" name="ring" min="13.5" max="22" value="14" step="0.5"><span class="ring">14</span>
                </div>
                <?php }else{ ?>
                <div class="sizes-list">
					<p>Ūgis, cm <label><input class="chbox" type="checkbox" name="hide-height" <?=$height_checked?>><span>nerodyti</span></label></p>
					<input id="height" type="range" name="height" min="50" max="230" value="<?=$e_height?>"><span class="height"><?=$e_height?></span>
					<p>Svoris, kg <label><input class="chbox" type="checkbox" name="hide-weight" <?=$weight_checked?>><span>nerodyti</span></label></p>
					<input id="weight" type="range" name="weight" min="1" max="200" value="<?=$e_weight?>"><span class="weight"><?=$e_weight?></span>
					<p>Viršutiniai drabužiai <label><input class="chbox" type="checkbox" name="hide-top" <?=$top_checked?>><span>nerodyti</span></label></p>
					<?php 
					$top_sizes = PDO("SELECT * FROM top_sizes", 'a', null);
					foreach ($top_sizes as $size) { ?>
						<label class="radio_image">
						  <input type="radio" name="top" value="<?=$size['id']?>" <?php if($size['id'] == $e_top) echo " checked";?>/>
						  <span><?=size_top($size['id'])?></span>
						</label>
					<?php } ?>
					
					<p>Kelnės <label><input class="chbox" type="checkbox" name="hide-pants" <?=$pants_checked?>><span>nerodyti</span></label></p>
					<?php 
					$pants_sizes = PDO("SELECT * FROM pants_sizes", 'a', null);
					foreach ($pants_sizes as $size) { ?>
						<label class="radio_image">
						  <input type="radio" name="pants" value="<?=$size['id']?>" <?php if($size['id'] == $e_pants) echo " checked";?>/>
						  <span><?=size_pants($size['id'])?></span>
						</label>
					<?php } ?>
					<p>Batų dydis <label><input class="chbox" type="checkbox" name="hide-shoe" <?=$shoe_checked?>><span>nerodyti</span></label></p>
					<input id="shoe" type="range" name="shoe" min="10" max="55" value="<?=$e_shoe?>" step="1"><span class="shoe"><?=$e_shoe?></span>
					<p>Žiedo dydis <label><input class="chbox" type="checkbox" name="hide-ring" <?=$ring_checked?>><span>nerodyti</span></label></p>
					<input id="ring" type="range" name="ring" min="13.5" max="22" value="<?=$e_ring?>" step="0.5"><span class="ring"><?=$e_ring?></span>
                </div>
                <?php } ?>
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