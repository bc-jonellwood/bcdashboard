<?php
// Created: 2025/01/15 13:10:27
// Last modified: 2025/01/15 13:50:34

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include_once(dirname(__FILE__) . '/../classes/Page.php');
// include(dirname(__FILE__) . '/../auth/UserAuth.php');
$pageId = '07F26810-ADBC-4588-BEB2-FBCDE43C2854';
$accessRequired = Page::getAccessRequired($pageId);
AccessControl::enforce($accessRequired);

// $page = new Page();

if (isset($_POST['sPageName']) && isset($_POST['sPageLoc']) && isset($_POST['iMinRoleId']) && isset($_POST['sPageFeatureGroup'])) {
    Page::addPage(
        $_POST['sPageName'],
        $_POST['sPageLoc'],
        $_POST['iMinRoleId'],
        $_POST['sPageFeatureGroup']
    );
}

echo "<div class='main'>";
echo "<div class='content'>";
echo "<h1>Add Page</h1>";
echo "<form action='addPage.php' method='post'>";
echo "<label for='title'>Page Name</label>";
echo "<input type='text' name='sPageName' id='sPageName' required>";
echo "<label for='title'>Page Location</label>";
echo "<input type='text' name='sPageLoc' id='sPageLoc' required>";
echo "<label for='title'>Minimum Role Id</label>";
echo "<input type='number' name='iMinRoleId' id='iMinRoleId' required>";
echo "<label for='title'>Page Feature Group</label>";
echo "<input type='text' name='sPageFeatureGroup' id='sPageFeatureGroup' required>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
echo "</div>";
echo "<a href='./index.php'><button class='btn btn-primary btn-sm'>Back</button></a>";
echo "</div>";
