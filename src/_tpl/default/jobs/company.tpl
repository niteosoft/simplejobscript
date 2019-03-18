{include file="1.5/layout/sjs-header.tpl"}
		
<div class="jobs-v1 company-detail">
	<div class="container">
 
		<div class="row mb2-half-p">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

				<div class="row">

					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mlpl0" >
					</div>

					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 mlpl0" >

		 				<ul class="nav navbar-nav pull-left ttu">
							<li><a href="{$BASE_URL}{$URL_COMPANIES}">{$translations.dashboard_recruiter.back}</a></li>
						</ul>

						<ul class="nav navbar-nav pull-right ttu">
							<li><a target="_blank" href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}">{$translations.dashboard_recruiter.add_company}</a></li>
						</ul>
					</div>

				</div>

				<div class="row mlpl0">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 mlpl0" >
					</div>
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 mlpl0" >
						<img id="profile" class="img-responsive" src="{$BASE_URL}{$company.profile_picture}" />
					</div>

				</div>

				<div class="row mlpl0">
					<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs mlpl0" >
					</div>

					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 mlpl0" >
						<div class="rise">
							<img id="profileLogo" class="img-responsive" src="{$BASE_URL}{$company.logo_path}" />
						</div>
					</div>

				</div>

				<div class="row mlpl0">
					<div class="col-lg-6 col-md-6 col-sm-1 hidden-xs mlpl0" >
					</div>

					<div class="col-lg-6 col-md-6 col-sm-11 col-sm-10 mlpl0">

						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 mlpl0 comp-info-pad" >
							<a target="_blank" href="http://{$company.url}"><button type="button" class="btn more-ur fl comp-pages-btn">{$translations.dashboard_recruiter.company_pages_label}</button></a>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 hidden-xs comp-info-loc" >
							<li><i class="fa fa-map-marker" aria-hidden="true"></i>{$company.hq}</li>
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4 hidden-xs mlpl0 comp-info-pad" >
							<h1 class="comp-detail-headline">{$company.name}</h1><br />
						</div>
					</div>
				</div>

				<div class="row mlpl0 comp-hr">
					<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs mlpl0" >
					</div>

					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 mlpl0" >
						<hr />
					</div>

				</div>

				<div class="row mlpl0 job-details">
					<div class="col-lg-2 col-md-2 col-sm-1 hidden-xs mlpl0" >
					</div>

					<div class="col-lg-9 col-md-9 col-sm-10 col-xs-12 mlpl0" >
						<div class="detail-font company-detail-block" >
							{$company.description}
						</div>
					</div>
				</div>

			</div>
		</div> 

		<div class="row company-jobs">
	

			<div class="col-lg-1 col-md-1 hidden-sm col-xs-4 mlpl0" >
			</div>

			<div class="col-lg-10 col-md-10 col-sm-11 col-xs-12 comp-jobs-tablet-fix">

				<hr />

				<div class="row search-heading">
						<h2 class="tal-desk">{$translations.dashboard_recruiter.open_jobs}</h2>
				</div>

				<div id="job-listings">
				{if $jobs}
					{include file="jobs/company-posts-loop.tpl"}
				{else}
					<div class="centerMobile">
						{$translations.dashboard_recruiter.no_entries}
					</div>
				{/if}
				</div>		

	
			</div>

		</div>


	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}