<?php
// Created: 2025/01/09 12:30:54
// Last modified:

include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../classes/User.php');
include(dirname(__FILE__) . '/../functions/logErrors.php');

$user = new User();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = trim($id, "'");
    $userData = $user->getUser($id);
}

?>
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
                                </div>
                            </div>
                            <div class="col-12">

                                <button class="btn btn-primary btn-sm" type="button" onclick="createPopover('updateProfileImage')">Update Profile Image</button>
                                <?php if (isset($userData['bIsLDAP']) && $userData['bIsLDAP'] == 0) {
                                    echo '<button class="btn btn-primary btn-sm" type="button" onclick="createPopover(\'updatePassword\')">Update Password</button>';
                                } ?>
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

<script>
    function createPopover(type) {
        // Remove any existing popovers
        const existingPopover = document.getElementById("popover");
        if (existingPopover) {
            existingPopover.remove();
        }

        // Create the container
        const popover = document.createElement("div");
        popover.className = type + "Popover";
        // popover.id = type + "Popover";
        popover.id = 'popover';
        popover.setAttribute("popover", "manual");

        // Add a close button
        const closeButton = document.createElement("button");
        closeButton.className = "btn-close mb-2";
        closeButton.setAttribute("popovertarget", type + "Popover");
        closeButton.setAttribute("popovertargetaction", "hide");
        closeButton.innerHTML = `<span aria-hidden="true">❌</span><span class="sr-only">Close</span>`;
        closeButton.addEventListener("click", () => popover.remove());
        popover.appendChild(closeButton);

        // Add from         const formContainer = document.createElement("div");
        formContainer.id = type + "Popover-content";
        // <input type="hidden" value="${userID}" name="userID" id="userID">

        if (type === "updateProfileImage") {
            formContainer.innerHTML = `
            <form action="uploadProfileImage.php" method="post" enctype="multipart/form-data">
                <input type="file" name="profileImage" id="profileImage">
                <input type="submit" value="Upload Image" name="submit" class="btn btn-primary btn-sm">
                <input type="hidden" value="<?= $userData['id'] ?>" name="userID" id="userID">
            </form>`;
        } else if (type === "updatePassword") {
            formContainer.innerHTML = `
            <form method="post">
                <div class="form-group">
                    <label for="currentPassword">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                </div>
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>
                <input type="hidden" value="<?= $userData['id'] ?>" name="userID" id="userID">
                <input type="submit" value="Update" name="submit" class="btn btn-primary btn-sm">
            </form>`;
        } else {
            console.error("Unknown popover type:", type);
            return;
        }

        popover.appendChild(formContainer);

        // Append the popover 
        document.body.appendChild(popover);

        // position the popover here since the CSS is being  a pain and htis made it work.
        popover.style.inset = "auto";
        popover.style.display = "block";
        popover.style.position = "absolute";
        popover.style.top = "65%";
        popover.style.left = "50%";
        popover.style.transform = "translate(-50%, -50%)";
        // i give up on figuring out why the blur is not working.
        document.body.style.backdropFilter = "blur(5px)";
    }
</script>