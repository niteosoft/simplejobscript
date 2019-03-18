{include file="header.tpl"}
		
<div class="admin-content">
	<div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">Subscribers</label>
	<div class="subheading">List of users receiving job alerts. There are 2 ways to send newsletter. 1) - export CSV and run newsletter via transaction email provider. 2) - setup a cronjob for "_tpl/cron_weekly_newsletter.php" file</div>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt15">
		<a href="{$BASE_URL_ADMIN}subscribers-csv/"><button type="submit" class="btn btn-default btn-primary mbtn" style="background-color: #E74C3C">Export to CSV</button></a>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			{if $subscribers}
			<ul class="applicants-list ">  
				{foreach item=subscriber from=$subscribers name=obj} 
				    <li class="p15"> 

				    <span>{$subscriber.email}</span>

			    	<div style="float:right;">

			    		{if $subscriber.confirmed == '1'}
	                	<span class="green mr10">confirmed</span>
	                	{else}
	                	<span class="red mr10">unconfirmed</span>
	                	{/if}

				    	<a href="{$BASE_URL_ADMIN}subscribers/delete/{$subscriber.id}/" title="Delete this subscriber" onclick="if(!confirm('Are you sure you want to delete this subscriber?'))return false;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>

				    </div>


					</li>
				{/foreach}
			</ul>
			{else}
				<ul class="applicants-list ">  
					<li class="p15"> 
					No subscribers for the moment
					</li>
				</ul>
			{/if}
			
			{if $pages}
			<div id="pagination-id" class="row pagination-cl" >
				<div class="col-md-12">
						{$pages}
				</div>
			</div>
			<br />
			{/if}

    </div>
</div>
</div>

{include file="footer.tpl"}