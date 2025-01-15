<?php
// Created: 2025/01/15 13:30:59
// Last modified: 2025/01/15 14:19:34

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include_once(dirname(__FILE__) . '/../classes/Page.php');
// include(dirname(__FILE__) . '/../auth/UserAuth.php');
$pageId = '3A174211-4727-4A38-A1BE-DA3967203795';
$accessRequired = Page::getAccessRequired($pageId);
AccessControl::enforce($accessRequired);

$page = new Page();
$pages = $page->getPages();
// echo "<pre>";

// print_r($pages);
// echo "</pre>";


echo "<div class='main'>";
echo "<div class='content'>";
echo "<h1>Pages Admin</h1>";
// echo "<p>This page is for Pages Admins</p>";
echo "<table class='table table-sm table-bordered border-primary'>";
echo "<thead>";
echo "<tr>";
echo "<th scope='col'>Page ID</th>";
echo "<th scope='col'>Page Name</th>";
echo "<th scope='col'>Page Location</th>";
echo "<th scope='col'>Minimum Role Id</th>";
echo "<th scope='col'>Page Feature Group</th>";
echo "<th scope='col'>Actions</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($pages as $page) {
    echo "<tr>";
    echo "<td>" . $page['sPageId'] . "</td>";
    echo "<td>" . $page['sPageName'] . "</td>";
    echo "<td class='align-left'>" . $page['sPageLoc'] . "</td>";
    echo "<td>" . $page['iMinRoleId'] . "</td>";
    echo "<td>" . $page['sPageFeatureGroup'] . "</td>";
    echo "<td>";
    echo "<a href='/segap/editPage.php?pageId=" . $page['sPageId'] . "'>Edit</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
echo "</div>";
echo "<a href='/segap/addPage.php'><button class='btn btn-primary btn-sm'>Add Page</button></a>";
echo "</div>";



include(dirname(__FILE__) . '/../components/footer.php');
?>
<link rel="stylesheet" href="pages.css">