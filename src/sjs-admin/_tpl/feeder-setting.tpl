{include file="header.tpl"}
		
<div class="admin-content">
	<div class="admin-wrap-content " >
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
		<label class="admin-label">DATA FEEDER SETTINGS</label>
		<a href="/sjs-admin/feeder"><div class="subheading" style="color: #000;opacity: 0.65;">(&larr;go back)</div></a><br />

		<div class="alert alert-info fade in main-color">
		    <a href="#" class="close" data-dismiss="alert">&times;</a>
		    <i class="fa fa-info-circle info-fa" aria-hidden="true"></i>&nbsp;
		  	Set your admin company email to receive job application notifications. Other company details can be managed <a href="{$BASE_URL_ADMIN}login-as/144/Admin" target="_blank">here</a> by clicking on MY COMPANY tab.
		</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	
		<form action="{$BASE_URL_ADMIN}feeder-settings" method="post">
			<div>
				<div class="form-group mb20">
					<label>Email</label>
					<input required value="{$EMAIL}" class="form-control minput" type="text" name="email" id="email" size="100" />
				</div>
			<div class="button-holder-np form-group" >
				<button type="submit" class="btn btn-default btn-primary mbtn" name="submit" id="submit" >Save</button>
			</div>
		</form>

	</div>
 </div>
</div><!-- #content -->

{if $update_popup == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Entry successfully updated');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}