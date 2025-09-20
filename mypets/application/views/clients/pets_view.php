<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <i class="fa fa-paw"></i> My Pets
        </h4>
    </div>
    <div class="panel-body">
        <?php if (empty($pets)): ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-info-circle fa-2x"></i>
                <h4>No Pets Registered</h4>
                <p>You don't have any pets registered yet. Contact us to add your pets to the system.</p>
            </div>
        <?php else: ?>
            <!-- Using the same card-based layout from Mypets_client.php -->
            <div class="row">
                <?php foreach ($pets as $pet): ?>
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-3">
                        <div class="panel panel-default pet-card">
                            <div class="panel-body text-center">
                                <!-- Pet Image -->
                                <div class="pet-image-container mb-3">
                                    <?php if (!empty($pet['image'])): ?>
                                        <img src="<?php echo base_url($pet['image']); ?>" 
                                             class="img-responsive img-circle pet-image" 
                                             alt="<?php echo $pet['pet_name']; ?>"
                                             style="width: 120px; height: 120px; object-fit: cover; margin: 0 auto;">
                                    <?php else: ?>
                                        <div class="pet-placeholder" style="width: 120px; height: 120px; background: #f5f5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                            <i class="fa fa-paw fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Pet Info -->
                                <h4 class="pet-name" style="margin-bottom: 10px; color: #333;">
                                    <?php echo $pet['pet_name']; ?>
                                </h4>
                                
                                <div class="pet-details">
                                    <p class="mb-2">
                                        <span class="label label-info"><?php echo $pet['pet_type']; ?></span>
                                    </p>
                                    <p class="text-muted mb-2">
                                        <strong>Breed:</strong> <?php echo $pet['breed']; ?>
                                    </p>
                                    <p class="text-muted mb-2">
                                        <strong>Age:</strong> <?php echo $pet['age']; ?> years old
                                    </p>
                                    <p class="text-muted mb-3">
                                        <strong>Sex:</strong> <?php echo ucfirst($pet['sex']); ?>
                                    </p>
                                </div>
                                
                                <!-- View Details Button -->
                                <a href="<?php echo site_url('clients/pets/view/' . $pet['id']); ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Same custom CSS styling from the original client pets view -->
<style>
.pet-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.pet-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.pet-image {
    border: 3px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pet-name {
    font-weight: 600;
    color: #2c3e50;
}

.pet-details p {
    margin-bottom: 8px;
    font-size: 14px;
}

.mb-3 {
    margin-bottom: 15px;
}

.mb-2 {
    margin-bottom: 10px;
}
</style>
