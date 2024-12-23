<?php
// Created: 2024/12/23 09:40:59
// Last modified: 2024/12/23 13:47:56
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
include(dirname(__FILE__) . '/../nimda/adminnav.php');
?>

<div class="main">
    <div class="container">
        <div class="edit-links hidden">
            <button class='not-btn' onclick='showLinksTable()' type='button'>Fetch Links</button>
            <!-- <p>Here you can edit links.</p> -->
        </div>
        <div class="add-links hidden">
            <button class='not-btn' onclick='showAddLinkForm()' type='button' id='create-add-btn'>Create Add Form</button>
            <div id="add-form" class="add-form"></div>
            <!-- <p>Here you can find more stuff.</p> -->
        </div>
        <div class="other-things hidden">
            <h2>Other Things</h2>
            <p>Here you can find other things.</p>
        </div>
    </div>
    <div id="edit-form-popover" name="edit-form-popover" class="edit-form-popover" popover="manual">
        <button class="btn btn-danger" popovertarget="edit-form-popover" popovertargetaction="hide">X</button>
        <div id="edit-form"></div>
    </div>

    <script>
        function generateGUID() {
            const randomHex = () => Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1).toUpperCase();
            return `${randomHex()}${randomHex()}-${randomHex()}-${randomHex()}-${randomHex()}-${randomHex()}${randomHex()}${randomHex()}`;
        }
        async function showLinksTable() {
            await fetch('getAllLinkData.php')
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
                    let th4 = document.createElement('th');
                    let th5 = document.createElement('th');
                    let th6 = document.createElement('th');
                    th1.innerHTML = 'Active';
                    th2.innerHTML = 'Text';
                    th3.innerHTML = 'URL';
                    th4.innerHTML = 'Icon';
                    th5.innerHTML = 'Class';
                    th6.innerHTML = 'Actions';
                    tr.appendChild(th1);
                    tr.appendChild(th2);
                    tr.appendChild(th3);
                    tr.appendChild(th4);
                    tr.appendChild(th5);
                    tr.appendChild(th6);
                    thead.appendChild(tr);
                    table.appendChild(thead);
                    data.forEach(link => {
                        let tr = document.createElement('tr');
                        tr.dataset.id = link.id;
                        let td1 = document.createElement('td');
                        let td2 = document.createElement('td');
                        let td3 = document.createElement('td');
                        let td4 = document.createElement('td');
                        let td5 = document.createElement('td');
                        let td6 = document.createElement('td');
                        td1.dataset.id = 'isActive';
                        td1.innerHTML = link.bIsActive === '1' ? 'Yes' : 'No';
                        td1.value = link.bIsActive;
                        td2.dataset.id = 'sText';
                        td2.innerHTML = link.sText;
                        td3.dataset.id = 'sHref';
                        td3.innerHTML = link.sHref;
                        td4.dataset.id = 'sIcon';
                        td4.innerHTML = link.sIcon;
                        td5.dataset.id = 'sClass';
                        td5.innerHTML = link.sClass;
                        let editButton = document.createElement('button');
                        editButton.setAttribute('class', 'not-btn');
                        editButton.innerHTML = 'Edit';
                        editButton.setAttribute('popovertarget', 'edit-form-popover');
                        editButton.setAttribute('popovertargetaction', 'show');
                        editButton.onclick = function() {
                            showEditLinkForm(link.id);
                        };
                        td6.appendChild(editButton);
                        tr.appendChild(td1);
                        tr.appendChild(td2);
                        tr.appendChild(td3);
                        tr.appendChild(td4);
                        tr.appendChild(td5);
                        tr.appendChild(td6);
                        tbody.appendChild(tr);
                    });
                    table.appendChild(tbody);
                    document.getElementsByClassName('edit-links')[0].appendChild(table);
                });
        }

        function showEditLinkForm(id) {
            let dataRow = document.querySelector('[data-id="' + id + '"]');
            let currentIsActive = dataRow.querySelector('[data-id="isActive"]').value;
            let currentText = dataRow.querySelector('[data-id="sText"]').innerHTML;
            let currentHref = dataRow.querySelector('[data-id="sHref"]').innerHTML;
            let currentIcon = dataRow.querySelector('[data-id="sIcon"]').innerHTML;
            let currentClass = dataRow.querySelector('[data-id="sClass"]').innerHTML;

            let form = document.createElement('form');
            form.setAttribute('class', 'edit-link-form');
            form.setAttribute('id', 'edit-link-form');
            // sText
            let label1 = document.createElement('label');
            label1.innerHTML = 'Text';
            let input1 = document.createElement('input');
            input1.setAttribute('type', 'text');
            input1.setAttribute('name', 'sText');
            input1.setAttribute('value', currentText);
            // sHref
            let label2 = document.createElement('label');
            label2.innerHTML = 'URL';
            let input2 = document.createElement('input');
            input2.setAttribute('type', 'text');
            input2.setAttribute('name', 'sHref');
            input2.setAttribute('value', currentHref);
            // sIcon
            let label3 = document.createElement('label');
            label3.innerHTML = 'Icon';
            let input3 = document.createElement('input');
            input3.setAttribute('type', 'text');
            input3.setAttribute('name', 'sIcon');
            input3.setAttribute('value', currentIcon);
            // sClass
            let label4 = document.createElement('label');
            label4.innerHTML = 'Class';
            // let input4 = document.createElement('input');
            // input4.setAttribute('type', 'text');
            // input4.setAttribute('name', 'sClass');
            // input4.setAttribute('value', currentClass);
            let classSelect = document.createElement('select');
            classSelect.setAttribute('name', 'sClass');
            let classOption1 = document.createElement('option');
            classOption1.setAttribute('value', 'emp');
            classOption1.innerHTML = 'Employee';
            let classOption2 = document.createElement('option');
            classOption2.setAttribute('value', 'com');
            classOption2.innerHTML = 'Communucation';
            let classOption3 = document.createElement('option');
            classOption3.setAttribute('value', 'app');
            classOption3.innerHTML = 'Application';
            if (currentClass === 'emp') {
                classOption1.setAttribute('selected', 'selected');
            } else if (currentClass === 'com') {
                classOption2.setAttribute('selected', 'selected');
            } else {
                classOption3.setAttribute('selected', 'selected');
            }
            classSelect.appendChild(classOption1);
            classSelect.appendChild(classOption2);
            classSelect.appendChild(classOption3);
            // isActive
            let label5 = document.createElement('label');
            label5.innerHTML = 'Active';
            let select = document.createElement('select');
            select.setAttribute('name', 'bIsActive');
            let optionYes = document.createElement('option');
            optionYes.setAttribute('value', '1');
            optionYes.innerHTML = 'Yes';
            let optionNo = document.createElement('option');
            optionNo.setAttribute('value', '0');
            optionNo.innerHTML = 'No';
            if (currentIsActive === '1') {
                optionYes.setAttribute('selected', 'selected');
            } else {
                optionNo.setAttribute('selected', 'selected');
            }
            select.appendChild(optionYes);
            select.appendChild(optionNo);
            // id hidden input for passing id to update script
            let input6 = document.createElement('input');
            input6.setAttribute('type', 'hidden');
            input6.setAttribute('name', 'id');
            input6.setAttribute('value', id);
            let submitButton = document.createElement('button');
            submitButton.setAttribute('type', 'button');
            submitButton.setAttribute('class', 'btn btn-sm btn-primary');
            submitButton.innerHTML = 'Update';
            submitButton.onclick = function() {
                submitEditLinkForm(id);
            };
            form.appendChild(label1);
            form.appendChild(input1);
            form.appendChild(label2);
            form.appendChild(input2);
            form.appendChild(label3);
            form.appendChild(input3);
            form.appendChild(label4);
            form.appendChild(classSelect);
            form.appendChild(label5);
            form.appendChild(select);
            form.appendChild(input6);
            form.appendChild(submitButton);
            //return form;
            document.getElementById('edit-form').append(form);
        }

        function submitEditLinkForm() {
            let popover = document.getElementById('edit-form-popover');
            let form = document.getElementById('edit-link-form');
            let formData = new FormData(form);
            fetch('updateLinkData.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === '200') {
                        popover.hidePopover();
                        alert('Link updated successfully.');
                        setTimeout(location.reload(), 500);
                    }
                });
        }

        function showAddLinkForm() {
            var createBtn = document.getElementById('create-add-btn');
            let form = document.createElement('form');
            // form.setAttribute('class', 'add-link-form');
            form.setAttribute('class', 'edit-link-form');
            form.setAttribute('id', 'add-link-form');
            // sText
            let label1 = document.createElement('label');
            label1.innerHTML = 'Text';
            form.appendChild(label1);
            let input1 = document.createElement('input');
            input1.setAttribute('type', 'text');
            input1.setAttribute('name', 'sText');
            form.appendChild(input1);
            // sHref
            let label2 = document.createElement('label');
            label2.innerHTML = 'URL';
            form.appendChild(label2);
            let input2 = document.createElement('input');
            input2.setAttribute('type', 'text');
            input2.setAttribute('name', 'sHref');
            form.appendChild(input2);
            // sIcon
            let label3 = document.createElement('label');
            label3.innerHTML = 'Icon';
            form.appendChild(label3);
            let input3 = document.createElement('input');
            input3.setAttribute('type', 'text');
            input3.setAttribute('name', 'sIcon');
            form.appendChild(input3);
            // sClass
            let label4 = document.createElement('label');
            label4.innerHTML = 'Class';
            form.appendChild(label4);
            // let input4 = document.createElement('input');
            let classSelect = document.createElement('select');
            classSelect.setAttribute('name', 'sClass');
            let classOption1 = document.createElement('option');
            classOption1.setAttribute('value', 'emp');
            classOption1.innerHTML = 'Employee';
            let classOption2 = document.createElement('option');
            classOption2.setAttribute('value', 'com');
            classOption2.innerHTML = 'Communucation';
            let classOption3 = document.createElement('option');
            classOption3.setAttribute('value', 'app');
            classOption3.innerHTML = 'Application';
            classSelect.appendChild(classOption1);
            classSelect.appendChild(classOption2);
            classSelect.appendChild(classOption3);
            form.appendChild(classSelect);
            // isActive
            let label5 = document.createElement('label');
            label5.innerHTML = 'Active';
            form.appendChild(label5);
            let select = document.createElement('select');
            select.setAttribute('name', 'bIsActive');
            let optionYes = document.createElement('option');
            optionYes.setAttribute('value', '1');
            optionYes.innerHTML = 'Yes';
            let optionNo = document.createElement('option');
            optionNo.setAttribute('value', '0');
            optionNo.innerHTML = 'No';
            select.appendChild(optionYes);
            select.appendChild(optionNo);
            form.appendChild(select);
            let input6 = document.createElement('input');
            input6.setAttribute('type', 'hidden');
            input6.setAttribute('name', 'sLinkId');
            input6.setAttribute('value', generateGUID());
            form.appendChild(input6);
            let submitButton = document.createElement('button');
            submitButton.setAttribute('type', 'button');
            submitButton.setAttribute('class', 'btn btn-sm btn-primary');
            submitButton.innerHTML = 'Add';
            submitButton.onclick = function() {
                submitAddLinkForm();
            };
            form.appendChild(submitButton);
            document.getElementById('add-form').append(form);
            createBtn.style.display = 'none';
        }

        function submitAddLinkForm() {
            var createBtn = document.getElementById('create-add-btn');
            let form = document.getElementById('add-link-form');
            let formData = new FormData(form);
            fetch('addLinkData.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === '200') {
                        alert('Link added successfully.');
                        createBtn.style.display = 'block';
                        setTimeout(location.reload(), 500);
                    }
                });
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