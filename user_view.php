<?php

   $user_info = user_info($view_id);
   $background = background($view_id);
   $background_color = background_color($view_id);
   $color = color($view_id);
   $clr = clr($view_id);  
   ?>
   <section class="user_content">
   		<ul class="user_info">
             <li class="user_gift_list">
               <div class="info">
                  <?php
                     $gifts = PDO("SELECT * FROM user_gifts WHERE user_id=:user_id", 'a', array(":user_id" => $view_id));
                     if(!empty($gifts)){
                        ?><span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-gift" aria-hidden="true"></i></span>
                        <ul class="user_lists list-gift"><?php
                        //$gifts_amount = count($gifts);
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
                                 <li class="edit-gift"></li>
                              </ul>
                           </li>
                        <?php
                        $i++;
                        } ?>
                        </ul><?php
                     } ?>
                  
               </div>
            </li> 
            <li class="user_interests" id="user_interests">
               <div class="info">
                  <?php
                     $interests = user_interests($view_id);
                     if(!empty($interests)){ ?>
                        <span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span>
                        <ul class="user_lists"><?php
                        foreach ($interests as $interest) {
                           ?><li><?=$interest["name"]?></li><?php
                        }
                        ?></ul><?php
                     }
                  ?>
               </div>
            </li>
            <li class="user_dislikes">
               <div class="info">
                  <?php
                     $dislikes = user_dislikes($view_id);
                     if(!empty($dislikes)){
                        ?><span class="main_icons bg_color" style="<?=$background_color?>"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></span>
                        <ul class="user_lists"><?php
                        foreach ($dislikes as $dislike) {
                           ?><li><?=$dislike["name"]?></li><?php
                        }
                        ?></ul><?php
                     }
                  ?>
               </div>
            </li>
            <li class="user_personal_info">
               <div class="info">
                  <?php
                     $sizes = user_sizes($view_id);
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
                     }
                  ?>
               </div>
            </li>
           
         </ul>
   </section> 
         <?php 
         if($back_button){
            ?>
            <div class="button_back">
               <a  style="<?=$background_color?>" href="/">Grįžti į paskyrą</a>
            </div>
            <?php
         }else{
            ?>
            <div class="button_back">
               <a  style="<?=$background_color?>" href="/">Aplankyti svetainę</a>
            </div>
            <?php
         }
         ?>
