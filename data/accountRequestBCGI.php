<h4 id="xsaverhead">IT Accounts</h4>


<?php
global $useris;
$goid = 0;
if ($_GET['new_id']) {
    $highest_empnum = 0;
    $goid = $_GET['new_id']; //136219
    $user_query = new WP_User_Query(array(
        'meta_query' => array(
            array(
                'key' => 'user_empnum',
                'value' => 900000,
                'compare' => '>',
                'type' => 'NUMERIC'
            )
        ),
        'fields' => 'ID'
    ));
    $user_ids = $user_query->get_results();
    foreach ($user_ids as $user_id) {
        $user_empnum = get_user_meta($user_id, 'user_empnum', true);
        if ($user_empnum > $highest_empnum) {
            $highest_empnum = $user_empnum;
        }
    }
    $new_empnum = $highest_empnum + 1;

    $params = array(
        'where' => 'd.id=' . $goid,
        'limit' => 1
    );
    $podsaccrequest = pods('accrequest', $params);
    $podsaccrequest->save('whoifas', $new_empnum);

    echo "goid " . $goid . "<br />";
    echo "new_empnum " . $new_empnum . "<br />";
    if ($podsaccrequest->total_found()) {
        $topfields['id'] = $podsaccrequest->display('id');
        $topfields['whofirst'] = $podsaccrequest->display('whofirst');
        $topfields['whomiddle'] = $podsaccrequest->display('whomiddle');
        $topfields['wholast'] = $podsaccrequest->display('wholast');
        $topfields['whopref'] = $podsaccrequest->display('whopref');
        $topfields['wholoc'] = $podsaccrequest->display('wholoc');
        $topfields['whojob'] = $podsaccrequest->display('whojob');
        $topfields['whoemail'] = $podsaccrequest->display('whoemail');
        $topfields['whotel'] = $podsaccrequest->display('whotel');
        $topfields['whohired'] = $podsaccrequest->display('whohired');
        $topfields['whoequiv'] = $podsaccrequest->display('whoequiv');
        $topfields['whocomments'] = $podsaccrequest->display('whocomments');
        $topfields['whodept'] = 99999;
        $topfields['termination'] = $podsaccrequest->display('termination');
        $topfields['effective'] = $podsaccrequest->display('effective');
        $user_name = strtolower($topfields['whofirst'] . '.' . $topfields['wholast']);
        $user_email = strtolower($topfields['whoemail']);
        echo "topfields " . print_r($topfields) . "<br />";

        if (! username_exists($user_name) && ! email_exists($topfields['whoemail'])) {
            $random_password = wp_generate_password($length = 8, $include_standard_special_chars = false);
            echo "random_password " . $random_password . "<br />";
            $new_user_id = wp_create_user($user_name, $random_password, $user_email);
            $ret = add_user_meta($new_user_id, 'user_empnum', $new_empnum);
            $ret = add_user_meta($new_user_id, 'first_name', $topfields['whofirst']);
            if ($topfields['whomiddle']) {
                $ret = add_user_meta($new_user_id, 'user_midname', $topfields['whomiddle']);
            }
            $ret = add_user_meta($new_user_id, 'last_name', $topfields['wholast']);
            if ($topfields['user_prefname']) {
                $ret = add_user_meta($new_user_id, 'user_prefname', $topfields['user_prefname']);
            }
            if ($topfields['wholoc']) {
                $ret = add_user_meta($new_user_id, 'user_location', $topfields['wholoc']);
            }
            if ($topfields['whojob']) {
                $ret = add_user_meta($new_user_id, 'user_jobtitle', $topfields['whojob']);
            }
            if ($topfields['whotel']) {
                $ret = add_user_meta($new_user_id, 'phonenumber', $topfields['whotel']);
            }
            if ($topfields['whohired']) {
                $ret = add_user_meta($new_user_id, 'user_hired', $topfields['whohired']);
            }
            if ($topfields['whodept']) {
                $ret = add_user_meta($new_user_id, 'user_dept', $topfields['whodept']);
            }
            $outpure = 'Account #' . $new_user_id . '/' . $new_empnum . ' created for ' . $topfields['whofirst'] . ' ' . $topfields['wholast'] . ' (' . $user_email . '). Please advise ' . $topfields['whofirst'] . ' to use the username ' . $user_name . ' with a password of ' . $random_password . ' - users should change their password after their first log in.';
            $outmsg = 'Account #' . $new_user_id . '/' . $new_empnum . ' created for <strong>' . $topfields['whofirst'] . ' ' . $topfields['wholast'] . '</strong> (' . $user_email . ')<br />Please advise ' . $topfields['whofirst'] . ' to use the username <strong>' . $user_name . '</strong> with a password of <strong>' . $random_password . '</strong><br />- users should change their password after their first log in.';
            $outstr = '<div id="msgboxmsg">' . $outmsg . '</div><br />If you are sure that ' . $user_email . ' is the correct email address for ' . $topfields['whofirst'] . '<br /><a href="mailto:' . $user_email . '?subject=BCGi (intranet) account created for you&body=' . $outpure . '" target="_blank">click here to email this message to them</a>';
        } else {
            $outstr =  'Unable to save as ' . $user_name . ' and or ' . $topfields['whoemail'] . ' already exists.';
        }
    }
    echo '<div id="dialogmsg"><div id="msgbox">' . $outstr . '</div></div>';
}


