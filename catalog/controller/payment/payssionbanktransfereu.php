<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionBanktransfereu extends ControllerPaymentPayssion {
	protected $pm_id = 'banktransfer_eu';
}