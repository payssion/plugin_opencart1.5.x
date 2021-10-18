<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionAirtm extends ControllerPaymentPayssion {
	protected $pm_id = 'airtm';
}