if (isset($_POST['dosearch'])) {
    $results = "";
    $outstr = "";
    $sql = "";
    $subsql = "";
    $frm_empid = preg_replace('/[^0-9]+/', '', trim($_POST['line_id']));
    $frm_empfn = preg_replace('/\d/', '', trim($_POST['line_fn']));
    $frm_empln = preg_replace('/\d/', '', trim($_POST['line_ln']));
    $frm_empdept = trim($_POST['line_dept']);

    if ($frm_empid == "") {
        unset($frm_empid);
    }
    if ($frm_empfn == "") {
        unset($frm_empfn);
    }
    if ($frm_empln == "") {
        unset($frm_empln);
    }
    if ($frm_empdept == "Department") {
        unset($frm_empdept);
    }
    if (isset($frm_empid)) {
        $subsql .= "['key' => 'user_empnum', 'value' => '" . $frm_empid . "', 'compare' => '=']";
    }
    if (isset($frm_empfn)) {
        $subsql .= "['key' => 'first_name', 'value' => '" . $frm_empfn . "', 'compare' => 'LIKE']";
    }
    if (isset($frm_empln)) {
        $subsql .= "['key' => 'last_name', 'value' => '" . $frm_empln . "', 'compare' => 'LIKE']";
    }
    if (isset($frm_empdept)) {
        $subsql .= "['key' => 'user_dept', 'value' => '" . $frm_empdept . "', 'compare' => '=']";
    }

    if ($subsql == "") {
        unset($subsql);
    }
    $frm_separated = $_POST['separated'] ? 'role__in' : 'role__not_in';
    if (isset($subsql)) {
        $user_query = new WP_User_Query(
            array(
                $frm_separated => 'disabled',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'first_name',
                        'value'   => $frm_empfn,
                        'compare' => 'LIKE',
                    ),
                    array(
                        'key'     => 'last_name',
                        'value'   => $frm_empln,
                        'compare' => 'LIKE',
                    ),
                    array(
                        'key'     => 'user_empnum',
                        'value'   => $frm_empid,
                        'compare' => 'LIKE',
                    ),
                    array(
                        'key'     => 'user_dept',
                        'value'   => $frm_empdept,
                        'compare' => 'LIKE',
                    ),
                ),
            )
        );
        $users = $user_query->get_results();

        if (!empty($users)) {
            $results .= '<div style="display:flex; flex-direction:column; margin:0 20px;">';
            foreach ($users as $user) {
                $user_id = $user->ID;
                $user_dept = get_user_meta($user_id, 'user_dept', true);
                $user_ifas = get_user_meta($user_id, 'user_empnum', true);
                $user_jobtitle = get_user_meta($user_id, 'user_jobtitle', true);
                if ($user_jobtitle == 'adminac') {
                    continue;
                }
                $params = array(
                    'where' => 'ifas=' . $user_dept,
                    'limit' => 1
                );
                $podd = pods('depts', $params);
                $checkarr = [];
                if ($podd->total() > 0) {
                    while ($podd->fetch()) {
                        $depttxt = $podd->display('post_title');
                        $checkera = $podd->field('checkera')['ID'];
                        $checkerb = $podd->field('checkerb')['ID'];
                        $checkerc = $podd->field('checkerc')['ID'];
                        if ($checkera) {
                            array_push($checkarr, $checkera);
                        }
                        if ($checkerb) {
                            array_push($checkarr, $checkerb);
                        }
                        if ($checkerc) {
                            array_push($checkarr, $checkerc);
                        }
                    }
                }
                if (in_array(get_current_user_id(), $checkarr) || in_array('administrator',  wp_get_current_user()->roles)) {
                    $blind = ' class="viewuser" title="View user"';
                    $blindcss = ' cursor:pointer;';
                } else {
                    $blind = ' class="noviewuser" title="You do not have permissions to view user"';
                    $blindcss = ' color:#cccccc; cursor:default;';
                }
                $results .= '<div style="background-color:#ffffff; margin-top:5px; padding:5px 10px; display:flex; border:ridge 2px #ffffff; box-shadow:inset 3px 3px 5px rgba(0,0,0,.5), 3px 3px 5px rgba(0,0,0,.5);' . $blindcss . '"' . $blind . ' data-userid="' . $user->ID . '"><div style="min-width:25%;">' . $user->display_name . '</div><div>' . $depttxt . ', ' . $user_jobtitle . '</div><div style="margin:0 20px 0 auto; display:flex;"><div style="margin-right:20px;">Employee ID #' . $user_ifas . '</div><i class="far fa-eye"></i><i class="fas fa-eye" style="display:none;"></i></div></div>';
            }
            $results .= '</div>';
        } else {
            $results .= '<div style="background-color:#ffffff; margin-top:5px; padding:5px 10px; display:flex; border:ridge 2px #ffffff; box-shadow:inset 3px 3px 5px rgba(0,0,0,.5), 3px 3px 5px rgba(0,0,0,.5); color:red; font-weight:bold;">No users found.</div>';
        }
    } else {
        $results .= "<div style='background-color:#ffffff; padding:5px 20px; margin:0 20px;'><i class='fas fa-exclamation-circle' style='color:red;'></i> Enter one or more search criteria above</div>";
    }
}
//$outstr .= "<div style='background-color:#ffffff;'>".print_r($_POST)."</div><br />";

