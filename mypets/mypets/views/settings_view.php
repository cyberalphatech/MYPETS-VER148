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
                        
                        <!-- Removed all JavaScript and added comprehensive information and file upload capabilities -->
                        
                        <!-- Module Information Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-info-circle"></i> MyPets Module Information
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5><strong>Current Database Status:</strong></h5>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-paw text-info"></i> <strong>Breeds:</strong> <?php echo isset($breeds_count) ? $breeds_count : 0; ?> records</li>
                                                    <li><i class="fa fa-medkit text-success"></i> <strong>Vaccines:</strong> <?php echo isset($vaccines_count) ? $vaccines_count : 0; ?> records</li>
                                                    <li><i class="fa fa-heart text-danger"></i> <strong>Pets:</strong> <?php echo isset($pets_count) ? $pets_count : 0; ?> records</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><strong>Module Features:</strong></h5>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-check text-success"></i> Pet Registration & Management</li>
                                                    <li><i class="fa fa-check text-success"></i> Breed Database (150+ breeds)</li>
                                                    <li><i class="fa fa-check text-success"></i> Vaccination Tracking (200+ vaccines)</li>
                                                    <li><i class="fa fa-check text-success"></i> Medical History</li>
                                                    <li><i class="fa fa-check text-success"></i> Owner Management</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><strong>Supported Animals:</strong></h5>
                                                <ul class="list-unstyled">
                                                    <li><i class="fa fa-paw"></i> Dogs (40+ breeds)</li>
                                                    <li><i class="fa fa-paw"></i> Cats (25+ breeds)</li>
                                                    <li><i class="fa fa-paw"></i> Birds (20+ species)</li>
                                                    <li><i class="fa fa-paw"></i> Horses, Rabbits, Ferrets</li>
                                                    <li><i class="fa fa-paw"></i> Reptiles, Fish, Livestock</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Data Import Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-paw"></i> Sample Breeds Data
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <p><strong>Import 150+ comprehensive breed records including:</strong></p>
                                        <ul class="list-unstyled">
                                            <li>• Dogs: All AKC groups (Sporting, Hound, Working, Toy, etc.)</li>
                                            <li>• Cats: Popular and rare breeds</li>
                                            <li>• Horses: Various disciplines and types</li>
                                            <li>• Exotic pets: Birds, reptiles, fish</li>
                                            <li>• Livestock: Cattle, sheep, goats, swine</li>
                                        </ul>
                                        
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle"></i> Each breed includes detailed information: temperament, size, life span, weight range, coat type, exercise needs, and origin country.
                                        </div>
                                        
                                        <?php echo form_open(admin_url('mypets/settings')); ?>
                                        <button type="submit" name="import_sample_breeds" value="1" class="btn btn-info btn-block">
                                            <i class="fa fa-download"></i> Import Sample Breeds Data
                                        </button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-medkit"></i> Sample Vaccines Data
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <p><strong>Import 200+ comprehensive vaccine records including:</strong></p>
                                        <ul class="list-unstyled">
                                            <li>• Core vaccines for all animal types</li>
                                            <li>• Lifestyle and regional vaccines</li>
                                            <li>• Exotic animal treatments</li>
                                            <li>• Livestock vaccination protocols</li>
                                            <li>• Fish and reptile health products</li>
                                        </ul>
                                        
                                        <div class="alert alert-success">
                                            <i class="fa fa-info-circle"></i> Each vaccine includes: type, description, frequency, age range, dosage, administration route, and manufacturer information.
                                        </div>
                                        
                                        <?php echo form_open(admin_url('mypets/settings')); ?>
                                        <button type="submit" name="import_sample_vaccines" value="1" class="btn btn-success btn-block">
                                            <i class="fa fa-download"></i> Import Sample Vaccines Data
                                        </button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Manual File Upload Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-upload"></i> Manual Data Upload
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <p><strong>Upload your own data files to customize the breeds and vaccines database:</strong></p>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5><i class="fa fa-file-code-o text-primary"></i> SQL File Upload</h5>
                                                <p>Upload SQL files containing INSERT statements for breeds or vaccines data.</p>
                                                
                                                <?php echo form_open_multipart(admin_url('mypets/settings')); ?>
                                                <div class="form-group">
                                                    <label>Select SQL File:</label>
                                                    <input type="file" name="sql_file" class="form-control" accept=".sql" required>
                                                    <small class="text-muted">Accepted format: .sql files with INSERT statements</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Data Type:</label>
                                                    <select name="sql_data_type" class="form-control" required>
                                                        <option value="">Select data type...</option>
                                                        <option value="breeds">Breeds Data</option>
                                                        <option value="vaccines">Vaccines Data</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="upload_sql_file" value="1" class="btn btn-primary">
                                                    <i class="fa fa-upload"></i> Upload SQL File
                                                </button>
                                                <?php echo form_close(); ?>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h5><i class="fa fa-file-excel-o text-success"></i> Excel File Upload</h5>
                                                <p>Upload Excel files with structured data that will be converted to database records.</p>
                                                
                                                <?php echo form_open_multipart(admin_url('mypets/settings')); ?>
                                                <div class="form-group">
                                                    <label>Select Excel File:</label>
                                                    <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required>
                                                    <small class="text-muted">Accepted formats: .xlsx, .xls, .csv</small>
                                                </div>
                                                <div class="form-group">
                                                    <label>Data Type:</label>
                                                    <select name="excel_data_type" class="form-control" required>
                                                        <option value="">Select data type...</option>
                                                        <option value="breeds">Breeds Data</option>
                                                        <option value="vaccines">Vaccines Data</option>
                                                        <option value="pets">Pets Data</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="upload_excel_file" value="1" class="btn btn-success">
                                                    <i class="fa fa-upload"></i> Upload Excel File
                                                </button>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <h5><i class="fa fa-exclamation-triangle"></i> File Upload Requirements:</h5>
                                            <ul class="mb-0">
                                                <li><strong>SQL Files:</strong> Must contain valid INSERT statements matching database table structure</li>
                                                <li><strong>Excel Files:</strong> First row should contain column headers matching database fields</li>
                                                <li><strong>Encoding:</strong> Files should be UTF-8 encoded to prevent character issues</li>
                                                <li><strong>Size Limit:</strong> Maximum file size is 10MB</li>
                                                <li><strong>Duplicates:</strong> Duplicate records will be automatically skipped</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-cogs"></i> Quick Actions & Management
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <a href="<?php echo admin_url('mypets/breeds'); ?>" class="btn btn-default btn-block">
                                                    <i class="fa fa-paw"></i><br>Manage Breeds<br>
                                                    <small class="text-muted">Add, edit, delete breed records</small>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="<?php echo admin_url('mypets/vaccines'); ?>" class="btn btn-default btn-block">
                                                    <i class="fa fa-medkit"></i><br>Manage Vaccines<br>
                                                    <small class="text-muted">Add, edit, delete vaccine records</small>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="<?php echo admin_url('mypets'); ?>" class="btn btn-default btn-block">
                                                    <i class="fa fa-list"></i><br>View All Pets<br>
                                                    <small class="text-muted">Browse registered pets</small>
                                                </a>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="<?php echo admin_url('mypets/add'); ?>" class="btn btn-primary btn-block">
                                                    <i class="fa fa-plus"></i><br>Add New Pet<br>
                                                    <small class="text-muted">Register a new pet</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Database Schema Information -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <i class="fa fa-database"></i> Database Schema Information
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5><strong>Breeds Table Structure:</strong></h5>
                                                <ul class="list-unstyled small">
                                                    <li>• id (Primary Key)</li>
                                                    <li>• name (Breed Name)</li>
                                                    <li>• animal_type (Dog, Cat, etc.)</li>
                                                    <li>• size (Small, Medium, Large)</li>
                                                    <li>• temperament</li>
                                                    <li>• life_span</li>
                                                    <li>• weight_range</li>
                                                    <li>• origin_country</li>
                                                </ul>
                                                <!-- Added Excel template download for breeds -->
                                                <div class="mt-2">
                                                    <a href="<?php echo base_url('modules/mypets/templates/breeds_template.xlsx'); ?>" 
                                                       class="btn btn-sm btn-success" download>
                                                        <i class="fa fa-file-excel-o"></i> Download Breeds Excel Template
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><strong>Vaccines Table Structure:</strong></h5>
                                                <ul class="list-unstyled small">
                                                    <li>• id (Primary Key)</li>
                                                    <li>• name (Vaccine Name)</li>
                                                    <li>• animal_type</li>
                                                    <li>• vaccine_type (Core/Non-core)</li>
                                                    <li>• description</li>
                                                    <li>• frequency</li>
                                                    <li>• age_range</li>
                                                    <li>• dosage</li>
                                                    <li>• route (Administration)</li>
                                                </ul>
                                                <!-- Added Excel template download for vaccines -->
                                                <div class="mt-2">
                                                    <a href="<?php echo base_url('modules/mypets/templates/vaccines_template.xlsx'); ?>" 
                                                       class="btn btn-sm btn-success" download>
                                                        <i class="fa fa-file-excel-o"></i> Download Vaccines Excel Template
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h5><strong>Pets Table Structure:</strong></h5>
                                                <ul class="list-unstyled small">
                                                    <li>• id (Primary Key)</li>
                                                    <li>• name (Pet Name)</li>
                                                    <li>• breed_id (Foreign Key)</li>
                                                    <li>• owner_name</li>
                                                    <li>• date_of_birth</li>
                                                    <li>• gender</li>
                                                    <li>• color</li>
                                                    <li>• microchip_number</li>
                                                    <li>• registration_date</li>
                                                </ul>
                                                <!-- Added Excel template download for pets -->
                                                <div class="mt-2">
                                                    <a href="<?php echo base_url('modules/mypets/templates/pets_template.xlsx'); ?>" 
                                                       class="btn btn-sm btn-success" download>
                                                        <i class="fa fa-file-excel-o"></i> Download Pets Excel Template
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php init_tail(); ?>
