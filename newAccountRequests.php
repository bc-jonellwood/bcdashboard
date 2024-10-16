<?php
// Created: 2024/09/12 13:12:49
// Last modified: 2024/10/16 15:35:30
include "./components/header.php"
?>
<script src="./data/accountRequestLocationData.js"></script>
<script>
    // function showDiv(e) {
    //     var t = e[e.selectedIndex].value;
    //     "New User" == t ? (document.getElementById("new-user").style.display = "block",
    //         document.getElementById("returning-user").style.display = "none",
    //         document.getElementById("change-user").style.display = "none",
    //         document.getElementById("remove-user").style.display = "none",
    //         document.getElementById("transfer-user").style.display = "none",
    //         document.getElementById("from-box").style.display = "none",
    //         document.getElementById("to-box").style.display = "block",
    //         document.getElementById("division-box").style.display = "block") : "Returning User" == t ? (document.getElementById("new-user").style.display = "none",
    //         document.getElementById("returning-user").style.display = "block",
    //         document.getElementById("change-user").style.display = "none",
    //         document.getElementById("remove-user").style.display = "none",
    //         document.getElementById("transfer-user").style.display = "none",
    //         document.getElementById("from-box").style.display = "none",
    //         document.getElementById("to-box").style.display = "block",
    //         document.getElementById("division-box").style.display = "block") : "Change User" == t ? (document.getElementById("new-user").style.display = "none",
    //         document.getElementById("returning-user").style.display = "none",
    //         document.getElementById("change-user").style.display = "block",
    //         document.getElementById("remove-user").style.display = "none",
    //         document.getElementById("transfer-user").style.display = "none",
    //         document.getElementById("from-box").style.display = "block",
    //         document.getElementById("to-box").style.display = "none",
    //         document.getElementById("division-box").style.display = "block") : "Remove User" == t ? (document.getElementById("new-user").style.display = "none",
    //         document.getElementById("returning-user").style.display = "none",
    //         document.getElementById("change-user").style.display = "none",
    //         document.getElementById("remove-user").style.display = "block",
    //         document.getElementById("transfer-user").style.display = "none",
    //         document.getElementById("from-box").style.display = "block",
    //         document.getElementById("to-box").style.display = "none",
    //         document.getElementById("division-box").style.display = "block") : "Transfer To" == t ? (document.getElementById("new-user").style.display = "none",
    //         document.getElementById("returning-user").style.display = "none",
    //         document.getElementById("change-user").style.display = "none",
    //         document.getElementById("remove-user").style.display = "none",
    //         document.getElementById("transfer-user").style.display = "block",
    //         document.getElementById("from-box").style.display = "none",
    //         document.getElementById("to-box").style.display = "block",
    //         document.getElementById("division-box").style.display = "block") : (document.getElementById("new-user").style.display = "none",
    //         document.getElementById("returning-user").style.display = "none",
    //         document.getElementById("change-user").style.display = "none",
    //         document.getElementById("remove-user").style.display = "none",
    //         document.getElementById("transfer-user").style.display = "none",
    //         document.getElementById("from-box").style.display = "none",
    //         document.getElementById("to-box").style.display = "none",
    //         document.getElementById("division-box").style.display = "none")
    // }

    // async function getAllDepartments() {
    //     await fetch("./API/getAllDepartments.php")
    //         .then((response) => response.json())
    //         .then((data) => {
    //             departments = data;
    //         });
    // }
    async function renderDepartmentSelect(id) {
        var locationData = requestLocationData();
        const selectElement = document.getElementById(id);
        for (var department of locationData) {
            selectElement.innerHTML += `
            <option value="${department.name}">${department.name}</option>
            `
        }
    }

    renderDepartmentSelect("account_request_from_dept");
    renderDepartmentSelect("account_request_to_dept");
