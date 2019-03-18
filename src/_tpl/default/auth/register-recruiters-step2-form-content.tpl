
<form id="register-form" name="register-form" method="post" action="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" role="form" enctype="multipart/form-data">
	<input type="hidden" name="step" id="step" value="2">
	<input type="hidden" name="employerid" id="employerid" value="{$employer_id}">
	<input type="hidden" name="employer_hash" id="employer_hash" value="{$employer_hash}">
	<input type="hidden" name="employer_email" id="employer_email" value="{$employer_email}">
	<input type="hidden" name="updatingEntry" id="updatingEntry" value="{$updatingEntry}">

	<div class="col-md-6 col-xs-12">

			<h3>{$translations.registration.company_name}</h3>
			<input required name="company_name" id="company_name" type="text" maxlength="300" />

			<h3>{$translations.registration.company_hq_label}</h3>
			<input required name="company_hq" id="company_hq" type="text" maxlength="400" />

			<h3>{$translations.registration.company_street_label}</h3>
			<input name="company_street" id="company_street" type="text" maxlength="500" />

			<h3>{$translations.registration.company_citypostcode_label}</h3>
			<input name="company_citypostcode" id="company_citypostcode" type="text" maxlength="500" />

			<h3>{$translations.registration.company_url_label}</h3>
			<input name="company_url" id="company_url" type="text" maxlength="1000" />

			<button type="submit" class="btn b2h btn-general" name="submit" id="submit">{$translations.registration.submit_final}</button>

	</div>

	<div class="col-md-6 col-xs-12">

			<h3>{$translations.registration.company_desc}</h3>		
			<textarea class="noTinymceTA" required name="company_desc" id="company_desc" maxlength="1000" rows="6" cols="42">{if $current_form}{$current_form.message}{/if}</textarea>
			<div class="textarea-feedback" id="textarea_feedback"></div>

			<div class="logo-upload-div">
				<label id="logoLabel" for="company_logo">{$translations.registration.company_logo_label}</label>
			 	<input type="file" name="company_logo" id="company_logo" class="form-control inputfile minput" />
			 	<div class="textarea-feedback mb25" >{$translations.registration.company_logo_hint}</div>

			 	<div id="uploadPreview"></div>
			 	<div id="logo-err" class="negative-feedback displayNone mt25">{$translations.registration.logo_err_msg}</div>
			 	<div id="logo-err2" class="negative-feedback displayNone mt25">{$translations.registration.logo_err_samesize}</div>
			 	<div id="logo-ok" class="pos-feedback-registration displayNone mt25">{$translations.registration.logo_ok}</div>
			</div>

	</div>

	<div class="col-md-12 col-xs-12">
		<br /><br /><br /><br />
	</div>

</form>

<script type="text/javascript">
	$(document).ready(function() {
		SimpleJobScript.I18n = {$translationsJson};
	    SimpleJobScript.initRegisterFormStep2Validation();

	    $('#company_logo').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#logoLabel').html(fname);
			else
				$('#logoLabel').html($('#logoLabel').html());
       });
	});
</script>
