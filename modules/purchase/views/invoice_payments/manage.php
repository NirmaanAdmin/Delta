<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
   .show_hide_columns {
      position: absolute;
      z-index: 999;
      left: 204px
   }
   table {
      table-layout: auto !important;
      width: 100%;
      border-collapse: collapse;
   }
   th,
   td {
      white-space: normal;
      word-wrap: break-word;
      overflow-wrap: break-word;
      vertical-align: top;
   }
   .tags-labels {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
      max-width: 100%;
      align-items: center;
   }
   .label-tag {
      display: inline-block;
      max-width: 100%;
      white-space: nowrap;
      /* Prevent text from stacking */
      overflow: hidden;
      text-overflow: ellipsis;
      padding: 5px 10px;
      background: #f0f0f0;
      border-radius: 5px;
   }
   .label-tag .tag {
      display: inline;
   }
   .table-table_pur_invoice_payments {
      font-size: 12px !important;
   }
   .table-table_pur_invoice_payments th,
   .table-table_pur_invoice_payments td {
      font-size: 12px !important;
   }
   #scroll-slider {
      position: absolute;
      right: 10px;
      width: 200px;
      height: 2px;
      background-color: #000000;
      border-radius: 5px;
      z-index: 10000;
      cursor: pointer;
  }

  #scroll-thumb {
      width: 15px;
      height: 15px;
      background-color: #ad729f;
      border-radius: 15px;
      position: relative;
      top: -6px;
  }
