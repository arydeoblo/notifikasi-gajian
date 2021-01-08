<?php
namespace app\src\bank;

use Yii;
use app\components\BcaParser;
use yii\console\Controller;
use yii\helpers\VarDumper;

class BcaBank implements BankInterface {
	public function checkBalance($person){
		$file_balance = '@app/data/balance.php';

		$req_file = require Yii::getAlias($file_balance);

		$limit = Yii::$app->params['notification']['limit'];

		$get_data = $req_file[$person];

		$prev_balance = $get_data['balance'];

		$parser = new BcaParser;

		/** Login **/
		$last_balance = $parser->getBalance($get_data['username'], $get_data['password']);

		$prev_balance = (int)$prev_balance;
		$last_balance = (int)$last_balance;
		$diff_balance = 0;

		if ($last_balance != $prev_balance) {

			if ($last_balance > $prev_balance) {
				$diff_balance = round(($last_balance - $prev_balance));
				$type = 'increase';
			}

			if ($last_balance < $prev_balance) {
				$diff_balance = round(($prev_balance - $last_balance));
				$type = 'decrease';
			}

			if ($last_balance < $prev_balance || $last_balance > $prev_balance) {

				$last_balance_format = number_format($last_balance, 2, ",", ".");
				$prev_balance_format = number_format($prev_balance, 2, ",", ".");
				$diff_balance_format = number_format($diff_balance, 2, ",", ".");

			}

			//Kirim notif jika selisih lebih dari 10000
			if (($diff_balance > 10000) && $last_balance != 0 && $last_balance != false) {
				/** set data to write **/
				$data = [$person => ['email' => $get_data['email'], 'username' => $get_data['username'], 'password' => $get_data['password'], 'balance' => $last_balance]];

				file_put_contents(Yii::getAlias($file_balance), "<?php\nreturn " . VarDumper::export($data) . ";\n", LOCK_EX);

				return ['type' => $type, 'prev_balance' => $prev_balance_format, 'last_balance' => $last_balance_format, 'diff_balance' => $diff_balance_format];
			}
		}

		return false;
	}
}