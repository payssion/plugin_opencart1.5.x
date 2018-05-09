<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionRapipagoar extends ControllerPaymentPayssion {
	protected $pm_id = 'rapipago_ar';
}