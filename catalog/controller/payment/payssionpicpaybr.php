<?php

require_once(realpath(dirname(__FILE__)) . "/payssion.php");
class ControllerPaymentPayssionPicpaybr extends ControllerPaymentPayssion {
    protected $pm_id = 'picpay_br';
}