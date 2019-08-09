<?php
include 'inc/config.php';

if (!isset($_REQUEST['id'])) {
    $directory->setAlert(
        'danger',
        'Unknown Listing'
    );
    // Redirect to the listing page
    header('location: /index.php');
    exit;
} elseif ($_POST) {
    if ($directory->update($_POST) > 0) {
        // Redirect to the listing page
        header('location: /index.php');
        exit;
    }
} else {
    $directory->selectListings(['id' => $_REQUEST['id']]);
}
$listing = $directory->listings[0];

$title = 'Update Listing';
require 'inc/header.php';
?>
<form method="post" action="update.php">
    <?php require 'views/form_listing.php'; ?>
    <input type="hidden" name="id" id="id" value="<?php echo $listing->getId(); ?>" />
    <input class="btn btn-primary" type="submit" name="submit" value="Update Listing" />
</form>
<?php
require 'inc/footer.php';