?>

<fieldset id="fldsettop">
    <legend>Find an employee/user by . . . </legend>
    <form action="" method="post">
        <div class="fieldset_body" style="display:flex; flex-flow:row;">

            <div class="fieldset_body" style="display:flex; flex-flow:column; width:75%;">

                <div class="fieldset_cola" style="display:flex; flex-flow:row; justify-content:space-between;">

                    <div class="fieldset_col">
                        <div style="font-size:0.8rem; font-weight:500; font-style:italic;">employee ID</div>
                        <input type="text" name="line_id" placeholder="Employee ID (eg. 5123)" pattern="[0-9]{4}" maxlength="4" value="<?= $frm_empid ?>" />
                    </div>

                    <div class="fieldset_col">
                        <div style="font-size:0.8rem; font-weight:500; font-style:italic;">and/or first name</div>
                        <input type="text" name="line_fn" placeholder="First Name" pattern="[A-Za-z]*" value="<?= $frm_empfn ?>" />
                    </div>

                    <div class="fieldset_col">
                        <div style="font-size:0.8rem; font-weight:500; font-style:italic;">and/or last name</div>
                        <input type="text" name="line_ln" placeholder="Last Name" pattern="[A-Za-z]*" value="<?= $frm_empln ?>" />
                    </div>

                </div>

                <div class="fieldset_cola" style="display:flex; flex-flow:row; justify-content:space-between;">
                    <div class="fieldset_col">
                        <div style="color:#ffffff; font-size:0.8rem; font-weight:500; font-style:italic;">and/or department</div>
                        <?php
                        $params = array(
                            'limit' => -1
                        );
                        $podb = pods('depts', $params);
                        if ($podb->total() > 0) {
                            $outstr = "<select id='deptddl' name='line_dept'>";
                            $outstr .= "<option>Department</option>";
                            while ($podb->fetch()) {
                                $insthis = $podb->field('ifas') == $frm_empdept ? ' SELECTED' : '';
                                $outstr .= "<option value='" . $podb->field('ifas') . "'" . $insthis . ">" . $podb->field('post_title') . "</option>";
                            }
                            $outstr .= "</select>";
                        }
                        echo $outstr;
                        $insthis = $_POST['separated'] ? ' CHECKED' : '';
                        ?>
                    </div>
                    <div class="fieldset_col">
                        <div style="color:#ffffff; font-size:0.8rem; font-weight:500; font-style:italic;">Separated</div>
                        <div class="toggle-switch">
                            <input type="checkbox" id="toggle" class="toggle-checkbox" name="separated" <?= $insthis ?>>
                            <label for="toggle" class="toggle-label"></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="fieldset_save">
                <button type="submit" name="dosearch">Search</button>
            </div>
        </div>
    </form>
