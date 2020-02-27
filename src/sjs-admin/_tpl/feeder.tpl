{include file="header.tpl"}
		
<div class="admin-content ">
	<div class="admin-wrap-content " >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<label class="admin-label">DATA FEEDER</label>
		<div class="alert alert-info fade in main-color">
		    <a href="#" class="close" data-dismiss="alert">&times;</a>
		     <i class="fa fa-info-circle info-fa" aria-hidden="true"></i>&nbsp;
		  	Post new jobs, create employer & jobseeker profiles [jobseeker = premium plugin]
		</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb10 mlpl0">
			<a href="{$BASE_URL_ADMIN}feeder/jobs">
				<button type="button" class="mbtn btn btn-default alizarinBtn">POST JOBS</button>
			</a>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb10 mlpl0">
			<a href="{$BASE_URL_ADMIN}feeder/import">
				<button type="button" class="mbtn btn btn-default alizarinBtn">IMPORT JOBS</button>
			</a>
		</div>
		
		{if $PROFILE_PLUGIN == '1'}
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb10 mlpl0">
			<a href="{$BASE_URL_ADMIN}feeder/candidates">
				<button type="button" class="mbtn btn btn-default alizarinBtn">ADD JOBSEEKERS</button>
			</a>
		</div>
		{/if}

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mb10">
			<a href="{$BASE_URL_ADMIN}feeder/employers">
				<button type="button" class="mbtn btn btn-default alizarinBtn">ADD EMPLOYERS</button>
			</a>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
			<a href="{$BASE_URL_ADMIN}feeder-settings">
				<button type="button" class="btn btn-default btn-primary mbtn">SETTINGS</button>
			</a>
		</div>
	</div>

</div><!-- #content -->
</div>

{include file="footer.tpl"}