{include file="header.tpl"}

	<div class="admin-content">
		<div class="admin-wrap-content" style="padding-right: 35px !important;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<label class="admin-label">Job locations</label>
				{if $REMOTE_PORTAL == 'activated'}
				<div class="subheading">Remote portal is activated. Locations won't be shown. You can change the settings <a target="_blank" href="/sjs-admin/settings/main/"> here.</a></div> <br />
				{else}
				<div class="subheading">Companies can select a location from this list when posting a job. Click "+" to add new or import locations in bulk by uploading a CSV file and clicking on "IMPORT"</a></div> 
				{/if}
			</div>

				<div class="ml15">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="list">
							{foreach from=$cities item=city}
							<div class="row settings-row p15" id="item{$city.id}" >
								<div class="icons">
									<a href="{$BASE_URL_ADMIN}cities/prepare-edit/{$city.id}/" title="Edit this city"><i class="fa fsx fa-gear fa-lg mr10" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" title="Delete this city" onclick="jobberBase.deleteCity('{$BASE_URL_ADMIN}cities/delete/', {$city.id})"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
								</div>
								<span>{$city.name}</span>
							</div>
							{/foreach}
						</div>

						<p style="margin: 20px -10px;"><a href="{$BASE_URL_ADMIN}cities/prepare-add/" title="Add a new city"><span title="Add new city" class="blueColor fui-plus-circle iconSize" aria-hidden="true"></span></a></p>
					</div>
				</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="background: #f2f2f2; padding: 2% 1%;">
			<form role="form" method="post" action="{$BASE_URL_ADMIN}cities/import" enctype="multipart/form-data" >

				<div class="form-group">
					<label id="bannerLabel" for="cv" style="font-size:15px;">UPLOAD CSV</label>
					<input required accept=".csv" name="cv" id="cv" class="inputfile form-control minput" type="file" />

					<!-- <div id="err" class="negative-feedback displayNone">{$translations.apply.cv_err}</div> -->
				</div>

				<div class="banBtnDiv">
					<button id="submitButton" type="submit" class="btn btn-default btn-primary mbtn" style=" background-color: #E74C3C">IMPORT</button>
				</div>
			</form>
		</div>


		</div><!-- #content -->
		</div>

{include file="footer.tpl"}


{literal}
<script type="text/javascript">

	{/literal}
		var fSize = "{$MAX_FILE_SIZE}";
		var fSizeText = "{$MAX_FILE_SIZE_TEXT}";
	{literal}

	$(document).ready(function() {

		$('#cv').change(function() {

			if (this.files && this.files[0].size > fSize){
				alert('File too large. There is a ' + fSizeText + ' upload limit.');
				this.files.value = null;
				$('#submitButton').attr('disabled','disabled');
				return;
			} else {
				$('#submitButton').removeAttr('disabled');
			}

			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#bannerLabel').html(fname);
			else
				$('#bannerLabel').html($('#bannerLabel').html());
        });
	});
</script>
{/literal}

{if $IMPORT_POPUP == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Locations have been imported');
   }, 1000);
</script>
{/if}


{if $cityAdded}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Location has been created');
   }, 1000);
</script>
{/if}

{if $cityEdited}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Location has been updated');
   }, 1000);
</script>
{/if}