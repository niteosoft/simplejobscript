{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">SJS CUSTOMIZER</label>
	<div class="subheading">Add custom CSS styles</div>
	<div class="textarea-feedback" >[tip: find element class you wish to change in browser developer tools/inspector, than paste it here and change values]</div>
	<p>(<a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}customizer/">&larr;go back</a>)</p>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mt25">
	    <form method="post" action="{$BASE_URL_ADMIN}customize-css" role="form" enctype="multipart/form-data">

			<div class="form-group">
 
	    	<div class="form-group">
			  <textarea class="form-control" rows="20" name="cssarea" id="cssarea">{$data}</textarea>
			</div>

			</div>
			<br /><br />

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
 				<button style="margin-top: 30px;" type="submit"  class="btn btn-default btn-primary mbtn" name="submit" id="submit" class="mt25" >SAVE</button>
 			</div>

		</form>
    </div>

    </div>
</div>

{if $updated == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Design updated');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}