<?php
// Created: 2024/11/06 09:26:16
// Last modified: 2024/12/03 11:00:24

if (!isset($_SESSION)) {
    session_start();
}
include "./components/header.php"
?>
<script>
    async function getInfoForSig() {
        const deptNameHolder = document.getElementById('deptName');
        const jobTitleHolder = document.getElementById('jobTitle');
        const phoneNumberHolder = document.getElementById('phoneNumber');
        const emailAddressHolder = document.getElementById('emailAddress');
        await fetch('./API/getUserInfoForSig.php')
            .then(response => response.json())
            .then(data => {
                console.log(data)
                deptNameHolder.innerText = data[0].sDepartmentName ? data[0].sDepartmentName : 'Tired Mongoose';
                jobTitleHolder.innerText = data[0].sJobTitle ? data[0].sJobTitle : 'Valued Employee';
                phoneNumberHolder.innerText = data[0].sMainPhoneNumber ? 'T : ' + data[0].sMainPhoneNumber : 'T: 843-719-4243';
                emailAddressHolder.innerText = data[0].sEmail ? data[0].sEmail : 'info@berkeleycountysc.gov'
                emailAddressHolder.href = data[0].sEmail ? `mailto:${data[0].sEmail}` : 'mailto:info@berkeleycountysc.gov';
            })
    }
</script>

<link rel="stylesheet" href="./styles/signature.css">
<div class="main">
    <div class="content">
        <?php include "./components/sidenav.php" ?>
        <div class="user_email_signature">
            <div id="copy_signature">
                <table cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td class="signature_badge" rowspan="12">
                                <a href="https://www.berkeleycountysc.gov/" target="_blank"><img border="0" id="badge" alt="Berkeley County Government" width="120" height="120" src="https://bic.berkeleycountysc.gov/assets/sealnew2020.png" style="margin-right:10px;"></a>
                                <!--SPACER-->
                                <img border="0" alt="Spacer" width="5" height="88" src="https://bic.berkeleycountysc.gov/assets/logo_spacer.png" style="margin-right:10px;">
                            </td>
                            <td valign="middle">
                                <table cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td colspan="2"><strong>
                                                    <?php if (isset($_SESSION['PreferredName'])) {
                                                        echo $_SESSION['PreferredName'] . ' ' . $_SESSION['LastName'];
                                                    } elseif (isset($_SESSION['FirstName'])) {
                                                        echo $_SESSION['FirstName'] . ' ' . $_SESSION['LastName'];
                                                    } else {
                                                        echo "Crazy Bird";
                                                    }
                                                    ?>
                                                </strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="d-flex gap-1">
                                                <p id="deptName">Information Technology</p>:<p id="jobTitle">SOFTWARE DEVELOPER</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" id="phoneNumber" class="d-flex gap-1">T: 843-719-5132</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">
                                                <a href="mailto:Jon.ellwood@berkeleycountysc.gov" id="emailAddress">Jon.ellwood@berkeleycountysc.gov</a><br>
                                                <a href="https://www.berkeleycountysc.gov" target="_blank">www.berkeleycountysc.gov</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">1003 US Highway 52 Moncks Corner, SC 29461</td>
                                        </tr>
                                        <tr>
                                            <td class="social_links" colspan="9"><a href="https://www.facebook.com/BerkeleySCGov/" target="_blank"><img alt="Facebook icon" border="0" width="23" height="23" src="https://berkeleycountysc.gov/images/logos/fb.png"></a><a href="https://twitter.com/berkeleyscgov" target="_blank"><img alt="Twitter icon" border="0" width="23" height="23" src="https://berkeleycountysc.gov/images/logos/tt.png"></a><a href="https://www.youtube.com/user/BerkeleyCountyGov/" target="_blank"><img alt="YouTube icon" border="0" width="23" height="23" src="https://berkeleycountysc.gov/images/logos/yt.png"></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="copy_options">
                <span class="copy_logo"><span class="ui-icon ui-icon-clipboard"></span>Copy For</span>
                <button class="btn btn-small btn-secondary" type="button" onclick="htmlClick('visual')">
                    Desktop
                </button>
                <button class="btn btn-small btn-info" type="button" onclick="htmlClick('text')">
                    Phone
                </button>
                <button class="btn btn-small btn-danger" type="button" onclick="holidayswap()">
                    Holiday
                </button>
            </div>
            <!-- <link href="/assets/email_signature-7c8cd2ed292c990d3069230944ff25c4.css" media="all" rel="stylesheet" type="text/css"> -->
            <!-- <script src="/assets/signature_copy-cddf2ff838a927d2408bb3574d833f3c.js" type="text/javascript"></script> -->
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        getInfoForSig();
    })
