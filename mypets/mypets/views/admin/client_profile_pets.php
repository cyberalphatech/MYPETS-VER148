<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mypets-section">
  <div class="col-md-12">
    <h4 class="customer-profile-group-heading"><i class="fa fa-paw"></i> <?php echo _l('mypets_client_pets'); ?></h4>
    <hr />

    <?php
      $CI =& get_instance();
      $CI->load->model('mypets/mypets_model');
      $pets = $CI->mypets_model->get_pets_for_customer($client_id);
    ?>

    <?php if (!empty($pets)) { ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Pet Name</th>
              <th>Breed</th>
              <th>Type</th>
              <th>Age</th>
              <th>Sex</th>
              <th>Image</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pets as $pet) { ?>
              <tr>
                <td><strong><?php echo htmlspecialchars($pet['pet_name']); ?></strong></td>
                <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                <td><?php echo htmlspecialchars($pet['pet_type']); ?></td>
                <td><?php echo htmlspecialchars($pet['age']); ?></td>
                <td><?php echo htmlspecialchars($pet['sex']); ?></td>
                <td>
                  <?php if (!empty($pet['image'])) { ?>
                    <img src="<?php echo base_url($pet['image']); ?>" class="img-circle" style="width:40px;height:40px;object-fit:cover;">
                  <?php } else { ?>
                    <span class="text-muted"><i class="fa fa-image"></i> No image</span>
                  <?php } ?>
                </td>
                <td>
                  <a href="<?php echo admin_url('mypets/view/' . $pet['id']); ?>" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo admin_url('mypets/edit/' . $pet['id']); ?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } else { ?>
      <div class="alert alert-info">
        <i class="fa fa-info-circle"></i> No pets registered for this customer.
        <div style="margin-top:10px;">
          <a href="<?php echo admin_url('mypets/add?customer_id=' . $client_id); ?>" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Add First Pet
          </a>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
