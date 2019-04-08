<?php
class ControllerPaymentPayssion extends Controller {
	protected $pm_id = '';
	public function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if (!$this->config->get('payssion_test')) {
			$this->data['action'] = 'https://www.payssion.com/payment/create.html';
		} else {
			$this->data['action'] = 'http://sandbox.payssion.com/payment/create.html';
		}

		$this->data['source'] = 'opencart';
		$this->data['pm_id'] = $this->pm_id;
		$this->data['api_key'] = $this->config->get('payssion_apikey');
		$this->data['track_id'] = $order_info['order_id'];
		$this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		$this->data['currency'] = $order_info['currency_code'];
		$this->data['description'] = $this->config->get('config_name') . ' - #' . $order_info['order_id'];
		$this->data['payer_name'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];

// 		if (!$order_info['payment_address_2']) {
// 			$this->data['address'] = $order_info['payment_address_1'] . ', ' . $order_info['payment_city'] . ', ' . $order_info['payment_zone'];
// 		} else {
// 			$this->data['address'] = $order_info['payment_address_1'] . ', ' . $order_info['payment_address_2'] . ', ' . $order_info['payment_city'] . ', ' . $order_info['payment_zone'];
// 		}

		//$this->data['postcode'] = $order_info['payment_postcode'];
		$this->data['country'] = $order_info['payment_iso_code_2'];
		//$this->data['telephone'] = $order_info['telephone'];
		$this->data['payer_email'] = $order_info['email'];
		
		$this->data['notify_url'] = $this->url->link('payment/payssion/notify');
		$this->data['success_url'] = $this->url->link('payment/payssion/callback');
		$this->data['redirect_url'] = $this->url->link('payment/payssion/callback');

		$this->data['api_sig'] = $this->generateSignature($this->data, $this->config->get('payssion_secretkey'));
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payssion.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/payssion.tpl';
		} else {
			$this->template =  'default/template/payment/payssion.tpl';
		}
		
		$this->render();
	}
	
	private function generateSignature(&$req, $secretKey) {
		$arr = array($req['api_key'], $req['pm_id'], $req['amount'], $req['currency'],
				$req['track_id'], '', $secretKey);
		$msg = implode('|', $arr);
		return md5($msg);
	}
	
	public function callback() {
		$this->load->language('payment/payssion');
	
		$this->data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
	
		if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
			$this->data['base'] = $this->config->get('config_url');
		} else {
			$this->data['base'] = $this->config->get('config_ssl');
		}
	
		$this->data['language'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
	
		$this->data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
	
		$this->data['text_response'] = $this->language->get('text_response');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success'));
		$this->data['text_failure'] = $this->language->get('text_failure');
		$this->data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/checkout', '', 'SSL'));
	
		if (isset($this->request->get['state']) && $this->request->get['state'] == 'complete') {
			$this->data['continue'] = $this->url->link('checkout/success');
				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payssion_success.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/payssion_success.tpl';
			} else {
				$this->template = 'default/template/payment/payssion_success.tpl';
			}
		} else {
			$this->data['continue'] = $this->url->link('checkout/cart');
				
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/payssion_failure.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/payment/payssion_failure.tpl';
			} else {
				$this->template = 'default/template/payment/payssion_failure.tpl';
			}
		}
		
		$this->response->setOutput($this->render());
	}

	public function notify() {
		$track_id = $this->request->post['track_id'];
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($track_id);
		if (!$order_info) {
			$this->response->setOutput('order id not found');
		} else if ($this->isValidNotify()) {
			if (!$this->request->server['HTTPS']) {
				$this->data['base'] = $this->config->get('config_url');
			} else {
				$this->data['base'] = $this->config->get('config_ssl');
			}
			
			$state = $this->request->post['state'];
			$message = '';
				
			if (isset($this->request->post['track_id'])) {
				$message .= 'track_id: ' . $this->request->post['track_id'] . "\n";
			}
				
			if (isset($this->request->post['pm_id'])) {
				$message .= 'pm_id: ' . $this->request->post['pm_id'] . "\n";
			}
			
			if (isset($this->request->post['state'])) {
				$message .= 'state: ' . $this->request->post['state'] . "\n";
			}
				
			if (isset($this->request->post['amount'])) {
				$message .= 'amount: ' . $this->request->post['amount'] . "\n";
			}
				
			if (isset($this->request->post['paid'])) {
				$message .= 'paid: ' . $this->request->post['paid'] . "\n";
			}
				
			if (isset($this->request->post['currency'])) {
				$message .= 'currency: ' . $this->request->post['currency'] . "\n";
			}
				
			if (isset($this->request->post['notify_sig'])) {
				$message .= 'notify_sig: ' . $this->request->post['notify_sig'] . "\n";
			}
				
			
			$status_list = array(
					'completed' => $this->config->get('payssion_order_status_id'),
					'pending' => $this->config->get('payssion_pending_status_id'),
					'cancelled_by_user' => $this->config->get('payssion_canceled_status_id'),
					'cancelled' => $this->config->get('payssion_canceled_status_id'),
					'rejected_by_bank' => $this->config->get('payssion_canceled_status_id'),
					'failed' => $this->config->get('payssion_failed_status_id'),
					'error' => $this->config->get('payssion_failed_status_id')
			);
				
			if (!$order_info['order_status_id']) {
				$this->model_checkout_order->confirm($track_id, $status_list[$state], $message, 'completed' == $state);
			} else {
				$this->model_checkout_order->update($track_id, $status_list[$state], $message);
			}
			
			$this->response->setOutput('notify success');
			
		} else {
			$this->model_checkout_order->confirm($track_id, $this->config->get('config_order_status_id'), $this->language->get('text_pw_mismatch'));
			$this->response->setOutput('notify verify failed');
		}

	}
	
	public function isValidNotify() {
		$apiKey = $this->config->get('payssion_apikey');;
		$secretKey = $this->config->get('payssion_secretkey');
	
		// Assign payment notification values to local variables
		$pm_id = $this->request->post['pm_id'];
		$amount = $this->request->post['amount'];
		$currency = $this->request->post['currency'];
		$track_id = $this->request->post['track_id'];
		$sub_track_id = $this->request->post['sub_track_id'];
		$state = $this->request->post['state'];
	
		$check_array = array(
				$apiKey,
				$pm_id,
				$amount,
				$currency,
				$track_id,
				$sub_track_id,
				$state,
				$secretKey
		);
		$check_msg = implode('|', $check_array);
		$check_sig = md5($check_msg);
		$notify_sig = $this->request->post['notify_sig'];
		return ($notify_sig == $check_sig);
	}
}