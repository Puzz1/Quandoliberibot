<?php

error_reporting(0);

$Supporter = array(
, //INSERISCI ID ADMIN
);

if(stripos($bot->msg, "/start")===0){
	$menu[] = array(
	 array("text" => "馃棾 INSERISCI ORARIO 馃棾",
                "callback_data" => "/tabella"),
		);
		if(in_array($bot->userID, $Supporter)){
		$menu[] = array(
	 array("text" => "馃攼 PANNELLO ADMIN 馃攼",
                "callback_data" => "/pannello"),
		);
	}
	$bot->sendMessage($bot->chatID, "Ciao, bentornato sul bot $bot->nome!", $menu);
}

if(stripos($bot->cbdata, "/menu")===0){
	$menu[] = array(
	 array("text" => "馃棾 INSERISCI ORARIO 馃棾",
                "callback_data" => "/tabella"),
		);
		if(in_array($bot->userID, $Supporter)){
		$menu[] = array(
	 array("text" => "馃攼 PANNELLO ADMIN 馃攼",
                "callback_data" => "/pannello"),
		);
	}
	$bot->editMessage($bot->chatID, $bot->msgid, "Ciao, bentornato sul bot $bot->nome!", $menu);
}

if(stripos($bot->cbdata, "/pannello")===0){
	 $menu[] = array(
				 array("text" => "鈫橈笍",
                "callback_data" => "/a"),
			array("text" => "Lun.",
                "callback_data" => "/a"),
	 array("text" => "Mar.",
                "callback_data" => "/a"),
	 array("text" => "Mer.",
                "callback_data" => "/a"),
	 array("text" => "Gio.",
                "callback_data" => "/a"),
	 array("text" => "Ven.",
                "callback_data" => "/a"),
	 array("text" => "Sab.",
                "callback_data" => "/a"),
		);
	for($i=9;$i<22;$i++){
		$lun = file_get_contents("riunioni/lun/$i.txt");
		$mar = file_get_contents("riunioni/mar/$i.txt");
		$mer = file_get_contents("riunioni/mer/$i.txt");
		$gio = file_get_contents("riunioni/gio/$i.txt");
		$ven = file_get_contents("riunioni/ven/$i.txt");
		$sab = file_get_contents("riunioni/sab/$i.txt");
		if($lun=="ok")
		$lun = "鉁�";
		else
			$lun = "鉂�";
				if($mar=="ok")
		$mar = "鉁�";
		else
			$mar = "鉂�";
				if($mer=="ok")
		$mer = "鉁�";
		else
			$mer = "鉂�";
				if($gio=="ok")
		$gio = "鉁�";
		else
			$gio = "鉂�";
				if($ven=="ok")
		$ven = "鉁�";
		else
			$ven = "鉂�";
				if($sab=="ok")
		$sab = "鉁�";
		else
			$sab = "鉂�";
	$menu[] = array(
		array("text" => "$i.",
                "callback_data" => "/a"),
			array("text" => "$lun",
                "callback_data" => "/set_lunq$i"),
	 array("text" => "$mar",
                "callback_data" => "/set_marq$i"),
	 array("text" => "$mer",
                "callback_data" => "/set_merq$i"),
	 array("text" => "$gio",
                "callback_data" => "/set_gioq$i"),
	 array("text" => "$ven",
                "callback_data" => "/set_venq$i"),
	 array("text" => "$sab",
                "callback_data" => "/set_sabq$i"),
		);
	}
	$menu[] = array(
	 array("text" => "銆斤笍 VEDI RISULTATI 銆斤笍",
                "callback_data" => "/risultati"),
		);
	$menu[] = array(
	 array("text" => "鈫笍 INDIETRO 鈫╋笍",
                "callback_data" => "/menu"),
		);
	$bot->editMessage($bot->chatID, $bot->msgid, "馃挔 Ciao capo! Spunta gli orari delle riunioni. 馃挔", $menu);
}

