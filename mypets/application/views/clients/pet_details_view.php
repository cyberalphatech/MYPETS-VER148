<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-paw"></i> <?php echo $pet->pet_name; ?>
        </h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <?php if (!empty($pet->image)): ?>
                    <img src="<?php echo base_url($pet->image); ?>" class="img-responsive img-thumbnail" alt="<?php echo $pet->pet_name; ?>">
                <?php else: ?>
                    <div class="well text-center">
                        <i class="fa fa-paw fa-5x text-muted"></i>
                        <p class="text-muted">No image available</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <!-- Using the same table structure from client_pet_details_view.php -->
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Pet Name:</th>
                        <td><strong><?php echo $pet->pet_name; ?></strong></td>
                    </tr>
                    <tr>
                        <th>Breed:</th>
                        <td><?php echo $pet->breed; ?></td>
                    </tr>
                    <tr>
                        <th>Pet Type:</th>
                        <td><span class="label label-info"><?php echo $pet->pet_type; ?></span></td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td><?php echo $pet->age; ?></td>
                    </tr>
                    <tr>
                        <th>Sex:</th>
                        <td><?php echo $pet->sex; ?></td>
                    </tr>
                </table>
                
                <div class="text-center">
                    <a href="<?php echo site_url('clients/pets'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Back to My Pets
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