</style>
<?php $module_name = 'vendor_billing_payments'; ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
                  <div class="row">
                     <div class="col-md-12">
                        <h4 class="no-margin font-bold"><i class="fa fa-clipboard" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
                        <hr />
                     </div>
                  </div>
                  <div class="row">
                        <div class="vbt_all_filters">

                           <div class="col-md-2">
                              <?php
                              $from_date_filter = get_module_filter($module_name, 'from_date');
                              $from_date_filter_val = !empty($from_date_filter) ? $from_date_filter->filter_value : '';
                              echo render_date_input('from_date', '', $from_date_filter_val, array('placeholder' => _l('from_date')));
                              ?>
                           </div>

                           <div class="col-md-2">
                              <?php
                              $to_date_filter = get_module_filter($module_name, 'to_date');
                              $to_date_filter_val = !empty($to_date_filter) ? $to_date_filter->filter_value : '';
                              echo render_date_input('to_date', '', $to_date_filter_val, array('placeholder' => _l('to_date')));
                              ?>
                           </div>

                           <div class="col-md-3 form-group">
                              <?php
                              $vendors_filter = get_module_filter($module_name, 'vendors');
                              $vendors_filter_val = !empty($vendors_filter) ? explode(",", $vendors_filter->filter_value) : '';
                              echo render_select('vendor_ft[]', $vendors, array('userid', 'company'), '', $vendors_filter_val, array('data-width' => '100%', 'data-none-selected-text' => _l('vendors'), 'multiple' => true, 'data-actions-box' => true), array(), 'no-mbot', '', false);
                              ?>
                           </div>

                           <div class="col-md-3 form-group">
                              <?php
                              $budget_head_filter = get_module_filter($module_name, 'budget_head');
                              $budget_head_filter_val = !empty($budget_head_filter) ? $budget_head_filter->filter_value : '';
                              ?>
                              <select name="budget_head" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('group_pur'); ?>" data-actions-box="true">
                                 <option value=""></option>
                                 <option value="None">None</option>
                                 <?php foreach ($budget_head as $head) { ?>
                                    <option value="<?php echo $head['id']; ?>" <?php echo ($budget_head_filter == $head['id']) ? 'selected' : ''; ?>><?php echo $head['name']; ?></option>
                                 <?php } ?>
                              </select>
                           </div>

                           <div class="col-md-3 form-group">
                              <?php
                              $billing_invoices_filter = get_module_filter($module_name, 'billing_invoices');
                              $billing_invoices_filter_val = !empty($billing_invoices_filter) ? $billing_invoices_filter->filter_value : '';
                              ?>
                              <select name="billing_invoices" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('pur_invoices'); ?>" data-actions-box="true">
                                 <option value=""></option>
                                 <option value="to_be_converted" <?php echo ($billing_invoices_filter_val == 'to_be_converted') ? 'selected' : ''; ?>>To Be Converted</option>
                                 <option value="converted" <?php echo ($billing_invoices_filter_val == 'converted') ? 'selected' : ''; ?>>Converted</option>
                              </select>
                           </div>

                           <div class="col-md-3 form-group">
                              <?php
                              $bil_payment_status_filter = get_module_filter($module_name, 'bil_payment_status');
                              $bil_payment_status_filter_val = !empty($bil_payment_status_filter) ? $bil_payment_status_filter->filter_value : '';
                              ?>
                              <select name="bil_payment_status" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('bil_payment_status'); ?>" data-actions-box="true">
                                 <option value=""></option>
                                 <option value="unpaid" <?php echo ($bil_payment_status_filter_val == 'unpaid') ? 'selected' : ''; ?>><?php echo _l('unpaid'); ?></option>
                                 <option value="partially_paid" <?php echo ($bil_payment_status_filter_val == 'partially_paid') ? 'selected' : ''; ?>><?php echo _l('partially_paid'); ?></option>
                                 <option value="paid" <?php echo ($bil_payment_status_filter_val == 'paid') ? 'selected' : ''; ?>><?php echo _l('paid'); ?></option>
                              </select>
                           </div>

                           <div class="col-md-1 form-group">
                              <a href="javascript:void(0)" class="btn btn-info btn-icon reset_vbt_all_filters">
                                 <?php echo _l('reset_filter'); ?>
                              </a>
                           </div>
                        </div></br>

                        <div class="col-md-offset-9 col-md-3">
                           <div style="align-items: end;padding: 0px;">
                              <?php echo form_open_multipart(admin_url('purchase/import_file_xlsx_vendor_billing_tracker'), array('id' => 'import_form')); ?>
                              <?php echo render_input('file_csv', 'choose_excel_file', '', 'file'); ?>
                              <div class="form-group">
                                 <button id="uploadfile" type="button" class="btn btn-info import" onclick="return uploadfilecsv(this);"><?php echo _l('import'); ?></button>
                                 <a href="<?php echo site_url('modules/purchase/uploads/file_sample/Sample_vendor_payment_tracker_item_en.xlsx') ?>" class="btn btn-primary">Template</a>
                              </div>
                              <?php echo form_close(); ?>
                              <div class="form-group" id="file_upload_response">
                              </div>
                           </div>
                        </div>
                  </div>

                  <!-- <div class="row">
                     <div id="scroll-slider">
                        <div id="scroll-thumb"></div>
                     </div>
                  </div> -->
                  </br>

                  <div class="btn-group show_hide_columns" id="show_hide_columns">
                     <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 4px 7px;">
                        <i class="fa fa-cog"></i> <?php  ?> <span class="caret"></span>
                     </button>
                     <div class="dropdown-menu" style="padding: 10px; min-width: 250px;">
                        <div>
                           <input type="checkbox" id="select-all-columns"> <strong><?php echo _l('select_all'); ?></strong>
                        </div>
                        <hr>
                        <?php
                        $columns = [
                           'id',
                           'invoice_code',
                           'invoice_number',
                           'vendor',
                           'group_pur',
                           'invoice_date',
                           'amount_without_tax',
                           'vendor_submitted_tax_amount',
                           'certified_amount',
                           'bil_payment_date',
                           'bil_payment_made',
                           'bil_tds',
                           'bil_total',
                           'ril_bill_no',
                           'ril_previous',
                           'ril_this_bill',
                           'ril_date',
                           'ril_amount',
                           'remarks',
                        ];
                        ?>
                        <div>
                           <?php foreach ($columns as $key => $label): ?>
                              <input type="checkbox" class="toggle-column" value="<?php echo $key; ?>" checked>
                              <?php echo _l($label); ?><br>
                           <?php endforeach; ?>
                        </div>
                     </div>
                  </div>
                  <div class="">
                     <table class="dt-table-loading table table-table_pur_invoice_payments">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th><?php echo _l('invoice_code'); ?></th>
                              <th><?php echo _l('invoice_number'); ?></th>
                              <th><?php echo _l('vendor'); ?></th>
                              <th><?php echo _l('group_pur'); ?></th>
                              <th><?php echo _l('invoice_date'); ?></th>
                              <th><?php echo _l('amount_without_tax'); ?></th>
                              <th><?php echo _l('vendor_submitted_tax_amount'); ?></th>
                              <th><?php echo _l('final_certified_amount'); ?></th>
                              <th><?php echo _l('bil_payment_date'); ?></th>
                              <th><?php echo _l('bil_payment_made'); ?></th>
                              <th><?php echo _l('bil_tds'); ?></th>
                              <th><?php echo _l('bil_total'); ?></th>
                              <th><?php echo _l('ril_bill_no'); ?></th>
                              <th><?php echo _l('ril_previous'); ?></th>
                              <th><?php echo _l('ril_this_bill'); ?></th>
                              <th><?php echo _l('ril_date'); ?></th>
                              <th><?php echo _l('ril_amount'); ?></th>
                              <th><?php echo _l('remarks'); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="total_vendor_submitted_amount_without_tax"></td>
                              <td class="total_vendor_submitted_tax_amount"></td>
                              <td class="total_final_certified_amount"></td>
                              <td></td>
                              <td class="total_payment_made"></td>
                              <td class="total_bil_tds"></td>
                              <td class="total_bil_total"></td>
                              <td></td>
                              <td class="total_ril_previous"></td>
                              <td class="total_ril_this_bill"></td>
                              <td></td>
                              <td class="total_ril_amount"></td>
                              <td></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php init_tail(); ?>
