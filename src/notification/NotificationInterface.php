<?php
namespace app\src\notification;

interface NotificationInterface {
	public function sendNotification($type, $prev_balance, $last_balance, $diff_balance);
}