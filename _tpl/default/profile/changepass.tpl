
<div class="row">
    <div class="col-md-12 col-sm-12 mb20">
        <p class="profile-subheadline">
            {$translations.profile.passchange_desc}
        </p>
    </div>
</div>

<form role="form" action="/{$URL_PROFILE}/pass-edited" method="post" >
    <div class="row">
        <div class="col-md-6 col-sm-12">

                   <input placeholder="{$translations.login.new_pass}" name="pass1" id="pass1" maxlength="50" type="password" class="minput" required /> 

                   <input placeholder="{$translations.login.new_pass2}" name="pass2" id="pass2" maxlength="50" type="password" class="minput" required /> 

                    <div id="passrecovery-feedback-err" class="negative-feedback mt0 displayNone">{$translations.login.err_passes}</div>  

        </div>

        <div class="col-md-6 col-sm-12">
            <a class="greenLink" href="{BASE_URL}{$URL_PROFILE}/{$URL_PROFILE_DELETE}">

                <button type="button"  class="btn mbtn zeromlplLeft">{$translations.profile.delete_acc_label}</button>


            </a>
        </div>

    </div>

    <div class="row mb50">
        <div class="col-md-6 col-sm-12 pushTop40">
            <button type="submit_forgotten_pass"  onclick="return SimpleJobScript.applicantPasswordValidation();" class="btn mbtn zeromlplLeft mt50" name="submit" id="submit" required><i class="fa fa-check fa-lg" aria-hidden="true"></i></button>
        </div>
    </div>
</form>
