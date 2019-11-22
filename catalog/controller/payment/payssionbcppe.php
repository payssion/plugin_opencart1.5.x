<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionBCPpe extends ControllerPaymentPayssion {
	protected $pm_id = 'bcp_pe';
}