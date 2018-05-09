<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionPagoefectivope extends ControllerPaymentPayssion {
	protected $pm_id = 'pagoefectivo_pe';
}