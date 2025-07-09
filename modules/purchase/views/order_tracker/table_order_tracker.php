<?php

defined('BASEPATH') or exit('No direct script access allowed');

$module_name = 'order_tracker';
$type_filter_name = 'order_tracker_type';
$rli_filter_name = 'rli_filter';
$vendors_filter_name = 'vendors';
$kind_filter_name = 'order_tracker_kind';
$budget_head_filter_name = 'budget_head';
$order_type_filter_name = 'order_type_filter';
$project_filter_name = 'projects';
$aw_unw_order_status_filter_name = 'aw_unw_order_status';

// Define columns for the table
$aColumns = [
    '1', // Sr.No
    'order_date',
    db_prefix() . 'pur_vendor.company as company_name',
    'item_scope',
    'quantity',
    'rate',
    'owners_company',
    db_prefix() . 'pur_order_tracker.status as order_status'
];

$sIndexColumn = 'id';
$sTable = db_prefix() . 'pur_order_tracker';

$join = [
    'LEFT JOIN ' . db_prefix() . 'pur_vendor ON ' . db_prefix() . 'pur_vendor.userid = ' . db_prefix() . 'pur_order_tracker.comapny',
    'LEFT JOIN ' . db_prefix() . 'ware_unit_type ON ' . db_prefix() . 'ware_unit_type.unit_type_id = ' . db_prefix() . 'pur_order_tracker.unit',
    'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'pur_order_tracker.owners_company',
];

$where = [];

// Add any filters you need here
$vendors = $this->ci->input->post('vendors');
if (isset($vendors)) {
    $where_vendors = '';
    foreach ($vendors as $t) {
        if ($t != '') {
            if ($where_vendors == '') {
                $where_vendors .= ' AND (' . db_prefix() . 'pur_order_tracker.comapny = "' . $t . '"';
            } else {
                $where_vendors .= ' or ' . db_prefix() . 'pur_order_tracker.comapny = "' . $t . '"';
            }
        }
    }
    if ($where_vendors != '') {
        $where_vendors .= ')';
        array_push($where, $where_vendors);
    }
}

$having = '';

// Query and process data
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    db_prefix() . 'pur_order_tracker.id',
    'comapny',
    'order_date',
    'item_scope',
    'quantity',
    'rate',
    'owners_company',
    db_prefix() . 'pur_order_tracker.status as order_status',
    'unit',
    db_prefix() . 'pur_vendor.company as company_name',
    db_prefix() . 'ware_unit_type.unit_code as unit_name',
    db_prefix() . 'projects.name as owners_comapny_name',
]);

$output  = $result['output'];
$rResult = $result['rResult'];

$sr = 1;
foreach ($rResult as $aRow) {
    $row = [];
    
    // Sr.No
    $row[] = $sr;
    
    // Order Date
    $row[] = date('d M, Y', strtotime($aRow['order_date']));
    
    // Company Name
    $row[] = $aRow['company_name'];
    
    // Item Scope
    $row[] = $aRow['item_scope'];
    
    // Quantity (with unit if available)
    $quantity = $aRow['quantity'];
    if (!empty($aRow['unit_name'])) {
        $quantity .= ' ' . $aRow['unit_name'];
    }
    $row[] = $quantity;
    
    // Rate
    $row[] = app_format_money($aRow['rate'], get_base_currency()->symbol);
    
    // Owner Company
    $row[] = $aRow['owners_comapny_name'];
    
    // Status
     $order_status_labels = [
            1 => ['label' => 'info', 'table' => 'bill_dispatched', 'text' => _l('Bill Dispatched')],
            2 => ['label' => 'success', 'table' => 'delivered', 'text' => _l('Delivered')],
            3 => ['label' => 'warning', 'table' => 'order_received', 'text' => _l('Order Received')],
            4 => ['label' => 'danger', 'table' => 'rejected', 'text' => _l('Rejected')],
         ];
         // Start generating the HTML
         $oreder_status = '';
         if (isset($order_status_labels[$aRow['order_status']])) {
            $status = $order_status_labels[$aRow['order_status']];
            $oreder_status = '<span class="inline-block label label-' . $status['label'] . '" id="status_aw_uw_span_' . $aRow['id'] . '" task-status-table="' . $status['table'] . '">' . $status['text'];
         } else {
            $oreder_status = '<span class="inline-block label " id="status_aw_uw_span_' . $aRow['id'] . '" >';
         }

         if (has_permission('order_tracker', '', 'edit') || is_admin()) {
            $oreder_status .= '<div class="dropdown inline-block mleft5 table-export-exclude">';
            $oreder_status .= '<a href="#" class="dropdown-toggle text-dark" id="tablePurOderStatus-' . $aRow['id'] . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $oreder_status .= '<span data-toggle="tooltip" title="' . _l('ticket_single_change_status') . '"><i class="fa fa-caret-down" aria-hidden="true"></i></span>';
            $oreder_status .= '</a>';

            $oreder_status .= '<ul class="dropdown-menu dropdown-menu-right" aria-labelledby="tablePurOderStatus-' . $aRow['id'] . '">';

            foreach ($order_status_labels as $key => $status) {
               if ($key != $aRow['order_status']) {
                  $oreder_status .= '<li>
                       <a href="javascript:void(0);" onclick="change_order_status(' . $key . ', ' . $aRow['id'] . '); return false;">
                           ' . $status['text'] . '
                       </a>
                   </li>';
               }
            }


            $oreder_status .= '</ul>';
            $oreder_status .= '</div>';
         }

         $oreder_status .= '</span>';
         $row[] = $oreder_status;
    
    $output['aaData'][] = $row;
    $sr++;
}
