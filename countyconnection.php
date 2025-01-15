<?php
//Created: 2024/12/05 09:36:35
//Last modified: 2025/01/15 14:46:12

// include_once "./API/dbheader.php";
// include "./components/header.php";
// include "./components/sidenav.php";
include(dirname(__FILE__) . '/components/header.php');
include(dirname(__FILE__) . '/components/sidenav.php');
$pageId = '3B94B683-70DF-40B1-8CC6-5EA91E46AB03';
$accessRequired = Page::getAccessRequired($pageId);
AccessControl::enforce($accessRequired);
?>
?>

<div class='container-header'>
    <h1>County Connection</h1>
</div>
<div class='connection-container'>
    <div class='connection-menu' id='connection-menu'>
        <p>Issues</p>
        <hr>
    </div>
    <div class='connection-content' id='connection-content'>
        <p>Content</p>
        <hr>
    </div>
    <div id="pdf-controls" class="pdf-controls">
        <span>
            <button id="prev-page" class="btn btn-sm btn-info">Previous</button>
            <button id="next-page" class="btn btn-sm btn-info">Next</button>
        </span>
        <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
        <span><input name="scale" type="range" min="1" max="2.5" step=".25" value="1.5" onchange="updateScale(this.value)"></span>
        <label for="scale" class="text-muted fs-6">Scale</label>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script>
    function updateScale(val) {
        scale = val;
        renderPage(pageNum);
    }

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

    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1.5,
        canvas = document.createElement('canvas'),
        ctx = canvas.getContext('2d');

    document.getElementById('connection-content').appendChild(canvas);

    function renderPage(num) {
        pageRendering = true;
        pdfDoc.getPage(num).then(page => {
            const viewport = page.getViewport({
                scale: scale
            });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            const renderTask = page.render(renderContext);

            renderTask.promise.then(() => {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        document.getElementById('page-num').textContent = num;
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }

    document.getElementById('prev-page').addEventListener('click', onPrevPage);
    document.getElementById('next-page').addEventListener('click', onNextPage);

    function loadPDF(filePath) {
        const pdfContainer = document.getElementById('connection-content');
        pdfContainer.innerHTML = ''; // Clear previous content
        pdfContainer.appendChild(canvas); // Re-append canvas

        pageNum = 1; // Reset page number to 1

        pdfjsLib.getDocument(filePath).promise.then(pdf => {
            pdfDoc = pdf;
            document.getElementById('page-count').textContent = pdf.numPages;
            renderPage(pageNum);
        });
    }

    function getFileList() {
        console.log('Fetching file list');
        fetch('./API/getCountyConnectionFileList.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const fileList = document.getElementById('connection-menu');
                const fileActions = document.getElementById('file-actions');
                data.forEach(file => {
                    let i = 0;
                    const fileItem = document.createElement('div');
                    // fileItem.innerHTML = `<p>${renderReadableFileName(file.sFileName)}</p>`;
                    fileItem.innerHTML += `<p><button id='btn-${i}' class='not-btn issue-btn' value='${file.sFileName}'>${formatDateToMonthYear(file.dtUploadSubmitted)}</button></p>`;
                    // fileItem.innerHTML = `<p>${file.sFileName}</p>`;
                    fileList.appendChild(fileItem);

                    fileItem.querySelector('button').addEventListener('click', function() {
                        loadPDF(this.value);
                    });
                });
            });
        setTimeout(clickFirstItem, 500);
    }
    document.addEventListener("DOMContentLoaded", getFileList);
</script>
<script>
    function clickFirstItem() {
        const firstItem = document.getElementById('btn-0');
        console.log(firstItem);
        if (firstItem) {
            firstItem.click();
            console.log('Button found');
            // console.log(firstItem.length);
        } else {
            console.log('Button not found');
        }
    }
    // document.addEventListener("DOMContentLoaded", setTimeout(clickFirstItem, 1000));
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
        grid-template-columns: 10% 90%;
    }

    .connection-menu {
        border-right: 1px solid var(--accent);
        padding: 20px
    }

    .connection-content {
        padding: 20px;
        display: flex;
        justify-content: center;
    }

    .pdf-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        flex-direction: column;
        position: absolute;
        right: 0;
        margin-right: 20px;

        span {
            font-size: medium;
        }
    }
</style>