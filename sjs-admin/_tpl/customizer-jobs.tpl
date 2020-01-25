{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">SJS CUSTOMIZER</label>
	<div class="subheading">Job listing page</div>
	<p>(<a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}customizer/">&larr;go back</a>)</p>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt25">
	    <form method="post" action="{$BASE_URL_ADMIN}customize-jobs" role="form" enctype="multipart/form-data">

			<div class="form-group">
 
			   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mb25">

			   		<label>Subheader image</label><br />

				   	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<label id="bannerLabel" for="jobs_subheader_bg_path">Upload new</label>
					 	<input type="file" name="jobs_subheader_bg_path" id="jobs_subheader_bg_path" class="form-control inputfile minput" />
					 	<div class="textarea-feedback" >[recommended size ratio 1600x500]</div>
			 	
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<img width="250" src="{$BASE_URL}{$customizer_data.jobs_subheader_bg_path}" />
					</div>

				</div>
				<br /><br /><br />

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
				   <label>Logo width (use "%" or "px")</label>
				   <input value="{$customizer_data.jobs_logo_width}" class="form-control" type="text" name="jobs_logo_width" id="jobs_logo_width" size="100" />
				   <br />

				   <label>Mobile logo width</label>
				   <input value="{$customizer_data.jobs_logo_width_mobile}" class="form-control" type="text" name="jobs_logo_width_mobile" id="jobs_logo_width_mobile" size="100" />
				   <br />

				   <label>Logo padding</label>
				   <input value="{$customizer_data.jobs_logo_padding}" class="form-control" type="text" name="jobs_logo_padding" id="jobs_logo_padding" size="100" />
				   <br />
				   
				</div>
 
				{if $PROFILE_PLUGIN == '1'}
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
						<div class="form-group" >
				
						   <input type="checkbox" name="jobs_candidates_on_flag" id="jobs_candidates_on_flag" data-size="mini" {if $customizer_data.jobs_candidates_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn top menu candidate links ON/OFF</label>
						   <div class="textarea-feedback" >[If you do not wish candidates to add resumes and sign up, you can disable it from menu]</div>
						</div>
						<br />
					</div>
				{/if}

			</div>
			<br /><br />

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
 				<button style="margin-top: 30px;" type="submit"  class="btn btn-default btn-primary mbtn" name="submit" id="submit" class="mt25" >SAVE</button>
 			</div>

		</form>
    </div>

    </div>
</div>

{literal}
<script type="text/javascript">
		$(document).ready(function() {

		$('#jobs_subheader_bg_path').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#bannerLabel').html(fname);
			else
				$('#bannerLabel').html($('#bannerLabel').html());
        });

        });
</script>
{/literal}

{if $updated == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Design updated');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}