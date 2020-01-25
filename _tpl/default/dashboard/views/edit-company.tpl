<div class="row board">
  <h2>{$translations.dashboard_recruiter.edit_company_headline}</h2>
  <p>{$translations.dashboard_recruiter.edit_company_note}</p>
</div>
<br /><br />

<div class="dash-form mlm20">
	<form id="register-form" name="register-form" method="post" action="/dashboard-company" role="form" enctype="multipart/form-data">
		<input type="hidden" id="employer_id" name="employer_id" value="{$ID}" />
		<input type="hidden" id="oldlogo-path" name="oldlogo-path" value="{$company.logo_path}" />
		<input type="hidden" id="oldPP" name="oldPP" value="{$company.profile_picture}" />

		<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12 mlReset">

			<label class="fw" for="company_name">{$translations.registration.company_name}</label>
			<input required name="company_name" id="company_name" value="{$company.name}" maxlength="300" type="text" class="form-control minput"  />

			<label class="fw" for="company_hq">{$translations.registration.company_hq_label}</label>
			<input required name="company_hq" id="company_hq" value="{$company.hq}" maxlength="400" type="text" class="form-control minput"  />

			<label class="fw" for="company_url">{$translations.registration.company_url_label}</label>
			<input required name="company_url" id="company_url" value="{$company.url}" maxlength="1000" type="text" class="form-control minput"  />

			<label class="fw" for="company_street">{$translations.registration.company_street_label}</label>
			<input required name="company_street" id="company_street" value="{$company.street}" maxlength="300" type="text" class="form-control minput"  />

			<label class="fw" for="company_citypostcode">{$translations.registration.company_citypostcode_label}</label>
			<input required name="company_citypostcode" id="company_citypostcode" value="{$company.city_postcode}" maxlength="300" type="text" class="form-control minput"  />

		</div>

		<div class="col-lg-6 col-sm-12 col-md-6 col-xs-12 pl5p">

			<label class="fw" id="editCompanyLabel" for="company_logo">{$translations.registration.company_logo_label}</label>
		 	<input type="file" name="company_logo" id="company_logo" class="form-control inputfile minput" style="padding: 10px;" />
		 	<div class="textarea-feedback mb25" >{$translations.registration.company_logo_hint}</div>

		 	<div id="uploadPreview"><img src="/{$company.logo_path}" /></div>
		 	<div id="logo-err" class="negative-feedback displayNone">{$translations.registration.logo_err_msg}</div>
		 	<div id="logo-err2" class="negative-feedback displayNone">{$translations.registration.logo_err_samesize}</div>
		 	<div id="logo-ok" class="positive-feedback displayNone">{$translations.registration.logo_ok}</div>
		 	<br /><br />

			<div class="dash-cb">
				<label>
					<input {if $company.public_page == '1'}checked{/if} name="profile_switch" id="profile_switch" type="checkbox" class="checkbox-custom" onchange="SimpleJobScript.companyPublicProfileSwitched(this.checked);">
					<h4>{$translations.dashboard_recruiter.profile_picture_label}</h4>
				</label>
			</div>

 			 <div id="public-profile-block" class="mb50 form-group {if $company.public_page == '0'}displayNone{/if}" >
 				<label id="ppLabel" for="pp_file">{$translations.dashboard_recruiter.pp_label}</label>
 			 	<input type="file" name="pp_file" id="pp_file" class="form-control inputfile minput" />
 			 	<div class="textarea-feedback fw mb20" >{$translations.dashboard_recruiter.pp_hint}</div>
 			 	<div id="uploadPreviewPP"><img src="{$BASE_URL}{$company.profile_picture}" /></div>
 			 	<div id="pp-err" class="negative-feedback mt10 displayNone">{$translations.dashboard_recruiter.pp_err}</div>
 			 </div>

		</div>

		<div class="col-lg-11 col-sm-11 col-md-11 col-xs-11 mlReset" >
					<label class="fw" for="company_desc">{$translations.registration.company_desc}</label>
			<textarea class="form-control" name="company_desc" id="company_desc" rows="10">{$company.description}</textarea>
			<br /><br />
		</div>

		<div class="col-lg-6 col-sm-8 col-md-6 col-xs-12 mb50" >
			<button type="submit" class="btn mbtn fl" name="submit" id="submit" ><i class="fa fa-check fa-lg" aria-hidden="true"></i></button>
		</div>

	</form>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		setTimeout(function(){
			//SimpleJobScript.initRegisterFormStep2Validation();
			 $('#company_logo').change(function() {
			 var fname = $('input#company_logo').val().split('\\').pop();
			 if( fname )
				$('#editCompanyLabel').html(fname);
			 else
				$('#editCompanyLabel').html($('#editCompanyLabel').html());
      		 });

			 SimpleJobScript.initPP();

			 $('#pp_file').change(function() {
			 var profileFname = $('input#pp_file').val().split('\\').pop();
			 if( profileFname )
				$('#ppLabel').html(profileFname);
			 else
				$('#ppLabel').html($('#ppLabel').html());
      		 });

		}, 800);
	  
	});
</script>
