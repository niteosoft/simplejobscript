{include file="1.5/layout/sjs-header.tpl"}

<div class="contact-us create-profile">
	<div class="container">

		<div class="row">
			<h2>{$translations.apply.create_profile_headline}</h2>
		</div>
		<br /><br />

		<form role="form" method="post" action="{$BASE_URL}{$URL_REGISTER_APPLICANTS}" enctype="multipart/form-data" >
			<input type="hidden" id="external_links" name="external_links" value="0" />

			<div class="row">
				
				<div class="col-md-6 col-xs-12">
						<h3>{$translations.apply.name}</h3>
						<input required id="apply_name" name="apply_name" type="text" maxlength="500">

						<h3>{$translations.apply.email}</h3>
						<input required type="email" id="apply_email" name="apply_email" maxlength="300">

						<h3>{$translations.apply.portfolio}</h3>
						<input type="text" id="portfolio" name="portfolio" maxlength="500">

						<h3>{$translations.apply.location}</h3>
						<input required type="text" id="apply_location" name="apply_location" >

				</div>

				<div class="col-md-6 col-xs-12">
					<h3>{$translations.apply.password}</h3>
					<input required type="password" id="pass1" name="pass1"  maxlength="50" >

					<h3>{$translations.registration.password2}</h3>
					<input required type="password" id="pass2" name="pass2"  maxlength="50" >
					<div id="feedback-err" class="negative-feedback displayNone">{$translations.login.err_passes}</div>

					<h3>{$translations.apply.phone}</h3>
					<input type="tel" id="apply_phone" name="apply_phone">

					<h3>{$translations.apply.occupation_placeholder}</h3>
					<input placeholder="{$translations.apply.occupation_desc}" required type="text" id="occupation" name="occupation" maxlength="500">

				</div>

			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12">

					<h3>{$translations.js.skills_label}</h3>
					<div class="profile-taggl minput textarea clearfix skillsTaggle"></div>
					
					<h3>{$translations.apply.create_profile_desc}</h3>
					<textarea required id="apply_msg" name="apply_msg" maxlength="500" rows="8" cols="50"></textarea>
					<div class="textarea-feedback tal" id="textarea_feedback"></div>

					<div class="clear-both"></div>

					<p>
						<label id="cvLabel" for="cv">{$translations.apply.cv_label}</label><input accept=".doc,.docx, .pdf" name="cv" id="cv" class="inputfile" type="file" /><span class="cv-hint">{$cv_hint}</span><br />
						 <span id="err" class="negative-feedback displayNone ml0 mt15">{$translations.apply.cv_err}</span>
				    </p>

				</div>
			</div>


			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="SMLinkDiv">
						<a id="addLink" class="green" onclick="return SimpleJobScript.addExternalLink();" href="#">{$translations.js.add_social_media}</a>
						<div id="addLinkBlock"></div>
					</div>
				</div>
			</div>

			{if $GDPR_ENABLED == '1'}
			<div class="row">
				<div class="col-md-6 col-xs-12">						
						<div class="tos">
							<label><input required type="checkbox" class="checkbox-custom"></input> 
							<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}gdpr"> {$translations.registration.accept_gdpr}</a></h4></label>
						</div>
				</div>
			</div>
			{/if}

			<div class="row">
				<div class="col-md-6 col-xs-12">						

						{if $ENABLE_RECAPTCHA}
						{$captcha_html}
						<div id="captcha_err" class="negative-feedback displayNone ml0" >{$translations.apply.captcha_empty_err}</div>
						{/if}

						<div class="tos">
							<label><input required type="checkbox" class="checkbox-custom"></input> 
							<h4>{$translations.registration.accept_part1} <a target="_blank" href="{$BASEURL}{TERMS_CONDITIONS_URL}"> {$translations.registration.accept_part2}</a></h4></label>
						</div>

				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-xs-12">

					<button type="submit" class="btn" onclick="return SimpleJobScript.createProfileValidation({$MAX_CV_SIZE});">{$translations.website_general.top_menu_register_label}</button>

				</div>
			</div>

			</div>
		</form>



</div>

{literal}
<script type="text/javascript">
	$(document).ready(function() {
		SimpleJobScript.I18n = {/literal}{$translationsJson}{literal};
		SimpleJobScript.initApplyValidation();

		$('#cv').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#cvLabel').html(fname);
			else
				$('#cvLabel').html($('#cvLabel').html());
        });
	});
</script>
{/literal}

{include file="1.5/layout/sjs-footer.tpl"}