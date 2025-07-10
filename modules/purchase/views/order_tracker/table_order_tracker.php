<?php

defined('BASEPATH') or exit('No direct script access allowed');

$module_name = 'order_tracker';
$vendors_filter_name = 'vendors';
$project_filter_name = 'projects_new';
$order_status_filter_name = 'order_tracker_status';

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

if ($this->ci->input->post('order_tracker_status') && count($this->ci->input->post('order_tracker_status')) > 0) {
    array_push($where, 'AND ' . db_prefix() . 'pur_order_tracker.status IN (' . implode(',', $this->ci->input->post('order_tracker_status')) . ')');
}

if (
    $this->ci->input->post('projects_new')
    && count($this->ci->input->post('projects_new')) > 0
) {
    array_push($where, 'AND ' . db_prefix() . 'pur_order_tracker.owners_company IN (' . implode(',', $this->ci->input->post('projects_new')) . ')');
}

if (
    $this->ci->input->post('vendors')
    && count($this->ci->input->post('vendors')) > 0
) {
    array_push($where, 'AND ' . db_prefix() . 'pur_order_tracker.comapny IN (' . implode(',', $this->ci->input->post('vendors')) . ')');
}

$project_filter_name_value = !empty($this->ci->input->post('projects_new')) ? implode(',', $this->ci->input->post('projects_new')) : NULL;
update_module_filter($module_name, $project_filter_name, $project_filter_name_value);


$status_filter_name_value = !empty($this->ci->input->post('order_tracker_status')) ? implode(',', $this->ci->input->post('order_tracker_status')) : NULL;
update_module_filter($module_name, $order_status_filter_name, $status_filter_name_value);

$vendor_filter_name_value = !empty($this->ci->input->post('vendors')) ? implode(',', $this->ci->input->post('vendors')) : NULL;
update_module_filter($module_name, $vendors_filter_name, $vendor_filter_name_value);

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
$this->ci->load->model('purchase/purchase_model');
$this->ci->load->model('projects_model');
$vendor_list  = $this->ci->purchase_model->get_vendor();
$vendor_by_id       = array_column($vendor_list,  null, 'userid');

$projects_list = $this->ci->projects_model->get();
$projects_by_id = array_column($projects_list, null, 'id');

