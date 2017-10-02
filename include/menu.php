<?php
//Formuojamas meniu.
if (isset($session) && $session->logged_in) {
    $path = "";
    //dump($session);
   $user_info = $session->userinfo;
   $hash = $user_info['hash'];
    if (isset($_SESSION['path'])) {
        $path = $_SESSION['path'];
        unset($_SESSION['path']);
    }
    ?>
      <div class="mob-menu">
      <div class="menu-icon"><span></span></div>
      </div>
      <nav id="menu">
        <ul id="menu_list">
          <li><a href="<?=$path."/?id=$hash"?>"><p>Peržiūra</p><span><i class="fa fa-user" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."useredit"?>"><p>Duomenys</p><span><i class="fa fa-pencil" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."gifts"?>"><p>Dovanos</p><span><i class="fa fa-gift" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."interests"?>"><p>Pomėgiai</p><span><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."dislikes"?>"><p>Baimės</p><span><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."sizes"?>"><p>Dydžiai</p><span><img src="pictures/human_icon.png"></span></a></li>
          <li><a href="<?=$path."share"?>"><p>Dalinkis</p><span><i class="fa fa-share-alt" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."exchange"?>"><p>Keiskis</p><span><i class="fa fa-users" aria-hidden="true"></i></span></a></li>
          <li><a href="<?=$path."process"?>"><p>Atsijungti</p><span><i class="fa fa-sign-out" aria-hidden="true"></i></span></a></li>
        </ul>
      </nav>

    <?php
     /*if ($session->isAdmin()) {
            echo "[<a href=\"" . $path . "admin/admin\">Administratoriaus sasaja</a>] &nbsp;&nbsp;";
        }*/
}
?>
