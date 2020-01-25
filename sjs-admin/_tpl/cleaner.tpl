{include file="header.tpl"} 

<div class="admin-content">
  <div class="admin-wrap-content" >
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb25">
			<label class="admin-label">
				Database cleaner
			</label>
			<div class="subheading">Clean old entries to reduce project database size.</div>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<ul class="list-group cleaner">
			  <li class="list-group-item">Temporary jobs - <strong>{$tmp_count}</strong><div class="float-right"><a href="{$BASE_URL_ADMIN}cleaner/tmp"><button type="button" class="mbtn btn btn-default alizarinBtn">CLEAN</button></a></div></li>
			  	 <li class="list-group-item">Expired jobs - <strong>{$exp_count}</strong><div class="float-right"><a href="{$BASE_URL_ADMIN}cleaner/exp"><button type="button" class="mbtn btn btn-default alizarinBtn">{if $EXPIRED_JOBS_ACTION == 'deactivate'}DEACTIVATE{else}CLEAN{/if}</button></a></div></li>

			  	  <li class="list-group-item">Expired job stats - <strong>{$old_hits_count}</strong><div class="float-right"><a href="{$BASE_URL_ADMIN}cleaner/hits"><button type="button" class="mbtn btn btn-default alizarinBtn">CLEAN</button></a></div></li>

			</ul>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{if $popup}
				<div class="alert alert-info fade in main-color">
				    <a href="#" class="close" data-dismiss="alert">&times;</a>
				    <i class="fa fa-check" aria-hidden="true"></i>
				    Redundant entries have been successfully deleted / deactivated. Consider to schedule an automatic cron job for this task.
				</div>
			{/if}
		</div>
  </div>
</div>



{include file="footer.tpl"}