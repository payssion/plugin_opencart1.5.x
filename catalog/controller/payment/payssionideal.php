<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssioniDeal extends ControllerPaymentPayssion {
	protected $pm_id = 'ideal_nl';
}