<?php
// Created: 2025/01/09 12:30:54
// Last modified:

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');

$user = new User();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = trim($id, "'");
    $userData = $user->getUser($id);
}

?> </td>
<link rel="stylesheet" type="text/css" href="user.css">
<div class="main">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <tr>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Profile for <?= (isset($userData['sPreferredName']) && $userData['sPreferredName']
                                                                    ? strtolower($userData['sPreferredName']) . ' ' . strtolower($userData['sLastName'])
                                                                    : strtolower($userData['sFirstName']) . ' ' . strtolower($userData['sLastName']))  ?> </td>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table>
                                    <tr>
                                        <th>Name:</th>
                                        <td> <?= $userData['sFirstName'] . ' ' . $userData['sMiddleName'] . ' ' . $userData['sLastName'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Preferred Name:</th>
                                        <td> <?= $userData['sPreferredName'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td> <?= $userData['sEmail'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Username:</th>
                                        <td> <?= $userData['sUserName'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Active Directory Status:</th>
                                        <td> <?= $userData['sADStatus'] == '1' ? 'Active' : 'Inactive' ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Department:</th>
                                        <td> <?= $userData['sDepartmentName'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Employee Number:</th>
                                        <td> <?= $userData['sEmployeeNumber'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Job Title:</th>
                                        <td> <?= $userData['sJobTitle'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date:</th>
                                        <td> <?= $userData['dtStartDate'] ?> </td>
                                    </tr>
                                    <tr>
                                        <th>End Date:</th>
                                        <td> <?= $userData['dtSeparationDate'] ? $userData['dtSeparationDate'] : 'Employee is Active' ?> </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row">
                                <div>
                                    <img src=<?= $userData['sProfileImgPath'] ?> alt="avatar" class='avatar' />
                                    <!-- <img src="https://ui-avatars.com/api/?name=<?= $userData['sPreferredName'] . ' ' . $userData['sLastName'] ?>" alt="not a kitty" class="avatar" /> -->
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-sm" type="button" popovertarget="updateProfileImagePopover" popovertargetaction="show">Update Profile Image</button>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<? include(dirname(__FILE__) . '/../components/footer.php') ?> </td>

<div class="updateProfileImagePopover" id="updateProfileImagePopover" name="updateProfileImagePopover" popover=manual>
    <button class="btn-close mb-2" popovertarget="updateProfileImagePopover" popovertargetaction="hide">
        <span aria-hidden=”true”>❌</span>
        <span class="sr-only">Close</span>
    </button>
    <div id="updateProfileImagePopover-content">
        <form action="uploadProfileImage.php" method="post" enctype="multipart/form-data">
            <input type="file" name="profileImage" id="profileImage">
            <input type="submit" value="Upload Image" name="submit" class="btn btn-primary btn-sm">
            <input type="hidden" value="<?= $userData['id'] ?>" name="userID" id="userID">
        </form>
    </div>
</div>