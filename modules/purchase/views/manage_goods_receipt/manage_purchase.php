<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
    .onoffswitch-label:before {

        height: 20px !important;
    }

    .show_hide_columns {
        position: absolute;
        z-index: 99999;
        left: 204px
    }
</style>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="small-table">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_hidden('purchase_id', $purchase_id); ?>
                        <div class="row">
                            <div class="col-md-12" style="padding: 0px;">
                                <div class="col-md-12" id="heading">
                                    <h4 class="no-margin font-bold"><i class="fa fa-shopping-basket" aria-hidden="true"></i> <?php echo _l('client_supply_tracker'); ?></h4>
                                    <hr />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1 pull-right">
                                <a href="#" class="btn btn-default pull-right btn-with-tooltip toggle-small-view hidden-xs" onclick="toggle_small_view_proposal(' .purchase_sm','#purchase_sm_view'); return false;" data-toggle="tooltip" title="<?php echo _l('invoices_toggle_table_tooltip'); ?>"><i class="fa fa-angle-double-left"></i></a>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-3">
                                <?php
                                $input_attr_e = [];
                                $input_attr_e['placeholder'] = _l('day_vouchers');

                                echo render_date_input('date_add', '', '', $input_attr_e); ?>
                            </div>

                            <div class="col-md-3">
                                <select name="kind" id="kind" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('cat'); ?>">
                                    <option value=""></option>
                                    <option value="Client Supply"><?php echo _l('client_supply'); ?></option>
                                    <option value="Bought out items"><?php echo _l('bought_out_items'); ?></option>
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <select name="delivery" id="delivery" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('delivery_status'); ?>">
                                    <option value=""></option>
                                    <option value="undelivered"><?php echo _l('undelivered'); ?></option>
                                    <option value="partially_delivered"><?php echo _l('partially_delivered'); ?></option>
                                    <option value="completely_delivered"><?php echo _l('completely_delivered'); ?></option>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <?php
                                echo render_select('vendors[]', $vendors, array('userid', 'company'), '', '', array('data-width' => '100%', 'data-none-selected-text' => _l('vendor'), 'multiple' => true, 'data-actions-box' => true), array(), 'no-mbot', '', false); 
                                ?>
                            </div>
                            
                        </div>
                        <br />
                        <div class="btn-group show_hide_columns" id="show_hide_columns">
                            <!-- Settings Icon -->
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 4px 7px;">
                                <i class="fa fa-cog"></i> <?php  ?> <span class="caret"></span>
                            </button>
                            <!-- Dropdown Menu with Checkboxes -->
                            <div class="dropdown-menu" style="padding: 10px; min-width: 250px;">
                                <!-- Select All / Deselect All -->
                                <div>
                                    <input type="checkbox" id="select-all-columns"> <strong><?php echo _l('select_all'); ?></strong>
                                </div>
                                <hr>
                                <!-- Column Checkboxes -->
                                <?php
                                $columns = [
                                    _l('id'),
                                    _l('stock_received_docket_code'),
                                    _l('reference_purchase_order'),
                                    _l('supplier_name'),
                                    // _l('Buyer'),
                                    _l('category'),
                                    _l('day_vouchers'),
                                    _l('production_status'),
                                    _l('status_label'),
                                ];
                                ?>
                                <div>
                                    <?php foreach ($columns as $key => $label): ?>
                                        <input type="checkbox" class="toggle-column" value="<?php echo $key; ?>" checked>
                                        <?php echo $label; ?><br>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                        <?php render_datatable(array(
                            _l('id'),
                            _l('stock_received_docket_code'),
                            _l('reference_purchase_order'),
                            _l('supplier_name'),
                            _l('category'),
                            _l('day_vouchers'),
                            _l('production_status'),
                            _l('status_label'),
                        ), 'table_manage_goods_receipt', ['purchase_sm' => 'purchase_sm']); ?>

                    </div>
                </div>
            </div>

            <div class="col-md-7 small-table-right-col">
                <div id="purchase_sm_view" class="hide">
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="send_goods_received" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open_multipart(admin_url('warehouse/send_goods_received'), array('id' => 'send_goods_received-form')); ?>
        <div class="modal-content modal_withd">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span><?php echo _l('send_received_note'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div id="additional_goods_received"></div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="vendor"><span class="text-danger">* </span><?php echo _l('vendor'); ?></label>
                        <select name="vendor[]" id="vendor" class="selectpicker" required multiple="true" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                            <?php foreach ($vendors as $s) { ?>
                                <option value="<?php echo html_entity_decode($s['userid']); ?>"><?php echo html_entity_decode($s['company']); ?></option>
                            <?php } ?>
                        </select>
                        <br>
                    </div>

                    <div class="col-md-12">
                        <label for="subject"><span class="text-danger">* </span><?php echo _l('subject'); ?></label>
                        <?php echo render_input('subject', '', '', '', array('required' => 'true')); ?>
                    </div>
                    <div class="col-md-12">
                        <label for="attachment"><span class="text-danger">* </span><?php echo _l('attachment'); ?></label>
                        <?php echo render_input('attachment', '', '', 'file', array('required' => 'true')); ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo render_textarea('content', 'content', '', array(), array(), '', 'tinymce') ?>
                    </div>
                    <div id="type_care">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button id="sm_btn" type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var hidden_columns = [3, 4, 5];
</script>
<?php init_tail(); ?>
<script>
    $(document).ready(function() {
        var table = $('.table-table_manage_goods_receipt').DataTable();

        // Handle "Select All" checkbox
        $('#select-all-columns').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('.toggle-column').prop('checked', isChecked).trigger('change');
        });

        // Handle individual column visibility toggling
        $('.toggle-column').on('change', function() {
            var column = table.column($(this).val());
            column.visible($(this).is(':checked'));

            // Sync "Select All" checkbox state
            var allChecked = $('.toggle-column').length === $('.toggle-column:checked').length;
            $('#select-all-columns').prop('checked', allChecked);
        });

        // Sync checkboxes with column visibility on page load
        table.columns().every(function(index) {
            var column = this;
            $('.toggle-column[value="' + index + '"]').prop('checked', column.visible());
        });

        // Prevent dropdown from closing when clicking inside
        $('.dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
</body>

</html>