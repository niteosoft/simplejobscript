{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content " >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<label class="admin-label">ADD JOBSEEKERS</label>
		<a href="/sjs-admin/feeder"><div class="subheading" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a><br />
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
	 <form role="form" method="post" action="{$BASE_URL_ADMIN}feeder/candidates" enctype="multipart/form-data" >
	 	<input type="hidden" id="external_links" name="external_links" value="0" />



		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 deskPr100">
				<div class="form-group mb40">
					<input placeholder="{$translations.apply.name}" required id="apply_name" name="apply_name" type="text" class="form-control minput" />
				</div>

				<div class="form-group mb40">
					<input placeholder="Email (*)" required id="apply_email" name="apply_email" type="email" maxlength="100" class="form-control minput" />
				</div>

				<div class="form-group mb40">
					<input placeholder="{$translations.apply.portfolio}" id="portfolio" placeholder="{$translations.apply.portfolio_placeholder}" name="portfolio" type="text" maxlength="100" class="form-control minput" />
				</div>

				<div class="form-group mb40">
					<input required id="occupation" name="occupation" placeholder="{$translations.apply.occupation_placeholder}" type="text" maxlength="200" class="form-control minput" />
					<div class="textarea-feedback" >{$translations.apply.occupation_desc}</div>
				</div>
				
				<div class="form-group">
					<textarea placeholder="About the Jobseeker (*)" required class="form-control" rows="5" id="apply_msg" name="apply_msg"></textarea>
					<div class="textarea-feedback" id="textarea_feedback"></div>
				</div>

				<div class="form-group mb40">
					<label id="bannerLabel" for="cv">{$translations.apply.cv_label}</label>
					<input accept=".doc,.docx, .pdf" name="cv" id="cv" class="inputfile form-control minput" type="file" />

					<div class="textarea-feedback" >{$cv_hint}</div>
					<div id="uploadPreview"></div>
					<div id="err" class="negative-feedback displayNone">{$translations.apply.cv_err}</div>
				</div>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mb40 deskPr100">
				<div class="form-group mb40">
					<input required placeholder="{$translations.apply.password}" type="password" id="pass1" name="pass1"  maxlength="50" class="form-control minput" />
				</div>
				<div class="form-group mb40">
					<input required placeholder="{$translations.registration.password2}" type="password" id="pass2" name="pass2"  maxlength="50" class="form-control minput" />
					<div id="feedback-err" class="negative-feedback displayNone">{$translations.login.err_passes}</div>
				</div>
				<div class="form-group mb40">
					<input placeholder="{$translations.apply.phone}" type="tel" id="apply_phone" name="apply_phone"  maxlength="50" class="form-control minput" />
				</div>
				<div class="form-group mb40">
					<input placeholder="Location (*)" type="text" id="apply_location" name="apply_location"  maxlength="400" class="form-control minput" />
				</div>

				<div class="form-group mb40">
					<div class="input textarea clearfix skillsTaggle"></div>
				</div>

		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group mb20">
				<a id="addLink" onclick="return Jobber.addExternalLink();" href="#">{$translations.js.add_social_media}</a>
			</div>

			<div id="addLinkBlock" class="mb30"></div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<button type="submit" class="btn btn-default btn-primary mbtn" onclick="return Jobber.createProfileValidationAdmin({$MAX_CV_SIZE});">SUBMIT</button>
		</div>

	</form>
	</div>
 </div>
</div><!-- #content -->

{literal}
<script type="text/javascript">
	$(document).ready(function() {

		$('#cv').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#bannerLabel').html(fname);
			else
				$('#bannerLabel').html($('#bannerLabel').html());
        });
	});
</script>
{/literal}

{if $CANDIDATE_ADDED == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Jobseeker has been added to the system');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}