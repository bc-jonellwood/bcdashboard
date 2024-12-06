<?php
include_once "./dbheader.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = strip_tags($_POST['title']);
    $department = strip_tags($_POST['department']);
    $describeYourself = strip_tags($_POST['describeYourself']);
    $favoriteHobby = strip_tags($_POST['favoriteHobby']);
    $favoriteOutsideInterest = strip_tags($_POST['favoriteOutsideInterest']);
    $favoriteShow = strip_tags($_POST['favoriteShow']);
    $favoriteVacation = strip_tags($_POST['favoriteVacation']);
    $somethingUnique = strip_tags($_POST['somethingUnique']);
    $publishDate = strip_tags($_POST['publishDate']);
    $publishDateTimeStamp = strtotime($publishDate);
    $sqlPublishDate = date('Y-m-d H:i:s', $publishDateTimeStamp);
    $expirationDate = strip_tags($_POST['expirationDate']);
    $expirationDateTimeStamp = strtotime($expirationDate);
    $sqlExpirationDate = date('Y-m-d H:i:s', $expirationDateTimeStamp);

    // Handle image upload
    if (isset($_FILES["image"])) {
        error_log("Image file detected: " . print_r($_FILES, true));
        $targetDir = "../uploads/photos/teamtuesday/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Insert data into database
                $sql = "INSERT INTO data_team_tuesday (sTitle, sDepartment, sDescribeYourself, sFavoriteHobby, sFavoriteOutsideInterest, sFavoriteShow, sFavoriteVacation, sSomethingUnique, dtPublishDate, dtExpireDate, sPhotoPath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(1, $title);
                $stmt->bindParam(2, $department);
                $stmt->bindParam(3, $describeYourself);
                $stmt->bindParam(4, $favoriteHobby);
                $stmt->bindParam(5, $favoriteOutsideInterest);
                $stmt->bindParam(6, $favoriteShow);
                $stmt->bindParam(7, $favoriteVacation);
                $stmt->bindParam(8, $somethingUnique);
                $stmt->bindParam(9, $sqlPublishDate);
                $stmt->bindParam(10, $sqlExpirationDate);
                $stmt->bindParam(11, $targetFile);

                if ($stmt->execute()) {
                    echo "New record created successfully";
                } else {
                    echo "Error: ";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        error_log("No image file detected.");
        echo "No image file was uploaded.";
    }
}
