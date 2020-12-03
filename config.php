<?php


$bot->setting([
	'parse_mode' => 'html',
	'disable_web_page_preview' => true,			
	'action' => false,							
	'usa_database' => true,	
	'channel_post' => true,
	'funziona_modificati' => true,	
	'admin' => [
		
	],			//Indicare Id Admin
	
	'develope_mode' => false,
	'nome_tabella' => 'tabella',


	/* SETTING MYSQL*/
	'host' => 'localhost',
	  "nome_utente" => "", //se non usi altervista inserisci il nome utente del DB
    "password" => "", //se non usi altervista inserisci la password di mysql
    "database" => "",
]); 
