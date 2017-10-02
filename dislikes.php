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
	    <div class="content"> 
	    	<?php 
	    		if (!empty($_POST["dislike"]) || !empty($_POST["own_dislike"])) {

	    			if(!empty($_POST["dislike"])){
	    				$dislikes = $_POST["dislike"];
	    			}else{
	    				$dislikes = false;
	    			}

	    			if(!empty($_POST["own_dislike"])){
	    				$own_dislikes = $_POST["own_dislike"];
	    			}else{
	    				$own_dislikes = false;
	    			}

	    			if($dislikes){
	    				$db = database();
	    				$sql = "DELETE FROM user_dislikes WHERE user_id =  :user_id";
						$stmt = $db->prepare($sql);
						$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);   
						$stmt->execute();

						foreach ($dislikes as $dislike => $value) {
							$db = database();
						      $pdo = $db->prepare(
						         "INSERT INTO user_dislikes (
						            user_id,
						            dislike_id
						         ) VALUES (
						            :user_id,
						            :dislike_id
						         )"
						      );
						      $pdo->execute(array(
						         ":user_id" => $user_id,
						         ":dislike_id" => $value
						         ));
						}
	    			}

	    			if($own_dislikes){
	    				foreach ($own_dislikes as $own_int => $value) {
	    					$name = PDO("SELECT id FROM dislikes WHERE name=:name LIMIT 1", 'r', array(":name" => $value));
	    					if(!empty($name)){
	    						echo "jau yra", $name["id"];
	    						$is = PDO("SELECT * FROM user_dislikes WHERE dislike_id=:dislike_id LIMIT 1", 'r', array(":dislike_id" => $name["id"]));
	    						if(empty($is)){
	        						$db = database();
							      $pdo = $db->prepare(
							         "INSERT INTO user_dislikes (
							            user_id,
							            dislike_id
							         ) VALUES (
							            :user_id,
							            :dislike_id
							         )"
							      );
							      $pdo->execute(array(
							         ":user_id" => $user_id,
							         ":dislike_id" => $name["id"]
							         ));
	    						}
	    					}else{
	    						$db = database();
							      $pdo = $db->prepare(
							         "INSERT INTO dislikes (
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
							         "INSERT INTO user_dislikes (
							            user_id,
							            dislike_id
							         ) VALUES (
							            :user_id,
							            :dislike_id
							         )"
							      );
							      $pdo->execute(array(
							         ":user_id" => $user_id,
							         ":dislike_id" => $int_id
							         ));
	    					}
	    				}
	    			}

	    			page_redirect('/');
	    		}
	    	?>
	        <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
	         <form method="POST" class="form">
	            <div class="my_dislikes">
	            <h3 style="<?=$background_color?>">Nemėgstu | Bijau | Nenoriu</h3>
	            	<?php
	            		$my_dislikes = user_dislikes($user_id);
	            		$my_ints = array();
	            		if(!empty($my_dislikes)){
	            			?><ul class="my_dislikes_list"><?php
	            			foreach ($my_dislikes as $dislike) { 
	            				$my_int_id = $dislike["dislike_id"]; ?>
	            				<li>
		                    	<input  type="checkbox" name="dislike[]" value="<?=$my_int_id?>" id="dislike_<?=$my_int_id?>" checked>
		                    	<label for="dislike_<?=$my_int_id?>"><?=$dislike['name']?></label>
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
	       
	        	<div class="pop_dislikes">
	        	<h3 style="<?=$background_color?>">Populiariausi</h3>
	               <?php
	               $popular_dislikes = popular_dislikes($my_ints);
	               $user_dislikes = user_dislikes($user_id);
	               if(!empty($user_dislikes)){
	               		$user_int_ids = array();
	                   foreach ($user_dislikes as $u_int) {
	                   		$user_int_ids[] = $u_int['dislike_id'];
	                   }
	               }else{
	               		$user_int_ids = array();
	               }
	               	?><ul class="popular_dislikes_list"><?php
	                foreach ($popular_dislikes as $int) {
	                	$int_id = $int['dislike_id'];
	                	?>
	                	<li>
	                	<input  type="checkbox" name="dislike[]" value="<?=$int_id?>" id="dislike_<?=$int_id?>" <?=in_array($int_id, $user_int_ids) ? ' checked' : '' ?>>	
	                	<label for="dislike_<?=$int_id?>"><?=$int['name']?></label>
	                	</li><?php
	                }
	                ?>
	                </ul>
	        	</div>
	        	<div class="own_dislikes">
	        		<h3 style="<?=$background_color?>">Nauja nemėgstama veikla / dalykas</h3>
	        		<input type="text" name="own_dislike[]" value=""><br>
	        	</div>
	        	<input style="<?=$background_color?>" type="button" name="add_dislike" class="add" value="+"><br>
	        	<input style="<?=$background_color?>" type="submit" value="Saugoti">
	        </form>
	    </div>
	</div><?php
    include("include/footer.php"); ?>  
    <?php 
} else {
    header("Location: /");
}
?>