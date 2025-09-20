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
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#vaccine_modal">
                                    <i class="fa fa-plus"></i> <?php echo _l('mypets_add_vaccine'); ?>
                                </button>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
                        
                        <!-- Improved filter section layout -->
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="animal_filter"><?php echo _l('mypets_animal_type'); ?></label>
                                    <select class="form-control" id="animal_filter" onchange="filterTable()">
                                        <option value=""><?php echo _l('mypets_all_animals'); ?></option>
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
                                    <label for="type_filter"><?php echo _l('mypets_vaccine_type'); ?></label>
                                    <select class="form-control" id="type_filter" onchange="filterTable()">
                                        <option value=""><?php echo _l('mypets_all_types'); ?></option>
                                        <option value="Core">Core</option>
                                        <option value="Non-Core">Non-Core</option>
                                        <option value="Lifestyle">Lifestyle</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_input"><?php echo _l('search'); ?></label>
                                    <input type="text" class="form-control" id="search_input" placeholder="Search vaccines..." onkeyup="filterTable()">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Improved table with better mobile responsiveness -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="vaccines_table">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('mypets_vaccine_name'); ?></th>
                                        <th><?php echo _l('mypets_animal_type'); ?></th>
                                        <th><?php echo _l('mypets_vaccine_type'); ?></th>
                                        <th class="hidden-xs"><?php echo _l('mypets_description'); ?></th>
                                        <th class="hidden-xs"><?php echo _l('mypets_frequency'); ?></th>
                                        <th class="hidden-sm hidden-xs"><?php echo _l('mypets_manufacturer'); ?></th>
                                        <th><?php echo _l('mypets_actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($vaccines) && !empty($vaccines)): ?>
                                        <?php foreach($vaccines as $vaccine): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($vaccine['vaccine_name']); ?></strong></td>
                                                <td><span class="label label-info"><?php echo htmlspecialchars($vaccine['animal_type']); ?></span></td>
                                                <td><span class="label label-<?php echo $vaccine['vaccine_type'] == 'Core' ? 'success' : ($vaccine['vaccine_type'] == 'Non-Core' ? 'warning' : 'default'); ?>"><?php echo htmlspecialchars($vaccine['vaccine_type']); ?></span></td>
                                                <td class="hidden-xs"><?php echo htmlspecialchars(substr($vaccine['description'], 0, 100)) . (strlen($vaccine['description']) > 100 ? '...' : ''); ?></td>
                                                <td class="hidden-xs"><?php echo htmlspecialchars($vaccine['frequency']); ?></td>
                                                <td class="hidden-sm hidden-xs"><?php echo htmlspecialchars($vaccine['manufacturer']); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-xs" onclick="edit_vaccine(<?php echo $vaccine['id']; ?>)" title="Edit">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="delete_vaccine(<?php echo $vaccine['id']; ?>)" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center"><?php echo _l('no_data_found'); ?></td>
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

<!-- Add/Edit Vaccine Modal -->
<div class="modal fade" id="vaccine_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="vaccine_modal_title"><?php echo _l('mypets_add_vaccine'); ?></h4>
            </div>
            <form id="vaccine_form" action="<?php echo admin_url('mypets/add_vaccine'); ?>" method="post">
                <div class="modal-body">
                    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    <input type="hidden" id="vaccine_id" name="vaccine_id" value="">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vaccine_name"><?php echo _l('mypets_vaccine_name'); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="vaccine_name" name="vaccine_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="animal_type"><?php echo _l('mypets_animal_type'); ?> <span class="text-danger">*</span></label>
                                <select class="form-control" id="animal_type" name="animal_type" required>
                                    <option value="">Select Animal Type</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Horse">Horse</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vaccine_type"><?php echo _l('mypets_vaccine_type'); ?> <span class="text-danger">*</span></label>
                                <select class="form-control" id="vaccine_type" name="vaccine_type" required>
                                    <option value="">Select Vaccine Type</option>
                                    <option value="Core">Core</option>
                                    <option value="Non-Core">Non-Core</option>
                                    <option value="Lifestyle">Lifestyle</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="manufacturer"><?php echo _l('mypets_manufacturer'); ?></label>
                                <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frequency"><?php echo _l('mypets_frequency'); ?></label>
                                <input type="text" class="form-control" id="frequency" name="frequency" placeholder="e.g., Annual, Every 6 months">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="age_range"><?php echo _l('mypets_age_range'); ?></label>
                                <input type="text" class="form-control" id="age_range" name="age_range" placeholder="e.g., 6-8 weeks, 12+ weeks">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="description"><?php echo _l('mypets_description'); ?></label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php init_tail(); ?>

<script>
function filterTable() {
    var animalFilter = document.getElementById('animal_filter').value.toLowerCase();
    var typeFilter = document.getElementById('type_filter').value.toLowerCase();
    var searchInput = document.getElementById('search_input').value.toLowerCase();
    var table = document.getElementById('vaccines_table');
    var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName('td');
        
        if (cells.length > 0) {
            var vaccineName = cells[0].textContent.toLowerCase();
            var animalType = cells[1].textContent.toLowerCase();
            var vaccineType = cells[2].textContent.toLowerCase();
            var description = cells[3].textContent.toLowerCase();
            var manufacturer = cells[5].textContent.toLowerCase();
            
            var showRow = true;
            
            // Animal filter
            if (animalFilter && animalType.indexOf(animalFilter) === -1) {
                showRow = false;
            }
            
            // Type filter
            if (typeFilter && vaccineType.indexOf(typeFilter) === -1) {
                showRow = false;
            }
            
            // Search filter
            if (searchInput && 
                vaccineName.indexOf(searchInput) === -1 && 
                description.indexOf(searchInput) === -1 && 
                manufacturer.indexOf(searchInput) === -1) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }
}

function edit_vaccine(id) {
    $.get('<?php echo admin_url('mypets/get_vaccine/'); ?>' + id, function(data) {
        if (!data.error) {
            $('#vaccine_id').val(data.id);
            $('#vaccine_name').val(data.vaccine_name);
            $('#animal_type').val(data.animal_type);
            $('#vaccine_type').val(data.vaccine_type);
            $('#manufacturer').val(data.manufacturer);
            $('#frequency').val(data.frequency);
            $('#age_range').val(data.age_range);
            $('#description').val(data.description);
            
            $('#vaccine_modal_title').text('<?php echo _l('mypets_edit_vaccine'); ?>');
            $('#vaccine_form').attr('action', '<?php echo admin_url('mypets/edit_vaccine/'); ?>' + id);
            $('#vaccine_modal').modal('show');
        }
    });
}

function delete_vaccine(id) {
    if (confirm('<?php echo _l('confirm_delete'); ?>')) {
        window.location.href = '<?php echo admin_url('mypets/delete_vaccine/'); ?>' + id;
    }
}

// Reset form when modal is closed
$('#vaccine_modal').on('hidden.bs.modal', function() {
    $('#vaccine_form')[0].reset();
    $('#vaccine_id').val('');
    $('#vaccine_modal_title').text('<?php echo _l('mypets_add_vaccine'); ?>');
    $('#vaccine_form').attr('action', '<?php echo admin_url('mypets/add_vaccine'); ?>');
});
</script>