</script>
<style>
    .main {
        overflow: auto;
        margin-left: 20px;
        margin-right: 20px;
        /* display: grid; */
        /* grid-template-columns: 5fr 1fr; */
        /* grid-template-columns: 5fr 2fr; */
    }

    .user_email_signature {
        border: 1px solid;
        border-color: var(--accent);
    }

    .user_email_signature #copy_signature {
        width: 75%;
    }

    .social_links {
        display: flex;
        justify-content: flex-start;
    }
</style>

<script>
    function iosCopyToClipboard(e) {
        var t = e.contentEditable,
            n = e.readOnly,
            a = document.createRange();
        e.contentEditable = !0,
            e.readOnly = !1,
            a.selectNodeContents(e);
        var c = window.getSelection();
        c.removeAllRanges(),
            c.addRange(a),
            e.setSelectionRange(0, 999999),
            e.contentEditable = t,
            e.readOnly = n
    }

    function getID() {
        return document.getElementById("copy_signature")
    }

    function selectIt(e) {
        var t = $("<textarea>").val(e);
        t.appendTo(".user_email_signature").select(),
            t.attr("class", "hide_after_choosing")
    }

    function getText(e) {
        return textID = e.innerHTML,
            textID = textID.replace(/<tr.*\W>/gi, ""),
            textID = textID.replace(/(<\/tr>).*<tr.*\W>/gi, "\n"),
            textID = textID.replace(/<tr>/gi, ""),
            textID = textID.replace(/(<\/tr>).*(<tr>)/gi, "\n\r"),
            textID = textID.replace(/(<\/tr>)/gi, "\n\r"),
            textID = textID.replace(/([<td].*\W>)/gi, ""),
            textID = textID.replace(/<td.*\W>/gi, ""),
            textID = textID.replace(/<td>/gi, ""),
            textID = textID.replace(/<\/td>/gi, ""),
            textID = textID.replace(/<tbody>/gi, ""),
            textID = textID.replace(/<\/tbody>/gi, ""),
            textID = textID.replace(/<table>/gi, ""),
            textID = textID.replace(/<\/table>/gi, ""),
            textID = textID.replace(/<strong>/gi, ""),
            textID = textID.replace(/<\/strong>/gi, ""),
            textID = textID.replace(/<br>/gi, "\r"),
            textID = textID.replace(/<a>/gi, ""),
            textID = textID.replace(/<a.*\W>/gi, ""),
            textID = textID.replace(/<\/a>/gi, ""),
            textID = textID.replace(/<img.*\W>/gi, ""),
            textID = textID.replace(/\B\n\s/g, ""),
            textID = textID.replace(/\B\s\s/g, ""),
            textID = textID.replace(/\b.\B\t/g, "\n"),
            textID = textID.replace(/\B\s/g, ""),
            textID
    }

    function selectText(e) {
        if (e = document.getElementById(e),
            document.body.createTextRange) {
            const t = document.body.createTextRange();
            t.moveToElementText(e),
                t.select()
        } else if (window.getSelection) {
            const n = window.getSelection(),
                t = document.createRange();
            t.selectNodeContents(e),
                n.removeAllRanges(),
                n.addRange(t)
        } else
            console.warn("Could not select text in node: Unsupported browser.")
    }

    function htmlClick(e) {
        switch (e) {
            case "text":
                dummyContent = getText(getID()),
                    dummy = selectIt(dummyContent),
                    iosCopyToClipboard(document.getElementsByClassName("hide_after_choosing")[0]);
                break;
            case "visual":
                selectText("copy_signature");
                break;
            default:
                dummyContent = "<table>" + getID() + "</table>",
                    dummy = selectIt(dummyContent)
        }
        document.execCommand("copy"),
            $(".hide_after_choosing").remove()
    }

    function holidayswap() {
        document.getElementById("badge").src.includes("Xmas") ? document.getElementById("badge").src = defaultBadge : (defaultBadge = document.getElementById("badge").src,
            document.getElementById("badge").src = "https://bic.berkeleycountysc.gov/Berkeley%20County%20-%20Easter%20Logo.png")
    }
    var defaultBadge;
</script>