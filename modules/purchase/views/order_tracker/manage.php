<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style>
   .form-inline textarea.form-control {

      width: auto !important;
   }

   .label-purple {
      background-color: rgb(205, 180, 252) !important;
      color: rgb(109, 0, 159);
   }

   .label-teal {
      background-color: #baf8ff;
      color: #0097A7;
   }

   .label-green {
      background-color: #d0fdd2;
      color: #0f8c14;
   }

   .label-secondary {
      background-color: #e1eef9;
      color: #6c757d;
   }

   .label-orange {
      background-color: #f8eedb;
      color: #FFA500;
   }

   .show_hide_columns {
      position: absolute;
      z-index: 999;
      left: 140px;
   }

   .export-btn-div {
      position: absolute;
      z-index: 999;
      left: 189px;
   }

   .loader-container {
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 9999;
   }

   .loader-gif {
      width: 100px;
      /* Adjust the size as needed */
      height: 100px;
   }
</style>
<?php $module_name = 'order_tracker'; ?>
<div id="wrapper">
   <div class="content">
      <div class="loader-container hide" id="loader-container">
         <img src="<?php echo site_url('modules/purchase/uploads/lodder/lodder.gif') ?>" alt="Loading..." class="loader-gif">
      </div>
      <div class="row">
         <div class="panel_s mbot10">
            <div class="panel-body">
               <div class="row">
                  <div class="col-md-12">
                     <h4 class="no-margin font-bold"><i class="fa fa-clipboard" aria-hidden="true"></i> <?php echo _l('order_tracker'); ?></h4>
                     <hr />
                  </div>
               </div>

               <div class="row">
                  <div class="_buttons col-md-12">
                     <button class="btn btn-info pull-left mright10 display-block" style="margin-right: 10px;" data-toggle="modal" data-target="#addNewRowModal">
                        <i class="fa fa-plus"></i> <?php echo _l('New'); ?>
                     </button>

                     <div class="all_ot_filters">

                        


                        
                        <div class="col-md-2">
                           <?php
                           $vendors_filter = get_module_filter($module_name, 'vendors');
                           $vendors_filter_val = !empty($vendors_filter) ? explode(",", $vendors_filter->filter_value) : '';
                           echo render_select('vendors[]', $vendors, array('userid', 'company'), '', $vendors_filter_val, array('data-width' => '100%', 'data-none-selected-text' => _l('Companies'), 'multiple' => true, 'data-actions-box' => true), array(), 'no-mbot', '', false);
                           ?>
                        </div>

                        <div class="col-md-2">
                           <?php
                           $projects_filter = get_module_filter($module_name, 'projects_new');
                           if (!empty($projects_filter) && $projects_filter->filter_value != '') {
                              $projects_filter_val = !empty($projects_filter) ? explode(",", $projects_filter->filter_value) : '';
                           } else {
                              $projects_filter_val = explode(",", 1);
                           }

                           echo render_select('projects_new[]', $projects, array('id', 'name'), '', $projects_filter_val, array('data-width' => '100%', 'data-none-selected-text' => _l('project'), 'multiple' => true, 'data-actions-box' => true), array(), 'no-mbot', '', false);
                           ?>
                        </div>

                        <div class="col-md-2 form-group">

                           <?php
                           $aw_unw_order_status_type_filter = get_module_filter($module_name, 'order_tracker_status');
                           $aw_unw_order_status_type_filter_val = !empty($aw_unw_order_status_type_filter) ? explode(",", $aw_unw_order_status_type_filter->filter_value) : [];
                           $order_status = [
                              1 => ['id' => '1', 'name' => _l('Bill Dispatched')],
                              2 => ['id' => '2', 'name' => _l('Delivered')],
                              3 => ['id' => '3', 'name' => _l('Order Received')],
                              4 => ['id' => '4', 'name' => _l('Rejected')],
                           ];

                           echo render_select('order_tracker_status[]', $order_status, array('id', 'name'), '', $aw_unw_order_status_type_filter_val, array('data-width' => '100%', 'data-none-selected-text' => _l('Order Status'), 'multiple' => true, 'data-actions-box' => true), array(), 'no-mbot', '', false); ?>
                        </div>

                        <div class="col-md-1 form-group">
                           <a href="javascript:void(0)" class="btn btn-info btn-icon reset_all_ot_filters">
                              <?php echo _l('reset_filter'); ?>
                           </a>
                        </div>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12" id="small-table">
               <div class="panel_s">
                  <div class="panel-body">
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
                              _l('Sr.No'),
                              _l('order_date'),
                              _l('Companies'),
                              _l('Item Scope'),
                              _l('Quantity'),
                              _l('Rate'),
                              _l('Owner Company'),
                              _l('Status'),
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
                     <div class="btn-group export-btn-div" id="export-btn-div">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 4px 7px;">
                           <i class="fa fa-download"></i> <?php echo _l('Export'); ?> <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu" style="padding: 10px;min-width: 94px;">
                           <a class="dropdown-item export-btn" href="<?php echo admin_url('purchase/order_tracker_pdf'); ?>" data-type="pdf">
                              <i class="fa fa-file-pdf text-danger"></i> PDF
                           </a><br>
                           <a class="dropdown-item export-btn" href="<?php echo admin_url('purchase/order_tracker_excel'); ?>" data-type="excel">
                              <i class="fa fa-file-excel text-success"></i> Excel
                           </a>
                        </div>
                     </div>

                     <div class="">
                        <table class="dt-table-loading table table-table_order_tracker">
                           <thead>
                              <tr>
                                 <th><?php echo _l('Sr.No'); ?></th>
                                 <th><?php echo _l('order_date'); ?></th>
                                 <th><?php echo _l('Companies'); ?></th>
                                 <th><?php echo _l('Item Scope'); ?></th>
                                 <th><?php echo _l('Quantity'); ?></th>
                                 <th><?php echo _l('Rate'); ?></th>
                                 <th><?php echo _l('Owner Company'); ?></th>
                                 <th><?php echo _l('Status'); ?></th>
                              </tr>
                           </thead>
                           <tbody>
                           </tbody>
                        </table>
                     </div>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="addNewRowModal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document" style="width: 98%;">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('Add New Order'); ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <!-- <div class="col-md-8 pull-right">
               <div class="col-md-2 pull-right">
                  <div id="dowload_file_sample" style="margin-top: 22px;">
                     <label for="file_csv" class="control-label"> </label>
                     <a href="<?php echo site_url('modules/purchase/uploads/file_sample/Sample_import_order_tracker_en.xlsx') ?>" class="btn btn-primary">Template</a>
                  </div>
               </div>
               <div class="col-md-4 pull-right" style="display: flex;align-items: end;padding: 0px;">
                  <?php echo form_open_multipart(admin_url('purchase/import_file_xlsx_order_tracker_items'), array('id' => 'import_form')); ?>
                  <?php echo form_hidden('leads_import', 'true'); ?>
                  <?php echo render_input('file_csv', 'choose_excel_file', '', 'file'); ?>

                  <div class="form-group" style="margin-left: 10px;">
                     <button id="uploadfile" type="button" class="btn btn-info import" onclick="return uploadfilecsv(this);"><?php echo _l('import'); ?></button>
                  </div>
                  <?php echo form_close(); ?>
               </div>

            </div> -->
            <div class="col-md-12 ">
               <div class="form-group pull-right" id="file_upload_response">

               </div>

            </div>
            <div id="box-loading" class="pull-right">

            </div>
         </div>
         <div class="modal-body invoice-item">
            <div class="row">
               <div class="col-md-12">
                  <div class="table-responsive" style="overflow-x: unset !important;">
                     <?php
                     echo form_open_multipart('', array('id' => 'order_tracker-form'));
                     ?>
                     <table class="table order-tracker-items-table items table-main-invoice-edit has-calculations no-mtop">
                        <thead>
                           <tr>
                              <th align="left"><?php echo _l('serial_no'); ?></th>
                              <th align="left"><?php echo _l('order_date'); ?></th>
                              <th align="left"><?php echo _l('Comapany Name'); ?></th>     
                              <th align="left"><?php echo _l('Item Scope'); ?></th>
                              <th align="left"><?php echo _l('Quantity'); ?></th>
                              <th align="left"><?php echo _l('Rate'); ?></th>
                              <th align="left"><?php echo _l('Owner Company'); ?></th>
                              <th align="center"><i class="fa fa-cog"></i></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php echo  $order_tracker_row_template; ?>
                        </tbody>
                     </table>
                     <button type="submit" class="btn btn-info pull-right"><?php echo _l('Save'); ?></button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="viewOrderAttachmentModal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document" style="width: 70%;">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo _l('attachment'); ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="view_order_attachment_modal">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="order_tracker_file_data"></div>

   <?php init_tail(); ?>
   <?php require 'modules/purchase/assets/js/import_excel_items_order_tracker_js.php'; ?>
   <?php require 'modules/purchase/assets/js/order_tracker_js.php'; ?>
   </body>

   </html>