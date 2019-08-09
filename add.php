<?php
include 'inc/config.php';

if ($_POST) {
    if ($directory->insert($_POST) > 0) {
        header('location: /index.php');
        exit;
    }
    $listing = $directory->listings[0];
} else {
    $listing = new ListingBasic();
}
$title = 'Add Conference';
require 'inc/header.php';
?>
<form method="post" action="add.php">
    <?php require 'views/form_listing.php'; ?>
    <input class="btn btn-primary" type="submit" name="submit" value="Add Listing" />
</form>
<?php
require 'inc/footer.php';