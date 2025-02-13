<?php

$TOKEN = "7706525404:AAHNjlc-30iylGDfUSnvtFoNo_fp-08gGIQ";
$WEBAPP_URL = "https://texnogenweb.netlify.app/index.html";
$API_URL = "https://api.telegram.org/bot$TOKEN/";

// Telegram'dan kelayotgan xabarlarni olish
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

if (isset($update["message"])) {
    $chat_id = $update["message"]["chat"]["id"];
    $text = $update["message"]["text"] ?? "";
    
    if ($text === "/start") {
        sendWebAppButton($chat_id);
    } elseif (isset($update["message"]["web_app_data"])) {
        $web_app_data = $update["message"]["web_app_data"]["data"];
        sendMessage($chat_id, "Sizdan ma'lumot keldi: $web_app_data");
    }
}

// WebApp tugmasi bilan menyu yuborish function sendWebAppButton($chat_id) {
    global $API_URL, $WEBAPP_URL;
    
    $keyboard = [
        "keyboard" => [[
            [
                "text" => "WebApp'ni ochish",
                "web_app" => ["url" => $WEBAPP_URL]
            ]
        ]],
        "resize_keyboard" => true
    ];
    
    $data = [
        "chat_id" => $chat_id,
        "text" => "WebApp'ni ochish uchun tugmani bosing:",
        "reply_markup" => json_encode($keyboard)
    ];
    
    file_get_contents($API_URL . "sendMessage?" . http_build_query($data));
}

// Oddiy matnli xabar yuborish function sendMessage($chat_id, $text) {
    global $API_URL;
    $data = ["chat_id" => $chat_id, "text" => $text];
    file_get_contents($API_URL . "sendMessage?" . http_build_query($data));
}

?>