$unit_list = $this->ci->purchase_model->get_units();
$unit_by_id = array_column($unit_list, null, 'id');
$sr = 1;
foreach ($rResult as $aRow) {
    $row = [];

    // Sr.No
    $row[] = $sr;

    // Order Date
    // $row[] = date('d M, Y', strtotime($aRow['order_date']));

    $order_date = '<input type="date" class="form-control order-date-input" 
                        value="' . $aRow['order_date'] . '" 
                        data-id="' . $aRow['id'] . '" ">';
    $row[] = $order_date;

    $company_raw = trim($aRow['comapny']);
    if ($company_raw !== '') {
        // Vendor is already selected
        $name = $vendor_html = '';
        if (isset($vendor_by_id[$company_raw])) {
            $u = $vendor_by_id[$company_raw];
            $name = $u['company'];
        }
        $vendor_html = '<span class="vendor-display" 
                           data-id="' . $aRow['id'] . '" 
                           data-vendor="' . html_escape($company_raw) . '">'
            . html_escape($name) .
            '</span>';
    } else {
        // No vendor selected - show dropdown
        $vendor_html = '<select class="form-control vendor-input selectpicker" 
                           data-live-search="true" 
                           data-width="100%" 
                           data-none-selected-text="None selected"
                           data-id="' . $aRow['id'] . '">
                           ';

        foreach ($vendor_by_id as $vendor) {
            $vendor_html .= '<option value="' . $vendor['userid'] . '">'
                . html_escape($vendor['company'])
                . '</option>';
        }

        $vendor_html .= '</select>';

        // Initialize selectpicker if it exists
        $vendor_html .= '<script>
                           if($.fn.selectpicker) {
                              $(".vendor-input").selectpicker();
                           }
                        </script>';
    }

    // Company Name
    $row[] = $vendor_html;

    // Item Scope
    $item_scope = '';
    if (!empty($aRow['item_scope'])) {
        // Display as plain text
        $item_scope = '<span class="item-scope-display" data-id="' . $aRow['id'] . '" >' .
            $aRow['item_scope'] .
            '</span>';
    } else {
        $item_scope = '<input type="text" class="form-control item-scope-input" 
                         placeholder="Enter Item Scope" 
                         data-id="' . $aRow['id'] . '" 
                        >';
    }

    $row[] = $item_scope;

    // Quantity (with unit if available)
    $quantity_html = '';
    if (!empty($aRow['quantity'])) {
        // Display as plain text
        $quantity_html = '<span class="quantity-display" data-id="' . $aRow['id'] . '" >' .
            $aRow['quantity'] .
            '</span>';
    } else {
        $quantity_html = '<input type="text" class="form-control quantity-input" 
                         placeholder="Enter Quantity" 
                         data-id="' . $aRow['id'] . '" 
                        >';
    }
    $quantity = $quantity_html;
    if (!empty($aRow['unit'])) {
        $unit_name_raw = trim($aRow['unit']);
        if ($unit_name_raw !== '') {
            // Vendor is already selected
            $name = $unit_html = '';
            if (isset($unit_by_id[$unit_name_raw])) {
                $u = $unit_by_id[$unit_name_raw];
                $name = $u['label'];
            }
            $unit_html = '<span class="unit-display" 
                           data-id="' . $aRow['id'] . '" 
                           data-unit="' . html_escape($unit_name_raw) . '">'
                . html_escape($name) .
                '</span>';
        } else {
            $unit_html = '<select class="form-control unit-input selectpicker" 
                           data-live-search="true" 
                           data-width="100%" 
                           data-none-selected-text="None selected"
                           data-id="' . $aRow['id'] . '">
                           ';

            foreach ($unit_by_id as $unit) {
                $unit_html .= '<option value="' . $unit['id'] . '">'
                    . html_escape($unit['label'])
                    . '</option>';
            }

            $unit_html .= '</select>';

            // Initialize selectpicker if it exists
            $unit_html .= '<script>
                           if($.fn.selectpicker) {
                              $(".unit-input").selectpicker();
                           }
                        </script>';
        }
        $quantity .= ' ' . $unit_html;
    }
    $row[] = $quantity;

    // Rate
    $rate_html = '';
    if (!empty($aRow['rate'])) {
        // Display as plain text
        $rate_html = '<span class="rate-display" data-id="' . $aRow['id'] . '">' .
            app_format_money($aRow['rate'], '₹') .
            '</span>';
    } else {
        // Render as an editable input if no total exists
        $rate_html = '<input type="number" class="form-control rate-input" 
                         placeholder="Enter Conatact Rate" 
                         data-id="' . $aRow['id'] . '" >';
    }
    $row[] = $rate_html;

    // Owner Company
    $owners_company_raw = trim($aRow['owners_company']);
    if ($owners_company_raw !== '') {
        // Vendor is already selected
        $name = $company_html = '';
        if (isset($projects_by_id[$owners_company_raw])) {
            $u = $projects_by_id[$owners_company_raw];
            $name = $u['name'];
        }
        $company_html = '<span class="company-display" 
                           data-id="' . $aRow['id'] . '" 
                           data-company="' . html_escape($owners_company_raw) . '">'
            . html_escape($name) .
            '</span>';
    } else {
        $company_html = '<select class="form-control company-input selectpicker" 
                           data-live-search="true" 
                           data-width="100%" 
                           data-none-selected-text="None selected"
                           data-id="' . $aRow['id'] . '">
                           ';

        foreach ($projects_by_id as $project) {
            $company_html .= '<option value="' . $project['id'] . '">'
                . html_escape($project['name'])
                . '</option>';
        }

        $company_html .= '</select>';

        // Initialize selectpicker if it exists
        $company_html .= '<script>
                           if($.fn.selectpicker) {
                              $(".company-input").selectpicker();
                           }
                        </script>';
    }
    $row[] = $company_html;

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
