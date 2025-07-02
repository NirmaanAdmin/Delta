<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
	.input-group-addon {
		padding-left: 6px !important;
		padding-right: 6px !important;
		font-size: 10px !important;
	}
</style>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12" id="small-table">
				<div class="panel_s">
					<?php echo form_open_multipart(admin_url('warehouse/manage_goods_receipt'), array('id' => 'add_goods_receipt')); ?>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h4 class="no-margin font-bold"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> Stock Received</h4>
								<hr>
							</div>
						</div>

						<?php
						$id = '';
						if (isset($goods_receipt)) {
							$id = $goods_receipt->id;
							echo form_hidden('isedit');
						}
						?>

						<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
						<input type="hidden" name="save_and_send_request" value="false">

						<!-- start-->
						<div class="row">
							<div class="col-md-6">
								<?php $goods_receipt_code = isset($goods_receipt) ? $goods_receipt->goods_receipt_code : (isset($goods_code) ? $goods_code : ''); ?>
								<?php echo render_input('goods_receipt_code', 'stock_received_docket_number', $goods_receipt_code, '', array('disabled' => 'true')) ?>
							</div>
							<!-- <div class="col-md-3">
								<?php $date_c =  isset($goods_receipt) ? $goods_receipt->date_c : $current_day ?>
								<?php echo render_date_input('date_c', 'accounting_date', _d($date_c)) ?>
							</div> -->
							<div class="col-md-3">
								<?php $date_add =  isset($goods_receipt) ? $goods_receipt->date_add : $current_day ?>
								<?php echo render_date_input('date_add', 'Receive Date', _d($date_add)) ?>
							</div>

							<div class="col-md-6 <?php if ($pr_orders_status == false) {
								echo 'hide';
								}; ?>">
								<div class="form-group">
									<label for="pr_order_id"><?php echo _l('reference_purchase_order'); ?></label>
									<select name="pr_order_id" id="pr_order_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>
										<?php foreach ($pr_orders as $pr_order) { ?>
											<option value="<?php echo html_entity_decode($pr_order['id']); ?>" <?php if (isset($goods_receipt) && ($goods_receipt->pr_order_id == $pr_order['id'])) {
												echo 'selected';
											} ?>><?php echo html_entity_decode($pr_order['pur_order_number'] . ' - ' . $pr_order['pur_order_name'] . ' - ' . get_vendor_name($pr_order['vendor'])); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-6 <?php if ($pr_orders_status == false) {
								echo 'hide';
								}; ?>">
								<div class="form-group">
									<label for="wo_order_id"><?php echo _l('reference_work_order'); ?></label>
									<select name="wo_order_id" id="wo_order_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>
										<?php foreach ($wo_orders as $wo_order) { ?>
											<option value="<?php echo html_entity_decode($wo_order['id']); ?>" <?php if (isset($goods_receipt) && ($goods_receipt->wo_order_id == $wo_order['id'])) {
												echo 'selected';
											} ?>><?php echo html_entity_decode($wo_order['wo_order_number'] . ' - ' . $wo_order['wo_order_name'] . ' - ' . get_vendor_name($wo_order['vendor'])); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="col-md-6 <?php if ($pr_orders_status == false) {
								echo 'hide';
								}; ?>">
								<div class="form-group">
									<label for="supplier_code"><?php echo _l('supplier_name'); ?></label>
									<select name="supplier_code" id="supplier_code" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>

										<?php if (isset($vendors)) { ?>
											<?php foreach ($vendors as $s) { ?>
												<option value="<?php echo html_entity_decode($s['userid']); ?>" <?php if (isset($goods_receipt) && $goods_receipt->supplier_code == $s['userid']) {
													echo 'selected';
												} ?>><?php echo html_entity_decode($s['company']); ?></option>
											<?php } ?>
										<?php } ?>

									</select>
								</div>
							</div>

							<div class="col-md-6 <?php if ($pr_orders_status == true) {
								echo 'hide';
								}; ?>">
								<?php $supplier_name =  isset($goods_receipt) ? $goods_receipt->supplier_name : '' ?>
								<?php
								echo render_input('supplier_name', 'supplier_name', $supplier_name) ?>
							</div>

							<div class=" col-md-3">
								<div class="form-group">
									<label for="buyer_id" class="control-label"><?php echo _l('Prepared By'); ?></label>
									<select name="buyer_id" class="selectpicker" id="buyer_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
										<option value=""></option>
										<?php foreach ($staff as $s) { ?>
											<option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if (isset($goods_receipt) && ($goods_receipt->buyer_id == $s['staffid'])) {
												echo 'selected';
											} ?>> <?php echo html_entity_decode($s['firstname'] . '' . $s['lastname']); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<?php if (ACTIVE_PROPOSAL == true) { ?>
								<div class="col-md-3 form-group <?php if ($pr_orders_status == false) {
									echo 'hide';
									}; ?>">
									<label for="project"><?php echo _l('project'); ?></label>
									<select name="project" id="project" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>

										<?php if (isset($projects)) { ?>
											<?php foreach ($projects as $s) { ?>
												<option value="<?php echo html_entity_decode($s['id']); ?>" <?php if (isset($goods_receipt) && $s['id'] == $goods_receipt->project) {
													echo 'selected';
												} ?>><?php echo html_entity_decode($s['name']); ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>

								<div class="col-md-3 form-group <?php if ($pr_orders_status == false) {
									echo 'hide';
									}; ?>">
									<label for="type"><?php echo _l('type_label'); ?></label>
									<select name="type" id="type" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>
										<option value="capex" <?php if (isset($goods_receipt) && $goods_receipt->type == 'capex') {
											echo 'selected';
											} ?>><?php echo _l('capex'); ?>
									    </option>
										<option value="opex" <?php if (isset($goods_receipt) && $goods_receipt->type == 'opex') {
											echo 'selected';
											} ?>><?php echo _l('opex'); ?>
										</option>
									</select>
								</div>

								<div class="col-md-3 form-group <?php if ($pr_orders_status == false) {
										echo 'hide';
									}; ?>">
									<label for="department"><?php echo _l('department'); ?></label>
									<select name="department" id="department" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>
										<?php if (isset($departments)) { ?>
											<?php foreach ($departments as $s) { ?>
												<option value="<?php echo html_entity_decode($s['departmentid']); ?>" <?php if (isset($goods_receipt) && $s['departmentid'] == $goods_receipt->department) {
													echo 'selected';
												} ?>><?php echo html_entity_decode($s['name']); ?></option>
											<?php } ?>

										<?php } ?>

									</select>
								</div>

								<div class="col-md-3 form-group <?php if ($pr_orders_status == false) {
										echo 'hide';
									}; ?>">
									<label for="requester"><?php echo _l('requester'); ?></label>
									<select name="requester" id="requester" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
										<option value=""></option>
										<?php if (isset($staffs)) { ?>
											<?php foreach ($staffs as $s) { ?>
												<option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if (isset($goods_receipt) && $s['staffid'] == $goods_receipt->requester) {
													echo 'selected';
												} ?>><?php echo html_entity_decode($s['lastname'] . ' ' . $s['firstname']); ?></option>
											<?php } ?>
										<?php } ?>
									</select>
								</div>

							<?php } ?>

							<div class=" col-md-3">
								<?php $deliver_name = (isset($goods_receipt) ? $goods_receipt->deliver_name : '');
								echo render_input('deliver_name', 'deliver_name', $deliver_name) ?>
							</div>

							<div class="col-md-3 ">
								<?php $warehouse_id_value = (isset($goods_receipt) ? $goods_receipt->warehouse_id : ''); ?>
								<a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle skucode-tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('goods_receipt_warehouse_tooltip'); ?>"></i></a>
								<?php echo render_select('warehouse_id_m', $warehouses, array('warehouse_id', 'warehouse_name'), 'warehouse_name', $warehouse_id_value); ?>
							</div>

							<?php if (ACTIVE_PROPOSAL == true) { ?>
								<div class="col-md-3 <?php if ($pr_orders_status == false) {
															echo 'hide';
														}; ?>">
									<?php $expiry_date =  isset($goods_receipt) ? $goods_receipt->expiry_date : $current_day ?>
									<?php echo render_date_input('expiry_date_m', 'expiry_date', _d($expiry_date)) ?>
								</div>
							<?php } ?>
							<div class="col-md-3 form-group">
								<?php $invoice_no = (isset($goods_receipt) ? $goods_receipt->invoice_no : '');
								echo render_input('invoice_no', 'invoice_no', $invoice_no) ?>
							</div>
							<div class="col-md-3 form-group">
								<?php $kind = (isset($goods_receipt) ? $goods_receipt->kind : '');
								echo render_input('kind', 'Category', $kind, '', array('readonly' => 'true')) ?>
							</div>
						</div>
					</div>
					<div class="panel_s" style="margin: 0px;">
						<div class="panel-body">
							<label for="attachment"><?php echo _l('attachment'); ?></label>
							<div class="attachments">
								<div class="attachment">
									<div class="col-md-5 form-group" style="padding-left: 0px;">
										<div class="input-group">
											<input type="file" extension="<?php echo str_replace(['.', ' '], '', get_option('ticket_attachments_file_extensions')); ?>" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]" accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
											<span class="input-group-btn">
												<button class="btn btn-success add_more_attachments p8" type="button"><i class="fa fa-plus"></i></button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<br /> <br />

							<?php
							if (isset($attachments) && count($attachments) > 0) {
								foreach ($attachments as $value) {
									echo '<div class="col-md-3">';
									$path = get_upload_path_by_type('inventory') . 'goods_receipt/' . $value['rel_id'] . '/' . $value['file_name'];
									$is_image = is_image($path);
									if ($is_image) {
										echo '<div class="preview_image">';
									}
							?>
									<a href="<?php echo site_url('download/file/inventory/' . $value['id']); ?>" class="display-block mbot5" <?php if ($is_image) { ?> data-lightbox="attachment-inventory-<?php echo $value['rel_id']; ?>" <?php } ?>>
										<i class="<?php echo get_mime_class($value['filetype']); ?>"></i> <?php echo $value['file_name']; ?>
										<?php if ($is_image) { ?>
											<img class="mtop5" src="<?php echo site_url('download/preview_image?path=' . protected_file_url_by_path($path) . '&type=' . $value['filetype']); ?>" style="height: 165px;">
										<?php } ?>
									</a>
									<?php if ($is_image) {
										echo '</div>';
										echo '<a href="' . admin_url('warehouse/delete_attachment/' . $value['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
									} ?>
							<?php echo '</div>';
								}
							} ?>
						</div>
					</div>
					<div class="panel_s">
						<div class="panel-body">
							<!-- <a href="#" id="show_documentation" class="btn btn-info pull-left mright10 display-block" data-toggle="modal" data-target="#documentationModal">
								Documentation
							</a> -->
							<h4 class="modal-title" id="documentationModalLabel">Documentation</h4>
							<table class="table items items-preview">
								<thead>
									<tr>
										<th style="width: 7%;">Sr. No</th>
										<th><?php echo _l('Checklist') ?></th>
										<th><?php echo _l('Required') ?></th>
										<th><?php echo _l('Attachments') ?></th>
										<th><?php echo _l('Download') ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									$checklist_items = [
										'1' => 'Stock Import Images',
										'2' => 'Technical/Security Staff sign',
										'3' => 'Transport Document',
										'4' => 'Production Certificate',
									];

									$sr = 1;
									foreach ($checklist_items as $key => $value) {
										$is_required = 1;
										$is_attachemnt = $file_id = 0;
										if (!empty($goods_documentitions)) {
											foreach ($goods_documentitions as $doc) {
												if ($doc->checklist_id == $key) {
													$is_required = $doc->required;
													$is_attachemnt = $doc->attachments;
													$file_id = $doc->id;
													$rel_id = $doc->goods_receipt_id;
												}
											}
										}
									?>
										<input type="hidden" name="checklist_id[<?= $key ?>]" value="<?= $key ?>">
										<tr>
											<td><?= $sr ?></td>
											<td><?= $value ?></td>
											<td style="text-align: center;">
												<div class="checkbox">
													<input type="hidden" name="required[<?= $key ?>]" value="0">
													<input type="checkbox" name="required[<?= $key ?>]" value="1"
														<?= $is_required ? 'checked="checked"' : '' ?> style="opacity: unset;">
												</div>
											</td>
											<td>
												<div class="attachment_new">
													<div class="col-md-12">
														<div class="form-group">
															<div class="input-group">
																<input type="file"
																	class="form-control"
																	name="doc_attachments[<?= $sr ?>][attachments_new][]"
																	accept="<?php echo get_form_form_accepted_mimes(); ?>">
																<span class="input-group-btn">
																	<button class="btn btn-default add_more_attachments_goods" data-item="<?= $sr ?>"
																		data-max="<?php echo get_option('maximum_allowed_form_attachments'); ?>" type="button">
																		<i class="fa fa-plus"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>
												</div>

											</td>
											<td>
												<?php if ($is_attachemnt == 1) : ?>
													<a href="javascript:void(0)" onclick="view_goods_receipt_attachments('<?= $file_id ?>','<?= $rel_id ?>','goods_receipt_checkl'); return false;" class="btn btn-info btn-icon">View Files</a>
												<?php endif; ?>
											</td>
										</tr>
									<?php
										$sr++;
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<div class="panel-body mtop10 invoice-item">
						<div class="row">
							<!-- <div class="col-md-4">
								<?php $this->load->view('warehouse/item_include/main_item_select'); ?>
							</div> -->
							<div class="col-md-12 text-right">
								<label class="bold mtop10 text-right" data-toggle="tooltip" title="" data-original-title="<?php echo _l('support_barcode_scanner_tooltip'); ?>"><?php echo _l('support_barcode_scanner'); ?>
									<i class="fa fa-question-circle i_tooltip"></i></label>
							</div>
						</div>

						<div class="horizontal-tabs">
							<ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">
								<li role="presentation" class="active">
									<a href="#final_items" aria-controls="final_items" role="tab" id="tab_final_items" data-toggle="tab">
										Items
									</a>
								</li>
							</ul>
						</div>

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="final_items">
								<div class="table-responsive s_table ">
									<table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
										<thead>
											<tr>
												<th width="1%"></th>
												<th align="left" style="width: 10%;"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item_description_new_lines_notice'); ?>"></i> <?php echo _l('Uniclass Code'); ?></th>
												<th align="left" style="width: 15%;"><?php echo _l('description'); ?></th>
												<th align="left" style="width: 10%;"><?php echo _l('area'); ?></th>
												<th align="left" style="width: 5%;"><?php echo _l('warehouse_name'); ?></th>
												<th align="right" style="width: 7%;" class="qty"><?php echo _l('po_quantity'); ?></th>
												<th align="right" style="width: 7%;" class="qty"><?php echo _l('received_quantity'); ?></th>
												<!-- <th align="right" style="width: 8%;"><?php echo _l('unit_price'); ?></th> -->
												<!-- <th align="right" style="width: 7%;"><?php echo _l('invoice_table_tax_heading'); ?></th> -->
												<th align="right" style="width: 10%;"><?php echo _l('lot_number'); ?></th>
												<!-- <th align="left" style="width: 7%;"><?php echo _l('vendor'); ?></th> -->
												<?php /* <th align="left" style="width: 8%;"><?php echo _l('production_status'); ?></th>
												<th align="left" style="width: 10%;"><?php echo _l('payment_date'); ?></th>
												<th align="left" style="width: 10%;"><?php echo _l('est_delivery_date'); ?></th>
												<th align="right" style="width: 10%;"><?php echo _l('delivery_date'); ?></th> */ ?>
												<!-- <th align="right"><?php echo _l('expiry_date'); ?></th> -->
												<!-- <th align="right" style="width: 7%;"><?php echo _l('invoice_table_amount_heading'); ?></th> -->

												<!-- <th align="center" style="width: 1%;"><i class="fa fa-cog"></i></th> -->
												<!-- <th align="center"></th> -->
											</tr>
										</thead>
										<tbody>
											<?php echo html_entity_decode($goods_receipt_row_template); ?>
										</tbody>
									</table>
								</div>
							</div>

							<!-- <div role="tabpanel" class="tab-pane" id="production_approvals">
								<div class="table-responsive s_table ">
									<table class="table invoice-production-approvals-table items table-main-invoice-edit has-calculations no-mtop">
										<thead>
											<tr>
												<th width="1%"></th>
												<th align="left" style="width: 15%;"><i class="fa fa-exclamation-circle" aria-hidden="true" data-toggle="tooltip" data-title="<?php echo _l('item_description_new_lines_notice'); ?>"></i> <?php echo _l('invoice_table_item_heading'); ?></th>
												<th align="left" style="width: 15%;"><?php echo _l('description'); ?></th>


											</tr>
										</thead>
										<tbody>
											<?php echo html_entity_decode($goods_receipt_production_approvals_template); ?>
										</tbody>
									</table>
								</div>
							</div> -->
						</div>


						<!-- <div class="col-md-8 col-md-offset-4">
							<table class="table text-right">
								<tbody>
									<tr id="subtotal">
										<td><span class="bold"><?php echo _l('total_goods_money'); ?> :</span>
										</td>
										<td class="wh-subtotal">
										</td>
									</tr>
									<tr id="totalmoney">
										<td><span class="bold"><?php echo _l('total_money'); ?> :</span>
										</td>
										<td class="wh-total">
										</td>
									</tr>
								</tbody>
							</table>
						</div> -->
						<div id="removed-items"></div>
					</div>

					<div class="row">
						<div class="col-md-12 mtop15">
							<div class="panel-body ">
								<?php $description = (isset($goods_receipt) ? $goods_receipt->description : ''); ?>
								<?php echo render_textarea('description', 'note', $description, array(), array(), 'mtop15'); ?>

								<div class="btn-bottom-toolbar text-right">
									<a href="<?php echo admin_url('warehouse/manage_purchase'); ?>" class="btn btn-default text-right mright5"><?php echo _l('close'); ?></a>

									<?php if (wh_check_approval_setting('1') != false) { ?>
										<?php if (isset($goods_receipt) && $goods_receipt->approval != 1) { ?>
											<a href="javascript:void(0)" class="btn btn-info pull-right mright5 add_goods_receipt_send"><?php echo _l('save_send_request'); ?></a>
										<?php } elseif (!isset($goods_receipt)) { ?>
											<a href="javascript:void(0)" class="btn btn-info pull-right mright5 add_goods_receipt_send"><?php echo _l('save_send_request'); ?></a>
										<?php } ?>
									<?php } ?>

									<?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
										<?php if (isset($goods_receipt) && $goods_receipt->approval == 0) { ?>
											<a href="javascript:void(0)" class="btn btn-info pull-right mright5 add_goods_receipt"><?php echo _l('submit'); ?></a>
										<?php } elseif (!isset($goods_receipt)) { ?>
											<a href="javascript:void(0)" class="btn btn-info pull-right mright5 add_goods_receipt"><?php echo _l('submit'); ?></a>
										<?php } ?>
									<?php } ?>
								</div>
							</div>
							<div class="btn-bottom-pusher"></div>
						</div>
					</div>

				</div>
				<!-- Documentation Modal -->
				<div class="modal fade" id="documentationModal" tabindex="-1" role="dialog" aria-labelledby="documentationModalLabel">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="documentationModalLabel">Documentation Checklist</h4>
							</div>
							<div class="modal-body">

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>

			</div>
		</div>
	</div>
	<div class="modal fade" id="viewgoodsReceiptAttachmentModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document" style="width: 70%;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?php echo _l('attachment'); ?></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="view_goods_receipt_attachments">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="goods_receipt_file_data"></div>

</div>
</div>
</div>
<div id="modal_wrapper"></div>


<?php init_tail(); ?>
<?php require 'modules/warehouse/assets/js/purchase_js.php'; ?>
</body>

</html>
<script>
	$("body").on("click", ".add_more_attachments_goods", function() {
		const itemIndex = $(this).data("item");

		const html = `
		<div class="attachment_new mt-2">
			<div class="col-md-12">
				<div class="form-group">
					<div class="input-group">
						<input type="file" class="form-control"
							name="doc_attachments[${itemIndex}][attachments_new][]" 
							accept="<?php echo get_form_form_accepted_mimes(); ?>">
						<span class="input-group-btn">
							<button class="btn btn-danger remove_attachment" type="button">
								<i class="fa fa-minus"></i>
							</button>
						</span>
					</div>
				</div>
			</div>
		</div>`;

		$(this).closest(".attachment_new").after(html);
	});
	$("body").on("click", ".remove_attachment", function() {
		$(this).closest(".attachment_new").remove();
	});
</script>