</fieldset>

<?= $results ?>

<fieldset id="fldsetbot">
    <legend>Add a new user</legend>
    <div class="fieldset_body" style="padding-bottom:5px; border-bottom:1px solid #ffffff;">
        <div class="fieldset_cola">
            <div class="fieldset_area"><span style="text-decoration:underline; font-weight:500;">Non-County users</span> Users are normally created when HR has inputted their data - which includes an Employee ID. Some potential BCGi users are not employed by the County and will therefore have no Employee ID - under these circumstances an account for BCGi can be created by using the Proceed button.</div>
        </div>
        <div class="fieldset_save"><button type="button" id="btn_add_noid" name="btn_add_noid">Proceed</button></div>
    </div>
    <div class="fieldset_body" style="margin-top:10px; padding-bottom:5px; border-bottom:1px dashed #ffffff;">
        <div class="fieldset_cola">
            <div class="fieldset_area"><span style="text-decoration:underline; font-weight:500;">County users awaiting their Employee ID</span> If you have used the above Search and could not find an employee it usually means that the HR data has not yet been created - your next step should be to follow that up with HR and not to use the Proceed button. If you do press Proceed and complete the ensuing form an entry for a new user will be created - however no further action can take place by IT until the HR data is received. If an account is created without an Employee ID this may produce duplicate profiles for the same user and possibly lead to delays and errors in finalising a user profile. You are therefore urged not to use the proceed button until HR has completed their data.</div>
        </div>
        <div class="fieldset_save"><button type="button" id="btn_add_preapp" name="btn_add_preapp">Proceed</button></div>
    </div>
    <form action="/it-account-request-change/" method="post">
        <div class="fieldset_body" style="margin-top:10px; border-bottom:1px solid #ffffff;">
            <div class="fieldset_cola">
                <div class="fieldset_area"><input type="text" id="findexistingapp" placeholder="Find existing application" style="padding:0 5px;"></div>
            </div>
            <div class="fieldset_save"></div>
        </div>
    </form>
</fieldset>

<script>
    jQuery(function($) {
        $(document).ready(function($) {

            function $dosubmit(gopage, goid, goeffective = false) {
                $('#spincontainer .spinitem').css("animation-play-state", "running");
                $('#spincontainer').show();
                if (gopage) {
                    var frm = '<form method="POST" action="/it-account-request-change/" id="toolform">';
                    frm += '<input type="hidden" name="gopage" id="gopage" value="' + gopage + '" />';
                    frm += '<input type="hidden" name="goid" id="goid" value="' + goid + '" />';
                    if (goeffective) {
                        frm += '<input type="hidden" name="goeffective" id="goeffective" value="' + goeffective + '" />';
                    }
                    frm += '</form>';
                    $('#the-content').append(frm)
                    $('#toolform').submit();
                }
            }

            function printData(el) {
                var divToPrint = document.getElementById(el);
                newWin = window.open("");
                newWin.document.write(divToPrint.outerHTML);
                newWin.print();
                newWin.close();
            }

            $('.viewonly input').attr('disabled', 'disabled');

            $('.viewuser').hover(function() {
                $(this).find('.far.fa-eye').toggle();
                $(this).find('.fas.fa-eye').toggle();
            });

            $('.viewuser').on('click', function() {
                $dosubmit('doexistinguser', $(this).data('userid'));
            });

            $('#btn_add_noid').click(function() {
                $dosubmit('doaddanon', '');
            });

            $('#btn_add_preapp').click(function() {
                window.location.assign('/it-account-request-preapp/');
            });

            $("#findexistingapp").on("keypress", function(event) {
                if (event.which == 13) {
                    event.preventDefault();
                    $action = 'findapplication';
                    $userifas = $(this).val();
                    $userwpid = 0;
                    $field = '';
                    $data = '';
                    $.ajax({
                        url: '/users_add_delete',
                        type: "POST",
                        async: true,
                        dataType: 'json',
                        data: {
                            'act': $action,
                            'ifas': $userifas,
                            'wpid': $userwpid,
                            'fld': $field,
                            'dat': $data
                        },
                        success: function(response) {
                            response = JSON.parse(response)
                            if (response) {
                                $(location).prop('href', '/it-account-request-preapp/?temp=' + $userifas)
                            } else {
                                alert("Application #" + $userifas + " not found");
                            }
                        },
                        error: function(xhr) {
                            alert("An error occured: " + xhr.status + " " + xhr.statusText);
                        }
                    });
                }
            });

            $("#dialogmsg").dialog({
                autoOpen: true,
                title: "<?= $subject ?>",
                minHeight: 200,
                minWidth: 200,
                width: 800,
                maxWidth: 600,
                modal: true,
                resizable: true,
                dialogClass: 'dialogClass',
                show: {
                    effect: "blind",
                    duration: 800
                },
                open: function() {
                    $(".ui-dialog-titlebar-close").hide();
                },
                buttons: [{
                    text: "Print",
                    click: function() {
                        printData('msgboxmsg');
                    }
                }, {
                    text: "OK",
                    click: function() {
                        $(this).dialog("close");
                    }
                }]
            });

            $('#spincontainer .spinitem').css("animation-play-state", "paused");
            $('#spincontainer').hide();

        });
    });
