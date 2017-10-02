<?php
include("header.php");
include("include/menu.php");
if ($session->logged_in) {
	$user_id = $session->id;
    $background = background($user_id);
    $background_color = background_color($user_id);
    $color = color($user_id);
    $clr = clr($user_id);
    $bgg = bgg($user_id);
    ?>	
            <div class="container">
                <div class="content"> <?php 
            		if (isset($_POST) && !empty($_POST["interest"]) || !empty($_POST["own_interest"])) {

            			if(!empty($_POST["interest"])){
            				$interests = $_POST["interest"];
            			}else{
            				$interests = false;
            			}

            			if(!empty($_POST["own_interest"])){
            				$own_interests = $_POST["own_interest"];
            			}else{
            				$own_interests = false;
            			}

            			if($interests){
            				$db = database();
            				$sql = "DELETE FROM user_interests WHERE user_id =  :user_id";
							$stmt = $db->prepare($sql);
							$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);   
							$stmt->execute();

							foreach ($interests as $interest => $value) {
								$db = database();
							      $pdo = $db->prepare(
							         "INSERT INTO user_interests (
							            user_id,
							            interest_id
							         ) VALUES (
							            :user_id,
							            :interest_id
							         )"
							      );
							      $pdo->execute(array(
							         ":user_id" => $user_id,
							         ":interest_id" => $value
							         ));
							}
            			}

            			if($own_interests){
            				foreach ($own_interests as $own_int => $value) {
            					dump($value);
            					$name = PDO("SELECT id FROM interests WHERE name=:name LIMIT 1", 'r', array(":name" => $value));
            					if(!empty($name)){
            						$is = PDO("SELECT * FROM user_interests WHERE interest_id=:interest_id LIMIT 1", 'r', array(":interest_id" => $name["id"]));
            						if(empty($is)){
                						$db = database();
								      $pdo = $db->prepare(
								         "INSERT INTO user_interests (
								            user_id,
								            interest_id
								         ) VALUES (
								            :user_id,
								            :interest_id
								         )"
								      );
								      $pdo->execute(array(
								         ":user_id" => $user_id,
								         ":interest_id" => $name["id"]
								         ));
            						}
            					}else{
            						$db = database();
								      $pdo = $db->prepare(
								         "INSERT INTO interests (
								            name
								         ) VALUES (
								            :name
								         )"
								      );
								      $pdo->execute(array(
								         ":name" => $value
								         ));

								      $int_id = $db->lastInsertId();

								      $pdo = $db->prepare(
								         "INSERT INTO user_interests (
								            user_id,
								            interest_id
								         ) VALUES (
								            :user_id,
								            :interest_id
								         )"
								      );
								      $pdo->execute(array(
								         ":user_id" => $user_id,
								         ":interest_id" => $int_id
								         ));
            					}
            				}
            			}
                		page_redirect('/');
                	}
                	?>
                    <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                     <form method="POST" class="form">
	                    <div class="my_interests">
	                    <h3 style="<?=$background_color?>">Mano pomėgiai</h3>
	                    	<?php
	                    		$my_interests = user_interests($user_id);
	                    		$my_ints = array();
	                    		if(!empty($my_interests)){
	                    			?><ul class="my_interests_list sortable"><?php
	                    			foreach ($my_interests as $interest) { 
	                    				$my_int_id = $interest["interest_id"]; ?>
	                    				<li>
				                    	<input type="checkbox" name="interest[]" value="<?=$my_int_id?>" id="interest_<?=$my_int_id?>" checked>
				                    	<label for="interest_<?=$my_int_id?>"><?=$interest['name']?></label>
				                    	</li><?php
				                    	$my_ints[] = $my_int_id;
	                    			}
	                    			?></ul><?php
	                    			$my_ints = implode(", ", $my_ints);
	                    		}else{
	                    			?><p>Įvardinkite savo pomėgius!</p><?php
	                    			$my_ints = null;
	                    		}
	                    	?>
	                    </div>
                   
                    	<div class="pop_interests">
                    	<h3 style="<?=$background_color?>">Populiariausi pomėgiai</h3>
		                   <?php
		                   $popular_interests = popular_interests($my_ints);
		                   $user_interests = user_interests($user_id);
		                   if(!empty($user_interests)){
		                   		$user_int_ids = array();
			                   foreach ($user_interests as $u_int) {
			                   		$user_int_ids[] = $u_int['interest_id'];
			                   }
		                   }else{
		                   		$user_int_ids = array();
		                   }
		                   	?><ul class="popular_interests_list"><?php
		                    foreach ($popular_interests as $int) {
		                    	$int_id = $int['interest_id'];
		                    	?>
		                    	<li>
		                    	<input  type="checkbox" name="interest[]" value="<?=$int_id?>" id="interest_<?=$int_id?>" <?=in_array($int_id, $user_int_ids) ? ' checked' : '' ?>>	
		                    	<label for="interest_<?=$int_id?>"><?=$int['name']?></label>
		                    	</li><?php
		                    }
		                    ?>
		                    </ul>
                    	</div>
                    	<div class="own_interests">
                    		<h3 style="<?=$background_color?>">Naujas pomėgis</h3>
                    		<input type="text" name="own_interest[]" value=""><br>
                    	</div>
                    	<input type="button" style="<?=$background_color?>" name="add_interest" class="add" value="+"><br>
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