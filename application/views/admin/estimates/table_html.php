<?php defined('BASEPATH') or exit('No direct script access allowed');

$table_data = array(
   'Budget #',
   'Budgeted Amount',
   'Change Order Amount',
   'Total Amount',
   'Invoiced Amount',
   'Remaining Amount',
   _l('estimates_total_tax'),
   array(
      'name'=>_l('invoice_estimate_year'),
      'th_attrs'=>array('class'=>'not_visible')
   ),
   array(
      'name'=>_l('estimate_dt_table_heading_client'),
      'th_attrs'=>array('class'=> (isset($client) ? 'not_visible' : ''))
   ),
   _l('project'),
   _l('estimate_dt_table_heading_date'),
   // _l('estimate_dt_table_heading_expirydate'),
   // _l('reference_no'),
   _l('estimate_dt_table_heading_status'),
   _l('tags'),
);

$custom_fields = get_custom_fields('estimate',array('show_on_table'=>1));

foreach($custom_fields as $field){
   array_push($table_data, [
     'name' => $field['name'],
     'th_attrs' => array('data-type'=>$field['type'], 'data-custom-field'=>1),
  ]);
}

$table_data = hooks()->apply_filters('estimates_table_columns', $table_data);

render_datatable($table_data, isset($class) ? $class : 'estimates', [],['id'=>$table_id ?? 'estimates']);
