{include file="1.5/layout/sjs-header.tpl"}

<div class="jobs-v1 companies-list">
	<div class="container">
		<div class="row search-heading">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h2 class="tal-desk">{$translations.companies.desc}</h2>
			</div>
		</div>

		<div class="row search-filter">
	
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

				{foreach item=c from=$companies}
				<div class="row search-result">

					<div class="col-lg-2 col-md-2 col-sm-3 colx-xs-12">
						<a href="{$BASE_URL}{$URL_JOBS_AT_COMPANY}/{$varnames[{$c.id}]}/{$c.id}" class="info">
							<img class="company-list-logo" src="/{$c.logo_path}" alt="Company logo" />
						</a>
					</div>
					<div class="col-lg-5 col-md-5 col-sm-12 colx-xs-12">
						<h3><a href="{$BASE_URL}{$URL_JOBS_AT_COMPANY}/{$varnames[{$c.id}]}/{$c.id}" class="info">{$c.name}</a></h3>
						<ul class="mb3p">
							<li><i class="fa fa-map-marker" aria-hidden="true"></i>{$c.hq}</li>
						</ul>
						<p class="company-desc">{$c.company_desc_excerpt}</p>

					</div>
					<div class="col-lg-5 col-md-5 hidden-sm-12 hidden-xs-12">
						<a href="{$BASE_URL}{$URL_JOBS_AT_COMPANY}/{$varnames[{$c.id}]}/{$c.id}" class="info"><button type="button" class="btn company-more-ur more-ur">{$translations.website_general.more}</button></a>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

						<div class="hidden-md hidden-lg hidden-sm col-xs-12">
							<a href="{$BASE_URL}{$URL_JOBS_AT_COMPANY}/{$varnames[{$c.id}]}/{$c.id}" class="info"><button type="button" class="btn company-more-ur">{$translations.website_general.more}</button></a>
							<hr />
						</div>

						<hr />
					</div>
				</div>
				{/foreach}

				<div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
					<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
					</div>
					<div class="ml19p col-lg-10 col-md-10 col-sm-6 col-xs-6">
						{include file="jobs/PAGINATOR.tpl"}
					</div>
				</div>

				<div class="col-lg-12 col-md-12 hidden-lg hidden-md">
						{include file="jobs/PAGINATOR.tpl"}
				</div>

			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}