<?php
//Created: 2024/12/05 09:36:35
//Last modified: 2024/12/06 13:45:47

// include_once "./API/dbheader.php";
include "./components/header.php";
include "./components/sidenav.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>County Connection Admin</title>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

</head>

<body>
    <div class='container-header'>
        <h1>County PIO Admin</h1>
    </div>
    <div class="admin-container">
        <div>
            <div>
                <p class="fs-5 text-center">Upload your County Connection Files here</p>
                <form action='/API/connectionupload.php' class='dropzone' id="connect-form"></form>
            </div>
            <hr>
            <div class='connection-container'>
                <div class='connection-menu'>
                    <span>Published Issues</span>
                    <div id="file-list"></div>
                </div>
                <!-- <div class='connection-content'>
                    <span>Actions</span>
                    <div id="file-actions"></div>
                </div> -->
            </div>
        </div>

        <div class="teamTuesday">
            <p class="fs-5 text-center">Create a Team Tuesday Entry</p>
            <form action="./API/addTeamTuesdayToDatabase.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" maxlength="125" placeholder="Example: Meet Joe Black" required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">County Department / Role</label>
                    <textarea class="form-control" id="department" name="department" rows="3" maxlength="255" placeholder="Example: Joe Black is a waffle engineer at Waffle House."></textarea>
                </div>
                <div class="mb-3">
                    <label for="describeYourself" class="form-label">Describe Yourself in Two Words</label>
                    <input type="text" class="form-control" id="describeYourself" name="describeYourself" maxlength="255" placeholder="Example: Purple Enigma."></input>
                </div>
                <div class="mb-3">
                    <label for="favoriteHobby" class="form-label">Favorite Hobby</label>
                    <input type="text" class="form-control" id="favoriteHobby" name="favoriteHobby" maxlength="125" placeholder="Example: Knitting kittens."></input>
                </div>
                <div class="mb-3">
                    <label for="favoriteOutsideInterest" class="form-label">Favorite Interest Outside of Work</label>
                    <textarea class="form-control" id="favoriteOutsideInterest" name="favoriteOutsideInterest" maxlength="255" placeholder="Example: Watching paint dry."></textarea>
                </div>
                <div class="mb-3">
                    <label for="favoriteShow" class="form-label">Favorite Show to binge Watch</label>
                    <input type="text" class="form-control" id="favoriteShow" name="favoriteShow" maxlength="125" placeholder="Example: The Office (Joe Black Edition)."></input>
                </div>
                <div class="mb-3">
                    <label for="favoriteVacation" class="form-label">Favorite Vacation Spot</label>
                    <input type="text" class="form-control" id="favoriteVacation" name="favoriteVacation" maxlength="125" placeholder="Example: The Moon."></input>
                </div>
                <div class="mb-3">
                    <label for="somethingUnique" class="form-label">Something Unique About You</label>
                    <textarea class="form-control" id="somethingUnique" name="somethingUnique" maxlength="1024" placeholder="Example: I can juggle 3 waffles at once."></textarea>
                </div>
                <div class="mb-3">
                    <label for="publishDate" class="form-label">Publish Date</label>
                    <input type="datetime-local" class="form-control" id="publishDate" name="publishDate" onchange="calculateExpirationDate(this.value)" required></input>
                    <!-- add hidden input that is 6 days and 23 hours from publish date -->
                    <input type="hidden" id="expirationDate" name="expirationDate" value=""></input>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required></input>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    Dropzone.options.connectForm = {
        paramName: "file",
        acceptedFiles: "application/pdf",
        chunking: true,
        chunkSize: 2000000,
        retryChunks: true,
        retryChunksLimit: 3,
        init: function() {
            this.on("success", function(file, response) {
                console.log(response);
                alert('File uploaded successfully');
            });
            this.on("complete", function(file) {
                this.removeFile(file);
            });
        }
    }
