<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\src\bank\BcaBank;
use yii\console\ExitCode;

class BcaController extends Controller {

	public function actionCheck($person) {

		$notification = Yii::$app->params['notification'];

		if(!class_exists($notification['class'])){
			$this->stderr('Error: ' . ExitCode::getReason(ExitCode::UNAVAILABLE));
         	return ExitCode::UNAVAILABLE;
		}

		$bank = new BcaBank();
		$checkBalance = $bank->checkBalance($person);

		if($checkBalance != false && $checkBalance != 0){
			$notifier = new $notification['class'];
			$notifier->sendNotification($checkBalance['type'], $checkBalance['prev_balance'], $checkBalance['last_balance'], $checkBalance['diff_balance']);

			$this->stdout('Balance Type : ' . strtoupper($checkBalance['type']) . "\n");
			return ExitCode::OK;
		}else{
			$this->stdout('Balance Type : NO CHANGES' . "\n");
			return ExitCode::OK;
		}
	}
}
