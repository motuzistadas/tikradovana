<?php
include("header.php");
include("include/menu.php");
if ($session->logged_in) {
	$user_id = $session->id;
	$background_color = background_color($user_id);
	$bgg = bgg($user_id);
	$show_err = false;
	$clr = clr($user_id);
	

	$gift = array();
	$update = false;
	if(!empty($_GET['edit']) && can_edit($user_id, $_GET['edit'])){
		$edit = $_GET['edit'];
		$gift = PDO("SELECT * FROM user_gifts WHERE id=:id LIMIT 1", 'r', array(":id" => $edit));
		$update = true;
	}else{
		$edit = false;
	}

	if(!empty($_POST['title'])){
		$title = $_POST['title'];
		if(!empty($_POST['details'])){
			$details = $_POST['details'];
		}else{
			$details = '';
		}
		if(!empty($_POST['url'])){
			$url = $_POST['url'];
		}else{
			$url = '';
		}
		$image = '';

		if($_POST['radio_img'] == 'own' && $update && $_FILES['my_files']['name'] == ''){
			$image = $gift['image'];
		}elseif ($_POST['radio_img'] == 'own'){
			//echo "string";
			$url = $_POST['url'];
			 $filename=$_FILES['my_files']['name'];
			 $filetype=$_FILES['my_files']['type'];
			 $filename = strtolower($filename);
			 $filetype = strtolower($filetype);

			 $errors = array();
			 $pos = strpos($filename,'php');
			 if(!($pos === false)) {
				 $errors[] = 'Palaikomi nuotraukų formatai: .jpg | .jpeg | .png | .gif';
			 }

			 $file_ext = strrchr($filename, '.');
			 $whitelist = array(".jpg",".jpeg",".gif",".png"); 
			 if (!(in_array($file_ext, $whitelist))) {
			    $errors[] = 'Palaikomi nuotraukų formatai: .jpg | .jpeg | .png | .gif';
			 }
			 $pos = strpos($filetype,'image');
			 if($pos === false) {
			  $errors[] = 'Kilo problemų įkeliant failą, bandykite dar kartą';
			 }
			 $imageinfo = getimagesize($_FILES['my_files']['tmp_name']);
			 if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg'&& $imageinfo['mime']      != 'image/jpg'&& $imageinfo['mime'] != 'image/png') {
			   $errors[] = 'Kilo problemų įkeliant failą, bandykite dar kartą';
			 }
			if(substr_count($filetype, '/')>1){
				$errors[] = 'Kilo problemų įkeliant failą, bandykite dar kartą';
			}
			$uploaddir = 'pictures/' ;
			
			if(!empty($errors)){
				$show_err = true; 
			}else{
				$new_name = md5(basename($_FILES['my_files']['name'])).$file_ext;
				$uploadfile = $uploaddir . $new_name;
				if (!move_uploaded_file($_FILES['my_files']['tmp_name'], $uploadfile)) {
				   ?><p class="error">Kilo problemų įkeliant failą, bandykite dar kartą</p><?php
				   
				}
				$image = $new_name;

			}
		}else{
			$image = $_POST['radio_img'].'.png';
		}

		if($image !== ''){
			if(!$update){
				  $db = database();
			      $pdo = $db->prepare(
			         "INSERT INTO user_gifts (
			            user_id,
			            title,
			            details,
			            url,
			            image
			         ) VALUES (
			            :user_id,
			            :title,
			            :details,
			            :url,
			            :image
			         )"
			      );
			      $pdo->execute(array(
			         ":user_id" => $user_id,
			         ":title" => $title,
			         ":details" => $details,
			         ":url" => $url,
			         ":image" => $image,
			         ));
			      page_redirect('/');
			}else{
				 $db = database();
		         $pdo = $db->prepare(
		            "UPDATE user_gifts SET 
		               title = :title,
		               details = :details,
		               url = :url,
		               image = :image
		            WHERE id=:id"
		         );
		         $pdo->execute(array(
		            ":title" => $title,
		            ":details" => $details,
		            ":url" => $url,
		            ":image" => $image,
		            ":id" => $edit
		            ));
		         page_redirect('/');
			}
		}
	} ?>

<div class="container">
    <div class="content"> 
        <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
         <form method="POST" class="form" enctype="multipart/form-data">
         	<span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-gift" aria-hidden="true"></i><p>Papildykite dovanų sąraša nauja dovana!</p></span>
            <div class="gift-list">
            	<ul class="radio_image_list" id="radio_image_list">
            		<?php 

            		if(!$update){
            			$default = ' checked';
            		}else{
            			$default = '';
            		}
            		$images = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16');
            		
            		$icon = array();
            		$i = 0;
            		foreach ($images as $image => $value) {
            			$i++;
            			if($value == '1'){
            				$def = $default;
            			}else{
            				$def = '';
            			}
            			if($gift['image'] == $value.'.png'){
            				$checked = ' checked';
            				$icon[] = 'icon';
            			}else{
            				$checked = '';
            			}
            			?>
            			<li>
							<label class="radio_image">
							  <input type="radio" name="radio_img" value="<?=$value?>" <?=$checked, $def?>/>
							  <img src="pictures/<?=$value?>.png">
							</label>
						</li>

            			<?php
            		}
            		if(empty($icon) && $update){
            			$own_img = ' checked';
            			$image_src = 'pictures/'.$gift['image'];
            		}else{
            			$own_img = '';
            			$image_src = '#';
            		}

            		if(empty($icon) && $update){
            			$display = ' style="display: inline"';
            		}else{
            			$display = '';
            		}

            		?>
					<li>
				        <input type="file" name="my_files" id="image" onchange="readURL(this);">
						<label class="radio_image last" <?=$display?>>
						  <input id="added-radio" type="radio" name="radio_img" value="own" <?=$own_img?>/>
						  <img id="list-img" src="<?=$image_src?>">
						</label>
						<label style="<?=$background_color?>" id="add_image" for="image"><span>Pridėti nuotrauką</span></label>
					</li>
				</ul>
				<div class="gift-info">
                	<label for="title">Pavadinimas</label>
                	<input type="text" name="title" id="title" required value="<?=$gift['title']?>">
                	<label for="details">Aprašymas</label>
                	<input type="text" name="details" id="details" value="<?=$gift['details']?>">
                	<label for="url">Nuoroda</label>
                	<input type="url" name="url" id="url" value="<?=$gift['url']?>">
                	<?php
                	if($show_err){
                		?><p class="error">Kilo problemų įkeliant failą, bandykite dar kartą><br>Palaikomi nuotraukų formatai: .jpg | .jpeg | .png | .gif</p><?php
                	}
                	?>
				</div>
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