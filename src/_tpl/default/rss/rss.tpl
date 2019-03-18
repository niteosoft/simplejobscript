{include file="1.5/layout/sjs-header.tpl"}

<div class="static-page">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<h1>{$translations.rss.title}</h1>
				<h2 class="rss-h2">{$translations.rss.intro}</h2>
				<br /><br />

				<ul class="rss-ul">
					<li><a href="{$BASE_URL}rss/all/">{$translations.rss.all_categories}</a></li>
					{section name=tmp loop=$categories}
					<li><a href="{$BASE_URL}rss/{$categories[tmp].var_name}/">{$categories[tmp].name}</a></li>
					{/section}
				</ul>

			</div>
		</div>
	</div>
</div>			

{include file="1.5/layout/sjs-footer.tpl"}