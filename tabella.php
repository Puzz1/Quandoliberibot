<?php
class Bot{  
    public $token;
    public $update;
    public $u;

/*
 _____        _                                         ___          _ 
|_   _|      | |                                       / _ \        (_)
  | |    ___ | |  ___   __ _  _ __   __ _  _ __ ___   / /_\ \ _ __   _ 
  | |   / _ \| | / _ \ / _` || '__| / _` || '_ ` _ \  |  _  || '_ \ | |
  | |  |  __/| ||  __/| (_| || |   | (_| || | | | | | | | | || |_) || |
  \_/   \___||_| \___| \__, ||_|    \__,_||_| |_| |_| \_| |_/| .__/ |_|
                        __/ |                                | |       
                       |___/                                 |_|       
*/
    public function __construct($token,$input){
        $this->token = 'bot'.$token;
        $this->input = $input;
        $this->update = json_decode($this->input);if ($this->update) {
        
            if ($update->message->forward_from && $config->funziona_inoltrati) {
             $this->fromnome = $this->update->message->forward_from->first_name;
             $this->fromcognome = $this->update->message->forward_from->last_name;
             $this->fromusername = $this->update->message->forward_from->username;
             $this->fromID = $this->update->message->forward_from->id;
            }
            if ($update->edited_message && $this->setting["funziona_modificati"]) {
             $update->message = $this->update->edited_message;
            }
            $this->chatID = $this->update->message->chat->id;
            $this->userID = $this->update->message->from->id;
            $this->msg = $this->update->message->text;
            $this->msgid = $this->update->message->message_id;
            $this->isbot = $this->update->message->from->is_bot;
            $this->nome = $this->update->message->from->first_name;
            $this->cognome = $this->update->message->from->last_name;
            $this->username = $this->update->message->from->username;
            $this->lingua = $this->update->message->from->language_code;
            $this->chat_type = $this->update->message->chat->type;
            if ($this->chatID < 0) {
                $this->titolo = $this->update->message->chat->title;
                $this->usernamechat = $this->update->message->chat->username;
            }
			$this->audio = $this->update->message->audio;
            $this->audio_id = $this->update->message->audio->file_id;
			$this->audio_name = $this->update->message->audio->title;
            $this->sticker = $this->update->message->sticker->file_id;
            $this->animation = $this->update->message->animation->file_id;
            $this->location = $this->update->message->location;
            $this->longitudine = $this->update->message->location->longitude;
            $this->latitudine = $this->update->message->location->latitude;
			$this->caption = $this->update->message->caption;
            $this->video = $this->update->message->video;
			$this->video_id = $this->update->message->video->file_id;
			$this->photo = $this->update->message->photo;
            $this->photo_id = $this->update->message->photo{0}->file_id;
			$this->photo_caption = $this->update->message->photo{0}->caption;
			$this->document = $this->update->message->document;
            $this->document_id = $this->update->message->document->file_id;
            $this->caption = $this->update->message->caption;
            if ($this->update->callback_query) {
                $this->msgid = $this->update->callback_query->message->message_id;
                    $this->chatID = $this->update->callback_query->message->chat->id;
                    $this->userID = $this->update->callback_query->from->id;
                    $this->cbdata = $this->update->callback_query->data;
                    $this->cbid = $this->update->callback_query->id;
                    $this->nome = htmlspecialchars($this->update->callback_query->from->first_name);
                    $this->cognome = htmlspecialchars($this->update->callback_query->from->last_name);
                    $this->username = htmlspecialchars($this->update->callback_query->from->username);
                    $this->is_bot = $this->update->callback_query->from->is_bot;
                    $this->lingua = $this->update->callback_query->from->language_code;
                    $this->chat_type = $this->update->callback_query->message->chat->type;
            }
            if ($this->update->message->reply_to_message) {
                $this->replymsg  = $this->update->message->reply_to_message->text;
                $this->replyid  = $this->update->message->reply_to_message->message_id;
                $this->replyuserid = $this->update->message->reply_to_message->from->id;
                $this->replynome = $this->update->message->reply_to_message->from->first_name;
                $this->replycognome = $this->update->message->reply_to_message->from->last_name;
                $this->replyusername = $this->update->message->reply_to_message->from->username;
                $this->replyfromnome = $this->update->message->reply_to_message->forward_from->first_name;
                $this->replyfromcognome = $this->update->message->reply_to_message->forward_from->last_name;
                $this->replyfromusername= $this->update->message->reply_to_message->forward_from->username;
                $this->replyfromID = $this->update->message->reply_to_message->forward_from->id;
            }
    }
}

