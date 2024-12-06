<?php
//Created: 2024/12/05 09:36:35
//Last modified: 2024/12/05 15:47:52

// include_once "./API/dbheader.php";
include "./components/header.php";
include "./components/sidenav.php";
?>

<!-- 
// echo "<div class='container-header'>";
// echo "<h1>County Connection Admin</h1>";
// echo "</div>";

// PDF upload form
// echo "<div class='pdf-upload-container'>";
// echo "<form id='pdf-upload-form' action='./API/connectionupload.php' method='post' enctype='multipart/form-data'>";
// echo "<input type='file' id='file-input' name='file' accept='application/pdf' hidden>";
// echo "<div id='drop-zone' class='drop-zone'>";
// echo "<p>Drag & Drop your PDF here or <span id='file-browse'>browse</span></p>";
// echo "</div>";
// echo "<hr>";
// echo "<button class='btn btn-primary' type='submit'>Upload PDF</button>";
// echo "</form>";
// echo "<form action='/target' class='dropzone'></form>";
// echo "</div>";


// echo "<div class='connection-container'>";
// echo "<div class='connection-menu'>";
// echo "<p>List of Previous Uploads</p>";
// echo "</div>";
// echo "<div class='connection-content'>";
// echo "<p>Actions</p>";
// echo "</div>";
// echo "</div>"; -->

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
        <h1>County Connection Admin</h1>
    </div>
    <div>
        <form action='/API/connectionupload.php' class='dropzone' id="connect-form"></form>
    </div>
    <hr>
    <div class='connection-container'>
        <div class='connection-menu'>
            <span>List of Previous Uploads</span>
            <div id="file-list"></div>
        </div>
        <div class='connection-content'>
            <span>Actions</span>
            <div id="file-actions"></div>
        </div>
    </div>
</body>

</html>



<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     const dropZone = document.getElementById('drop-zone');
    //     const fileInput = document.getElementById('file-input');
    //     const fileBrowse = document.getElementById('file-browse');

    //     dropZone.addEventListener('dragover', (e) => {
    //         e.preventDefault();
    //         dropZone.classList.add('dragover');
    //     });

    //     dropZone.addEventListener('dragleave', () => {
    //         dropZone.classList.remove('dragover');
    //     });

    //     dropZone.addEventListener('drop', (e) => {
    //         e.preventDefault();
    //         dropZone.classList.remove('dragover');
    //         if (e.dataTransfer.files.length) {
    //             fileInput.files = e.dataTransfer.files;
    //         }
    //     });

    //     fileBrowse.addEventListener('click', () => {
    //         fileInput.click();
    //     });

    //     fileInput.addEventListener('change', () => {
    //         if (fileInput.files.length) {
    //             dropZone.querySelector('p').textContent = fileInput.files[0].name;
    //         }
    //     });
    // });
</script>
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
                    fileItem.innerHTML = `<p>${renderReadableFileName(file.sFileName)}</p>`;
                    // fileItem.innerHTML = `<p>${file.sFileName}</p>`;
                    fileList.appendChild(fileItem);

                    const fileAction = document.createElement('div');
                    fileAction.innerHTML = `<button class='btn btn-primary btn-sm'>Download</button>`;
                    fileActions.appendChild(fileAction);
                });
            });
    }
    document.addEventListener("DOMContentLoaded", getFileList);
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

    .drop-zone {
        padding: 20px;
        border: 2px dashed var(--accent);
        border-radius: 10px;
        cursor: pointer;
    }

    .drop-zone.dragover {
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
</style>