{include file="header.tpl"} 

<div class="admin-content">
	<div class="admin-wrap-content" >

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb25">
			<label class="admin-label">
				JOB BOARD UPDATES
			</label>

			 {if $SJS_PRODUCT == 'free'}
				<div class="subheading">You can update your project to a full version with premium plugins, product support, new version notifications and software updates</div>
			 {else}
				{if $LICENSE_EXISTS == '1'}
					<div class="subheading">{if $VERSION_UPDATE_URL}<u>There is a new version of SJS {$version_data->new_version}. You can update your job board. </u>{/if}{if $LS == '3'}Your site URL has not been activated yet please contact our team. {/if}{if $LS == '1' or $LS == '3'}New version release and software updates notifications are turned ON. To contact our support visit this<a href="https://simplejobscript.com/product-support/" target="_blank"> LINK</a>. {/if}{if $LS == '2'}Expired licenses are no longer eligible for product support, new version notifications and software updates. {/if}Product information, instructions and features roadmap can be found <a href="https://simplejobscript.com/job-board-updates/" target="_blank">HERE</a>.</div>
				{else}
					<div class="subheading">Activate your license in order to receive product support, new version notifications and software updates</a></div>
				{/if}
			 {/if}

		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="overflow: hidden">
			  
			  <strong>{$PR_VERSION}</strong>
			  <hr />

			  {if $SJS_PRODUCT == 'free'}

			  	<a href="https://simplejobscript.com/downloads/simplejobscript-complete/" target="_blank"><button type="button" class="mbtn btn btn-default alizarinBtn">Update</button></a>

			  {elseif $SJS_PRODUCT == 'full'}

			  	{if $LICENSE_EXISTS == '1'}
					 <p>License Key: <strong>&nbsp;&nbsp;&nbsp;{$LICENSE_KEY}</strong></p>

				  	 {if $LICENSE_ERR_STATUS == '1'}
				  	 	<span class="alizarin"><strong>{$LICENSE_ERR}</strong></span>
				  	 {else}

					 	 <p>Status: <strong>&nbsp;&nbsp;&nbsp;{if $LS == '1'}<span class="green"> activated </span>{elseif $LS == '0'} <span class="blue"> inactivated </span>{elseif $LS == '3'}<span class="blue"> domain inactivated </span>{else}<span class="alizarin"> expired </span>{/if}</strong></p>

					 	 <p>Expiration: <strong>&nbsp;&nbsp;&nbsp;{$l_expiry}</strong>&nbsp; <span class="apply-desc-span">(Y/M/D)</span></p>
				
						 {if $MULTI_LICENSE == 'true'}
					 	 <p><u>You can install and activate your job board license on {$MULTI_LICENSE_ACTIVATIONS_LEFT} more {if $SINGULAR_FLAG}domain{else}domains{/if}.</u></p>
					 	 {/if}

					 	 {if $VERSION_UPDATE_URL}
					 	 	{if $LS == '1'}
					 			 <a href="{$VERSION_UPDATE_URL}" target="_blank"><button type="button" class="mbtn btn btn-default alizarinBtn">UPDATE version</button></a>
					 	 	{else}
					 	 		 <span class="alizarin"><strong> An active license and valid domain is needed in order to obtain any updates</strong></span>
					 	 	{/if}
					 	 {/if}

					 	 {if $RENEW_BTN == 'true'}
					 	  	<a href="{$RENEW_URL}" target="_blank"><button type="button" class="mbtn btn btn-default alizarinBtn">RENEW YOUR LICENSE</button></a>
					 	 {/if}


				  	 {/if}

			  	{else}
			  		<form method="post" action="{$BASE_URL_ADMIN}updates/activation">

						<label>License key:</label>

						<input required class="form-control minput" type="text" id="license_key" name="license_key" maxlength="50" value="{if $populate_lk}{$populate_lk}{/if}" />
						<br />

			  			<button type="submit" class="mbtn btn btn-default alizarinBtn">ACTIVATE</button>
			  		</form>

			  		{if $err_msg}
			  		<br />
			  		<span class="alizarin"><strong>{$err_msg}</strong></span>
			  		{/if}

			  		{if $populate_lk}
			  			<div class="mt20">
			  				<a href="{$BASE_URL_ADMIN}updates">REFRESH</a>
			  			</div>
			  		{/if}

			  	{/if}
		
			  	 
			  {/if}
			  	
		</div>

    </div>
</div><!-- #content -->

{if $license_added_popup == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('License has been activated');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}

