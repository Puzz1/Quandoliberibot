<?php
$bot->connessione($bot->setting["host"],$bot->setting["nome_utente"],$bot->setting["password"],$bot->setting["database"]);
if($_GET["install"]){
$bot->sendMessage($bot->setting["admin"][0],"Tabella: ".$bot->tabella." installata");
	$bot->conn->query("CREATE TABLE IF NOT EXISTS $bot->tabella(
			ID int(11) AUTO_INCREMENT,
            chat_id BIGINT(11) NOT NULL,
            nome TEXT(50) , 
            username TEXT(50),
            page TEXT(100),
            PRIMARY KEY (id));");
}
if($bot->chatID > 0){
if($bot->conn->query("SELECT * FROM $bot->tabella WHERE chat_id = '$bot->chatID'")->rowCount() == 0){
	
	$bot->conn->query("INSERT INTO $bot->tabella SET chat_id = '$bot->chatID',nome = '$bot->nome', username = '$bot->username',page = ''");
}
if($bot->u["page"] == "ban"){
	exit;
} 
}
