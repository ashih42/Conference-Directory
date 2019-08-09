<?php
echo '<div class="listing panel ';
switch ($listing->getStatus()) {
    case 'featured':
        echo 'panel-success';
        break;
    case 'premium':
        echo 'panel-info';
        break;
    case 'inactive':
        echo 'panel-danger';
        break;
    default:
        echo 'panel-default';
}
echo '">' . PHP_EOL;
    echo '<div class="panel-heading">';
        echo '<div class="input-group">' . PHP_EOL;
            echo '<h3 class="panel-title">' . $listing->getTitle() . '</h3>' . PHP_EOL;

            echo '<div class="input-group-btn">' . PHP_EOL;
                echo '<form method="post" action="delete.php">' . PHP_EOL;
                echo '<input type="hidden" name="id" value="' . $listing->getId() . '" />' . PHP_EOL;
                echo '<a class="btn glyphicon glyphicon-edit" title="Click here to update record in the database." '
                    . 'href="update.php?id=' . $listing->getId() . '"></a>' . PHP_EOL;
                echo '<button class="btn glyphicon glyphicon-remove" type="submit" name="action" id="action" '
                    . 'title="Click here to delete record in the database." value="DELETE" '
                    . 'onclick="return confirm(\'Are you sure you want to DEACTIVATE this listing? \')"></button>' . PHP_EOL;
                echo '</form>' . PHP_EOL;
            echo '</div>' . PHP_EOL;
        echo '</div>' . PHP_EOL;

    echo '</div>';
    echo '<div class="panel-body">';
    if (is_a($listing, 'ListingPremium') && !empty($listing->getDescription()))
        echo '<p>' . $listing->getDescription() . '</p>';
    echo '<p>' . PHP_EOL;
if (!empty($listing->getWebsite())) {
    echo ' <a href="' . $listing->getWebsite() . '" target="_blank">' . $listing->getWebsite() . '</a> | ' . PHP_EOL;
}
if (!empty($listing->getEmail())) {
    echo ' <a href="mailto:' . $listing->getEmail() . '" target="_blank">' . $listing->getEmail() . '</a> | ' . PHP_EOL;
}
if (!empty($listing->getTwitter())) {
    echo ' <a href="https://twitter.com/' . $listing->getTwitter() . '" target="_blank">@' . $listing->getTwitter() . '</a> | ' . PHP_EOL;
}

if (is_a($listing, 'ListingFeatured') && !empty($listing->getCoc())) {
    echo '<a href="javascript:;" onclick="toggle(\'coc' . $listing->getID() . '\')">Code of Conduct</a> |';
}
    echo '</p>' . PHP_EOL;
    echo '</div>' . PHP_EOL;/**/

if (is_a($listing, 'ListingFeatured') && !empty($listing->getCoc())) {
    echo '<div class="panel-footer" id="coc' . $listing->getId();
    echo '" style="display:"none">' . $listing->getCoc() . '</div>';
}

echo '</div>' . PHP_EOL;