if(stripos($bot->cbdata, "/risultati")===0){
	foreach(scandir("riunioni/totali") as $tot){
if($tot=="gio" || $tot=="mar" || $tot=="mer" || $tot=="lun" || $tot=="gio" || $tot=="ven" || $tot=="sab" || $tot=="." || $tot==".." || $tot=="..." || $tot==".txt" || $tot=="txt"){
}else{
	$l = '<a href="tg://user?id='.$tot.'">'.$tot.'</a>';
$testo .= "\n\n馃啍 $l:\n";
foreach(scandir("riunioni/totali/$tot") as $tet){
	if($tet=="." || $tet==".." || $tet=="..." || $tet==".txt" || $tet=="txt"){
}else{
$i = 1;
foreach(scandir("riunioni/totali/$tot/$tet") as $tit){
if($tit=="." || $tit==".." || $tit=="..." || $tit==".txt" || $tit=="txt"){
}else{
	if($i==0){
	}else{
		$testo .= "  鈹� $tet\n";
		$i = 0;
	}
$tit = str_replace(".txt", "", $tit);
$testo .= "    鈹� $tit:00\n";
}
}
}
}
}
}
	$bot->sendMessage($bot->chatID, "$testo");
}

if(stripos($bot->cbdata, "/set")===0){
	$ex = explode("_", $bot->cbdata)[1];
	$giorno = explode("q", $ex)[0];
	$ora = explode("q", $ex)[1];
	$cac = file_get_contents("riunioni/$giorno/$ora.txt");
	if($cac==""){
	mkdir("riunioni");
	mkdir("riunioni/$giorno");
	file_put_contents("riunioni/$giorno/$ora.txt", "ok");
	}else{
unlink("riunioni/$giorno/$ora.txt");
		foreach(scandir("riunioni/totali") as $tot){
			$black = file_get_contents("riunioni/totali/$tot/$giorno/$ora.txt");
			if($black!="")
unlink("riunioni/totali/$tot/$giorno/$ora.txt");
		}
	}
	 $menu[] = array(
				 array("text" => "鈫橈笍",
                "callback_data" => "/a"),
			array("text" => "Lun.",
                "callback_data" => "/a"),
	 array("text" => "Mar.",
                "callback_data" => "/a"),
	 array("text" => "Mer.",
                "callback_data" => "/a"),
	 array("text" => "Gio.",
                "callback_data" => "/a"),
	 array("text" => "Ven.",
                "callback_data" => "/a"),
	 array("text" => "Sab.",
                "callback_data" => "/a"),
		);
	for($i=9;$i<22;$i++){
		$lun = file_get_contents("riunioni/lun/$i.txt");
		$mar = file_get_contents("riunioni/mar/$i.txt");
		$mer = file_get_contents("riunioni/mer/$i.txt");
		$gio = file_get_contents("riunioni/gio/$i.txt");
		$ven = file_get_contents("riunioni/ven/$i.txt");
		$sab = file_get_contents("riunioni/sab/$i.txt");
		if($lun=="ok")
		$lun = "鉁�";
		else
			$lun = "鉂�";
				if($mar=="ok")
		$mar = "鉁�";
		else
			$mar = "鉂�";
				if($mer=="ok")
		$mer = "鉁�";
		else
			$mer = "鉂�";
				if($gio=="ok")
		$gio = "鉁�";
		else
			$gio = "鉂�";
				if($ven=="ok")
		$ven = "鉁�";
		else
			$ven = "鉂�";
				if($sab=="ok")
		$sab = "鉁�";
		else
			$sab = "鉂�";
	$menu[] = array(
		array("text" => "$i.",
                "callback_data" => "/a"),
			array("text" => "$lun",
                "callback_data" => "/set_lunq$i"),
	 array("text" => "$mar",
                "callback_data" => "/set_marq$i"),
	 array("text" => "$mer",
                "callback_data" => "/set_merq$i"),
	 array("text" => "$gio",
                "callback_data" => "/set_gioq$i"),
	 array("text" => "$ven",
                "callback_data" => "/set_venq$i"),
	 array("text" => "$sab",
                "callback_data" => "/set_sabq$i"),
		);
	}
		$menu[] = array(
	 array("text" => "銆斤笍 VEDI RISULTATI 銆斤笍",
                "callback_data" => "/risultati"),
		);
	$menu[] = array(
	 array("text" => "鈫笍 INDIETRO 鈫╋笍",
                "callback_data" => "/menu"),
		);
	$bot->editButton($bot->chatID, $bot->msgid, $menu);
}

