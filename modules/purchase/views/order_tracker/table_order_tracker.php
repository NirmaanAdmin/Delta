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
    $status_badge = '';
    switch ($aRow['order_status']) {
        case 1:
            $status_badge = '<span class="label label-warning">' . _l('Bill Dispatched') . '</span>';
            break;
        case 2:
            $status_badge = '<span class="label label-success">' . _l('Delivered') . '</span>';
            break;
        case 3:
            $status_badge = '<span class="label label-info">' . _l('Order Received') . '</span>';
            break;
        case 4:
            $status_badge = '<span class="label label-danger">' . _l('Rejected'). '</span>';
    }
    $row[] = $status_badge;
    
    $output['aaData'][] = $row;
    $sr++;
}
