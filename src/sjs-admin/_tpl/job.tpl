{include file="header.tpl"}
		
		<div class="admin-content">
		  <div class="admin-wrap-content">
			<strong><a href="{$back_link}" title="home"><button class="btn btn-default back-button">back</button></a></strong><br />
		
			<div id="job-content">
				{include file="job-details.tpl"}
			
				<div id="job-bottom">
					<div id="number-views">
						<span class="blue-font">Published on: &nbsp;</span><span class="moderate-black">{$job.post_date}</span><br />
						<span class="blue-font">Viewed: &nbsp;</span><span class="moderate-black">{$job.views_count} times </span> 
					</div>
					<div class="clear"></div>
				</div>
			</div>

			<div id="job-applicants">
				<h4 class="dark-font" style="margin-bottom: 0px">{$applicants|@count} applicant(s){if $applicants|@count > 0}, latest on top{/if}</h4>

				<ul class="applicants-list">  
					{foreach item=applicant from=$applicants name=cvs} 
					    <li style="overflow: hidden;"> 
					    	<div style="float: left;">
					    		<span class="applicant-name">{$applicant.name}</span><br /><a href="mailto:{$applicant.email}">{$applicant.email}</a>
						        <div style="font-size: 11px;">
						            applied 
									 on <strong>{$apply_dates[$applicant.id]}</strong>
						        </div>
					    	</div>
					    	{if $applicant.cv_path != ''}
					    	<div style="float: right;">
					    		 <div title="Download cv"><br /><a target="_blank" href="{$BASE_URL}{$applicant.cv_path}"><i class="{$cvs[$applicant.id]}" aria-hidden="true"></i></a></div>
					    	</div>
					    	 {/if}
					    </li>
					{/foreach}
				</ul>
			</div>
		</div><!-- /content -->
		</div>

{include file="footer.tpl"}