if(stripos($bot->cbdata, "/tabella")===0){
 $menu[] = array(
				 array("text" => "鈫橈笍",
                "callback_data" => "/a"),
			array("text" => "Lun.",
                "callback_data" => "/a"),
	 array("text" => "Mar.",
                "callback_data" => "/a"),
	 array("text" => "Mer.",
                "callback_data" => "/a"),
	 array("text" => "Gio.",
                "callback_data" => "/a"),
	 array("text" => "Ven.",
                "callback_data" => "/a"),
	 array("text" => "Sab.",
                "callback_data" => "/a"),
		);
	for($i=9;$i<22;$i++){
		$lun = file_get_contents("riunioni/lun/$i.txt");
		$mar = file_get_contents("riunioni/mar/$i.txt");
		$mer = file_get_contents("riunioni/mer/$i.txt");
		$gio = file_get_contents("riunioni/gio/$i.txt");
		$ven = file_get_contents("riunioni/ven/$i.txt");
		$sab = file_get_contents("riunioni/sab/$i.txt");
		if($lun=="ok"){
				$lun = file_get_contents("riunioni/totali/lun/$i.txt");
			if($lun=="")
				$lun = 0;
		}
		else
			$lun = "鉂�";
				if($mar=="ok")
		{
				$mar = file_get_contents("riunioni/totali/mar/$i.txt");
			if($mar=="")
				$mar = 0;
		}
		else
			$mar = "鉂�";
				if($mer=="ok")
		{
				$mer = file_get_contents("riunioni/totali/mer/$i.txt");
			if($mer=="")
				$mer = 0;
		}
		else
			$mer = "鉂�";
				if($gio=="ok")
		{
				$gio = file_get_contents("riunioni/totali/gio/$i.txt");
			if($gio=="")
				$gio = 0;
		}
		else
			$gio = "鉂�";
				if($ven=="ok")
		{
				$ven = file_get_contents("riunioni/totali/ven/$i.txt");
			if($ven=="")
				$ven = 0;
		}
		else
			$ven = "鉂�";
				if($sab=="ok")
		{
				$sab = file_get_contents("riunioni/totali/sab/$i.txt");
			if($sab=="")
				$sab = 0;
		}
		else
			$sab = "鉂�";
	$menu[] = array(
		array("text" => "$i.",
                "callback_data" => "/a"),
			array("text" => "$lun",
                "callback_data" => "/add_lunq$i"),
	 array("text" => "$mar",
                "callback_data" => "/add_marq$i"),
	 array("text" => "$mer",
                "callback_data" => "/add_merq$i"),
	 array("text" => "$gio",
                "callback_data" => "/add_gioq$i"),
	 array("text" => "$ven",
                "callback_data" => "/add_venq$i"),
	 array("text" => "$sab",
                "callback_data" => "/add_sabq$i"),
		);
	}
		$menu[] = array(
	 array("text" => "鈾伙笍 AGGIORNA LISTA 鈾伙笍",
                "callback_data" => "/tabella"),
		);
	if(in_array($bot->userID, $Supporter)){
	$menu[] = array(
	 array("text" => "鈫笍 INDIETRO 鈫╋笍",
                "callback_data" => "/menu"),
		);
	}
$bot->editMessage($bot->chatID, $bot->msgid, "馃敯 Lista date riunioni 馃敯", $menu);
}

