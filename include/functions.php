<?php

function dump($data)
{
    echo "<pre>";
    var_dump($data); 
    echo "</pre>";
}

function page_redirect($location)
 {
   echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
   exit; 
 }

 function user_info($user_id){
 	$user_info = PDO("SELECT * FROM users WHERE id=:id LIMIT 1", 'r', array(":id" => $user_id));
 	return $user_info; 
 }

function database() {

	try {
		$db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}
	catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die;
	}		

	return $db;
}

function PDO($query, $t = 'a', $parameters = null, &$rowCount = null){

	$db = database();
	$pdo = $db->prepare($query);

	$pdo->execute($parameters);

	if($t == 'a' OR $t == 'r' OR $t == 'c'){
		$rowCount = $pdo->rowCount();
		if($t == 'a') return $pdo->fetchAll(PDO::FETCH_ASSOC);
		if($t == 'r') return $pdo->fetch(PDO::FETCH_ASSOC);
		if($t == 'c') return $pdo->fetchColumn(PDO::FETCH_ASSOC);
	}
	else if($t = 'i'){
		return $db->lastInsertId();
	}
}


/******************LIKES**********************/

function user_interests($user_id){
	$db = database();
	$pdo = $db->prepare("SELECT										
	ui.interest_id, 
	i.name
	FROM user_interests as ui 
	LEFT JOIN interests as i ON ui.interest_id = i.id
	WHERE ui.user_id=:user_id ");
	$pdo->execute(array(":user_id" => $user_id));
	$interests = $pdo->fetchAll(PDO::FETCH_ASSOC);
	return $interests;
}

function popular_interests($without = null){
	if($without !== null){
		$without = "WHERE ui.interest_id NOT IN (".$without.")";
	}else{
		$without = "";
	}
	$db = database();
	$pdo = $db->prepare("SELECT										
	ui.interest_id, 
	COUNT(ui.id) as frequency, 
	i.name
	FROM user_interests as ui 
	LEFT JOIN interests as i on ui.interest_id = i.id
	".$without."
	GROUP BY interest_id ORDER BY frequency DESC LIMIT 10");
	$pdo->execute();
	$pop_interests = $pdo->fetchAll(PDO::FETCH_ASSOC);
	return $pop_interests;
}

/******************DISLIKES**********************/

function user_dislikes($user_id){
	$db = database();
	$pdo = $db->prepare("SELECT										
	ui.dislike_id, 
	i.name
	FROM user_dislikes as ui 
	LEFT JOIN dislikes as i ON ui.dislike_id = i.id
	WHERE ui.user_id=:user_id ");
	$pdo->execute(array(":user_id" => $user_id));
	$dislikes = $pdo->fetchAll(PDO::FETCH_ASSOC);
	return $dislikes;
}

function popular_dislikes($without = null){
	if($without !== null){
		$without = "WHERE ui.dislike_id NOT IN (".$without.")";
		//echo $without;
	}else{
		$without = "";
	}
	$db = database();
	$pdo = $db->prepare("SELECT										
	ui.dislike_id, 
	COUNT(ui.id) as frequency, 
	i.name
	FROM user_dislikes as ui 
	LEFT JOIN dislikes as i on ui.dislike_id = i.id
	".$without."
	GROUP BY dislike_id ORDER BY frequency DESC LIMIT 10");
	$pdo->execute();
	$pop_dislikes = $pdo->fetchAll(PDO::FETCH_ASSOC);
	return $pop_dislikes;
}

/******************SIZES**********************/

function user_sizes($user_id){
	$sizes = PDO("SELECT * FROM user_sizes WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	return $sizes;
}

function size_top($size_id){
	$sizes = PDO("SELECT * FROM top_sizes WHERE id=:id LIMIT 1", 'r', array(":id" => $size_id));
	return $sizes['size'];
}

function size_pants($size_id){
	$sizes = PDO("SELECT * FROM pants_sizes WHERE id=:id LIMIT 1", 'r', array(":id" => $size_id));
	return $sizes['size'];
}

/*function main_style($user_id){
	$user_style = PDO("SELECT background_color, font_color FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));

	if(!empty($user_style)){
		if(!empty($user_style["background_color"])){
			$background = 'background:'.$user_style["background_color"].';';
		}else{
			$background = '';
		}
		if(!empty($user_style["font_color"])){
			$font = 'color:'.$user_style["font_color"].';';
		}else{
			$font = '';
		}

		return 'style="'.$background.$font.'"';
	}else{
		return '';
	}
}*/

function background($user_id){
	$user_style = PDO("SELECT background FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["background"])){
			return 'background-image: url(/headers/'.$user_style["background"].'.png)';
		}else{
			return '';
		}
	}
}

function bgg($user_id){
	$user_style = PDO("SELECT header FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if($user_style["header"] !== '0'){
			return 'background: url(/backgrounds/b'.$user_style["header"].'.png) repeat scroll 0% 0%';
		}else{
			return '';
		}
	}
}

function color($user_id){
	$user_style = PDO("SELECT color FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["color"])){
			return 'color: '.$user_style["color"];
		}else{
			return false;
		}
	}
}

function clr($user_id){
	$user_style = PDO("SELECT color FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["color"])){
			return $user_style["color"];
		}else{
			return false;
		}
	}
}

function background_color($user_id){
	$user_style = PDO("SELECT color FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["color"])){
			return 'background-color: '.$user_style["color"];
		}else{
			return '';
		}
	}
}

/*function bgg($user_id){
	$user_style = PDO("SELECT header FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["header"])){
			return 'background-color: '.$user_style["color"];
		}else{
			return '';
		}
	}
}*/

function title($user_id){
	$user_style = PDO("SELECT title FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["title"])){
			return $user_style["title"];
		}else{
			return '';
		}
	}
}

function description($user_id){
	$user_style = PDO("SELECT description FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["description"])){
			return $user_style["description"];
		}else{
			return '';
		}
	}
}

function user_bg($user_id){
	$user_style = PDO("SELECT background FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["background"])){
			return $user_style["background"];
		}else{
			return '';
		}
	}
}

function user_hdr($user_id){
	$user_style = PDO("SELECT header FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["header"])){
			return $user_style["header"];
		}else{
			return '';
		}
	}
}

function user_clr($user_id){
	$user_style = PDO("SELECT color FROM user_style WHERE user_id=:user_id LIMIT 1", 'r', array(":user_id" => $user_id));
	if(!empty($user_style)){
		if(!empty($user_style["color"])){
			return $user_style["color"];
		}else{
			return '';
		}
	}
}

function can_edit($user_id, $gift_id){
	$gift = PDO("SELECT * FROM user_gifts WHERE user_id=:user_id AND id = :id LIMIT 1", 'r', array(":user_id" => $user_id, "id" => $gift_id));
	if($gift != null){
		return true;
	}else{
		return false;
	}
}

