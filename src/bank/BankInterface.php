<?php
namespace app\src\bank;

interface BankInterface {
	public function checkBalance($person);
}