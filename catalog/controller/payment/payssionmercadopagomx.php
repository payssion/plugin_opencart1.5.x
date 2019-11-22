<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionMercadopagomx extends ControllerPaymentPayssion {
	protected $pm_id = 'mercadopago_mx';
}