<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4><?php echo $title; ?></h4>
                        <hr class="hr-panel-heading" />

                        <p>A special welcome from Italy! It's just past 2 PM, a great time to manage your pets.</p>
                        <p>You have successfully navigated to a new page within the module.</p>
                        <br>
                        <a href="<?php echo admin_url('mypets'); ?>" class="btn btn-default">
                            Go Back to Dashboard
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
