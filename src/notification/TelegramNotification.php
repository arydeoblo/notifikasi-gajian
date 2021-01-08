<?php
namespace app\src\notification;

use Yii;

class TelegramNotification implements NotificationInterface {
	public function sendNotification($type, $prev_balance, $last_balance, $diff_balance){

		$api_url = "https://api.telegram.org/bot";

		$telegram = Yii::$app->params['notification']['notifier']['telegram'];
		/**
		 * Build Message
		 */
		$new_line_char = "%0A";
		$date = $date = date('d/M/Y H:i:s');

		if($type == 'decrease'){
			$title = "Berkurang - Rekening BCA";
			$sub_title = "Berkurang";
		}else{
			$title = "Bertambah - Rekening BCA";
			$sub_title = "Bertambah";
		}

		$message = $title;
		$message .= $new_line_char . $new_line_char;
		$message .= "Waktu : {$date}" . $new_line_char;
		$message .= "Saldo Awal : Rp. {$prev_balance}" . $new_line_char;
		$message .= "Saldo {$sub_title}: Rp. {$diff_balance}" . $new_line_char;
		$message .= "-----------------------------------------" . $new_line_char . $new_line_char;
		$message .= "Saldo Akhir : Rp. {$last_balance}";
		
		file_get_contents($api_url . $telegram['bot_key'] . "/sendMessage?chat_id=" . $telegram['chat_id'] . "&text=" . $message);
	}
}