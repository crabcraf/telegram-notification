<?php
$obj_TelegramBot = new Telegram_Bot();
$message='hello world';
list($flg_TelegramBot_SendMsg,$flg_TelegramBot_result)=$obj_TelegramBot->send_message($message);
class Telegram_Bot
{
    private $botToken = '';
    private $api_url= "https://api.telegram.org/bot";
    private $chat_id = '';
    function send_message($message)
    {
        $params = [
            'chat_id' => $this->chat_id,
            'text' => $message
        ];
        $curl_timeout = '60';
        $ch = curl_init($this->api_url.$this->botToken . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $curl_timeout);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // logs
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $verbose = fopen('curl_debug_file.txt', 'a');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        // result
        $output = curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($response == '200') {
            return array(true,'');
        } else {
            return array(false,'response code:' . $response);
        }
    }
}