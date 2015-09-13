<?php
class ControllerPaymentPayssion extends Controller {
	private $error = array();

	public function index() {	
		$this->language->load('payment/payssion');
		
		$title = $this->language->get('heading_title');
		$class_name = get_class($this);
		$index = strrpos($class_name, 'Payssion');
		$id = strtolower(substr($class_name, $index));
		$channel = false;
		if (strlen($class_name) - $index > 8) {
			$channel = true;
			$title = substr($class_name, $index + 8) . ' (via Payssion)';
		}
		$this->data['pm'] = $id;
		
		$this->document->setTitle($title);

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting($id, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $title;
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_testmode_on'] = $this->language->get('text_testmode_on');
		$this->data['text_testmode_off'] = $this->language->get('text_testmode_off');

		$this->data['entry_apikey'] = $this->language->get('entry_apikey');
		$this->data['entry_secretkey'] = $this->language->get('entry_secretkey');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_pending_status'] = $this->language->get('entry_pending_status');
		$this->data['entry_canceled_status'] = $this->language->get('entry_canceled_status');
		$this->data['entry_failed_status'] = $this->language->get('entry_failed_status');
		$this->data['entry_chargeback_status'] = $this->language->get('entry_chargeback_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['apikey'])) {
			$this->data['error_apikey'] = $this->error['apikey'];
		} else {
			$this->data['error_apikey'] = '';
		}

		if (isset($this->error['secretkey'])) {
			$this->data['error_secretkey'] = $this->error['secretkey'];
		} else {
			$this->data['error_secretkey'] = '';
		}

		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_payment'),
				'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $title,
				'href'      => $this->url->link('payment/', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('payment/' . $id, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['payssion_apikey'])) {
			$this->data['payssion_apikey'] = $this->request->post['payssion_apikey'];
		} else {
			$this->data['payssion_apikey'] = $this->config->get('payssion_apikey');
		}

		if (isset($this->request->post['payssion_secretkey'])) {
			$this->data['payssion_secretkey'] = $this->request->post['payssion_secretkey'];
		} else {
			$this->data['payssion_secretkey'] = $this->config->get('payssion_secretkey');
		}

		if (isset($this->request->post['payssion_test'])) {
			$this->data['payssion_test'] = $this->request->post['payssion_test'];
		} else {
			$this->data['payssion_test'] = $this->config->get('payssion_test');
		}

		if (isset($this->request->post['payssion_total'])) {
			$this->data['payssion_total'] = $this->request->post['payssion_total'];
		} else {
			$this->data['payssion_total'] = $this->config->get('payssion_total');
		}

		if (isset($this->request->post['payssion_order_status_id'])) {
			$this->data['payssion_order_status_id'] = $this->request->post['payssion_order_status_id'];
		} else {
			$this->data['payssion_order_status_id'] = $this->config->get('payssion_order_status_id');
		}
		
		if (isset($this->request->post['payssion_pending_status_id'])) {
			$this->data['payssion_pending_status_id'] = $this->request->post['payssion_pending_status_id'];
		} else {
			$this->data['payssion_pending_status_id'] = $this->config->get('payssion_pending_status_id');
		}
		
		if (isset($this->request->post['payssion_canceled_status_id'])) {
			$this->data['payssion_canceled_status_id'] = $this->request->post['payssion_canceled_status_id'];
		} else {
			$this->data['payssion_canceled_status_id'] = $this->config->get('payssion_canceled_status_id');
		}
		
		if (isset($this->request->post['payssion_failed_status_id'])) {
			$this->data['payssion_failed_status_id'] = $this->request->post['payssion_failed_status_id'];
		} else {
			$this->data['payssion_failed_status_id'] = $this->config->get('payssion_failed_status_id');
		}
		
		if (isset($this->request->post['payssion_chargeback_status_id'])) {
			$this->data['payssion_chargeback_status_id'] = $this->request->post['payssion_chargeback_status_id'];
		} else {
			$this->data['payssion_chargeback_status_id'] = $this->config->get('payssion_chargeback_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$geo_zone_id = $id . '_geo_zone_id';
		if (isset($this->request->post[$geo_zone_id])) {
			$this->data[$geo_zone_id] = $this->request->post[$geo_zone_id];
		} else {
			$this->data[$geo_zone_id] = $this->config->get($geo_zone_id);
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$pm_status = $id . '_status';
		if (isset($this->request->post[$pm_status])) {
			$this->data[$pm_status] = $this->request->post[$pm_status];
		} else {
			$this->data[$pm_status] = $this->config->get($pm_status);
		}

		$pm_sortorder = $id . '_sort_order';
		if (isset($this->request->post[$pm_sortorder])) {
			$this->data[$pm_sortorder] = $this->request->post[$pm_sortorder];
		} else {
			$this->data[$pm_sortorder] = $this->config->get($pm_sortorder);
		}

		$this->template = $channel ? 'payment/payssion_channel.tpl' : 'payment/payssion.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/payssion')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['payssion_apikey']) && !$this->request->post['payssion_apikey']) {
			$this->error['apikey'] = $this->language->get('error_apikey');
		}

		if (isset($this->request->post['payssion_secretkey']) && !$this->request->post['payssion_secretkey']) {
			$this->error['secretkey'] = $this->language->get('error_secretkey');
		}

		return !$this->error;
	}
}