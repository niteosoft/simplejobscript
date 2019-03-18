{include file="header.tpl"}

		<div class="admin-content">
	     <div class="admin-wrap-content">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="admin-label">
				Edit job
			</label>
			<span class="back-area" >
			 	<a href="{$HTTP_REFERER}" style="float: right;"><button type="button" class="btn btn-default back-button" >{$translations.dashboard_recruiter.back}</button></a>
			 </span>
		</div>

		<br />

		<div class="container-fluid ">

			<form method="post" action="{$BASE_URL_ADMIN}post-edited/" role="form">
				<input type="hidden" id="job_id" name="job_id" value="{$job.id}" />
				<input type="hidden" id="referer" name="referer" value="{$referer}" />

				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mb20">

					<!-- catgory-->
					<div class="form-group mb20">
						<label class="grayLabel" for="type">{$translations.dashboard_recruiter.post_type_label}</label>
						<select id="type_select" name="type_select" class="form-control minput">
							{foreach from=$types key=id item=value}
								<option {if $value == $job.type_name}selected{/if} value="{$id}">{$value}</option>
							{/foreach}
						</select>
					</div>

					<!-- job types-->
					<div class="form-group mb20">
						<label class="grayLabel" for="type">{$translations.dashboard_recruiter.post_category_label}</label>
						<select id="cat_select" name="cat_select" class="form-control minput">
							{foreach from=$cats key=id item=value}
								<option {if $id == $job.category_id}selected{/if} value="{$id}">{$value}</option>
							{/foreach}
						</select>
					</div>

					{if $remote_portal == 'deactivated'}
						<div class="grayLabel form-group mb20">
							<label for="description">Location</label>
							<select id="location_select" name="location_select" class="form-control minput">
							{foreach from=$cities key=id item=value}
								<option {if $id == $job.city_id}selected{/if} value="{$id}">{$value}</option>
							{/foreach}
							</select>
						</div>
					{/if}
				</div>

				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="grayLabel form-group mb20">
						<label for="title">{$translations.dashboard_recruiter.post_title_label}</label>
						<input required name="title" id="title" maxlength="400" type="text" class="form-control minput" value="{$job.title}" />
					</div>

					<div class="grayLabel form-group ">
						<label for="salary">{$translations.dashboard_recruiter.salary_label}</label>
						<input {if $lock_post}disabled{/if} name="salary" id="salary" maxlength="100" type="text" class="form-control minput" value="{$job.salary}" />
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mlpl0">
						<div class="form-group mb20 grayLabel">
							<label for="description">{$translations.dashboard_recruiter.post_desc_label}</label>
							<textarea id="description" name="description">{$job.description}</textarea>
						</div>
					</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

					 <div class="form-group mb20">
					 	<input type="checkbox" onchange="applyChanged(this.checked);" name="apply_online_switch" id="apply_online_switch" data-size="mini" {if $job.apply_online == '1'}checked{/if} /><label style="margin-left: 10px; margin-bottom" class="switch-label mt25 grayLabel">{$translations.dashboard_recruiter.apply_label}</label><span class="apply-desc-span">{$translations.dashboard_recruiter.apply_desc}</span>
					 </div>

					 <div id="apply-desc-block" class="form-group mb20 {if $job.apply_online == '1'} displayNone{/if}" >
						<label class="green">{$translations.dashboard_recruiter.howto_apply_label}</label>
						<input id="howtoTA" class="form-control minput" rows="5" cols="5" id="howtoapply" name="howtoapply" value="{$job.apply_desc}"></input>
					 </div>
				</div>
					 <br /><br />
				 </div>
				  <br />

				  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					  <div class="form-group mb20">
					  	<button  type="submit" onclick="return validateDesc();" class="btn btn-default btn-primary mbtn" name="submit" id="submit" >{$translations.dashboard_recruiter.change_password_submit}</button>

				  		<a href="{$HTTP_REFERER}"><button type="button" class="right-btn btn btn-default btn-warning mbtn" >{$translations.dashboard_recruiter.cancel}</button></a>
					  </div>
				  </div>

			</form>
			<br />
			</div>
	</div><!-- /content -->
	</div>

{literal}
<script type="text/javascript">
	$(document).ready(function(){
		var theme = "{/literal}{$THEME}{literal}";
		tinymce.init({selector:'textarea:not(.noTinymceTA)', content_css : "/_tpl/" + theme + "/1.5/css/custom-editor.css", height : 300, resize: 'both' , theme: 'modern', toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image', toolbar2: 'preview media | forecolor emoticons', plugins: ["paste advlist autolink lists link image charmap preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars media nonbreaking save table contextmenu directionality emoticons template textcolor colorpicker textpattern "], paste_retain_style_properties: "color font-style font-size",paste_webkit_styles: "color font-style font-size" });
	});

	function applyChanged(val) {
		if (val == false) {
			$('#apply-desc-block').removeClass('displayNone');
		} else {
			$('#howtoTA').val('');
			$('#apply-desc-block').addClass('displayNone');
		}
	}

	function validateDesc() {
		if (tinymce.activeEditor.getContent() == "") {
			alert("Please, fill in the job description");
			return false;
		} else return true;
	}

</script>
{/literal}		

{include file="footer.tpl"}
