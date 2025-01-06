<?php
// Created: 2025/01/06 13:39:51
// Last modified: 2025/01/06 13:56:20


// $department = new Department();
// $departments = $department->getDepartments();

echo '<div class="form-group">';
echo '<label for="departments">Departments <img src="/images/database.png" alt="db" class="edit-icon" /></label>';
echo '<select class="form-control" id="departments" name="departments[]" multiple>';
foreach ($departments as $department) {
    echo '<option value="' . $department['iDepartmentNumber'] . '">' . $department['sDepartmentName'] . '</option>';
}
echo '</select>';
echo '</div>';
