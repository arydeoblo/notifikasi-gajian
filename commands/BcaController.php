<?php

namespace app\commands;

use app\components\BcaParser;
use Yii;
use yii\console\Controller;
use yii\helpers\VarDumper;

class BcaController extends Controller {

	public $file_balance = '@app/data/balance.php';

	public function actionCheck($person) {
		$date = date('d/M/Y H:i:s');
		$req_file = require Yii::getAlias($this->file_balance);

		$get_data = $req_file[$person];

		$last_balance = $get_data['balance'];

		$parser = new BcaParser;

		/** Login **/

		$new_balance = $parser->getBalance($get_data['username'], $get_data['password']);

		if ($new_balance != $last_balance) {

			if ($new_balance > $last_balance) {
				$selisih = number_format($new_balance - $last_balance, 2, ",", ".");
				$sub_title = "Bertambah";
				$subject = "Saldo Rekening BCA Bertambah - " . $date;
			}

			if ($new_balance < $last_balance) {
				$selisih = number_format($last_balance - $new_balance, 2, ",", ".");
				$sub_title = "Berkurang";
				$subject = "Saldo Rekening BCA Berkurang - " . $date;
			}

			if ($new_balance < $last_balance || $new_balance > $last_balance) {

				$new_balance_format = number_format($new_balance, 2, ",", ".");
				$last_balance_format = number_format($last_balance, 2, ",", ".");

				$message = "<h2>Saldo Rekening BCA {$sub_title}</h2>";
				$message .= "<hr>";
				$message .= "Waktu : {$date} WIB<br><br>";
				$message .= "Saldo Awal : Rp. {$last_balance_format}<br><br>";
				$message .= "Saldo {$sub_title} : Rp. {$selisih}<br><br>";
				$message .= "<hr>";
				$message .= "<strong>Saldo Akhir : Rp. {$new_balance_format}</strong>";

			}

			//Kirim notif jika lebih dari 15000
			if (($selisih >= 15000) && $last_balance != 0) {
				$this->sendMail($get_data['email'], $subject, $message);
			}

		}

		/** set data to write **/
		$data = [$person => ['email' => $get_data['email'], 'username' => $get_data['username'], 'password' => $get_data['password'], 'balance' => $new_balance]];

		file_put_contents(Yii::getAlias($this->file_balance), "<?php\nreturn " . VarDumper::export($data) . ";\n", LOCK_EX);
	}

	protected function sendMail($to, $subject, $message) {
		// Send email
		Yii::$app->mailer->compose()
			->setFrom('bca-notif@bahirul.id')
			->setTo($to)
			->setSubject($subject)
			->setHtmlBody($message)
			->send();
	}

}
