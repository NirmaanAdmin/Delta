<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="col-md-4 col-md-offset-4 text-center mbot15">
    <h1 class="text-uppercase register-heading"><?php echo _l('clients_register_heading'); ?></h1>
</div>
<div class="col-md-10 col-md-offset-1">
    <?php echo form_open('purchase/authentication_vendor/register', [
        'id' => 'register-form',
        'enctype' => 'multipart/form-data'
    ]); ?>
    <div class="panel_s">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="bold register-contact-info-heading"><?php echo _l('client_register_contact_info'); ?></h4>
                    <div class="form-group mtop15 register-firstname-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="firstname"><?php echo _l('clients_firstname'); ?></label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo set_value('firstname'); ?>">
                        <?php echo form_error('firstname'); ?>
                    </div>
                    <div class="form-group register-lastname-group">
                        <label class="control-label" for="lastname"><?php echo _l('clients_lastname'); ?></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo set_value('lastname'); ?>">
                        <?php echo form_error('lastname'); ?>
                    </div>
                    <div class="form-group register-email-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="email"><?php echo _l('clients_email'); ?></label>
                        <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>">
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group register-contact-phone-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="contact_phonenumber"><?php echo _l('clients_phone'); ?></label>
                        <input type="text" class="form-control" name="contact_phonenumber" id="contact_phonenumber" value="<?php echo set_value('contact_phonenumber'); ?>">
                    </div>
                    <div class="form-group register-website-group">
                        <label class="control-label" for="website"><?php echo _l('client_website'); ?></label>
                        <input type="text" class="form-control" name="website" id="website" value="<?php echo set_value('website'); ?>">
                    </div>
                    <div class="form-group register-position-group">
                        <label class="control-label" for="title"><?php echo _l('contact_position'); ?></label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title'); ?>">
                    </div>
                    <div class="form-group register-password-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="password"><?php echo _l('clients_register_password'); ?></label>
                        <input type="password" class="form-control" name="password" id="password">
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group register-password-repeat-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="passwordr"><?php echo _l('clients_register_password_repeat'); ?></label>
                        <input type="password" class="form-control" name="passwordr" id="passwordr">
                        <?php echo form_error('passwordr'); ?>
                    </div>
                    <div class="form-group">
                        <label for="bank_detail" class="control-label"><?php echo _l('bank_detail'); ?></label>
                        <textarea id="bank_detail" name="bank_detail" class="form-control" rows="4">
                        </textarea>
                    </div>
                   
                </div>
                <div class="col-md-6">
                    <h4 class="bold register-company-info-heading"><?php echo _l('client_register_company_info'); ?></h4>
                    <div class="form-group mtop15 register-company-group">
                        <small class="req text-danger">* </small>
                        <label class="control-label" for="company"><?php echo _l('clients_company'); ?></label>
                        <input type="text" class="form-control" name="company" id="company" value="<?php echo set_value('company'); ?>">
                        <?php echo form_error('company'); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group register-vat-group">
                                <small class="req text-danger">* </small>
                                <label class="control-label" for="vat"><?php echo _l('vendor_vat'); ?></label>
                                <input type="text" class="form-control" name="vat" id="vat" value="<?php echo set_value('vat'); ?>">
                                <?php echo form_error('vat'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group register-vat-group">
                                <label class="control-label"><?php echo _l('attachment'); ?></label>
                                <input type="file" name="vat_file" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group register-company-phone-group">
                        <label class="control-label" for="phonenumber"><?php echo _l('clients_phone'); ?></label>
                        <input type="text" class="form-control" name="phonenumber" id="phonenumber" value="<?php echo set_value('phonenumber'); ?>">
                    </div>
                    <div class="form-group register-country-group">
                        <label class="control-label" for="lastname"><?php echo _l('clients_country'); ?></label>
                        <select data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" data-live-search="true" name="country" class="form-control" id="country">
                            <option value=""></option>
                            <?php foreach(get_all_countries() as $country){ ?>
                            <option value="<?php echo pur_html_entity_decode($country['country_id']); ?>"<?php if(get_option('customer_default_country') == $country['country_id']){echo ' selected';} ?> <?php echo set_select('country', $country['country_id']); ?>><?php echo pur_html_entity_decode($country['short_name']); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group register-city-group">
                        <label class="control-label" for="city"><?php echo _l('clients_city'); ?></label>
                        <input type="text" class="form-control" name="city" id="city" value="<?php echo set_value('city'); ?>">
                    </div>
                    <div class="form-group register-address-group">
                        <label class="control-label" for="address"><?php echo _l('clients_address'); ?></label>
                        <input type="text" class="form-control" name="address" id="address" value="<?php echo set_value('address'); ?>">
                    </div>
                    <div class="form-group register-zip-group">
                        <label class="control-label" for="zip"><?php echo _l('clients_zip'); ?></label>
                        <input type="text" class="form-control" name="zip" id="zip" value="<?php echo set_value('zip'); ?>">
                    </div>
                    <div class="form-group register-state-group">
                        <label class="control-label" for="state"><?php echo _l('clients_state'); ?></label>
                        <input type="text" class="form-control" name="state" id="state" value="<?php echo set_value('state'); ?>">
                    </div>

                </div>

                <?php if(render_custom_fields( 'vendors','') != ''){ ?>
                <div class="col-md-12">
                        
                            <hr class="hr-panel-separator" />
                        

                        <?php echo render_custom_fields( 'vendors',''); ?>
                </div>
                <?php } ?>
          
       </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="mbot15 mtop20 company-profile-shipping-address-heading"><?php echo _l('details_of_work_completed'); ?></h4>
                <div class="table-responsive s_table">
                    <table class="table items no-mtop" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th align="center"><?php echo _l('client'); ?></th>
                                <th align="center"><?php echo _l('type_of_project'); ?></th>
                                <th align="center"><?php echo _l('location'); ?></th>
                                <th align="center"><?php echo _l('mini_contractor'); ?></th>
                                <th align="center"><?php echo _l('scope_of_works'); ?></th>
                                <th align="center"><?php echo _l('contract_prices'); ?></th>
                                <th align="center"><?php echo _l('start_date'); ?></th>
                                <th align="center"><?php echo _l('end_date'); ?></th>
                                <th align="center"><?php echo _l('size_of_project'); ?></th>
                                <th align="center"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody class="work_completed_main">
                            <tr class="item">
                                <td>
                                    <input type="text" name="client" class="form-control" placeholder="<?php echo _l('client'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="type_of_project" class="form-control" placeholder="<?php echo _l('type_of_project'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="location" class="form-control" placeholder="<?php echo _l('location'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="mini_contractor" class="form-control" placeholder="<?php echo _l('mini_contractor'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="scope_of_works" class="form-control" placeholder="<?php echo _l('scope_of_works'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="contract_prices" class="form-control" placeholder="<?php echo _l('contract_prices'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="start_date" class="form-control" placeholder="<?php echo _l('start_date'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="end_date" class="form-control" placeholder="<?php echo _l('end_date'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="size_of_project" class="form-control" placeholder="<?php echo _l('size_of_project'); ?>">
                                </td>
                                <td>
                                    <?php
                                    $new_item = true;
                                    ?>
                                    <button type="button" onclick="add_vendor_work_completed_item_to_table('undefined','undefined',<?php echo e($new_item); ?>); return false;"
                                        class="btn pull-right btn-primary"><i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="removed-work-completed"></div>
                </div>
            </div>

            <div class="col-md-12">
                <h4 class="mbot15 mtop20 company-profile-shipping-address-heading"><?php echo _l('details_of_current_work'); ?></h4>
                <div class="table-responsive s_table">
                    <table class="table items no-mtop" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th align="center"><?php echo _l('client'); ?></th>
                                <th align="center"><?php echo _l('type_of_project'); ?></th>
                                <th align="center"><?php echo _l('location'); ?></th>
                                <th align="center"><?php echo _l('mini_contractor'); ?></th>
                                <th align="center"><?php echo _l('scope_of_works'); ?></th>
                                <th align="center"><?php echo _l('contract_prices'); ?></th>
                                <th align="center"><?php echo _l('start_date'); ?></th>
                                <th align="center"><?php echo _l('proposed_end_date'); ?></th>
                                <th align="center"><?php echo _l('building_height'); ?></th>
                                <th align="center"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody class="work_progress_main">
                            <tr class="item">
                                <td>
                                    <input type="text" name="client" class="form-control" placeholder="<?php echo _l('client'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="type_of_project" class="form-control" placeholder="<?php echo _l('type_of_project'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="location" class="form-control" placeholder="<?php echo _l('location'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="mini_contractor" class="form-control" placeholder="<?php echo _l('mini_contractor'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="scope_of_works" class="form-control" placeholder="<?php echo _l('scope_of_works'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="contract_prices" class="form-control" placeholder="<?php echo _l('contract_prices'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="start_date" class="form-control" placeholder="<?php echo _l('start_date'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="end_date" class="form-control" placeholder="<?php echo _l('end_date'); ?>">
                                </td>
                                <td>
                                    <input type="text" name="size_of_project" class="form-control" placeholder="<?php echo _l('size_of_project'); ?>">
                                </td>
                                <td>
                                    <?php
                                    $new_item = true;
                                    ?>
                                    <button type="button" onclick="add_vendor_work_progress_item_to_table('undefined','undefined',<?php echo e($new_item); ?>); return false;"
                                        class="btn pull-right btn-primary"><i class="fa fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="removed-work-progress"></div>
                </div>
            </div>
        </div>

        <div class="row mbot15">
            <div class="col-md-12">
                <h4 class="mbot15 mtop20 company-profile-shipping-address-heading"><?php echo _l('attachment'); ?></h4>
                <input type="file" name="file[]" multiple class="form-control" />
            </div>
        </div>

        <div class="row mbot15">
            <div class="col-md-12 register-terms-and-conditions-wrapper">
                <div class="text-center">
                    <div class="checkbox">
                        <input type="checkbox" name="accept_terms_and_conditions" id="accept_terms_and_conditions" <?php echo set_checkbox('accept_terms_and_conditions', 'on'); ?>>
                        <label for="accept_terms_and_conditions">
                            <?php echo _l('gdpr_terms_agree', site_url('purchase/vendors_portal/terms_and_conditions')); ?>
                        </label>
                    </div>
                    <?php echo form_error('accept_terms_and_conditions'); ?>
                </div>
            </div>
        </div>

       <div class="row">
            <div class="col-md-12 text-center">
                <div class="form-group">
                    <button type="submit" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('clients_register_string'); ?></button>
                </div>
            </div>
        </div>
   </div>
</div>

<?php echo form_close(); ?>
</div>

<?php require 'modules/purchase/assets/js/file_managements/vendor_additional_work_js.php'; ?>
