<?php
defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'mypets.id as id',
    'pet_name',
    'breed',
    'pet_type',
    'company as customer_name',
    'sex',
    'image',
    db_prefix() . 'mypets.customer_id as customer_id', // Added for the link
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'mypets';
$join         = ['LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'mypets.customer_id'];
$result       = data_tables_init($aColumns, $sIndexColumn, $sTable, $join);
$output       = $result['output'];
$rResult      = $result['rResult'];

foreach ($rResult as $aRow) {
    $row   = [];
    $row[] = $aRow['id'];
    $row[] = $aRow['pet_name'];
    $row[] = $aRow['breed'];
    $row[] = $aRow['pet_type'];
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['customer_id']) . '">' . $aRow['customer_name'] . '</a>';
    $row[] = $aRow['sex'];
    $row[] = '<img src="' . base_url($aRow['image']) . '" class="img-responsive img-circle" style="width: 30px; height: 30px;">';
    $actions = '<a href="#" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>';
    $actions .= '<a href="#" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>';
    $row[] = $actions;
    $output['aaData'][] = $row;
}

echo json_encode($output);
die();
