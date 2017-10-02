<?php
if ($session->logged_in) {
   $userinfo = $session->userinfo;
   $user_id = $session->id;   
   
   $background = background($user_id);
   $background_color = background_color($user_id);
   $color = color($user_id);
   $clr = clr($user_id);
   
  

   if(!empty($_GET['delete']) && can_edit($user_id, $_GET['delete'])){
      $db = database();
      $sql = "DELETE FROM user_gifts WHERE id =  :id";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':id', $_GET['delete'], PDO::PARAM_INT);   
      $stmt->execute();
      page_redirect('/');
   }

   if(!empty($_POST["title"]) || !empty($_POST["background"]) || !empty($_POST["bg_color"]) || !empty($_POST["description"]) || !empty($_POST["header_image"])){
      if($_POST["background"] !== ""){
         $bg = $_POST["background"];
      }else{
         $bg = "";
      }

      if($_POST["bg_color"] !== ""){
         $bg_color = $_POST["bg_color"];
      }else{
         $bg_color = "";
      }

      if($_POST["title"] !== ""){
         $title = $_POST["title"];
      }else{
         $title = "";
      }

      if($_POST["description"] !== ""){
         $description = $_POST["description"];
      }else{
         $description = "";
      }

       if($_POST["header_image"] !== ""){
         $header_image = $_POST["header_image"];
      }else{
         $header_image = "";
      }


      $style_id = PDO("SELECT id FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
      if(empty($style_id)){
         $db = database();
         $pdo = $db->prepare(
            "INSERT INTO user_style (
               user_id,
               color,
               background,
               title,
               description,
               header
            ) VALUES (
               :user_id,
               :color,
               :background,
               :title,
               :description,
               :header
            )"
         );
         $pdo->execute(array(
            ":user_id" => $user_id,
            ":color" => $bg_color,
            ":background" => $bg,
            ":title" => $title,
            ":description" => $description,
            ":header" => $header_image
            ));
      }else{
         $db = database();
         $pdo = $db->prepare(
            "UPDATE user_style SET 
               color = :color,
               background = :background,
               title = :title,
               description = :description,
               header = :header
            WHERE user_id=:user_id"
         );
         $pdo->execute(array(
            ":user_id" => $user_id,
            ":color" => $bg_color,
            ":background" => $bg,
            ":title" => $title,
            ":description" => $description,
            ":header" => $header_image
            ));
      }

      ?><meta http-equiv='refresh' content='0'><?php
   }

   //dump($_POST);
   ?>
   <section class="user_content">
       
   		<ul class="user_info">
            <li class="user_gift_list">
               <div class="info">
                  <a href="/gifts"><i class="fa fa-plus" aria-hidden="true"></i></a>
                  <?php
                     $gifts = PDO("SELECT * FROM user_gifts WHERE user_id=:user_id", 'a', array(":user_id" => $user_id));
                     if(!empty($gifts)){
                        ?><span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-gift" aria-hidden="true"></i></span>
                        <ul class="user_lists list-gift"><?php
                        $i = 0;
                        foreach ($gifts as $gift) { 
                           $title = $gift["title"];
                           if($gift["details"] !== ''){
                              $details = $gift["details"];
                           }else{
                              $details = '';
                           }
                           if($gift["url"] !== ''){
                              $url = '<a target="_blank" href="'.$gift["url"].'"><span style="'.$color.'" class="font_color external_link"><i class="fa fa-external-link" aria-hidden="true"></i></span></a>';
                           }else{
                              $url = '';
                           }
                           
                           ?>
                           <li>
                              <?php
                              if($i > 0) {
                                 ?><hr class="clr" style="border-top: 2px dashed <?=$clr?>"><?php
                              }
                              ?>
                              <ul class="list-element">
                                 <li class="li_img"><img src="pictures/<?=$gift['image']?>"></li>
                                 <li class="li_title"><span class="gift_title"><?=$title?></span>
                                 <span class="gift_details"><?=$details?></span></li>
                                 <li class="link li_link"><?=$url?></li>
                                 <li class="edit-gift"><a href="/gifts?edit=<?=$gift['id']?>" class="font_color" style="right: 1.3em;<?=$color?>"><i class="fa fa-pencil" aria-hidden="true"></i></a><a href="?delete=<?=$gift['id']?>" class="font_color" style="<?=$color?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                              </ul>
                           </li>
                        <?php
                        $i++;
                        } ?>
                        </ul><?php
                     }else{
                        ?><div class="empty_info bg_color" style="<?=$background_color?>">
                              <a href="/gifts"><i class="fa fa-gift" aria-hidden="true"></i>
                              <p>DOVANŲ SĄRAŠAS</p></a>
                        </div><?php
                     } ?>
                  
               </div>
            </li> 
   			<li class="user_interests" id="user_interests">
   				<div class="info">
                  <a href="/interests"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <?php
                     $interests = user_interests($user_id);
                     if(!empty($interests)){ ?>
                        <span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                        <ul class="user_lists"><?php
                        foreach ($interests as $interest) {
                           ?><li><?=$interest["name"]?></li><?php
                        }
                        ?></ul><?php
                     }else{
                        ?><div class="empty_info bg_color" style="<?=$background_color?>">
                              <a href="/interests"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                              <p>POMĖGIAI</p></a>
                        </div><?php
                     }
                  ?>
   				</div>
   			</li>
   			<li class="user_dislikes">
   				<div class="info">
   					<a href="/dislikes"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <?php
                     $dislikes = user_dislikes($user_id);
                     if(!empty($dislikes)){
                        ?><span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></span>
                        <ul class="user_lists"><?php
                        foreach ($dislikes as $dislike) {
                           ?><li><?=$dislike["name"]?></li><?php
                        }
                        ?></ul><?php
                     }else{
                        ?><div class="empty_info bg_color" style="<?=$background_color?>">
                              <a href="/dislikes"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                              <p>AČIŪ, BET NE</p></a>
                        </div><?php
                     }
                  ?>
   				</div>
   			</li>
   			<li class="user_personal_info">
   				<div class="info">
   					<a href="/sizes"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <?php
                     $sizes = user_sizes($user_id);
                     if(!empty($sizes)){
                        ?><span class="main_icons bg_color" style="<?=$background_color?>"><img src="pictures/human_icon.png"></span>
                        <ul class="user_lists">
                           <?php
                           if($sizes["height"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Ūgis: </div>
                                 <div class="size_value"><?=$sizes["height"]?> cm</div>
                              </li>
                           <?php } 
                           if($sizes["weight"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Svoris: </div>
                                 <div class="size_value"><?=$sizes["weight"]?> kg</div>
                              </li>
                           <?php }
                           if($sizes["top_id"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Viršus: </div>
                                 <div class="size_value"><?=size_top($sizes["top_id"])?></div>
                              </li>
                           <?php }
                           if($sizes["pants_id"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Kelnės: </div>
                                 <div class="size_value"><?=size_pants($sizes["pants_id"])?></div>
                              </li>
                           <?php }
                           if($sizes["shoe"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Batų dydis: </div>
                                 <div class="size_value"><?=$sizes["shoe"]?></div>
                              </li>
                           <?php }
                           if($sizes["ring"] !== '0'){
                              ?>
                              <li>
                                 <div class="size_title">Žiedo dydis: </div>
                                 <div class="size_value"><?=$sizes["ring"]?></div>
                              </li>
                           <?php }
                           ?>
                        </ul><?php
                     }else{
                        ?><div class="empty_info bg_color" style="<?=$background_color?>">
                              <a href="/sizes"><img src="pictures/human_medium.png">
                              <p>DYDŽIAI</p></a>
                        </div><?php
                     }
                  ?>
   				</div>
   			</li>
   			
   		</ul>
   </section> 
<?php   
} else {
    header("Location: index.php");
}
?>