</script>
<script>
    function formatDateToMonthYear(dateString) {
        const date = new Date(dateString);
        const options = {
            year: 'numeric',
            month: 'short'
        };
        return date.toLocaleDateString('en-US', options);
    }

    function renderReadableFileName(fileName) {
        const fileNameParts = fileName.split('_');
        const year = fileNameParts[1];
        const month = fileNameParts[2];
        // const day = fileNameParts[3];
        // const time = fileNameParts[4].split('.')[0];
        // return `Connection ${year}-${month}-${day} ${time}`;
        return `Connection ${year}-${month}`;
    }

    function getFileList() {
        console.log('Fetching file list');
        fetch('./API/getCountyConnectionFileList.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const fileList = document.getElementById('file-list');
                const fileActions = document.getElementById('file-actions');
                data.forEach(file => {
                    const fileItem = document.createElement('div');
                    // fileItem.innerHTML = `<p>${renderReadableFileName(file.sFileName)}</p>`;
                    fileItem.innerHTML += `<p>${formatDateToMonthYear(file.dtUploadSubmitted)}</p>`;
                    // fileItem.innerHTML = `<p>${file.sFileName}</p>`;
                    fileList.appendChild(fileItem);

                    // const fileAction = document.createElement('div');
                    // fileAction.innerHTML = `<button class='btn btn-primary btn-sm'>Download</button>`;
                    // fileActions.appendChild(fileAction);
                });
            });
    }
    document.addEventListener("DOMContentLoaded", getFileList);
</script>
<script>
    async function getExistingTeamTuesday() {
        await fetch('./API/getAllTeamTuesdayDates.php')
            .then(response)
    }
</script>

<script>
    // function to calculate expiration date
    function calculateExpirationDate(publishDate) {
        // const publishDateValue = document.getElementById('publishDate').value;
        // const publishDate = new Date(publishDateValue);
        const expiratinDateHolder = document.getElementById('expirationDate');
        const expirationDate = new Date(publishDate);
        expirationDate.setDate(expirationDate.getDate() + 6);
        expirationDate.setHours(expirationDate.getHours() + 23);
        expiratinDateHolder.value = expirationDate.toISOString();
        // return expirationDate;
    }
</script>

<style>
    @font-face {
        font-family: Galada;
        src: url('./fonts/Galada.ttf');
    }

    .container-header {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        background-image: url('./images/hero-welcome-bg.png');
    }

    h1 {
        margin: 0 !important;
        padding: 0 !important;
        font-family: Galada;
        font-size: 50px;
        color: var(--bg);
        text-shadow: var(--accent) 1px 0 10px;
    }

    .admin-container {
        display: grid;
        grid-template-columns: 50% 50%;
        margin: 10px;
        padding: 10px;
    }


    .connection-container {
        margin: 20px;
        display: grid;
        grid-template-columns: 30% 70%;
    }

    .connection-menu {
        padding: 20px;
        border-right: 1px solid var(--accent);

        span {
            border-bottom: 1px solid var(--accent);
            margin-bottom: 20px;
        }
    }

    .connection-content {
        padding: 20px;

        span {
            border-bottom: 1px solid var(--accent);
            margin-bottom: 20px;
        }
    }

    .pdf-upload-container {
        margin-top: 20px;
        padding: 20px;
        border: 2px dashed var(--accent);
        border-radius: 10px;
        text-align: center;
    }

    .dropzone {
        /* padding: 20px; */
        /* border: 2px dashed var(--accent); */
        /* border-radius: 10px; */
        cursor: pointer;
        width: 50% !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .dropzone.dragover {
        background-color: var(--accent);
        color: var(--bg);
    }

    #file-browse {
        color: var(--accent);
        cursor: pointer;
        text-decoration: underline;
    }

    .btn-sm {
        border-radius: 6px;
        width: 100px;
    }

    .teamTuesday {
        margin-right: 10%;
    }
</style>