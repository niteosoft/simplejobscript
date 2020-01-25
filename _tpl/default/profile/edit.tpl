
<div class="row">
    <div class="col-md-12 col-sm-12 mb20">
        <p class="profile-subheadline">
            {$translations.profile.edit_subheadline}
        </p>
    </div>
</div>


<form role="form" action="/{$URL_PROFILE}/profile-edited" method="post" enctype="multipart/form-data" >
	<input type="hidden" id="external_links" name="external_links" value="{$applicant.sm_links|@count}" />

	<div class="row tal">
		<div class="col-md-6 col-sm-12">

		   <label>{$translations.profile.form_name}:</label>
		   <input required class="minput opaque" value="{$applicant.fullname}" name="fullname" id="fullname" maxlength="50" type="text"  /> 
		   <br />

		   <label>{$translations.apply.occupation_label}:</label>
		   <input required class="minput opaque" value="{$applicant.occupation}" name="occupation" id="occupation" maxlength="200" type="text"  /> 
		   <br />

		   <label class="fullW">{$translations.profile.form_contact}:</label>
		   <input class="minput opaque" value="{$applicant.phone}" name="phone" id="phone" maxlength="50" type="text"  />
		    <br />


		   <label>{$translations.dashboard_recruiter.post_location_label}</label>
		   <input required class="minput opaque" value="{$applicant.location}" name="location" id="location" maxlength="400" type="text"  />
		    <br />

		   <label>{$translations.profile.form_weblink}:</label>
		   <input class="minput opaque" value="{$applicant.weblink}" name="weblink" id="weblink" maxlength="50" type="text"  />
		    <br />
 
			<div class="tos">
					<label class="fullW"><input name="public_profile" id="public_profile" {if $applicant.public_profile == 1}checked{/if} type="checkbox" class="checkbox-custom"></input> 
					<h4 class="pt9">{$translations.profile.form_profile}</h4></label>
			</div> 
			<br />

			<div class="tos">
					<label class="fullW"><input name="subscription_flag" id="subscription_flag" {if $subs_data == 1}checked{/if} type="checkbox" class="checkbox-custom"></input> 
					<h4 class="pt9">{$translations.profile.form_subscription}</h4></label>
			</div> 

		 </div>

		 <div class="col-md-6 col-sm-12 m-mobt8">

			<label>{$translations.profile.form_desc}</label>
			<textarea class="noTinymceTA minput opaque pTextArea" required id="msg" name="msg" maxlength="500" rows="8" cols="50">{$applicant.message}</textarea>
			 <br />

			<label>{$translations.profile.skills}</label>
			<div class="input textarea clearfix profileEditTaggle minput edit-profile"></div>

			 <div class="row">
				 <div class="col-md-6 col-sm-12">
				 	<label class="mob-mb5">{$translations.profile.form_cv} </label>
				 </div>

				 <div class="col-md-6 col-sm-12">
			 		{if $applicant.cv_path == '' or $applicant.cv_path == '-'}
			  		<i class="fa fa-close opaque-fa" aria-hidden="true"></i>
			  		{else}
			  		<a href="{$BASE_URL}{$applicant.cv_path}">
			  			<i class="{$img_path}" aria-hidden="true"></i>
			  		</a>
			  		{/if}
				 </div>
			 </div>
			 <br /><br />

			 <div class="row">
				 <div class="col-md-12 col-sm-12">
				 	<label>{$translations.profile.form_newcv} </label>
				 	
				 </div>
				 <br /> <br />

				 <div class="col-md-12 col-sm-12">
					<label id="applicantCvLabel" for="applicantCv">{$translations.profile.form_upload}</label>
				  	<input accept=".pdf,.doc,.docx" type="file" name="applicantCv" id="applicantCv" class="form-control inputfile minput" />
				  	<input type="hidden" id="currentCv" name="currentCv" value="{$applicant.cv_path}" />
				 </div>
	
			 </div>

		 </div>

		  <div class="col-md-12 col-sm-12 mt50">
				<a id="esmId" class="green" onclick="return SimpleJobScript.showSMfields();" >{$translations.js.edit_social_media}</a>
				<br /><br />


				<div id="showSMfieldsBlockId" class="displayNone">

					<div id="SMsubBlock">
				 {foreach $applicant.sm_links as $obj}
				 	<div id="sm_fg_{$obj@iteration}" class="form-group mb30">
				 		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl0 ml0 mb20">
					 		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pl0 ml0">
								<div class="form-group">
								   <input value="{$obj->linkToShow}" name="sm_url_{$obj@iteration}" id="sm_url_{$obj@iteration}" type="text" class="form-control grayInput minput"  /> 
								</div>
							</div>

							<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml20-desk">
								<div class="form-group">
								   <select id="sm_select_{$obj@iteration}" name="sm_select_{$obj@iteration}" class="form-control minput">
								   {foreach $SM_PROFILES as $ITEM}
								   	  <option {if $obj->smId == $ITEM.id}selected{/if} value="{$ITEM.id}">{$ITEM.name}</option>
								   {/foreach}
								   </select>
								</div>
							</div>

							<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
									<a id="sm_close_{$obj@iteration}" class="green" href="#sm_close_{$obj@iteration}" onclick="return SimpleJobScript.removeProfileSMfield('{$obj@iteration}');"><i class="fa fa-close mt18" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				 {/foreach}
				 	</div>

				 	<div class="form-group mb30">
						<a id="addSMLink" class="green" onclick="return SimpleJobScript.addProfileSMLink();" >{if $applicant.sm_links|@count lt 4}{$translations.js.add_social_media}{else}<span class="limr">{$translations.js.limit_reached}</span>{/if}</a>
					</div>

				</div>
		  </div>

		<div class="row mb50">
		    <div class="col-md-6 col-sm-12">
		    	<button type="submit" class="btn mbtn zeromlplLeft mt50" name="submit" id="submit" >{$translations.website_general.text_save}</button>
		    </div>
		</div>

	</div>

</form>


<script type="text/javascript">
{literal}
{/literal}
   {foreach $applicant.sm_links as $obj}
 {literal}
 	var elIndex = {/literal}{$obj@iteration}{literal} - 1;
	if ($('#sm_close_' + elIndex).length) {
		$('#sm_close_' + elIndex).addClass('displayNone');
	}
 {/literal}
   {/foreach}
 {literal}

	 $('#applicantCv').change(function() {
		 var fname = $('input[type=file]').val().split('\\').pop();
		 if( fname )
			$('#applicantCvLabel').html(fname);
		 else
			$('#applicantCvLabel').html($('#applicantCvLabel').html());
		 });
{/literal}
</script>