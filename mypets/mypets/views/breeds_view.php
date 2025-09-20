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
                                <h4><?php echo $title; ?></h4>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#breedModal">
                                    <i class="fa fa-plus"></i> Add New Breed
                                </button>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted">Manage pet breed information including characteristics, temperament, and care requirements.</p>
                                
                                <!-- Improved filter options layout -->
                                <div class="row" style="margin-bottom: 15px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="animal_type_filter">Animal Type</label>
                                            <select class="form-control" id="animal_type_filter">
                                                <option value="">All Animal Types</option>
                                                <?php foreach($animal_types as $type): ?>
                                                    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="breed_group_filter">Breed Group</label>
                                            <select class="form-control" id="breed_group_filter">
                                                <option value="">All Breed Groups</option>
                                                <?php foreach($breed_groups as $group): ?>
                                                    <option value="<?php echo $group; ?>"><?php echo $group; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="breed_search">Search</label>
                                            <input type="text" class="form-control" id="breed_search" placeholder="Search breeds..." onkeyup="filterBreeds()">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Improved breeds table with better mobile responsiveness -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="breedsTable">
                                        <thead>
                                            <tr>
                                                <th class="hidden-xs">ID</th>
                                                <th>Breed Name</th>
                                                <th>Animal Type</th>
                                                <th class="hidden-xs">Group</th>
                                                <th>Size</th>
                                                <th class="hidden-sm hidden-xs">Temperament</th>
                                                <th class="hidden-sm hidden-xs">Life Span</th>
                                                <th class="hidden-sm hidden-xs">Weight</th>
                                                <th class="hidden-xs">Exercise</th>
                                                <th class="hidden-sm hidden-xs">Children</th>
                                                <th class="hidden-sm hidden-xs">Pets</th>
                                                <th class="hidden-sm hidden-xs">Origin</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($breeds)): ?>
                                                <?php foreach ($breeds as $breed): ?>
                                                    <tr>
                                                        <td class="hidden-xs"><?php echo $breed['id']; ?></td>
                                                        <td><strong><?php echo $breed['breed_name']; ?></strong></td>
                                                        <td><span class="label label-info"><?php echo $breed['animal_type']; ?></span></td>
                                                        <td class="hidden-xs"><?php echo !empty($breed['breed_group']) ? $breed['breed_group'] : '-'; ?></td>
                                                        <td>
                                                            <?php if (!empty($breed['size'])): ?>
                                                                <?php
                                                                $size_class = '';
                                                                switch($breed['size']) {
                                                                    case 'Toy': $size_class = 'label-primary'; break;
                                                                    case 'Small': $size_class = 'label-success'; break;
                                                                    case 'Medium': $size_class = 'label-warning'; break;
                                                                    case 'Large': $size_class = 'label-danger'; break;
                                                                    case 'Giant': $size_class = 'label-default'; break;
                                                                    default: $size_class = 'label-default';
                                                                }
                                                                ?>
                                                                <span class="label <?php echo $size_class; ?>"><?php echo $breed['size']; ?></span>
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="hidden-sm hidden-xs"><?php echo !empty($breed['temperament']) ? substr($breed['temperament'], 0, 50) . '...' : '-'; ?></td>
                                                        <td class="hidden-sm hidden-xs"><?php echo !empty($breed['life_span']) ? $breed['life_span'] : '-'; ?></td>
                                                        <td class="hidden-sm hidden-xs"><?php echo !empty($breed['weight_range']) ? $breed['weight_range'] : '-'; ?></td>
                                                        <td class="hidden-xs">
                                                            <?php if (!empty($breed['exercise_needs'])): ?>
                                                                <?php
                                                                $exercise_class = '';
                                                                switch($breed['exercise_needs']) {
                                                                    case 'Low': $exercise_class = 'label-success'; break;
                                                                    case 'Moderate': $exercise_class = 'label-warning'; break;
                                                                    case 'High': $exercise_class = 'label-danger'; break;
                                                                    case 'Very High': $exercise_class = 'label-default'; break;
                                                                    default: $exercise_class = 'label-default';
                                                                }
                                                                ?>
                                                                <span class="label <?php echo $exercise_class; ?>"><?php echo $breed['exercise_needs']; ?></span>
                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="hidden-sm hidden-xs"><?php echo $breed['good_with_children'] ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'; ?></td>
                                                        <td class="hidden-sm hidden-xs"><?php echo $breed['good_with_pets'] ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>'; ?></td>
                                                        <td class="hidden-sm hidden-xs"><?php echo !empty($breed['origin_country']) ? $breed['origin_country'] : '-'; ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-default btn-xs" onclick="viewBreed(<?php echo $breed['id']; ?>)" title="View Details">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-default btn-xs" onclick="editBreed(<?php echo $breed['id']; ?>)" title="Edit">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-xs" onclick="deleteBreed(<?php echo $breed['id']; ?>)" title="Delete">
                                                                    <i class="fa fa-remove"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="13" class="text-center text-muted">No breeds found. Click "Add New Breed" to get started.</td>
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
    </div>
