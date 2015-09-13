<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
  <div class="content">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
          <tr>
            <td><span class="required">*</span><?php echo $entry_apikey; ?></td>
            <td>
              <input type="text" name="payssion_apikey" value="<?php echo $payssion_apikey ?>" placeholder="<?php echo $entry_apikey; ?>" id="input-merchant" />
              <?php if ($error_apikey) { ?>
              <span class="error"><?php echo $error_apikey; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><span class="required">*</span><?php echo $entry_secretkey; ?></td>
            <td>
              <input type="text" name="payssion_secretkey" value="<?php echo $payssion_secretkey; ?>" placeholder="<?php echo $entry_secretkey; ?>" id="input-password" />
              <?php if ($error_secretkey) { ?>
              <span class="error"><?php echo $error_secretkey; ?></span>
              <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_test; ?></td>
            <td>
              <select name="payssion_test" id="input-test">
                <?php if ($payssion_test == '0') { ?>
                <option value="0" selected="selected"><?php echo $text_off; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_off; ?></option>
                <?php } ?>
                <?php if ($payssion_test == '100') { ?>
                <option value="100" selected="selected"><?php echo $text_successful; ?></option>
                <?php } else { ?>
                <option value="100"><?php echo $text_successful; ?></option>
                <?php } ?>
                <?php if ($payssion_test == '101') { ?>
                <option value="101" selected="selected"><?php echo $text_declined; ?></option>
                <?php } else { ?>
                <option value="101"><?php echo $text_declined; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td>
              <select name="payssion_order_status_id" id="input-order-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payssion_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_pending_status; ?></td>
            <td>
              <select name="payssion_pending_status_id" id="input-pending-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payssion_pending_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_canceled_status; ?></td>
            <td>
              <select name="payssion_canceled_status_id" id="input-canceled-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payssion_canceled_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_failed_status; ?></td>
            <td>
              <select name="payssion_failed_status_id" id="input-failed-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payssion_failed_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_chargeback_status; ?></td>
            <td>
              <select name="payssion_chargeback_status_id" id="input-chargeback-status">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $payssion_chargeback_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td>
              <select name="payssion_geo_zone_id" id="input-geo-zone">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $payssion_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td>
              <select name="payssion_status" id="input-status">
                <?php if ($payssion_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td>
              <input type="text" name="payssion_sort_order" value="<?php echo $payssion_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" />
            </td>
          </tr>
          </table>
        </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 