{include file="header.tpl"}
		
		<div class="admin-content" >
		 <div class="admin-wrap-content">
			<div id="job-listings">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<label class="admin-label">
						{$translations.category.jobs_for} {$current_category_name} {if $current_type}/ {$current_type}{/if}
					</label>
					<div class="subheading">Star activates premium/spotlight position. Green circle activates/deactivates the job</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mb15">
					<div id="sort-by-type">
					{$translations.category.display_only}&nbsp; 
					<a href="{$BASE_URL_ADMIN}{$URL_JOBS}/{$current_category}" title="All" >
					  <div class="box">
						Reset
					  </div>
					</a>
						{section name=tmp loop=$types}
						<a class="{if $current_type == $types[tmp].var_name}active{/if}" href="{$BASE_URL_ADMIN}{$URL_JOBS}/{$current_category}/{$types[tmp].var_name}/" title="{$current_category} {$types[tmp].name}" >
						  <div class="box">
							{$types[tmp].name}
						  </div>
						  </a>
						{/section}	
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 by_name" >
								<div class="col-md-10 col-sm-12 col-xs-12 inputsearch">
									<input placeholder="Job title" value="" class="form-control" type="text" id="search" />
								</div>
								<div class="col-md-2 col-sm-12 col-xs-12 mb15" >
									<input type="hidden" value="{$BASE_URL_ADMIN}{$URL_JOBS}/{$current_category}" name="url_search" id="url_search">
									<button id="search_by_name" class="btn btn-default btn-primary">SEARCH</button>							
									
								</div>
							</div>	
						</div>

					</div>
				</div>
				
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="container-fluid">
						{include file="posts-loop.tpl"}
					</div>
				</div>

			</div>
		</div>
		</div>
<script type="text/javascript">
$("#search_by_name").click(function(){
	var string = $("#search").val();
	var inputvalue = $("#url_search").val();
	window.location.replace(inputvalue+'?string='+string);

})	

</script>
{if $JOB_EDITED == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Job has been edited');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}