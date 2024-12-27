<?php
// Created: 2024/12/27 13:55:41
// Last modified: 2024/12/27 15:12:03
include(dirname(__FILE__) . '/../components/header.php');
include(dirname(__FILE__) . '/../components/sidenav.php');
?>

<head>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
</head>
<div class="main">
    <div class="container">
        <form action="./API/printshopupload.php">
            <fieldset>
                <legend>Details</legend>
                <div class="top-grid">
                    <div class="form-group">
                        <label class="form-label" for="jobType">Job Type</label>
                        <select name="jobType" id="jobType" class="form-control" aria-required="true" aria-invalid="false" required>
                            <option value="Brochures">Brochures</option>
                            <option value="Booklets">Booklets</option>
                            <option value="BusinessCards">Business Cards</option>
                            <option value="Copies">Copies</option>
                            <option value="Envelopes">Envelopes</option>
                            <option value="Flyers">Flyers</option>
                            <option value="Letterhead">Letterhead</option>
                            <option value="Posters">11 x 17 Posters</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity to Print</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" aria-required="true" aria-invalid="false" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="department">Department</label>
                        <select id="department" name="department" title="department" class="form-control">
                            <option value="Administrative Services">Administrative Services</option>
                            <option value="Airport Services">Airport Services</option>
                            <option value="Animal Control Officer">Animal Control Officer</option>
                            <option value="Animal Services">Animal Services</option>
                            <option value="Auditors Office">Auditors Office</option>
                            <option value="BCWS Administration">BCWS Administration</option>
                            <option value="BCWS Billing">BCWS Billing</option>
                            <option value="BCWS Code Enforcement">BCWS Code Enforcement</option>
                            <option value="BCWS Engineering">BCWS Engineering</option>
                            <option value="BCWS Finance">BCWS Finance</option>
                            <option value="BCWS Operations">BCWS Operations</option>
                            <option value="BCWS Purchasing">BCWS Purchasing</option>
                            <option value="Building & Codes Enforcement">Building & Codes Enforcement</option>
                            <option value="Building & Fleet Maintenance">Building & Fleet Maintenance</option>
                            <option value="Central FD">Central FD</option>
                            <option value="Clerk Of Courts Office">Clerk Of Courts Office</option>
                            <option value="Clerk Of Courts Office/DSS">Clerk Of Courts Office/DSS</option>
                            <option value="COFC / DSS Incentive">COFC / DSS Incentive</option>
                            <option value="Communications">Communications</option>
                            <option value="Coroners Office">Coroners Office</option>
                            <option value="County Administration">County Administration</option>
                            <option value="County Council">County Council</option>
                            <option value="County Supervisors Office">County Supervisors Office</option>
                            <option value="Cypress Gardens">Cypress Gardens</option>
                            <option value="Delinquent Tax">Delinquent Tax</option>
                            <option value="DUI Prosecutor Grant">DUI Prosecutor Grant</option>
                            <option value="DUI Prosecutor Grant">DUI Prosecutor Grant</option>
                            <option value="DUI Prosecutor Grant">DUI Prosecutor Grant</option>
                            <option value="Economic Development">Economic Development</option>
                            <option value="Emergency Management">Emergency Management</option>
                            <option value="Emergency Medical Services">Emergency Medical Services</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Facilities & Grounds">Facilities & Grounds</option>
                            <option value="Farm and Land Services">Farm and Land Services</option>
                            <option value="Finance">Finance</option>
                            <option value="Fleet Management">Fleet Management</option>
                            <option value="Geographic Information Systems">Geographic Information Systems</option>
                            <option value="GIS/Address Information">GIS/Address Information</option>
                            <option value="GIS/Consortium">GIS/Consortium</option>
                            <option value="Grants Administration">Grants Administration</option>
                            <option value="Human Resources">Human Resources</option>
                            <option value="Human Resources-Services">Human Resources-Services</option>
                            <option value="Information Technology">Information Technology</option>
                            <option value="JAG Grant - DOM Viol Invest">JAG Grant - DOM Viol Invest</option>
                            <option value="JAG Grant - DOM Viol Invest">JAG Grant - DOM Viol Invest</option>
                            <option value="JAG Grant - Elder Abuse Invest">JAG Grant - Elder Abuse Invest</option>
                            <option value="JAG Grant - Elder Abuse Invest">JAG Grant - Elder Abuse Invest</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Legal">Legal</option>
                            <option value="Library Admin">Library Admin</option>
                            <option value="Library Admin">Library Admin</option>
                            <option value="Library Cane Bay">Library Cane Bay</option>
                            <option value="Library Cane Bay">Library Cane Bay</option>
                            <option value="Library Daniel Island">Library Daniel Island</option>
                            <option value="Library Daniel Island">Library Daniel Island</option>
                            <option value="Library Goose Creek">Library Goose Creek</option>
                            <option value="Library Goose Creek">Library Goose Creek</option>
                            <option value="Library Hanahan">Library Hanahan</option>
                            <option value="Library Hanahan">Library Hanahan</option>
                            <option value="Library Moncks Corner">Library Moncks Corner</option>
                            <option value="Library Moncks Corner">Library Moncks Corner</option>
                            <option value="Library Sangaree">Library Sangaree</option>
                            <option value="Library Sangaree">Library Sangaree</option>
                            <option value="Library St Stephen">Library St Stephen</option>
                            <option value="Library St Stephen">Library St Stephen</option>
                            <option value="Library State Aid Funds">Library State Aid Funds</option>
                            <option value="Magistrate Court">Magistrate Court</option>
                            <option value="Magistrate Court/Victim Wit">Magistrate Court/Victim Wit</option>
                            <option value="Maintenance Garage">Maintenance Garage</option>
                            <option value="Master In Equity">Master In Equity</option>
                            <option value="Mosquito Abatement">Mosquito Abatement</option>
                            <option value="One Cent Sales Tax">One Cent Sales Tax</option>
                            <option value="ONE CENT SALES TAX">ONE CENT SALES TAX</option>
                            <option value="Other">Other</option>
                            <option value="Permitting">Permitting</option>
                            <option value="Planning & Zoning">Planning & Zoning</option>
                            <option value="POLL WORKERS ELECTION EXPENSES">POLL WORKERS ELECTION EXPENSES</option>
                            <option value="Probate Court">Probate Court</option>
                            <option value="Procurement">Procurement</option>
                            <option value="Public Defender">Public Defender</option>
                            <option value="PUBLIC INFORMATION OFFICE">PUBLIC INFORMATION OFFICE</option>
                            <option value="Pump & Plant Electrical Maintenance">Pump & Plant Electrical Maintenance</option>
                            <option value="Pump & Plant Mechanical Maintenance">Pump & Plant Mechanical Maintenance</option>
                            <option value="RADIO SHOP">RADIO SHOP</option>
                            <option value="Real Property Services">Real Property Services</option>
                            <option value="Register Of Deeds Office">Register Of Deeds Office</option>
                            <option value="Roads & Bridges">Roads & Bridges</option>
                            <option value="Safety & Risk Management">Safety & Risk Management</option>
                            <option value="Sangaree Special Tax District">Sangaree Special Tax District</option>
                            <option value="Scalehouse">Scalehouse</option>
                            <option value="Sheriff's Office">Sheriff's Office</option>
                            <option value="Sheriff's Office Detention Ctr">Sheriff's Office Detention Ctr</option>
                            <option value="Sheriff's Office/School">Sheriff's Office/School</option>
                            <option value="Sheriff's Office/Victim Wit">Sheriff's Office/Victim Wit</option>
                            <option value="Sheriff-Hwy DUI/EVN">Sheriff-Hwy DUI/EVN</option>
                            <option value="Sheriffs Office/DSS">Sheriffs Office/DSS</option>
                            <option value="SHF-COPS GRANT">SHF-COPS GRANT</option>
                            <option value="SHF-DUI GRANT #2">SHF-DUI GRANT #2</option>
                            <option value="SHF-DUI GRANT #2">SHF-DUI GRANT #2</option>
                            <option value="SHF-DUI GRANT #2">SHF-DUI GRANT #2</option>
                            <option value="Solicitor - JAG Grant">Solicitor - JAG Grant</option>
                            <option value="SOLICITOR - STATE">SOLICITOR - STATE</option>
                            <option value="Solicitor Grant Juvenile">Solicitor Grant Juvenile</option>
                            <option value="Solicitor Grant Violent">Solicitor Grant Violent</option>
                            <option value="Solicitor State Grant - Drug Ct">Solicitor State Grant - Drug Ct</option>
                            <option value="Solicitor's Office CDV">Solicitor's Office CDV</option>
                            <option value="Solicitors Office">Solicitors Office</option>
                            <option value="Solicitors Office/PTI Program">Solicitors Office/PTI Program</option>
                            <option value="Solicitors Office/Spec Prog">Solicitors Office/Spec Prog</option>
                            <option value="Solicitors Office/Victim Wit">Solicitors Office/Victim Wit</option>
                            <option value="Solid Waste Collections">Solid Waste Collections</option>
                            <option value="Solid Waste Disposal">Solid Waste Disposal</option>
                            <option value="Solid Waste Landfill Gas">Solid Waste Landfill Gas</option>
                            <option value="Solid Waste Recycling">Solid Waste Recycling</option>
                            <option value="SRO ELEM GRANTS">SRO ELEM GRANTS</option>
                            <option value="Stormwater Management">Stormwater Management</option>
                            <option value="Stormwater Municipalities">Stormwater Municipalities</option>
                            <option value="STORMWATER/R&B">STORMWATER/R&B</option>
                            <option value="Tax Assessment Review Board">Tax Assessment Review Board</option>
                            <option value="Tourism">Tourism</option>
                            <option value="TRAFFIC GRANT - SHERIFF">TRAFFIC GRANT - SHERIFF</option>
                            <option value="Treasurers Office">Treasurers Office</option>
                            <option value="Treatment Plant">Treatment Plant</option>
                            <option value="Veterans Affairs">Veterans Affairs</option>
                            <option value="VICTIM ADVOCATE GRANT">VICTIM ADVOCATE GRANT</option>
                            <option value="VICTIM ADVOCATE GRANT">VICTIM ADVOCATE GRANT</option>
                            <option value="VICTIM ADVOCATE GRANT">VICTIM ADVOCATE GRANT</option>
                            <option value="Voters Registration & Elections">Voters Registration & Elections</option>
                            <option value="Wastewater Collections">Wastewater Collections</option>
                            <option value="WASTEWATER COLLECTIONS">WASTEWATER COLLECTIONS</option>
                            <option value="Water Distribution">Water Distribution</option>
                            <option value="Whitesville FD">Whitesville FD</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Options</legend>
                <div class="mid-section">
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paperTypeOptions" id="paperTypeOptions1">
                            <label class="form-check-label" for="paperTypeOptions1">
                                20 lb
                            </label>
                            <p class="form-text">Basic copy paper, single sided copies</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paperTypeOptions" id="paperTypeOptions2">
                            <label class="form-check-label" for="paperTypeOptions2">
                                24 lb
                            </label>
                            <p class="form-text">Letterhead</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paperTypeOptions" id="paperTypeOptions3">
                            <label class="form-check-label" for="paperTypeOptions3">
                                28 lb
                            </label>
                            <p class="form-text">Double sided copies, presentations, brochures</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paperTypeOptions" id="paperTypeOptions4">
                            <label class="form-check-label" for="paperTypeOptions4">
                                Cardstock
                            </label>
                            <p class="form-text">Business Cards, Cut Materials, Greeting Cards, etc.</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paperTypeOptions" id="paperTypeOptions5">
                            <label class="form-check-label" for="paperTypeOptions5">
                                Other
                            </label>
                            <p class="form-text">Photo, Certificate, etc.</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="colorPaper" name="colorPaper">
                            <label class="form-check-label" for="colorPaper">
                                Color Paper
                            </label>
                            <p class="form-text">Yellow, Blue, etc.</p>
                        </div>
                    </div>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="configOptions" id="configOptions1">
                            <label class="form-check-label" for="configOptions1">
                                1-sided
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="configOptions" id="configOptions2">
                            <label class="form-check-label" for="configOptions2">
                                2-sided
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="foldedPaper" name="foldedPaper">
                            <label class="form-check-label" for="foldedPaper">
                                Folded
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="cutPaper" name="cutPaper">
                            <label class="form-check-label" for="cutPaper">
                                Cut
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="multiPaper" name="multiPaper">
                            <label class="form-check-label" for="multiPaper">
                                Multi images on page
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="threeHolePaper" name="threeHolePaper">
                            <label class="form-check-label" for="threeHolePaper">
                                3-hole punch
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="stapledPaper" name="stapledPaper">
                            <label class="form-check-label" for="stapledPaper">
                                Stapled
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Envelope Options</legend>
                <div class="bottom-section">
                    <div class="regEnvelopes">
                        <p><b>Regular Envelopes</b></p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="regEnvelope1" name="regEnvelope">
                            <label class="form-check-label" for="regEnvelope1">
                                Box (500)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="regEnvelope2" name="regEnvelope">
                            <label class="form-check-label" for="regEnvelope2">
                                Case (2,500)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="regEnvelope3" name="regEnvelope" selected>
                            <label class="form-check-label" for="regEnvelope3">
                                N/A
                            </label>
                        </div>
                    </div>
                    <div class="winEnvelopes">
                        <p><b>Window Envelopes</b></p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="winEnvelope1" name="winEnvelope">
                            <label class="form-check-label" for="winEnvelope1">
                                Box (500)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="winEnvelope2" name="winEnvelope">
                            <label class="form-check-label" for="winEnvelope2">
                                Case (2,500)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="" id="winEnvelope3" name="winEnvelope" selected>
                            <label class="form-check-label" for="winEnvelope3">
                                N/A
                            </label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Description / Details</legend>
                <div class="form-group">
                    <label class="form-label" for="additionalInfo">Please provide details of your Paper and Configuration options</label>
                    <textarea class="form-control" aria-label="With textarea" name="additionalInfo" id="additionalInfo" rows="3"></textarea>
                </div>
            </fieldset>

            <fieldset>
                <!-- <div class="bottom-section"> -->
                <legend>Add Files</legend>
                <div>
                    <p class="fs-5 text-center">Drop file(s)</p>
                    <form action='/API/printshopupload.php' class='dropzone' id="print-shop-form"></form>
                </div>
                <!-- </div> -->
            </fieldset>

            <fieldset>
                <legend>When completed</legend>
                <div class="bottom-section">
                    <div class="form-group">
                        <label class="form-label" for="sendTo">Please send to:</label>
                        <input type="text" name="sendTo" id="sendTo">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="emailTo">Or email for pick up</label>
                        <input type="email" name="emailTo" id="emailTo">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>


<style>
    fieldset {
        margin-top: 20px;
    }

    .top-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 20px;
        gap: 20px
    }

    .mid-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 20px;
        gap: 20px;

    }

    .bottom-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 20px;
        gap: 20px;

    }

    legend {
        border-bottom: 1px solid var(--accent);
    }
</style>