<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2025/01/09 12:49:04
?>
<script>
    function closeToast() {
        var toast = document.getElementById("toast-popover")
        toast.hidePopover();
    }
</script>

<div id="toast-popover" class="toast-popover" name="toast-popover" popover>
    <div class="toast-popover-header">
        <h5 class="toast-popover-title" id="toast-popover-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" popovertarget="toast-popover" popovertargetaction="hide"></button>
    </div>
    <div class="toast-popover-body">
        <p id="toast-message"></p>
    </div>
</div>
</body>
<footer id="footer" class="footer">
    <div class="footer-text" style="min-width: -webkit-fill-available" ;>
        <!-- <img src=" ./icons/help.svg" alt="help" width="32" height="32" /> -->
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
            <path fill="#E3E3E3"
                d="M10 .4A9.6 9.6 0 0 0 .4 10a9.6 9.6 0 1 0 19.2-.001C19.6 4.698 15.301.4 10 .4m-.151 15.199h-.051c-.782-.023-1.334-.6-1.311-1.371c.022-.758.587-1.309 1.343-1.309l.046.002c.804.023 1.35.594 1.327 1.387c-.023.76-.578 1.291-1.354 1.291m3.291-6.531c-.184.26-.588.586-1.098.983l-.562.387q-.46.358-.563.688c-.056.174-.082.221-.087.576v.09H8.685l.006-.182c.027-.744.045-1.184.354-1.547c.485-.568 1.555-1.258 1.6-1.287a1.7 1.7 0 0 0 .379-.387c.225-.311.324-.555.324-.793c0-.334-.098-.643-.293-.916c-.188-.266-.545-.398-1.061-.398c-.512 0-.863.162-1.072.496c-.216.341-.325.7-.325 1.067v.092H6.386l.004-.096c.057-1.353.541-2.328 1.435-2.897c.563-.361 1.264-.544 2.081-.544c1.068 0 1.972.26 2.682.772c.721.519 1.086 1.297 1.086 2.311c-.001.567-.18 1.1-.534 1.585"
                class="contrast" />
        </svg>
        <div id='add-year'>Developed by Berkeley County Government IT Department <a href="/nimda/index.php" class="hidden-link">&copy;</a></div>
        <div><a href='/changelog/index.html' target="_blank">App Version: 0.0.0</a></div>
        <div id='mode'>User: <a href='/user/index.php?id=<?php echo $_SESSION['userID']; ?>' class="hidden-link">Awesome Cat</a></div>
        <!-- <a href='/changelogView.php' target='_blank'>App Version: -->
        <!-- <//?php echo $_SESSION['appVersion'] ?></a> -->

    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

<style>
    .footer {
        padding: 10px;
    }

    .footer-text {
        display: flex;
        flex-direction: row;
        /* width: 97%; */
        justify-content: space-around;
        align-items: center;
        margin: 2px;
        /* margin-top: 10px; */
        border-radius: 7px;
        padding: 5px;
        background-color: var(--bg);
        color: var(--fg);
        font-size: medium;
    }

    .toast-popover {
        width: 15em;
        height: 4em;
        padding: 10px;
        /* background-color: light-dark(#242424, #808080); */
        background-color: var(--bg);
        /* color: light-dark(#000, #fff); */
        color: var(--fg);
        border: 2px solid;
        border-color: light-dark(#111, #ddd);
        border-radius: 7px;
        position: fixed;
        bottom: 0;
        right: 0;
    }

    .toast-popover-header {
        display: flex;
        justify-content: space-between;
        font-size: medium;
    }

    .success {
        /* color: var(--success); */
        border-color: var(--success);
    }

    .toast-popover-body {
        font-size: medium;
        color: light-dark(#000, #ccc);
    }

    [popover]:popover-open {
        translate: 0 0;
    }

    [popover] {
        transition: translate 0.7s ease-out, display 0.7s ease-out allow-discrete;
        translate: 30rem 0;

    }

    @starting-style {
        [popover]:popover-open {
            translate: 20rem 0;
        }
    }

    #toast-popover {
        position: fixed;
        bottom: 0;
        right: 0;
        margin-top: 88dvh;
        margin-left: 75dvw;
    }

    .hidden-link {
        text-decoration: none;
        color: inherit;
        cursor: inherit;
    }

    .hidden-link:hover {
        text-decoration: none;
        color: inherit;
        cursor: inherit;
    }
</style>