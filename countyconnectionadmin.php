<?php
//Created: 2024/12/05 09:36:35
//Last modified: 2024/12/05 10:14:52

// include_once "./API/dbheader.php";
include "./components/header.php";
include "./components/sidenav.php";

echo "<div class='container-header'>";
echo "<h1>County Connection Admin</h1>";
echo "</div>";

// PDF upload form
echo "<div class='pdf-upload-container'>";
echo "<form id='pdf-upload-form' action='./API/connectionupload.php' method='post' enctype='multipart/form-data'>";
echo "<input type='file' id='file-input' name='file' accept='application/pdf' hidden>";
echo "<div id='drop-zone' class='drop-zone'>";
echo "<p>Drag & Drop your PDF here or <span id='file-browse'>browse</span></p>";
echo "</div>";
echo "<hr>";
echo "<button class='btn btn-primary' type='submit'>Upload PDF</button>";
echo "</form>";
echo "</div>";


echo "<div class='connection-container'>";
echo "<div class='connection-menu'>";
echo "<p>List of Previous Uploads</p>";
echo "</div>";
echo "<div class='connection-content'>";
echo "<p>Actions</p>";
echo "</div>";
echo "</div>";





?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file-input');
        const fileBrowse = document.getElementById('file-browse');

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
            }
        });

        fileBrowse.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                dropZone.querySelector('p').textContent = fileInput.files[0].name;
            }
        });
    });
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
        grid-template-columns: 15% 85%;
    }

    .connection-menu {
        border-right: 1px solid var(--accent);
        padding: 20px
    }

    .connection-content {
        padding: 20px;
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
</style>