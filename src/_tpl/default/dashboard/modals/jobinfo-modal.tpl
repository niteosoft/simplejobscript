
{section name=index loop=$dash_jobs}
 	<div id="modal_{$dash_jobs[index].id}" class="modal fade" role="dialog">
 		<div class="modal-dialog">
 			<div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Job details</h4>
		      </div>
	      	  <div class="modal-body">
		      	<div class="modal-label mb5">{$translations.dashboard_recruiter.jobs_expires}:</div>
		      		{$dash_jobs[index].expires_date}
		      </div>
		      <div class="modal-body">
		      	<div class="modal-label mb5">{$translations.dashboard_recruiter.jobs_ad_type}:</div>
		      		{if $job.spotlight == '1'} 
		      			{$translations.dashboard_recruiter.jobs_premium}
      				{else}
      					{$translations.dashboard_recruiter.jobs_standard}
      				{/if}
		      </div>
		      <div class="modal-body">
		      	<div class="modal-label mb5">{$translations.dashboard_recruiter.jobs_type}:</div>
		      		{$dash_jobs[index].type_name}
		      </div>
		      <div class="modal-body">
		      	<div class="modal-label mb5">{$translations.dashboard_recruiter.jobs_category}:</div>
		      		{$dash_jobs[index].category_name}
		      </div>
		      <div class="modal-body">
		      	<div class="modal-label mb5">{$translations.dashboard_recruiter.post_location_label}</div>
		      		{$dash_jobs[index].location}
		      </div>
		      <div class="modal-footer">
		       <button type="button" class="btn btn-green" data-dismiss="modal">{$translations.js.close}</button>
		      </div>
		    </div>
 		</div>
 	</div>
 {/section}