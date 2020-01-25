{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content " >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<label class="admin-label">ADD EMPLOYERS</label>
		<a href="/sjs-admin/feeder"><div class="subheading" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a><br />
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
	 <form role="form" method="post" action="{$BASE_URL_ADMIN}feeder/employers" enctype="multipart/form-data" >

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 deskPr100">
			<h4 class="oph general-headline gray-border-bottom">Company data</h4>

	 		<div class="form-group mb40">
			<input placeholder="{$translations.registration.company_name}" required name="company_name" id="company_name" maxlength="300" type="text" class="form-control grayInput minput "  />
			</div>

			<div class="form-group mb40">
				<input placeholder="{$translations.registration.company_hq_label}" required name="company_hq" id="company_hq" maxlength="300" type="text" class="form-control grayInput minput"  />
			</div>

			<div class="form-group mb40">
				<input placeholder="{$translations.registration.company_url_label}" name="company_url" id="company_url" maxlength="1000" type="text" class="form-control grayInput minput"  />
			</div>

			<div class="form-group mb40">
				<input placeholder="{$translations.registration.company_street_label}" name="company_street" id="company_street" maxlength="300" type="text" class="form-control grayInput minput"  />
			</div>

			<div class="form-group mb40">
			<input placeholder="{$translations.registration.company_citypostcode_label}" name="company_citypostcode" id="company_citypostcode" maxlength="300" type="text" class="form-control grayInput minput"  />
			</div>

			<div class="form-group mb40">
				<label id="bannerLabel" for="company_logo">{$translations.registration.company_logo_label}</label>
			 	<input type="file" name="company_logo" id="company_logo" class="form-control inputfile minput" />
			 	<div class="textarea-feedback" >{$translations.registration.company_logo_hint}</div>
			 	<div id="uploadPreview"></div>
			 	<div id="logo-err" class="negative-feedback displayNone">{$translations.registration.logo_err_msg}</div>
			 	<div id="logo-err2" class="negative-feedback displayNone">{$translations.registration.logo_err_samesize}</div>
			 	<div id="logo-ok" class="positive-feedback displayNone mt20">{$translations.registration.logo_ok}</div>
			</div>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6  deskPr100">
			<h4 class="oph general-headline gray-border-bottom">Employer</h4>
	 		<div class="form-group mb40">
				<input placeholder="Employer name" name="register_name" id="register_name" maxlength="400" type="text" class="form-control grayInput minput"  />
				<div id="err-reg-name" class="negative-feedback displayNone">{$translations.login.err_name}</div>
			</div>
			<div class="form-group mb40">
				<input required placeholder="{$translations.registration.email}" name="register_email" id="register_email" maxlength="400" type="email" class="form-control grayInput minput"  />
				<div id="err-reg-email" class="negative-feedback displayNone">{$translations.login.err_email}</div>
			</div>

			<div class="form-group mb40">
				<input required placeholder="Password (*)" name="register_pass1" id="register_pass1" maxlength="50" type="password" class="form-control grayInput minput"  />
			</div>

			<div class="form-group mb40">
				<input required placeholder="Repeat password (*)" name="register_pass2" id="register_pass2" maxlength="50" type="password" class="form-control grayInput minput"  />
				<div id="err-reg-pass2" class="negative-feedback displayNone">{$translations.login.err_passes}</div>
			</div>

		</div>

			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<div class="form-group mb40">
					<label>About company</label>
					<textarea name="company_desc" id="company_desc" ></textarea>
					<div class="textarea-feedback" id="textarea_feedback"></div>
				</div>
			</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<button type="submit" class="btn btn-default btn-primary mbtn" onclick="return Jobber.validatePasswords();">SUBMIT</button>
		</div>

	</form>
	</div>
 </div>
</div><!-- #content -->

{literal}
<script type="text/javascript">
	$(document).ready(function() {

		var theme = "{/literal}{$THEME}{literal}";
		tinymce.init({selector:'textarea:not(.noTinymceTA)', content_css : "/_tpl/" + theme + "/1.5/css/custom-editor.css", height : 300, resize: 'both' , theme: 'modern', toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image', toolbar2: 'preview media | forecolor emoticons', plugins: ["paste advlist autolink lists link image charmap preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars media nonbreaking save table contextmenu directionality emoticons template textcolor colorpicker textpattern "], paste_retain_style_properties: "color font-style font-size",paste_webkit_styles: "color font-style font-size" });

		$('#company_logo').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#bannerLabel').html(fname);
			else
				$('#bannerLabel').html($('#bannerLabel').html());
        });
	});
</script>
{/literal}

{if $COMPANY_ADDED == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Employer has been added to the system');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}