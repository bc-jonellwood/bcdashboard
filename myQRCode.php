<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/03 13:35:15
include "./components/header.php"
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<script>
    function generateQR() {
        clearCode();
        var text = document.getElementById("text").value;
        if (!text) {
            // throw new Error("Input text cannot be empty.");
            document.getElementById("text").value = 'https://berkeleycountysc.gov/';
        }
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: text,
            width: 256,
            height: 256,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode.makeCode(text);
    }

    function clearCode() {
        // document.getElementById("text").value = "";
        document.getElementById("qrcode").innerHTML = "";
    }

    function downloadQR() {
        try {
            var qrcodeElement = document.getElementById("qrcode");
            var canvas = document.createElement("canvas");
            var context = canvas.getContext("2d");

            // Set canvas dimensions
            canvas.width = 256;
            canvas.height = 256;

            // Draw the QR code onto the canvas
            var img = qrcodeElement.querySelector("img");
            if (!img) {
                throw new Error("No QR Code image found to download.");
            }

            context.drawImage(img, 0, 0);

            // Create a link to download the image
            var link = document.createElement("a");
            link.href = canvas.toDataURL("image/png");
            link.download = "qrcode.png";
            link.click();
        } catch (error) {
            console.error("Error downloading QR Code:", error.message);
            alert("An error occurred while downloading the QR Code: " + error.message);
        }
    }
</script>


<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="input-holder">
        <h2>Enter a URL and press "Enter" Key</h2>
    </div>
    <div class="input-holder">
        <input id="text" type="text" value="https://berkeleycountysc.gov/" style="width:80%" /><br />
    </div>
    <div class="code-holder">
        <div id="qrcode"></div>
    </div>
    <div class="button-holder">
        <button class="btn btn-primary" onclick="clearCode()">Clear QR Code</button>
        <button class="btn btn-primary" onclick="generateQR()">Generate QR Code</button>
        <button class="btn btn-primary" onclick="downloadQR()">Download QR Code</button>
    </div>
</div>
<?php include "./components/footer.php" ?>
<style>
    .input-holder,
    .code-holder,
    .button-holder {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .input-holder,
    .button-holder {
        display: flex;
        gap: 50px;
        max-height: 60px;
        margin-top: 50px;
    }

    #qrcode {
        width: 260px;
        height: 260px;
        margin-top: 15px;
    }
</style>

<script>
    var qrcode = new QRCode("qrcode");

    function makeCode() {
        var elText = document.getElementById("text");

        if (!elText.value) {
            // alert("Input a text");
            // elText.focus();
            elText.value = 'https://berkeleycountysc.gov/';
            return;
        }

        qrcode.makeCode(elText.value);
    }

    makeCode();

    $("#text").
    on("blur", function() {
        makeCode();
    }).
    on("keydown", function(e) {
        if (e.keyCode == 13) {
            makeCode();
        }
    });
</script>