    public function curl($method,$args = []){
        $args = http_build_query($args);
        $token = $this->token;
        $request = curl_init("https://api.telegram.org/$token/$method");   
        curl_setopt_array($request, array(
        CURLOPT_CONNECTTIMEOUT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_USERAGENT => 'cURL request',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $args,
        ));
        $result = curl_exec($request);
        curl_close($request);
    return $result;
    }
    public function setting($setting = ["parse_mode" => "html","disable_web_page_preview" => false,"action" => false,"usa_database" => false,"channel_post" =>false,"funziona_modificati" =>false,"admin" => [],"develope_mode" => false,"nome_tabella" => "Ciao"]){
        $this->setting = $setting;
        $this->tabella = $setting["nome_tabella"];
    }
    public function action($chat_id = 0,$action = ""){
        $args = [
            "chat_id" => $chat_id,
            "action" => $action
        ];
        
        return $this->curl("sendChatAction",$args);
    }
    public function sendMessage($chat_id=0,$text="",$menu = false,$type = 'inline',$parse_mode = null,$dwpp = null,$msgid = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        if($dwpp == null){
            $dwpp = $this->setting["disable_web_page_preview"];
        }
        $args = [
            "chat_id" => $chat_id,
            "text"=>$text,
            "parse_mode"=>$parse_mode,
            "reply_to_message_id" => $msgid,
            "disable_web_page_preview" => $dwpp
            
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        if($this->setting["action"]){
        $this->action($chat_id,"typing");
    }
        return $this->curl("sendMessage",$args);
    }
    public function forwardMessage($chat_id = 0,$from_chat_id = 0,$msgid = 0){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "from_chat_id" => $from_chat_id,
            "message_id" => $msgid,
            "parse_mode" => $parse_mode
        ];
        return $this->curl("forwardMessage",$args);
    }
    function sendPhoto($chat_id = 0, $photo = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "photo" => $photo,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode

 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        if($this->setting["action"]){
        $this->action($chat_id,"upload_photo");
    }
        return $this->curl("sendPhoto",$args);
    }
    function sendAudio($chat_id = 0, $audio = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "audio" => $audio,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
if($this->setting["action"]){
        $this->action($chat_id,"upload_audio");
    }
        return $this->curl("sendAudio",$args);
    }
    function sendDocument($chat_id = 0, $document = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "document" => $document,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode,
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
if($this->setting["action"]){
        $this->action($chat_id,"upload_document");
    }
        return $this->curl("sendDocument",$args);
    }
    function sendVideo($chat_id = 0, $video = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "video" => $video,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        if($this->setting["action"]){
        $this->action($chat_id,"upload_video");
    }
        return $this->curl("sendVideo",$args);
    }
    function sendAnimation($chat_id = 0, $animation = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "animation" => $animation,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        return $this->curl("sendAnimation",$args);
    }
    function sendVoice($chat_id = 0, $voice = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "voice" => $voice,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        if($this->setting["action"]){
        $this->action($chat_id,"upload_audio");
    }
        return $this->curl("sendVoice",$args);
    }
    function sendVideoNote($chat_id = 0, $video_note = 0,$caption = "", $menu = 0,$type = "inline", $parse_mode = null,$reply_message_id = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
        $args = [
            "chat_id" => $chat_id,
            "video_note" => $video_note,
            "caption" => $caption,
            "reply_to_message_id" => $reply_message_id,
            "parse_mode" => $parse_mode
 
        ];
        if($menu){
            if($type == "inline"){
                $tastiera = json_encode(["inline_keyboard" => $menu]); 
            }elseif($type = "button"){
                $tastiera = json_encode(["keyboard" => $menu,"resize_keyboard"=>true]);
            }
            $args["reply_markup"] = $tastiera;
        }
        if($this->setting["action"]){
        $this->action($chat_id,"send_video_note");
    }
        return $this->curl("sendVideoNote",$args);
    }
    public function deleteMessage($chat_id = 0,$msgid = null){
        $args = [
            "chat_id"=>$chat_id,
            "message_id"=>$msgid
        ];
        $this->curl("deleteMessage",$args);
    }
    public function getFile($file_id = ""){
        $args = [
            "file_id" => $file_id,
        ];
        return $this->curl("getFile",$args);
    }
    public function kick($chat_id,$user_id,$date){
        $args = [
            "chat_id"=>$chat_id,
            "user_id"=>$user_id,
            "until_date"=>$date,
        ];
        return $this->curl("kickChatMember",$args);
    }
    public function unban($chat_id,$user_id){
        $args = [
            "chat_id"=>$chat_id,
            "user_id"=>$user_id,
        ];
        return $this->curl("unbanChatMember",$args);
    }
    public function ban($chat_id,$user_id,$date = 0,$can_send_messages = false,$can_send_media_messages = false,$can_send_other_messages = false,$can_add_web_page_previews = false){
        $args = [
            "chat_id" => $chat_id,
            "user_id" => $user_id,
            "until_date" => $date,
            "can_send_messages" => $can_send_messages,
            "can_send_media_messages" => $can_send_media_messages,
            "can_send_other_messages" => $can_send_other_messages,
            "can_add_web_page_previews" => $can_add_web_page_previews
        ];
        return $this->curl("restrictChatMember",$args);
    }
    public function promoteChatMember($chat_id,$user_id,$can_change_info = false,$can_post_messages = false,$can_edit_messages=false,$can_delete_messages=false,$can_invite_users = false,$can_restrict_members = false,$can_pin_messages = false,$can_promote_members = false){
        $args = [
            "chat_id" => $chat_id,
            "user_id" => $user_id,
            "can_post_messages" => $can_post_messages,
            "can_edit_messages" => $can_edit_messages,
            "can_delete_messages" => $can_delete_messages,
            "can_invite_users" => $can_invite_users,
            "can_restrict_members" => $can_restrict_members,
            "can_pin_messages" => $can_pin_messages,
            "can_promote_members" =>$can_promote_members
        ];
        return $this->curl("promoteChatMember",$args);
    }
    public function exportChatInviteLink($chat_id){
        $args = [
            "chat_id" => $chat_id,
        ];
        return $this->curl("exportChatInviteLink",$args);
    }
    public function setChatPhoto($chat_id,$photo = ""){
        $args = [
            "chat_id"=>$chat_id,
            "photo" => $photo,
        ];
        return $this->curl("setChatPhoto",$args);
    }
    public function deleteChatPohto($chat_id){
        $args = ["chat_id" =>$chat_id];
        return $this->curl("deleteChatPohto",$args);
    }
    public function setChatTitle($chat_id,$title= ""){
        $args = [
            "chat_id" =>$chat_id,
            "title" => $title,
        ];
        return $this->curl("setChatTitle",$args);
    }
    public function setChatDescription($chat_id,$description = ""){
        $args = [
            "chat_id" => $chat_id,
            "description" => $description,
        ];
        return $this->curl("setChatDescription",$args);
    }
    public function pin($chat_id,$msgid,$notification = true){
        $args = [
            "chat_id" => $chat_id,
            "message_id" => $msgid,
            "disable_notification" => $notification,
        ];
        return $this->curl("pinChatMessage",$args);
    }
    public function unPin($chat_id){
        $args = ["chat_id"=>$chat_id];
        return $this->curl("unpinChatMessage",$args);
    }
    public function leaveChat($chat_id){
        $args = ["chat_id" => $chat_id];
        return $this->curl("leaveChat",$args);
    }
    public function getChat($chat_id){
        $args = ["chat_id" => $chat_id];
        return $this->curl("getChat",$args);
    }
    public function getChatAdministrators($chat_id){
        $args = ["chat_id"=>$chat_id];
        return $this->curl("getChatAdministrators",$args);
    }
    public function getChatMembersCount($chat_id){
        $args = ["chat_id"=>$chat_id];
        return $this->curl("getChatMembersCount",$args);
    }
    public function getChatMember($chat_id,$user_id){
        $args = [
            "chat_id"=>$chat_id,
            "user_id"=>$user_id,
        ];
        return $this->curl("getChatMember",$args);
    }
public function editMessage($chat_id,$msgid,$text = "",$reply_markup = null,$parse_mode = null,$disable_web_page_preview = null){
    if($parse_mode == null){
        $parse_mode = $this->setting["parse_mode"];
    }
    if($disable_web_page_preview == null){
        $disable_web_page_preview = $this->setting["disable_web_page_preview"];
    }
    $args = [
        "chat_id" => $chat_id,
        "message_id" => $msgid,
        "text"=>$text,
        "parse_mode" => $parse_mode,
        "disable_web_page_preview" => $disable_web_page_preview,
    ];
    if($reply_markup != null){
        $args["reply_markup"] = json_encode(["inline_keyboard" => $reply_markup]);
    }
    return $this->curl("editMessageText",$args);
}
public function notifica($id,$text,$alert = false){
    $args = array(
    'callback_query_id' => $id,
    'text' => $text,
    'show_alert' => $alert,
    'disable_web_page_preview' => true,
    );
    return $this->curl("answerCallbackQuery",$args);
}
public function editCaption($chat_id,$msgid,$caption,$parse_mode = null){
        if($parse_mode == null){
            $parse_mode = $this->setting["parse_mode"];
        }
    $args = [
        "chat_id"=>$chat_id,
        "message_id" => $msgid,
        "caption"=>$caption,
        "parse_mode"=>$parse_mode
    ];
    return $this->curl("editMessageCaption",$args);
}
public function editButton($chat_id,$msgid,$reply_markup){
    $args = [
        "chat_id"=>$chat_id,
        "message_id" => $msgid,
        "reply_markup" => json_encode(["inline_keyboard" => $reply_markup]),
    ];
    return $this->curl("editMessageReplyMarkup",$args);
}
public function getUserProfilePhotos($user_id){
    $args = [
        "user_id" => $user_id
    ];
    return $this->curl("getUserProfilePhotos",$args);
}
/*
______  _                     _____        _                                              ___          _ 
|  ___|(_)                   |_   _|      | |                                            / _ \        (_)
| |_    _  _ __    ___         | |    ___ | |  ___   __ _  _ __   __ _  _ __ ___        / /_\ \ _ __   _ 
|  _|  | || '_ \  / _ \        | |   / _ \| | / _ \ / _` || '__| / _` || '_ ` _ \       |  _  || '_ \ | |
| |    | || | | ||  __/        | |  |  __/| ||  __/| (_| || |   | (_| || | | | | |      | | | || |_) || |
\_|    |_||_| |_| \___|        \_/   \___||_| \___| \__, ||_|    \__,_||_| |_| |_|      \_| |_/| .__/ |_|
                                                     __/ |                                     | |       
                                                    |___/                                      |_|       
*/
/*
______         _           _                       
|  _  \       | |         | |                      
| | | |  __ _ | |_   __ _ | |__    __ _  ___   ___ 
| | | | / _` || __| / _` || '_ \  / _` |/ __| / _ \
| |/ / | (_| || |_ | (_| || |_) || (_| |\__ \|  __/
|___/   \__,_| \__| \__,_||_.__/  \__,_||___/ \___|
*/
	
public function connessione($host = "",$user = "",$pass = "",$nome_db = ""){
    try{
        $this->conn = new PDO("mysql:host=$host;dbname=$nome_db",$user,$pass);
        if($this->setting["develope_mode"]){
            $this->sendMessage($this->setting["admin"][0],"connessione al database riuscita");
        }
        if($this->userID){

			$this->u = $this->conn->query("SELECT * FROM $this->tabella WHERE chat_id = '$this->userID'")->fetch();
        }
        
    }catch(PDOException $e){
        if($this->setting["develope_mode"]){
            $this->sendMessage($this->setting["admin"][0],"Connessione non riuscita, errore: ".$e->getMessage());
        }
    }
}
public function page($chat_id,$page){
    $r = $this->conn->query("UPDATE $this->tabella SET page = '$page' WHERE chat_id = '$chat_id'");
}

    

    
}


