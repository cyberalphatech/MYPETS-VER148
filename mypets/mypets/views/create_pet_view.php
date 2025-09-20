<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
                        
                        <?php echo form_open_multipart(admin_url('mypets/create')); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Using the working customer dropdown format -->
                                <?php echo render_select('customer_id', $customers, ['userid', 'company'], _l('mypets_form_customer'), '', [], [], 'required'); ?>
                            </div>
                            <div class="col-md-6">
                                <!-- Using pet_name field name as in working version -->
                                <?php echo render_input('pet_name', _l('mypets_form_pet_name'), '', 'text', ['required' => true]); ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('breed', _l('mypets_form_breed')); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('pet_type', _l('mypets_form_pet_type')); ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_input('age', _l('mypets_form_age'), '', 'number'); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_select('sex', [
                                    ['id' => 'Male', 'name' => 'Male'],
                                    ['id' => 'Female', 'name' => 'Female']
                                ], ['id', 'name'], _l('mypets_form_sex')); ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="image"><?php echo _l('mypets_tbl_header_image'); ?></label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    <small class="text-muted">Allowed formats: JPG, JPEG, PNG, GIF. Max size: 2MB</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right"><?php echo _l('submit'); ?></button>
                                <a href="<?php echo admin_url('mypets'); ?>" class="btn btn-default pull-right" style="margin-right: 10px;">Cancel</a>
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
