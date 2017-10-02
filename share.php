<?php
include("header.php");
include("include/menu.php");
include("include/phpqrcode/qrlib.php");
if ($session->logged_in) {
    $user_id = $session->id;
    $background = background($user_id);
    $background_color = background_color($user_id);
    $color = color($user_id);
    $clr = clr($user_id);
    $user_info = user_info($user_id);
    $hash = $user_info["hash"];
    $ur = 'http://www.tikradovana.lt/?id='.$hash;
    $view_link = 'http://'.$_SERVER['HTTP_HOST'].'?id='.$hash;
    $link = '<a href="'.$view_link.'">tikradovana.lt</a>';
    $bgg = bgg($user_id);

    $title=urlencode('tikradovana');
    $url=urlencode($ur);
    $image=urlencode('http://goo.gl/dS52U');
    ?>
    
        <div class="container">
            <div class="content"> 

                <a href="/"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <h3 class="qr_heading" style="<?=$background_color?>">Dalinkis savo reprezentaciniu langu ir gauk dovanas, kurių nereikės padėti į stalčių!</h3>
                <div class="facebook_share">
                  <a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[url]=<?php echo $url; ?>&amp;', 'sharer', 'toolbar=0,status=0,width=548,height=325');" target="_parent" href="javascript: void(0)">
                      <i class="fa fa-facebook-square"></i> <span>Dalintis</span>
                  </a>
                </div>
                <div class="qrcode">
                    <?php 
                    $codeDir = $_SERVER["DOCUMENT_ROOT"].'/qrcodes/';
                    $file_name = $hash.'.png';
                    $absolutePath = $codeDir.$file_name;
                    $relativePath = '/qrcodes/'.$file_name;
                    if (!file_exists($absolutePath)) {
                        QRcode::png($view_link, $absolutePath);
                         ?>
                         <img src="<?=$relativePath?>">
                         <button class="button download_qr"><i class="fa fa-download" aria-hidden="true"></i></button>
                         <?php
                    }else{
                        ?>
                        <img src="<?=$relativePath?>">
                        <button style="<?=$background_color?>" class="button download_qr"><i class="fa fa-download" aria-hidden="true"></i></button>
                        <?php
                    }
                    ?>
                </div><?php

                $send = false;
                $wrong_email = false;
                if (isset($_REQUEST['email']))  {
                  $admin_email = $user_info["email"];
                  $email = $_REQUEST['email'];
                  $subject = $_REQUEST['subject'];
                  $msg = $_REQUEST['msg'];
                  
                 // dump($_REQUEST);
                  $wrong_emails = array();
                  foreach ($email as $mail => $value) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                       $wrong_emails[] = $value;
                    } 
                  }

                    if(empty($wrong_emails)){
                      $to = implode(", ", $email);
                      $headers  = 'MIME-Version: 1.0' . "\r\n";
                      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                      $headers .= 'From: ' . $admin_email . "\r\n";
                      //dump($msg);
                      mail($to, $subject, $msg, $headers);
                      $send = true;
                    }else{
                      $wrong_email = true;
                       ?> 
                        <h3 class="email_heading" style="<?=$background_color?>">Išsiųsk nuorodą draugams!</h3>
                        <div class="mail_form">
                            <form method="post" class="form">
                              <div class="emails">
                              <?php 
                              $i = 0;
                              foreach ($email as $mail => $value) {
                               if($i == '0'){
                                ?><label for="main_email">El. paštas</label>
                                <input id="main_email" name="email[]" type="text"/ value="<?=$value?>">
                                <a href="#" class="add_email"><i class="fa fa-plus" aria-hidden="true"></i></a><?php
                                  
                               }else{
                                ?><div><input required name="email[]" type="text" value="<?=$value?>" /><a href="#" class="delete_field"><i class="fa fa-times" aria-hidden="true"></i></a></div><?php
                               }
                               if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    ?><p class="error_message">* Netinkamas el. pašto adresas</p><?php
                                  }
                               $i++;
                              }
                              ?>
                                
                              </div>
                              <label for="email_subject">Tema</label>
                              <input id="email_subject" name="subject" type="text" /><br />
                              <br />
                              <label for="email_msg">Žinutė</label>
                              <textarea id="email_msg" name="msg" rows="8" cols="40"><?=$msg?></textarea><br />
                              <input style="<?=$background_color?>" type="submit" value="Siųsti" />
                              
                            </form>
                        </div> <?php
                    }
                  
                  }
                  if(!$wrong_email){
                    ?> 
                    <h3 class="email_heading" style="<?=$background_color?>">Išsiųsk nuorodą draugams!</h3>
                    <div class="mail_form">
                        <form method="post" class="form">
                          <div class="emails">
                            <label for="main_email">El. paštas</label>
                            <input id="main_email" name="email[]" type="text"/>
                            <a href="#" class="add_email"><i class="fa fa-plus" aria-hidden="true"></i></a>
                          </div>
                    
                          <label for="email_subject">Tema</label>
                          <input id="email_subject" name="subject" type="text" /><br />
                          <br />
                          <label for="email_msg">Žinutė</label>
                          <textarea id="email_msg" name="msg" rows="8" cols="40"><?=$link?></textarea><br />
                          <input style="<?=$background_color?>" type="submit" value="Siųsti" />
                           <?php
                              if($send){
                                ?><p>Žinutė sėkmingai išsiųsta nurodytiems gavėjams!</p><?php
                              }
                            ?>
                        </form>
                    </div>
                    <?php
                  } ?>
            </div>
        </div><?php
        include("include/footer.php"); ?>  
    <?php 
} else {
    header("Location: /");
}
?>