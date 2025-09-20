<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<h4 class="customer-profile-group-heading">My Pets</h4>
<div class="col-md-12">
    <?php
    $table_data = ['#', 'Pet Name', 'Breed', 'Pet Type', 'Age', 'Sex', 'Image'];
    // Pass the customer's ID to the table
    $table_attributes = [
        'data-customer-id' => $client->userid
    ];
    render_datatable($table_data, 'client-pets-table', [], $table_attributes);
    ?>
</div>

<script>
    $(function(){
        // Get the customer ID from the table's data attribute
        var customerId = $('.table-client-pets-table').data('customer-id');
        // Define the server-side URL, passing the customer ID
        var serverSideUrl = "<?php echo admin_url('mypets/client_pets_table/'); ?>" + customerId;
        
        initDataTable('.table-client-pets-table', serverSideUrl);
    });
</script>