if(stripos($bot->cbdata, "/add")===0){
		$ex = explode("_", $bot->cbdata)[1];
	$giorno = explode("q", $ex)[0];
	$ora = explode("q", $ex)[1];
	$block = file_get_contents("riunioni/$giorno/$ora.txt");
	if($block=="ok"){
	$cac = file_get_contents("riunioni/totali/$bot->userID/$giorno/$ora.txt");
			$cec = file_get_contents("riunioni/totali/$giorno/$ora.txt");
		if($cec=="")
			$cec = 0;
	if($cac==""){
	mkdir("riunioni");
		mkdir("riunioni/totali");
		mkdir("riunioni/totali/$bot->userID");
	mkdir("riunioni/totali/$bot->userID/$giorno");
	file_put_contents("riunioni/totali/$bot->userID/$giorno/$ora.txt", "ok");
			mkdir("riunioni");
		mkdir("riunioni/totali");
	mkdir("riunioni/totali/$giorno");
	file_put_contents("riunioni/totali/$giorno/$ora.txt", $cec+1);
	}else{
unlink("riunioni/totali/$bot->userID/$giorno/$ora.txt");
					mkdir("riunioni");
		mkdir("riunioni/totali");
	mkdir("riunioni/totali/$giorno");
	file_put_contents("riunioni/totali/$giorno/$ora.txt", $cec-1);
	}
	}
 $menu[] = array(
				 array("text" => "鈫橈笍",
                "callback_data" => "/a"),
			array("text" => "Lun.",
                "callback_data" => "/a"),
	 array("text" => "Mar.",
                "callback_data" => "/a"),
	 array("text" => "Mer.",
                "callback_data" => "/a"),
	 array("text" => "Gio.",
                "callback_data" => "/a"),
	 array("text" => "Ven.",
                "callback_data" => "/a"),
	 array("text" => "Sab.",
                "callback_data" => "/a"),
		);
	for($i=9;$i<22;$i++){
		$lun = file_get_contents("riunioni/lun/$i.txt");
		$mar = file_get_contents("riunioni/mar/$i.txt");
		$mer = file_get_contents("riunioni/mer/$i.txt");
		$gio = file_get_contents("riunioni/gio/$i.txt");
		$ven = file_get_contents("riunioni/ven/$i.txt");
		$sab = file_get_contents("riunioni/sab/$i.txt");
		if($lun=="ok"){
				$lun = file_get_contents("riunioni/totali/lun/$i.txt");
			if($lun=="")
				$lun = 0;
		}
		else
			$lun = "鉂�";
				if($mar=="ok")
		{
				$mar = file_get_contents("riunioni/totali/mar/$i.txt");
			if($mar=="")
				$mar = 0;
		}
		else
			$mar = "鉂�";
				if($mer=="ok")
		{
				$mer = file_get_contents("riunioni/totali/mer/$i.txt");
			if($mer=="")
				$mer = 0;
		}
		else
			$mer = "鉂�";
				if($gio=="ok")
		{
				$gio = file_get_contents("riunioni/totali/gio/$i.txt");
			if($gio=="")
				$gio = 0;
		}
		else
			$gio = "鉂�";
				if($ven=="ok")
		{
				$ven = file_get_contents("riunioni/totali/ven/$i.txt");
			if($ven=="")
				$ven = 0;
		}
		else
			$ven = "鉂�";
				if($sab=="ok")
		{
				$sab = file_get_contents("riunioni/totali/sab/$i.txt");
			if($sab=="")
				$sab = 0;
		}
		else
			$sab = "鉂�";
	$menu[] = array(
		array("text" => "$i.",
                "callback_data" => "/a"),
			array("text" => "$lun",
                "callback_data" => "/add_lunq$i"),
	 array("text" => "$mar",
                "callback_data" => "/add_marq$i"),
	 array("text" => "$mer",
                "callback_data" => "/add_merq$i"),
	 array("text" => "$gio",
                "callback_data" => "/add_gioq$i"),
	 array("text" => "$ven",
                "callback_data" => "/add_venq$i"),
	 array("text" => "$sab",
                "callback_data" => "/add_sabq$i"),
		);
	}
		$menu[] = array(
	 array("text" => "鈾伙笍 AGGIORNA LISTA 鈾伙笍",
                "callback_data" => "/tabella"),
		);
	if(in_array($bot->userID, $Supporter)){
	$menu[] = array(
	 array("text" => "鈫笍 INDIETRO 鈫╋笍",
                "callback_data" => "/menu"),
		);
	}
	$bot->editButton($bot->chatID, $bot->msgid, $menu);
}