</div>

<!-- Add/Edit Breed Modal -->
<div class="modal fade" id="breedModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Breed</h4>
            </div>
            <form id="breedForm" action="<?php echo admin_url('mypets/add_breed'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="breed_name">Breed Name *</label>
                                <input type="text" class="form-control" name="breed_name" id="breed_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="animal_type">Animal Type *</label>
                                <select class="form-control" name="animal_type" id="animal_type" required>
                                    <option value="">Select Animal Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Horse">Horse</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Bird">Bird</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="breed_group">Breed Group</label>
                                <input type="text" class="form-control" name="breed_group" id="breed_group">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="size">Size</label>
                                <select class="form-control" name="size" id="size">
                                    <option value="">Select Size</option>
                                    <option value="Toy">Toy</option>
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                    <option value="Giant">Giant</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="life_span">Life Span</label>
                                <input type="text" class="form-control" name="life_span" id="life_span" placeholder="e.g., 10-12 years">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="weight_range">Weight Range</label>
                                <input type="text" class="form-control" name="weight_range" id="weight_range" placeholder="e.g., 55-75 lbs">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exercise_needs">Exercise Needs</label>
                                <select class="form-control" name="exercise_needs" id="exercise_needs">
                                    <option value="">Select Exercise Needs</option>
                                    <option value="Low">Low</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="High">High</option>
                                    <option value="Very High">Very High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grooming_needs">Grooming Needs</label>
                                <select class="form-control" name="grooming_needs" id="grooming_needs">
                                    <option value="">Select Grooming Needs</option>
                                    <option value="Low">Low</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="High">High</option>
                                    <option value="Very High">Very High</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="origin_country">Origin Country</label>
                                <input type="text" class="form-control" name="origin_country" id="origin_country">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="coat_type">Coat Type</label>
                                <input type="text" class="form-control" name="coat_type" id="coat_type">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="good_with_children" id="good_with_children" value="1" checked>
                                    Good with Children
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="good_with_pets" id="good_with_pets" value="1" checked>
                                    Good with Other Pets
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="temperament">Temperament</label>
                        <input type="text" class="form-control" name="temperament" id="temperament" placeholder="e.g., Friendly, Intelligent, Loyal">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">Save Breed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function viewBreed(id) {
    // Implementation for viewing breed details
    alert('View breed details for ID: ' + id);
}

function editBreed(id) {
    // Implementation for editing breed
    alert('Edit breed for ID: ' + id);
}

function deleteBreed(id) {
    if (confirm('Are you sure you want to delete this breed?')) {
        window.location.href = '<?php echo admin_url("mypets/delete_breed/"); ?>' + id;
    }
}

function filterBreeds() {
    var animalType = document.getElementById('animal_type_filter').value;
    var breedGroup = document.getElementById('breed_group_filter').value;
    var searchTerm = document.getElementById('breed_search').value.toLowerCase();
    var table = document.getElementById('breedsTable');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName('td');
        
        if (cells.length > 0) {
            var breedName = cells[1].textContent.toLowerCase();
            var rowAnimalType = cells[2].textContent.trim();
            var rowBreedGroup = cells[3].textContent.trim();
            var temperament = cells[5] ? cells[5].textContent.toLowerCase() : '';
            
            var showRow = true;
            
            // Animal type filter
            if (animalType && !rowAnimalType.includes(animalType)) {
                showRow = false;
            }
            
            // Breed group filter
            if (breedGroup && rowBreedGroup !== breedGroup && rowBreedGroup !== '-') {
                showRow = false;
            }
            
            // Search filter
            if (searchTerm && 
                breedName.indexOf(searchTerm) === -1 && 
                temperament.indexOf(searchTerm) === -1) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }
}

function initializeFilters() {
    document.getElementById('animal_type_filter').addEventListener('change', filterBreeds);
    document.getElementById('breed_group_filter').addEventListener('change', filterBreeds);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeFilters);
} else {
    initializeFilters();
}
</script>

<?php init_tail(); ?>
