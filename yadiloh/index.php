<?php
// Created: 2025/01/09 10:53:08
// Last modified: 2025/01/15 14:41:32
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../yadiloh/adminnav.php');
$pageId = 'bde8e412-daae-4cc8-bcad-16b914680465';
$accessRequired = Page::getAccessRequired($pageId);
AccessControl::enforce($accessRequired);
?>

<div class="main">
    <div class="container">
        <div class="edit-holidays hidden">
            <button class="not-btn" onclick='showHolidaysTable()' type="button">Fetch Holidays</button>
        </div>
        <div class="add-holidays hidden">
            <button class="not-btn" onclick="showAddHolidayForm()" type="button">Create Add Form</button>
            <div id="add-form" class="add-form"></div>
        </div>
    </div>

    <div id="edit-form-popover" name="edit-form-popover" class="edit-form-popover" popover="manual">
        <button class="btn btn-danger" popovertarget="edit-form-popover" popovertargetaction="hide">X</button>
        <div id="edit-form"></div>
    </div>
</div>

<script>
    function generateGUID() {
        const randomHex = () => Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1).toUpperCase();
        return `${randomHex()}${randomHex()}-${randomHex()}-${randomHex()}-${randomHex()}-${randomHex()}${randomHex()}${randomHex()}`;
    }
    async function showHolidaysTable() {
        await fetch('/API/getHolidays.php')
            .then(response => response.json())
            .then(data => {
                //console.log(data);
                let table = document.createElement('table');
                table.setAttribute('class', 'table');
                let thead = document.createElement('thead');
                let tbody = document.createElement('tbody');
                let tr = document.createElement('tr');
                let th1 = document.createElement('th');
                let th2 = document.createElement('th');
                let th3 = document.createElement('th');
                // let th4 = document.createElement('th');
                // let th5 = document.createElement('th');
                let th6 = document.createElement('th');
                th1.innerHTML = 'Name';
                th2.innerHTML = 'Date';
                th3.innerHTML = 'Group ID';
                // th4.innerHTML = 'Icon';
                // th5.innerHTML = 'Class';
                th6.innerHTML = 'Actions';
                tr.appendChild(th1);
                tr.appendChild(th2);
                tr.appendChild(th3);
                // tr.appendChild(th4);
                // tr.appendChild(th5);
                tr.appendChild(th6);
                thead.appendChild(tr);
                table.appendChild(thead);
                data.forEach(link => {
                    let tr = document.createElement('tr');
                    tr.dataset.id = link.id;
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    // let td4 = document.createElement('td');
                    // let td5 = document.createElement('td');
                    let td6 = document.createElement('td');
                    td1.dataset.id = 'sName';
                    td1.innerHTML = link.sName ? link.sName : 'No Name';
                    td1.value = link.sName;
                    td2.dataset.id = 'dtDate';
                    td2.value = link.dtDate;
                    td2.innerHTML = link.dtDate;
                    td3.dataset.id = 'iGroupId';
                    td3.value = link.iGroupId;
                    td3.innerHTML = link.iGroupId;
                    // td4.dataset.id = 'sIcon';
                    // td4.innerHTML = link.sIcon;
                    // td5.dataset.id = 'sClass';
                    // td5.innerHTML = link.sClass;
                    let editButton = document.createElement('button');
                    editButton.setAttribute('class', 'not-btn');
                    editButton.innerHTML = 'Edit';
                    editButton.setAttribute('popovertarget', 'edit-form-popover');
                    editButton.setAttribute('popovertargetaction', 'show');
                    editButton.onclick = function() {
                        showEditHolidayForm(link.id);
                    };
                    td6.appendChild(editButton);
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    // tr.appendChild(td4);
                    // tr.appendChild(td5);
                    tr.appendChild(td6);
                    tbody.appendChild(tr);
                });
                table.appendChild(tbody);
                document.getElementsByClassName('edit-holidays')[0].appendChild(table);
            });
    }

    function showEditHolidayForm(id) {
        // console.log("proof of life" + id);
        let dataRow = document.querySelector('[data-id="' + id + '"]');
        let currentName = dataRow.querySelector('[data-id="sName"]').value;
        let currentDate = dataRow.querySelector('[data-id="dtDate"]').value;
        let currentGroupId = dataRow.querySelector('[data-id="iGroupId"]').value;

        let form = document.createElement('form');
        form.setAttribute('class', 'edit-link-form');
        form.setAttribute('id', 'edit-holiday-form');
        let label1 = document.createElement('label');
        label1.innerHTML = 'Name';
        let input1 = document.createElement('input');
        input1.setAttribute('type', 'text');
        input1.setAttribute('name', 'sName');
        input1.setAttribute('value', currentName);
        let label2 = document.createElement('label');
        label2.innerHTML = 'Date';
        let input2 = document.createElement('input');
        input2.setAttribute('type', 'date');
        input2.setAttribute('name', 'dtDate');
        input2.setAttribute('value', currentDate);
        let label3 = document.createElement('label');
        label3.innerHTML = 'Group ID';
        let input3 = document.createElement('input');
        input3.setAttribute('type', 'text');
        input3.setAttribute('name', 'iGroupId');
        input3.setAttribute('value', currentGroupId);
        let input4 = document.createElement('input');
        input4.setAttribute('type', 'hidden');
        input4.setAttribute('name', 'id');
        input4.setAttribute('value', id);
        let submitButton = document.createElement('button');
        submitButton.setAttribute('type', 'button');
        submitButton.setAttribute('class', 'btn btn-sm btn-primary');
        submitButton.innerHTML = 'Update';
        submitButton.onclick = function() {
            submitEditHolidayForm(id);
        };
        form.appendChild(label1);
        form.appendChild(input1);
        form.appendChild(label2);
        form.appendChild(input2);
        form.appendChild(label3);
        form.appendChild(input3);
        form.appendChild(input4);
        form.appendChild(submitButton);
        document.getElementById('edit-form').append(form);
    }

    function submitEditHolidayForm() {
        let popover = document.getElementById('edit-form-popover');
        let form = document.getElementById('edit-holiday-form');
        console.log(form);
        let formData = new FormData(form);
        fetch('updateHolidayData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === '200') {
                    popover.hidePopover();
                    alert('Holiday updated successfully.');
                    setTimeout(location.reload(), 500);
                }
            })
    }


    function showAddHolidayForm() {
        var createBtn = document.getElementById('create-add-btn');
        let form = document.createElement('form');
        form.setAttribute('class', 'add-link-form');
        form.setAttribute('id', 'add-holiday-form');
        let label1 = document.createElement('label');
        label1.innerHTML = 'Name';
        let input1 = document.createElement('input');
        input1.setAttribute('type', 'text');
        input1.setAttribute('name', 'sName');
        let label2 = document.createElement('label');
        label2.innerHTML = 'Date';
        let input2 = document.createElement('input');
        input2.setAttribute('type', 'date');
        input2.setAttribute('name', 'dtDate');
        let label3 = document.createElement('label');
        label3.innerHTML = 'Group ID';
        let input3 = document.createElement('input');
        input3.setAttribute('type', 'text');
        input3.setAttribute('name', 'iGroupId');

        let submitButton = document.createElement('button');
        submitButton.setAttribute('type', 'button');
        submitButton.setAttribute('class', 'btn btn-sm btn-primary');
        submitButton.innerHTML = 'Add';
        submitButton.onclick = function() {
            submitAddHolidayForm();
        };
        form.appendChild(label1);
        form.appendChild(input1);
        form.appendChild(label2);
        form.appendChild(input2);
        form.appendChild(label3);
        form.appendChild(input3);
        form.appendChild(submitButton);
        document.getElementById('add-form').append(form);
        createBtn.style.display = 'none';
    }

    function submitAddHolidayForm() {
        var createBtn = document.getElementById('create-add-btn');
        let form = document.getElementById('add-holiday-form');
        let formData = new FormData(form);
        fetch('addHolidayData.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === '200') {
                    createBtn.style.display = 'block';
                    alert('Holiday added successfully.');
                    setTimeout(location.reload(), 500);
                }
            })
    }
</script>
<style>
    .main {
        display: grid;
        grid-template-columns: 80% 20%;
    }

    .container {
        /* display: grid; */
        /* grid-template-columns: 80% 20%; */
        margin-left: 10px !important;
        margin-right: 10px !important;
    }

    .table {
        background-color: var(--bg);
        color: var(--fg);
        font-size: large;
    }

    popover {
        inset: auto;

    }

    .edit-form-popover {
        font-size: large;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: var(--bg);
        color: var(--fg);
        padding: 20px;
        border-radius: 7px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        /* display: none; */
        backdrop-filter: blur(10px) !important;
    }

    .edit-link-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 20px;
        position: relative;
    }

    .edit-form-popover.btn-danger {
        position: absolute;
        top: 0;
        margin-top: 20px;
        right: 0;
        margin-right: 20px;
    }

    .add-form {
        width: 50%;
        margin-left: auto;
        margin-right: auto;
    }

    /* :popover-open {
            backdrop-filter: blur(10px) !important;
        } */
    ::backdrop {
        backdrop-filter: blur(5px) !important;
    }
</style>