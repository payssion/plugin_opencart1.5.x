<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionTrustly extends ControllerPaymentPayssion {
	protected $pm_id = 'trustly';
}