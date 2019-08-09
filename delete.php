<?php
include 'inc/config.php';

if (isset($_POST['id'])) {
    $directory->delete($_POST['id']);
} else {
    $directory->setAlert(
        'danger',
        'Unknown Listing'
    );
}
// Redirect to the listing page
header('location: /index.php');
exit;