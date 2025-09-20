<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="#" class="btn btn-primary"> <i class="fa fa-plus"></i> New Owner
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />

                        <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin">Owner Summary</h4>
                            </div>
                            <div class="col-md-2 col-xs-6 border-right">
                                <h3 class="bold">1</h3>
                                <span class="text-dark">Total</span>
                            </div>
                            <div class="col-md-2 col-xs-6 border-right">
                                <h3 class="bold">1</h3>
                                <span class="text-success">Active</span>
                            </div>
                            <div class="col-md-2 col-xs-6 border-right">
                                <h3 class="bold">0</h3>
                                <span class="text-danger">Inactive</span>
                            </div>
                            </div>
                        <hr class="hr-panel-heading" />

                        <?php
                        $table_data = [
                            '#',
                            'Company',
                            'Primary Contact',
                            'Primary Email',
                            'Phone',
                            'Active',
                            'Groups',
                            'Date Created',
                        ];
                        render_datatable($table_data, 'pet-owners-table');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-pet-owners-table', window.location.href);
    });
</script>
