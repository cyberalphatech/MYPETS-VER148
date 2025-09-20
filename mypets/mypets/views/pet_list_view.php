<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 class="no-margin"><?php echo $title; ?></h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo admin_url('mypets/create'); ?>" class="btn btn-info">
                                    <i class="fa fa-plus"></i> <?php echo _l('mypets_new_pet_button'); ?>
                                </a>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
                        
                        <!-- Added search and filter functionality -->
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type_filter">Animal Type</label>
                                    <select class="form-control" id="type_filter" onchange="filterPets()">
                                        <option value="">All Types</option>
                                        <option value="Dog">Dog</option>
                                        <option value="Cat">Cat</option>
                                        <option value="Horse">Horse</option>
                                        <option value="Rabbit">Rabbit</option>
                                        <option value="Bird">Bird</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search_input">Search</label>
                                    <input type="text" class="form-control" id="search_input" placeholder="Search pets..." onkeyup="filterPets()">
                                </div>
                            </div>
                        </div>

                        <!-- Improved table with better responsive design -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="pets_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pet Name</th>
                                        <th>Breed</th>
                                        <th>Type</th>
                                        <th>Customer</th>
                                        <th>Sex</th>
                                        <th class="hidden-xs">Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pets)): ?>
                                        <?php foreach ($pets as $pet): ?>
                                            <tr>
                                                <td><?php echo $pet['id']; ?></td>
                                                <td><strong><?php echo htmlspecialchars($pet['pet_name']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                                                <td><span class="label label-info"><?php echo htmlspecialchars($pet['pet_type']); ?></span></td>
                                                <td>
                                                    <?php if (!empty($pet['customer_name'])): ?>
                                                        <a href="<?php echo admin_url('clients/client/' . $pet['customer_id']); ?>">
                                                            <?php echo htmlspecialchars($pet['customer_name']); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No customer</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($pet['sex']); ?></td>
                                                <td class="hidden-xs">
                                                    <?php if (!empty($pet['image'])): ?>
                                                        <img src="<?php echo base_url($pet['image']); ?>" 
                                                             class="img-responsive img-circle" 
                                                             style="width: 30px; height: 30px;" 
                                                             alt="Pet Image">
                                                    <?php else: ?>
                                                        <span class="text-muted">No image</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?php echo admin_url('mypets/edit/' . $pet['id']); ?>" 
                                                           class="btn btn-default btn-xs" 
                                                           title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a href="<?php echo admin_url('mypets/delete/' . $pet['id']); ?>" 
                                                           class="btn btn-danger btn-xs" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this pet?');">
                                                            <i class="fa fa-remove"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                <p class="text-muted">No pets found.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
function filterPets() {
    var typeFilter = document.getElementById('type_filter').value.toLowerCase();
    var searchInput = document.getElementById('search_input').value.toLowerCase();
    var table = document.getElementById('pets_table');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName('td');
        
        if (cells.length > 0) {
            var petName = cells[1].textContent.toLowerCase();
            var breed = cells[2].textContent.toLowerCase();
            var petType = cells[3].textContent.toLowerCase();
            var customer = cells[4].textContent.toLowerCase();
            
            var showRow = true;
            
            // Type filter
            if (typeFilter && petType.indexOf(typeFilter) === -1) {
                showRow = false;
            }
            
            // Search filter
            if (searchInput && 
                petName.indexOf(searchInput) === -1 && 
                breed.indexOf(searchInput) === -1 && 
                customer.indexOf(searchInput) === -1) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }
}
</script>
