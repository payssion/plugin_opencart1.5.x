<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionPaynowsg extends ControllerPaymentPayssion {
	protected $pm_id = 'paynow_sg';
}