</script>
<div class="main">
    <?php include "./components/sidenav.php" ?>
    <div class="content">
        <div class="form_wrapper">
            <form accept-charset="UTF-8" action="/account_requests" class="simple_form form-horizontal" id="new_account_request" method="post">
                <div>
                    <input name="utf8" type="hidden" value="&#x2713;" />
                    <input name="authenticity_token" type="hidden" value="u24XBioUzYTIQMWbw0DcJj9/8jFWEUtZJP5+s/KPWxo=" />
                </div>
                <fieldset>
                    <legend>
                        Submit Account Request
                    </legend>

                    <span class="text-error">
                        <h5>* Required fields</h5>
                    </span>
                    <!-- <p><strong>If you are unsure about any of these fields, please
                    <a href="https://bic.berkeleycountysc.gov/admin/arguidelines" target="_blank">click here to review the account request submission guidelines</a></strong>.</p> -->
                    <div class="form-group">
                        <!-- <select class="form-control" id="account_request_action" name="account_request[action]" onchange="showDiv(this)" required="required"> -->
                        <select class="form-control" id="account_request_action" name="account_request[action]" required="required">
                            <option value="">Select Request Type</option>
                            <option value="New User">New User</option>
                            <option value="Returning User">Returning User</option>
                            <option value="Change User">Change User</option>
                            <option value="Remove User">Remove User</option>
                            <option value="Transfer To">Transfer To</option>
                        </select>
                        <span class="text-error">*</span>
                    </div>

                    <div class="form-group">
                        <div id="new-user"></div>
                    </div>

                    <div class="form-group">
                        <div id="returning-user"></div>
                    </div>
                    <div class="form-group">
                        <div id="change-user"></div>
                    </div>
                    <div class="form-group">
                        <div id="remove-user"></div>
                    </div>
                    <div class="form-group">
                        <div id="transfer-user"></div>
                    </div>

                    <div id="from-box" style="display:none;">
                        <select id="account_request_from_dept" name="account_request[from_dept]" title="From Department" class="form-control">
                        </select>
                    </div>
                    <div id="to-box" style="display:none;">
                        <select id="account_request_to_dept" name="account_request[to_dept]" title="To Department" class="form-control">
                        </select>
                    </div>

                    <!-- <div id="division-box" style="display:none; font-size:1.15em;">
                        <div class="form-group">
                            <div class="input string optional account_request_division"><input class="form-control" id="account_request_division" maxlength="100" name="account_request[division]" placeholder="Division" size="50" title="Division" type="text" /></div>
                        </div>
                    </div> -->


                    <div class="form-group">
                        <div class="form-control d-flex justify-content-between">
                            <div class="input string required account_request_first_name">
                                <label for="account_request_first_name" class="form-label">First Name: </label>
                                <input class="form-control" id="account_request_first_name" maxlength="100" name="account_request[first_name]" placeholder="First Name" required="required" size="50" title="First Name" type="text" />
                            </div>
                            <span class="text-error">*</span>
                            <!-- </div> -->
                            <!-- <div class="form-group"> -->
                            <!-- <div class="form-control d-flex justify-content-between"> -->
                            <div class="input string optional account_request_middle_initial">
                                <label for="account_request_middle_initial" class="form-label">Middle Initial/Name: </label>
                                <input class="form-control" id="account_request_middle_initial" maxlength="100" name="account_request[middle_initial]" placeholder="Middle Initial/Name" size="50" title="Middle Initial" type="text" />
                            </div>
                            <div class="input string required account_request_last_name">
                                <label for="account_request_last_name" class="form-label">Last Name: </label>
                                <input class="form-control" id="account_request_last_name" maxlength="100" name="account_request[last_name]" placeholder="Last Name" required="required" size="50" title="Last Name" type="text" />
                            </div>
                            <span class="text-error">*</span><br />
                        </div>
                        <p class="form-text text-muted">Middle initial/name is required for AS400 profiles.</p>
                    </div>


                    <div class="form-control">
                        <div class="input string optional account_request_pref_name">
                            <label for="account_request_pref_name" class="form-label">Preferred Name (If Different)</label>
                            <input class="form-control" id="account_request_pref_name" maxlength="100" name="account_request[pref_name]" size="50" title="Preferred Name" type="text" />
                        </div>
                    </div>
                    <div class="form-control">
                        <div class="input string optional account_request_start_date">
                            <label for="account_request_start_date" class="form-label">Start Date</label>
                            <input type="date" data-provide="datepicker" class="form-control" id="account_request_start_date" name="account_request[start_date]" title="Start Date" />
                        </div>
                    </div>
                    <div class="form-control">
                        <select id="account_request_physical_location" name="account_request[physical_location]" class="form-control">
                            <option value="">Select Location...</option>
                            <option value="Administration Building">Administration Building</option>
                            <option value="Airport">Airport</option>
                            <option value="Animal Center">Animal Center</option>
                            <option value="Communications">Communications</option>
                            <option value="Coroner&#x27;s Office">Coroner&#x27;s Office</option>
                            <option value="County Morgue">County Morgue</option>
                            <option value="Court House">Court House</option>
                            <option value="Cypress Gardens">Cypress Gardens</option>
                            <option value="Detention Center">Detention Center</option>
                            <option value="EMD - EOC">EMD - EOC</option>
                            <option value="EMS Main Admin">EMS Main Admin</option>
                            <option value="Facilities &amp; Grounds">Facilities &amp; Grounds</option>
                            <option value="Fleet Garage">Fleet Garage</option>
                            <option value="Goose Creek Satellite Office">Goose Creek Satellite Office</option>
                            <option value="Heritage Room - Cypress Gardens">Heritage Room - Cypress Gardens</option>
                            <option value="Laboratory Department">Laboratory Department</option>
                            <option value="Library - Cane Bay">Library - Cane Bay</option>
                            <option value="Library - Daniel Island">Library - Daniel Island</option>
                            <option value="Library - Goose Creek">Library - Goose Creek</option>
                            <option value="Library - Hanahan">Library - Hanahan</option>
                            <option value="Library - Moncks Corner">Library - Moncks Corner</option>
                            <option value="Library - Sangaree">Library - Sangaree</option>
                            <option value="Library - St. Stephen">Library - St. Stephen</option>
                            <option value="Library Administration Building">Library Administration Building</option>
                            <option value="Live Oak Campus">Live Oak Campus</option>
                            <option value="Medic #3">Medic #3</option>
                            <option value="Mosquito Abatement/Control">Mosquito Abatement/Control</option>
                            <option value="Narcotics">Narcotics</option>
                            <option value="Police Records">Police Records</option>
                            <option value="Public Defender">Public Defender</option>
                            <option value="Public Works Building">Public Works Building</option>
                            <option value="Purchasing">Purchasing</option>
                            <option value="Radio Shop">Radio Shop</option>
                            <option value="Records Building">Records Building</option>
                            <option value="Rescue Building">Rescue Building</option>
                            <option value="Roads &amp; Bridges">Roads &amp; Bridges</option>
                            <option value="Sangaree Special Tax District">Sangaree Special Tax District</option>
                            <option value="Small Engine Repair Shop">Small Engine Repair Shop</option>
                            <option value="St Stephens Magistrate Office">St Stephens Magistrate Office</option>
                            <option value="Stormwater/R&amp;B">Stormwater/R&amp;B</option>
                            <option value="Veteran&#x27;s Affairs">Veteran&#x27;s Affairs</option>
                            <option value="Voter Registration and Elections">Voter Registration and Elections</option>
                            <option value="Water &amp; Sanitation-Central Berkeley Treatment Plant">Water &amp; Sanitation-Central Berkeley Treatment Plant</option>
                            <option value="Water &amp; Sanitation-Landfill">Water &amp; Sanitation-Landfill</option>
                            <option value="Water &amp; Sanitation-Lower Berkeley Treatment Plant">Water &amp; Sanitation-Lower Berkeley Treatment Plant</option>
                            <option value="Water &amp; Sanitation-Main Office">Water &amp; Sanitation-Main Office</option>
                            <option value="Wellness Clinic">Wellness Clinic</option>
                            <option value="Whites Ville FD">Whites Ville FD</option>
                        </select>
                        <span class="text-error">*</span>
                    </div>

                    <div class="form-control">
                        <div class="input tel required account_request_phone">
                            <label for="account_request[phone]" class="form-label">Desk Phone: </label>
                            <input class="form-control" id="account_request_phone" maxlength="12" name="account_request[phone]" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Desk Phone (XXX-XXX-XXXX)" required="required" size="12" title="Desk Phone #" type="tel" />
                        </div>
                        <span class="text-error">*</span>
                    </div>

                    <div class="form-control d-flex">
                        <div class="form-control">
                            <div class="input string required account_request_employee_number">
                                <label for="account_request[employee_number]" class="form-label">Employee Number: </label>
                                <input class="form-control" id="account_request_employee_number" maxlength="10" name="account_request[employee_number]" placeholder="Employee Number" required="required" size="10" title="Employee Number" type="text" />
                            </div>
                            <span class="text-error">*</span>
                        </div>

                        <div class="form-control">
                            <!-- <div class="input string required account_request_job_title"> -->
                            <label for="account_request[job_title]" class="form-label">Job Title: </label>
                            <input class="form-control" id="account_request_job_title" maxlength="255" name="account_request[job_title]" placeholder="Job Title" required="required" size="50" title="Job Title" type="text" />
                            <!-- </div> -->
                            <span class="text-error">*</span>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="account_request[email_type]" class="form-label">Email Type:
                            <select id="account_request_email_type" name="account_request[email_type]" class="form-control">
                                <option value="None">None</option>
                                <option value="G1">G1</option>
                                <option value="G3">G3</option>
                            </select>
                            <span class="text-error">*</span>&nbsp;&nbsp;<strong><a href="https://bic.berkeleycountysc.gov/admin/arguidelines#emailtype" target="_blank">?</a></strong>
                        </label>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-control">
                            <label for="account_request[time_approver]" class="form-label">Time Approver:</label>
                            <select id="account_request_time_approver" name="account_request[time_approver]" class="form-control">
                                <option value="Alicia Batten">Alicia Batten</option>
                                <option value="Aliya George">Aliya George</option>
                                <option value="Allen Milburn">Allen Milburn</option>
                                <option value="Allison Bilton">Allison Bilton</option>
                                <option value="Amanda Morris">Amanda Morris</option>
                                <option value="Amanda Troy">Amanda Troy</option>
                                <option value="Angela Pinson">Angela Pinson</option>
                                <option value="Anthony Williams">Anthony Williams</option>
                                <option value="April Shuler">April Shuler</option>
                                <option value="Ashley Powell">Ashley Powell</option>
                                <option value="Ashley Taylor">Ashley Taylor</option>
                                <option value="Barbara Ash">Barbara Ash</option>
                                <option value="Benjamin Milligan">Benjamin Milligan</option>
                                <option value="Betty Branton">Betty Branton</option>
                                <option value="Bradly Clark">Bradly Clark</option>
                                <option value="Brian Holden">Brian Holden</option>
                                <option value="Bruce Hawkins">Bruce Hawkins</option>
                                <option value="Candace Dunn">Candace Dunn</option>
                                <option value="Carolyn Umphlett">Carolyn Umphlett</option>
                                <option value="Charles Chears">Charles Chears</option>
                                <option value="Charles Grady">Charles Grady</option>
                                <option value="Christopher Heironimus   M.S.">Christopher Heironimus M.S.</option>
                                <option value="Craig Nessel">Craig Nessel</option>
                                <option value="Crystal Smalls">Crystal Smalls</option>
                                <option value="Cynthia Forte">Cynthia Forte</option>
                                <option value="Daniel Corbin">Daniel Corbin</option>
                                <option value="Daniel Thrower">Daniel Thrower</option>
                                <option value="Danielle Waters">Danielle Waters</option>
                                <option value="Danny Scantland">Danny Scantland</option>
                                <option value="Darnell Hartwell">Darnell Hartwell</option>
                                <option value="David Kornahrens">David Kornahrens</option>
                                <option value="David Parker">David Parker</option>
                                <option value="David Taschner">David Taschner</option>
                                <option value="Debbie Sweatman">Debbie Sweatman</option>
                                <option value="Dianne Riggs">Dianne Riggs</option>
                                <option value="Emily Whitfield">Emily Whitfield</option>
                                <option value="Eric Dziamniski">Eric Dziamniski</option>
                                <option value="Ester Williamson">Ester Williamson</option>
                                <option value="Evelyn Harmon">Evelyn Harmon</option>
                                <option value="Faith Johnson">Faith Johnson</option>
                                <option value="Felicia Walters">Felicia Walters</option>
                                <option value="Felisa Fludd">Felisa Fludd</option>
                                <option value="Florence Lewis-Coker">Florence Lewis-Coker</option>
                                <option value="Gene Brunson">Gene Brunson</option>
                                <option value="Gerald Baxley">Gerald Baxley</option>
                                <option value="Gregory Keefer">Gregory Keefer</option>
                                <option value="Heather McDowell">Heather McDowell</option>
                                <option value="Helen Sexton">Helen Sexton</option>
                                <option value="Henry Jackson">Henry Jackson</option>
                                <option value="Henry Wright">Henry Wright</option>
                                <option value="Hope Thomas">Hope Thomas</option>
                                <option value="Jacqueline Stanley">Jacqueline Stanley</option>
                                <option value="Jakob Koeniger">Jakob Koeniger</option>
                                <option value="James Ayers">James Ayers</option>
                                <option value="James Crepeau">James Crepeau</option>
                                <option value="James Troy">James Troy</option>
                                <option value="James Varner">James Varner</option>
                                <option value="Janet Austin">Janet Austin</option>
                                <option value="Janet Jurosko">Janet Jurosko</option>
                                <option value="Jeff Ward">Jeff Ward</option>
                                <option value="Jeffery Brown">Jeffery Brown</option>
                                <option value="Jenna-Ley Walls">Jenna-Ley Walls</option>
                                <option value="Jennifer Hinson">Jennifer Hinson</option>
                                <option value="Jenny Davis">Jenny Davis</option>
                                <option value="Jerri Christmas">Jerri Christmas</option>
                                <option value="John Villeponteaux">John Villeponteaux</option>
                                <option value="John Williams">John Williams</option>
                                <option value="Joshua Cooper">Joshua Cooper</option>
                                <option value="Karen Altman">Karen Altman</option>
                                <option value="Karen Biegert">Karen Biegert</option>
                                <option value="Karen Guerry">Karen Guerry</option>
                                <option value="Keith Kornahrens">Keith Kornahrens</option>
                                <option value="Kelly Herrin">Kelly Herrin</option>
                                <option value="Kirstin Steele">Kirstin Steele</option>
                                <option value="Kyle Harvey">Kyle Harvey</option>
                                <option value="Laura Baker">Laura Baker</option>
                                <option value="Lauren Willis">Lauren Willis</option>
                                <option value="Leah Dupree">Leah Dupree</option>
                                <option value="Linda Hill">Linda Hill</option>
                                <option value="Lisa Villeponteaux">Lisa Villeponteaux</option>
                                <option value="Lori Glover">Lori Glover</option>
                                <option value="Luke Johnson">Luke Johnson</option>
                                <option value="Mark Dirks">Mark Dirks</option>
                                <option value="Matthew (Ryan) Gatlin">Matthew (Ryan) Gatlin</option>
                                <option value="Melanie Chears">Melanie Chears</option>
                                <option value="Melissa Bowens">Melissa Bowens</option>
                                <option value="Melissa Wheatley">Melissa Wheatley</option>
                                <option value="Michael Hardwick">Michael Hardwick</option>
                                <option value="Michael Nelson">Michael Nelson</option>
                                <option value="Michael Shirey">Michael Shirey</option>
                                <option value="Molliann Ollic">Molliann Ollic</option>
                                <option value="Molly Owens-John">Molly Owens-John</option>
                                <option value="Montorony Jenkins">Montorony Jenkins</option>
                                <option value="Myra Dix">Myra Dix</option>
                                <option value="Nancy Port">Nancy Port</option>
                                <option value="Nanette Hamilton">Nanette Hamilton</option>
                                <option value="Patricia DeMenna">Patricia DeMenna</option>
                                <option value="Patricia Travis">Patricia Travis</option>
                                <option value="Patricia Wyman">Patricia Wyman</option>
                                <option value="Priscilla Bland">Priscilla Bland</option>
                                <option value="Randall Matthews">Randall Matthews</option>
                                <option value="Randy Demory">Randy Demory</option>
                                <option value="Rhonda Reid">Rhonda Reid</option>
                                <option value="Richard Kollman">Richard Kollman</option>
                                <option value="Richard Marchand">Richard Marchand</option>
                                <option value="Robert Gaskins">Robert Gaskins</option>
                                <option value="Ronald Gaskins">Ronald Gaskins</option>
                                <option value="Rose Brown">Rose Brown</option>
                                <option value="Royce Rembert">Royce Rembert</option>
                                <option value="Sam Gaither">Sam Gaither</option>
                                <option value="Sandra Holland">Sandra Holland</option>
                                <option value="Sarah Reynolds">Sarah Reynolds</option>
                                <option value="Scottie Craven">Scottie Craven</option>
                                <option value="Shamika Guthrie">Shamika Guthrie</option>
                                <option value="Sharon Fashion">Sharon Fashion</option>
                                <option value="Sherri Graham">Sherri Graham</option>
                                <option value="Sherrie Cash">Sherrie Cash</option>
                                <option value="Shonda Williams">Shonda Williams</option>
                                <option value="Stacy Thomas">Stacy Thomas</option>
                                <option value="Sue Hillrich">Sue Hillrich</option>
                                <option value="Tammy Murphy">Tammy Murphy</option>
                                <option value="Tanya Robison">Tanya Robison</option>
                                <option value="Teresa Fuda">Teresa Fuda</option>
                                <option value="Theresa Joyce">Theresa Joyce</option>
                                <option value="Timothy Boyle">Timothy Boyle</option>
                                <option value="Timothy King">Timothy King</option>
                                <option value="Troy Coakley">Troy Coakley</option>
                                <option value="Vicki Blankenship">Vicki Blankenship</option>
                                <option value="Wendy Weaver">Wendy Weaver</option>
                                <option value="William Jones">William Jones</option>
                                <option value="William Rochester">William Rochester</option>
                                <option value="Wilson Baggett">Wilson Baggett</option>
                                <option value="Zachary Cyrus">Zachary Cyrus</option>
                            </select>
                            <span class="text-error">*</span>
                        </div>
                        <div class="form-control">
                            <label for="account_request_leave_approver" class="form-label">Leave Approver</label>
                            <select id="account_request_leave_approver" name="account_request[leave_approver]" class="form-control">
                                <option value="">Leave Approver</option>
                                <option value="Alicia Batten">Alicia Batten</option>
                                <option value="Aliya George">Aliya George</option>
                                <option value="Allen Milburn">Allen Milburn</option>
                                <option value="Allison Bilton">Allison Bilton</option>
                                <option value="Amanda Morris">Amanda Morris</option>
                                <option value="Amanda Troy">Amanda Troy</option>
                                <option value="Angela Pinson">Angela Pinson</option>
                                <option value="Anthony Williams">Anthony Williams</option>
                                <option value="April Shuler">April Shuler</option>
                                <option value="Ashley Powell">Ashley Powell</option>
                                <option value="Ashley Taylor">Ashley Taylor</option>
                                <option value="Barbara Ash">Barbara Ash</option>
                                <option value="Benjamin Milligan">Benjamin Milligan</option>
                                <option value="Betty Branton">Betty Branton</option>
                                <option value="Bradly Clark">Bradly Clark</option>
                                <option value="Brian Holden">Brian Holden</option>
                                <option value="Bruce Hawkins">Bruce Hawkins</option>
                                <option value="Candace Dunn">Candace Dunn</option>
                                <option value="Carolyn Umphlett">Carolyn Umphlett</option>
                                <option value="Charles Chears">Charles Chears</option>
                                <option value="Charles Grady">Charles Grady</option>
                                <option value="Christopher Heironimus   M.S.">Christopher Heironimus M.S.</option>
                                <option value="Craig Nessel">Craig Nessel</option>
                                <option value="Crystal Smalls">Crystal Smalls</option>
                                <option value="Cynthia Forte">Cynthia Forte</option>
                                <option value="Daniel Corbin">Daniel Corbin</option>
                                <option value="Daniel Thrower">Daniel Thrower</option>
                                <option value="Danielle Waters">Danielle Waters</option>
                                <option value="Danny Scantland">Danny Scantland</option>
                                <option value="Darnell Hartwell">Darnell Hartwell</option>
                                <option value="David Kornahrens">David Kornahrens</option>
                                <option value="David Parker">David Parker</option>
                                <option value="David Taschner">David Taschner</option>
                                <option value="Debbie Sweatman">Debbie Sweatman</option>
                                <option value="Dianne Riggs">Dianne Riggs</option>
                                <option value="Emily Whitfield">Emily Whitfield</option>
                                <option value="Eric Dziamniski">Eric Dziamniski</option>
                                <option value="Ester Williamson">Ester Williamson</option>
                                <option value="Evelyn Harmon">Evelyn Harmon</option>
                                <option value="Faith Johnson">Faith Johnson</option>
                                <option value="Felicia Walters">Felicia Walters</option>
                                <option value="Felisa Fludd">Felisa Fludd</option>
                                <option value="Florence Lewis-Coker">Florence Lewis-Coker</option>
                                <option value="Gene Brunson">Gene Brunson</option>
                                <option value="Gerald Baxley">Gerald Baxley</option>
                                <option value="Gregory Keefer">Gregory Keefer</option>
                                <option value="Heather McDowell">Heather McDowell</option>
                                <option value="Helen Sexton">Helen Sexton</option>
                                <option value="Henry Jackson">Henry Jackson</option>
                                <option value="Henry Wright">Henry Wright</option>
                                <option value="Hope Thomas">Hope Thomas</option>
                                <option value="Jacqueline Stanley">Jacqueline Stanley</option>
                                <option value="Jakob Koeniger">Jakob Koeniger</option>
                                <option value="James Ayers">James Ayers</option>
                                <option value="James Crepeau">James Crepeau</option>
                                <option value="James Troy">James Troy</option>
                                <option value="James Varner">James Varner</option>
                                <option value="Janet Austin">Janet Austin</option>
                                <option value="Janet Jurosko">Janet Jurosko</option>
                                <option value="Jeff Ward">Jeff Ward</option>
                                <option value="Jeffery Brown">Jeffery Brown</option>
                                <option value="Jenna-Ley Walls">Jenna-Ley Walls</option>
                                <option value="Jennifer Hinson">Jennifer Hinson</option>
                                <option value="Jenny Davis">Jenny Davis</option>
                                <option value="Jerri Christmas">Jerri Christmas</option>
                                <option value="John Villeponteaux">John Villeponteaux</option>
                                <option value="John Williams">John Williams</option>
                                <option value="Joshua Cooper">Joshua Cooper</option>
                                <option value="Karen Altman">Karen Altman</option>
                                <option value="Karen Biegert">Karen Biegert</option>
                                <option value="Karen Guerry">Karen Guerry</option>
                                <option value="Keith Kornahrens">Keith Kornahrens</option>
                                <option value="Kelly Herrin">Kelly Herrin</option>
                                <option value="Kirstin Steele">Kirstin Steele</option>
                                <option value="Kyle Harvey">Kyle Harvey</option>
                                <option value="Laura Baker">Laura Baker</option>
                                <option value="Lauren Willis">Lauren Willis</option>
                                <option value="Leah Dupree">Leah Dupree</option>
                                <option value="Linda Hill">Linda Hill</option>
                                <option value="Lisa Villeponteaux">Lisa Villeponteaux</option>
                                <option value="Lori Glover">Lori Glover</option>
                                <option value="Luke Johnson">Luke Johnson</option>
                                <option value="Mark Dirks">Mark Dirks</option>
                                <option value="Matthew (Ryan) Gatlin">Matthew (Ryan) Gatlin</option>
                                <option value="Melanie Chears">Melanie Chears</option>
                                <option value="Melissa Bowens">Melissa Bowens</option>
                                <option value="Melissa Wheatley">Melissa Wheatley</option>
                                <option value="Michael Hardwick">Michael Hardwick</option>
                                <option value="Michael Nelson">Michael Nelson</option>
                                <option value="Michael Shirey">Michael Shirey</option>
                                <option value="Molliann Ollic">Molliann Ollic</option>
                                <option value="Molly Owens-John">Molly Owens-John</option>
                                <option value="Montorony Jenkins">Montorony Jenkins</option>
                                <option value="Myra Dix">Myra Dix</option>
                                <option value="Nancy Port">Nancy Port</option>
                                <option value="Nanette Hamilton">Nanette Hamilton</option>
                                <option value="Patricia DeMenna">Patricia DeMenna</option>
                                <option value="Patricia Travis">Patricia Travis</option>
                                <option value="Patricia Wyman">Patricia Wyman</option>
                                <option value="Priscilla Bland">Priscilla Bland</option>
                                <option value="Randall Matthews">Randall Matthews</option>
                                <option value="Randy Demory">Randy Demory</option>
                                <option value="Rhonda Reid">Rhonda Reid</option>
                                <option value="Richard Kollman">Richard Kollman</option>
                                <option value="Richard Marchand">Richard Marchand</option>
                                <option value="Robert Gaskins">Robert Gaskins</option>
                                <option value="Ronald Gaskins">Ronald Gaskins</option>
                                <option value="Rose Brown">Rose Brown</option>
                                <option value="Royce Rembert">Royce Rembert</option>
                                <option value="Sam Gaither">Sam Gaither</option>
                                <option value="Sandra Holland">Sandra Holland</option>
                                <option value="Sarah Reynolds">Sarah Reynolds</option>
                                <option value="Scottie Craven">Scottie Craven</option>
                                <option value="Shamika Guthrie">Shamika Guthrie</option>
                                <option value="Sharon Fashion">Sharon Fashion</option>
                                <option value="Sherri Graham">Sherri Graham</option>
                                <option value="Sherrie Cash">Sherrie Cash</option>
                                <option value="Shonda Williams">Shonda Williams</option>
                                <option value="Stacy Thomas">Stacy Thomas</option>
                                <option value="Sue Hillrich">Sue Hillrich</option>
                                <option value="Tammy Murphy">Tammy Murphy</option>
                                <option value="Tanya Robison">Tanya Robison</option>
                                <option value="Teresa Fuda">Teresa Fuda</option>
                                <option value="Theresa Joyce">Theresa Joyce</option>
                                <option value="Timothy Boyle">Timothy Boyle</option>
                                <option value="Timothy King">Timothy King</option>
                                <option value="Troy Coakley">Troy Coakley</option>
                                <option value="Vicki Blankenship">Vicki Blankenship</option>
                                <option value="Wendy Weaver">Wendy Weaver</option>
                                <option value="William Jones">William Jones</option>
                                <option value="William Rochester">William Rochester</option>
                                <option value="Wilson Baggett">Wilson Baggett</option>
                                <option value="Zachary Cyrus">Zachary Cyrus</option>
                            </select>
                            <span class="text-error">*</span>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="account_request_setup_equivalent">Setup Equivalent: (for access rights)</label>
                        <select id="account_request_setup_equivalent" name="account_request[setup_equivalent]" class="form-control">
                            <option value="Adrian Hayden">Adrian Hayden</option>
                            <option value="Berkeley County Store">Berkeley County Store</option>
                            <option value="Brady Turcotte">Brady Turcotte</option>
                            <option value="Brian Field">Brian Field</option>
                            <option value="Brian Holden">Brian Holden</option>
                            <option value="Carla Carswell">Carla Carswell</option>
                            <option value="Christopher Heironimus   M.S.">Christopher Heironimus M.S.</option>
                            <option value="David Ingle">David Ingle</option>
                            <option value="Edward Mus">Edward Mus</option>
                            <option value="Eugene Phillips">Eugene Phillips</option>
                            <option value="Geoff Bresnan">Geoff Bresnan</option>
                            <option value="Greg Davis">Greg Davis</option>
                            <option value="Help Desk User">Help Desk User</option>
                            <option value="Howard Crosby">Howard Crosby</option>
                            <option value="Ian Francis">Ian Francis</option>
                            <option value="IT Test User">IT Test User</option>
                            <option value="Jason Kirkland">Jason Kirkland</option>
                            <option value="Jasper Addison">Jasper Addison</option>
                            <option value="Jeff Hickerson">Jeff Hickerson</option>
                            <option value="Jeff Ward">Jeff Ward</option>
                            <option value="Jeffery Brown">Jeffery Brown</option>
                            <option value="Jeffrey Gailfus">Jeffrey Gailfus</option>
                            <option value="Jerri Christmas">Jerri Christmas</option>
                            <option value="Jon Ellwood">Jon Ellwood</option>
                            <option value="Justin Goldsmith">Justin Goldsmith</option>
                            <option value="Kailey Owens">Kailey Owens</option>
                            <option value="Luke Johnson">Luke Johnson</option>
                            <option value="Lynn Cunningham">Lynn Cunningham</option>
                            <option value="Mark Shuford">Mark Shuford</option>
                            <option value="MARTIN ROWELL">MARTIN ROWELL</option>
                            <option value="Michael Chew">Michael Chew</option>
                            <option value="Michael Gaskins">Michael Gaskins</option>
                            <option value="Patricia White">Patricia White</option>
                            <option value="Patrick Snow">Patrick Snow</option>
                            <option value="Pete Bustraan">Pete Bustraan</option>
                            <option value="Riley Johnson">Riley Johnson</option>
                            <option value="Shannon Brock">Shannon Brock</option>
                            <option value="Shawn Heyward">Shawn Heyward</option>
                            <option value="Shawn Sims">Shawn Sims</option>
                            <option value="Steve Schindler">Steve Schindler</option>
                            <option value="TERESA MCCOY">TERESA MCCOY</option>
                            <option value="Terry Norton">Terry Norton</option>
                            <option value="Tony Smith">Tony Smith</option>
                            <option value="William Welch">William Welch</option>
                        </select>
                        <span class="text-error">*</span>
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="form-control">
                            <div class="input string required account_request_cpu_asset">
                                <label for="account_request_cpu_asset" class="form-label">CPU Asset Number: </label>
                                <input class="form-control" id="account_request_cpu_asset" maxlength="40" name="account_request[cpu_asset]" required="required" size="40" title="CPU Asset Number" type="text" />
                            </div>
                            <span class="text-error">*</span>
                        </div>

                        <div class="form-control">
                            <div class="input string required account_request_monitor_asset">
                                <label for="account_request_monitor_asset" class="form-label">Monitor 1 Asset Number: </label>
                                <input class="form-control" id="account_request_monitor_asset" maxlength="40" name="account_request[monitor_asset]" required="required" size="40" title="Monitor 1 Asset Number" type="text" />
                            </div>
                            <span class="text-error">*</span>
                        </div>

                        <div class="form-control">
                            <div class="input string optional account_request_monitor_asset_2">
                                <label for="account_request_monitor_asset_2" class="form-label">Monitor 2 Asset Number: </label>
                                <input class="form-control" id="account_request_monitor_asset_2" maxlength="40" name="account_request[monitor_asset_2]" size="40" title="Monitor 2 Asset Number" type="text" />
                            </div>
                            <span class="text-error"></span>
                        </div>

                        <div class="form-control">
                            <div class="input string optional account_request_printer_asset">
                                <label for="account_request_printer_asset" class="form-label">Printer Asset Number: </label>
                                <input class="form-control" id="account_request_printer_asset" maxlength="100" name="account_request[printer_asset]" size="50" title="Printer Asset Number" type="text" />
                            </div>
                            <span class="text-error"></span>
                        </div>
                    </div>
                    <div class="form-group">

                        <h4>Employee Access Rights</h4>
                        <div class="checkbox-holder">
                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_network_yn form-check">
                                            <input name="account_request[network_yn]" type="hidden" value="0" class="form-check-input" />
                                            <input class="form-check-input" id="account_request_network_yn" name="account_request[network_yn]" type="checkbox" value="1" />
                                            <label class="form-check-label" for="account_request_network_yn">Network (Required for email)</label>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_internet_yn form-check">
                                            <input name="account_request[internet_yn]" type="hidden" value="0" /><input class="boolean optional form-check-input" id="account_request_internet_yn" name="account_request[internet_yn]" type="checkbox" value="1" />
                                            <label class="boolean optional form-check-label" for="account_request_internet_yn">Internet</label>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_appextender_yn">
                                            <input name="account_request[appextender_yn]" type="hidden" value="0" /><input class="boolean optional form-check-input" id="account_request_appextender_yn" name="account_request[appextender_yn]" type="checkbox" value="1" /><label class="boolean optional form-check-label" for="account_request_appextender_yn">Mayan</label>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_as400_yn"><input name="account_request[as400_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_as400_yn" name="account_request[as400_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_as400_yn">AS400</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_dynamics_yn"><input name="account_request[dynamics_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_dynamics_yn" name="account_request[dynamics_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_dynamics_yn">Cogsdale / Dynamics</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_timesheet_yn"><input name="account_request[timesheet_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_timesheet_yn" name="account_request[timesheet_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_timesheet_yn">Timesheet Approver</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_leave_yn"><input name="account_request[leave_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_leave_yn" name="account_request[leave_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_leave_yn">Leave Approver</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_assessment_utils_yn"><input name="account_request[assessment_utils_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_assessment_utils_yn" name="account_request[assessment_utils_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_assessment_utils_yn">Assessment Utils</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_assesspro_yn"><input name="account_request[assesspro_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_assesspro_yn" name="account_request[assesspro_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_assesspro_yn">AssessPro</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_cms_yn"><input name="account_request[cms_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_cms_yn" name="account_request[cms_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_cms_yn">CMS</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_energov_yn"><input name="account_request[energov_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_energov_yn" name="account_request[energov_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_energov_yn">Energov</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_evidence_yn"><input name="account_request[evidence_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_evidence_yn" name="account_request[evidence_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_evidence_yn">Evidence Manager</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_joint_plan_yn"><input name="account_request[joint_plan_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_joint_plan_yn" name="account_request[joint_plan_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_joint_plan_yn">Joint Plan Review</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_ifas_yn"><input name="account_request[ifas_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_ifas_yn" name="account_request[ifas_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_ifas_yn">Finance Enterprise</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_road_manager_yn"><input name="account_request[road_manager_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_road_manager_yn" name="account_request[road_manager_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_road_manager_yn">Road Manager</label></div>
                                    </div>
                                </label>
                            </div>

                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_city_works_yn"><input name="account_request[city_works_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_city_works_yn" name="account_request[city_works_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_city_works_yn">City Works</label></div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_eam_yn"><input name="account_request[eam_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_eam_yn" name="account_request[eam_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_eam_yn">EAM</label></div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_bill_trust_yn"><input name="account_request[bill_trust_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_bill_trust_yn" name="account_request[bill_trust_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_bill_trust_yn">Bill Trust</label></div>
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label class="checkbox">
                                    <div class="form-group">
                                        <div class="input boolean optional account_request_analytics_yn"><input name="account_request[analytics_yn]" type="hidden" value="0" /><input class="boolean optional" id="account_request_analytics_yn" name="account_request[analytics_yn]" type="checkbox" value="1" /><label class="boolean optional" for="account_request_analytics_yn">Analytics</label></div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <ul>
                            <li>*Employee Online access is managed by HR and given all employees.</li>
                            <!--li style="color:red; font-weight:bold;">* For AppXtender you <u>must</u> enter in the Additional Comments box below the required Group&nbsp;Name/s<br /-->
                            <!--a href="/forms/GrpAcc.xlsx" target="_blank">Click here for details on all Group Names</a></li-->
                        </ul>
                    </div>

                    <h4>Additional Comments</h4>
                    Use Markdown for formatting &nbsp;&nbsp;<a id="markdown" href="#">See examples</a>
                    <div id="markdown_examples">
                        <table class="table-striped table-bordered" width="500px">
                            <tbody>
                                <tr class="table">
                                    <td>
                                        [Link](http://example.com/)
                                    </td>
                                    <td>
                                        <a href="http://example.com/">Link</a>
                                    </td>
                                </tr>
                                <tr class="table">
                                    <td>
                                        *Italic*
                                    </td>
                                    <td>
                                        <em>Italic</em>
                                    </td>
                                </tr>
                                <tr class="table">
                                    <td>
                                        **Bold**
                                    </td>
                                    <td>
                                        <strong>Bold</strong>
                                    </td>
                                </tr>
                                <tr class="table">
                                    <td>
                                        * Listed<br>
                                        * Items
                                    </td>
                                    <td>
                                        <ul>
                                            <li>Listed</li>
                                            <li>Items</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br>

                    </div>

                    <div class="form-group">
                        <div class="input text optional account_request_comments"><textarea class="text optional span6" cols="40" id="account_request_comments" name="account_request[comments]" placeholder="Put additional comments here, such as info for specific accounts or additional people to notify upon creation." rows="10" title="Additional Comments">
</textarea></div>
                    </div>
                    <br />




                    <div>
                        <strong>Will be Authorized by: Jon Ellwood</strong>
                    </div>

                    <div class="actions">
                        <br />
                        <input class="btn btn-primary" data-disable-with="Please wait..." name="commit" type="submit" value="Submit Request" /> or <a href="/account_requests" class="btn">Cancel</a>
                    </div>
                </fieldset>

            </form>
        </div>
    </div>
</div>
<?php include "./components/footer.php" ?>

<!-- <script>
    window.onload = function() {
        var e = document.getElementById("account_request_action").value;
        "New User" == e && (document.getElementById("new-user").style.display = "block",
                document.getElementById("returning-user").style.display = "none",
                document.getElementById("change-user").style.display = "none",
                document.getElementById("remove-user").style.display = "none",
                document.getElementById("transfer-user").style.display = "none",
                document.getElementById("from-box").style.display = "none",
                document.getElementById("to-box").style.display = "block",
                document.getElementById("division-box").style.display = "block"),
            "Returning User" == e ? (document.getElementById("new-user").style.display = "none",
                document.getElementById("returning-user").style.display = "block",
                document.getElementById("change-user").style.display = "none",
                document.getElementById("remove-user").style.display = "none",
                document.getElementById("transfer-user").style.display = "none",
                document.getElementById("from-box").style.display = "none",
                document.getElementById("to-box").style.display = "block",
                document.getElementById("division-box").style.display = "block") : "Change User" == e ? (document.getElementById("new-user").style.display = "none",
                document.getElementById("returning-user").style.display = "none",
                document.getElementById("change-user").style.display = "block",
                document.getElementById("remove-user").style.display = "none",
                document.getElementById("transfer-user").style.display = "none",
                document.getElementById("from-box").style.display = "block",
                document.getElementById("to-box").style.display = "none",
                document.getElementById("division-box").style.display = "block") : "Remove User" == e ? (document.getElementById("new-user").style.display = "none",
                document.getElementById("returning-user").style.display = "none",
                document.getElementById("change-user").style.display = "none",
                document.getElementById("remove-user").style.display = "block",
                document.getElementById("transfer-user").style.display = "none",
                document.getElementById("from-box").style.display = "block",
                document.getElementById("to-box").style.display = "none",
                document.getElementById("division-box").style.display = "block") : "Transfer To" == e ? (document.getElementById("new-user").style.display = "none",
                document.getElementById("returning-user").style.display = "none",
                document.getElementById("change-user").style.display = "none",
                document.getElementById("remove-user").style.display = "none",
                document.getElementById("transfer-user").style.display = "block",
                document.getElementById("from-box").style.display = "none",
                document.getElementById("to-box").style.display = "block",
                document.getElementById("division-box").style.display = "block") : (document.getElementById("new-user").style.display = "none",
                document.getElementById("returning-user").style.display = "none",
                document.getElementById("change-user").style.display = "none",
                document.getElementById("remove-user").style.display = "none",
                document.getElementById("transfer-user").style.display = "none",
                document.getElementById("from-box").style.display = "none",
                document.getElementById("to-box").style.display = "none",
                document.getElementById("division-box").style.display = "none")
    };
</script> -->
<style>
    .form_wrapper {
        margin: 25px auto 0px;
        background: white;
        border-radius: 10px;
        -webkit-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
        -moz-box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 90;
        padding: 25px;
        max-width: 1000px;
        width: auto;
    }

    form {
        margin: 0 0 20px;
    }

    .text-error {
        color: #b94a48;
    }

    .checkbox-holder {
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        flex-direction: row;
        gap: 10px;
    }
</style>