<script>
   $(document).ready(function() {
      var table = $('.table-table_pur_invoice_payments').DataTable();

      // On page load, fetch and apply saved preferences for the logged-in user
      $.ajax({
         url: admin_url + 'purchase/getPreferences',
         type: 'GET',
         dataType: 'json',
         success: function(data) {
            console.log("Retrieved preferences:", data);

            // Ensure DataTable is initialized
            let table = $('.table-table_pur_invoice_payments').DataTable();

            // Loop through each toggle checkbox to update column visibility
            $('.toggle-column').each(function() {
               // Parse the column index (ensuring it's a number)
               let colIndex = parseInt($(this).val(), 10);

               // Use the saved preference if available; otherwise, default to visible ("true")
               let prefValue = data.preferences && data.preferences[colIndex] !== undefined ?
                  data.preferences[colIndex] :
                  "true";

               // Convert string to boolean if needed
               let isVisible = (typeof prefValue === "string") ?
                  (prefValue.toLowerCase() === "true") :
                  prefValue;

               // Set column visibility but prevent immediate redraw (redraw = false)
               table.column(colIndex).visible(isVisible, false);
               // Update the checkbox state accordingly
               $(this).prop('checked', isVisible);
            });

            // Finally, adjust columns and redraw the table once
            table.columns.adjust().draw();

            // Update the "Select All" checkbox based on individual toggle states
            let allChecked = $('.toggle-column').length === $('.toggle-column:checked').length;
            $('#select-all-columns').prop('checked', allChecked);
         },
         error: function() {
            console.error('Could not retrieve column preferences.');
         }
      });

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

         // Save updated preferences
         saveColumnPreferences();
      });

      // Prevent dropdown from closing when clicking inside
      $('.dropdown-menu').on('click', function(e) {
         e.stopPropagation();
      });

      // Function to collect and save preferences via AJAX
      function saveColumnPreferences() {
         var preferences = {};
         $('.toggle-column').each(function() {
            preferences[$(this).val()] = $(this).is(':checked');
         });

         $.ajax({

            url: admin_url + 'purchase/savePreferences',
            type: 'POST',
            data: {
               preferences: preferences
            },
            success: function(response) {
               console.log('Preferences saved successfully.');
            },
            error: function() {
               console.error('Failed to save preferences.');
            }
         });
      }
   });

   function uploadfilecsv() {
      "use strict";

      if (($("#file_csv").val() != '') && ($("#file_csv").val().split('.').pop() == 'xlsx')) {
         var formData = new FormData();
         formData.append("file_csv", $('#file_csv')[0].files[0]);
         if (<?php echo  pur_check_csrf_protection(); ?>) {
            formData.append(csrfData.token_name, csrfData.hash);
         }

         $.ajax({
            url: admin_url + 'purchase/import_file_xlsx_vendor_payment_tracker',
            method: 'post',
            data: formData,
            contentType: false,
            processData: false

         }).done(function(response) {
            response = JSON.parse(response);
            $("#file_csv").val(null);
            $("#file_csv").change();
            $(".panel-body").find("#file_upload_response").html();

            if ($(".panel-body").find("#file_upload_response").html() != '') {
               $(".panel-body").find("#file_upload_response").empty();
            };
            $("#file_upload_response").append("<h4><?php echo _l("_Result") ?></h4><h5><?php echo _l('import_line_number') ?> :" + response.total_rows + " </h5>");
            $("#file_upload_response").append("<h5><?php echo _l('import_line_number_success') ?> :" + response.total_row_success + " </h5>");
            $("#file_upload_response").append("<h5><?php echo _l('import_line_number_failed') ?> :" + response.total_row_false + " </h5>");
            if ((response.total_row_false > 0) || (response.total_rows_data_error > 0)) {
               $("#file_upload_response").append('<a href="' + site_url + response.filename + '" class="btn btn-warning"  ><?php echo _l('download_file_error') ?></a>');
            }
            if (response.total_rows < 1) {
               alert_float('warning', response.message);
            }
         });
         return false;

      } else if ($("#file_csv").val() != '') {
         alert_float('warning', "<?php echo _l('_please_select_a_file') ?>");
      }

   }
   // Initialize the DataTable
   var table_pur_invoice_payments = $('.table-table_pur_invoice_payments').DataTable();
</script>
</body>
</html>