</script>
<style>
    #the-content {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        background-color: var(--global--corp-blued);
        font-size: 0.9rem;
    }

    #xsaverhead {
        display: none;
    }

    .tooltip {
        display: none;
        position: absolute;
        background-color: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    button {
        margin-left: 5px;
    }

    fieldset {
        border: 2px ridge #ffffff;
        box-shadow: inset 3px 3px 5px rgba(0, 0, 0, .5), 3px 3px 5px rgba(0, 0, 0, .5);
        padding-top: 0;
        padding-bottom: 10px;
    }

    fieldset legend {
        color: #ffffff;
        text-shadow: 2px 2px 4px #000000;
        font-size: 1.2rem;
    }

    fieldset .fieldset_body {
        display: flex;
    }

    fieldset .fieldset_cola {
        width: 75%;
    }

    fieldset .fieldset_col {
        color: #ffffff;
        width: 32%;
        display: flex;
        flex-flow: column;
    }

    fieldset .fieldset_area {
        color: #ffffff;
    }

    fieldset .fieldset_save {
        color: #ffffff;
        width: 24%;
        display: flex;
        align-items: bottom;
    }

    fieldset#fldsettop {
        margin: 0 20px;
    }

    fieldset#fldsetbot {
        margin: 20px 20px;
    }

    .toggle-checkbox {
        display: none;
        margin-bottom: 0;
    }

    .toggle-label {
        position: relative;
        display: inline-block;
        width: 53px;
        height: 26px;
        background-color: #ccc;
        border-radius: 34px;
        cursor: pointer;
        transition: background-color 0.2s;
        border: 1px solid #ffffff;
    }

    .toggle-label::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        left: 4px;
        top: 2px;
        background-color: #ffffff;
        border-radius: 50%;
        transition: transform 0.2s;
    }

    .toggle-checkbox+.toggle-label {
        margin-bottom: 2px;
    }

    .toggle-checkbox:checked+.toggle-label {
        background-color: #327791;
    }

    .toggle-checkbox:checked+.toggle-label::before {
        transform: translateX(26px);
    }

    #fldsettop ::-webkit-input-placeholder,
    #fldsettop :-ms-input-placeholder,
    #fldsettop ::-ms-input-placeholder,
    #fldsettop ::placeholder {
        color: #005677 !important;
    }

    #fldsettop ::-moz-placeholder {
        color: #005677 !important;
        opacity: 1 !important;
    }

    .dialogClass {
        padding: 0 10px 10px 10px;
        box-shadow: 2px 2px 5px 5px #888888;
    }

    .ui-dialog-titlebar .ui-dialog-title {
        color: #ffffff;
        font-weight: 500;
    }

    .ui-dialog-content.ui-widget-content {
        background-color: #ffffff;
        padding: 10px;
    }

    .ui-dialog-buttonset {
        text-align: right;
    }

    #dialogmsg div#msgbox {
        text-align: center;
    }

    #dialogmsg div#msgbox a {
        padding: 0 10px;
        text-decoration: none;
        border: 1px solid var(--global--corp-blued);
        background-color: #D6D6D6;
    }

    #dialogmsg div#msgbox a:hover {
        background-color: #cccccc;
    }
</style>