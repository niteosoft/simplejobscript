{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content " >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<label class="admin-label">Import Jobs in Bulk</label>
		<a href="/sjs-admin/feeder"><div class="subheading mb10" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a>
		<div class="alert alert-info fade in main-color">
		    <a href="#" class="close" data-dismiss="alert">&times;</a>
		     <i class="fa fa-info-circle info-fa" aria-hidden="true"></i>&nbsp;
		    You can download the job import sample file from <a download href="{$BASE_URL}uploads/csv/IMPORT_FILE_SAMPLE.csv">here</a>. Please follow this format to ensure a successful upload. You can add types / locations / categories that exist in your project, or add and import new ones. Employer account / email needs to exist. Maximum file size per 1 import - 1MB (up to 20 000 jobs).
		</div><br />
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
		 <form role="form" method="post" action="{$BASE_URL_ADMIN}feeder/import" enctype="multipart/form-data" >

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 deskPr100">
	
						<div class="form-group mb40">
							<label id="bannerLabel" for="cv">Upload a file</label>
							<input accept=".csv" name="cv" id="cv" class="inputfile form-control minput" type="file" />

							<div class="textarea-feedback" >[csv]</div>
							<div id="uploadPreview"></div>
							<div id="err" class="negative-feedback displayNone">File too large or invalid format</div>
							{if $ERR_IMPORT}<div id="err" class="negative-feedback">Import has failed to complete, please check if the headers format is correct</div>{/if}
						</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<button id="submitButton" type="submit" class="btn btn-default btn-primary mbtn" onclick="return Jobber.createProfileValidationAdmin({$MAX_CV_SIZE});">SUBMIT</button>
				</div>

		</form>
	</div>
 </div>
</div><!-- #content -->

{literal}
<script type="text/javascript">

	{/literal}
		var fSize = "{$MAX_FILE_SIZE}";
		var fSizeText = "{$MAX_FILE_SIZE_TEXT}";
	{literal}

	$(document).ready(function(){

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

{if $IMPORT_SUCCESS == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Import completed');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}