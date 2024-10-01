<?php

// Created: 2023/02/07 09:49:43
// Last modified: 2024/10/01 13:24:03

function locationSelect()
{
    // $counter = 100;
    echo `
    <select class="form-control required" id="ID" name="course_session[room_id]" required="required">
        <option value="4">Assembly Room</option>
        <option value="23">BCWS Engineering Conference Room</option>
        <option value="28">BCWS Executive Conference Room</option>
        <option value="24">BCWS Operations Bay Area</option>
        <option value="25">BCWS Solid Waste Bay Area</option>
        <option value="27">BCWS Training Room</option>
        <option value="29">BCWS Treatment Plant Breakroom/Shed Area</option>
        <option value="6">Council's Conference Room (Room 100)</option>
        <option value="5">Council's Conference Room (Room 125)</option>
        <option value="22">Courthouse - Courtroom A</option>
        <option value="18">Courthouse - Courtroom E</option>
        <option value="16">Courthouse - Grand Jury Room</option>
        <option value="10">Courthouse - Jury Panel Room</option>
        <option value="17">Courthouse - Jury Room B</option>
        <option value="13">Dean Hall - Cypress Gardens</option>
        <option value="20">Emergency Services Training Center</option>
        <option value="34">EOC - EMD Training (Admin Bldg)</option>
        <option value="31">Fleet Management Director's Office</option>
        <option value="9">Goose Creek Satellite Office</option>
        <option value="36">Heritage Room - Cypress Gardens</option>
        <option value="8">Human Resources Department</option>
        <option value="33">IT Multi Function Room</option>
        <option value="19">Live Oak Complex - Magistrate Courtroom A</option>
        <option value="14">Live Oak Complex - Magistrate Courtroom B</option>
        <option value="15">Live Oak Complex - Magistrate Courtroom C</option>
        <option value="11">Live Oak Complex - Other</option>
        <option value="1">Multi-Purpose Room (Room 106B)</option>
        <option value="37">SO Annex</option>
        <option value="32">Supervisors Conference Room</option>
        <option value="35">Wellness Clinic</option>
</select>

`;

    // $counter++;
}
