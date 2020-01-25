{include file="1.5/layout/sjs-header.tpl"}

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<h2>404</h2>
				<i class="fa fa-safari" aria-hidden="true"></i>
				<h3>{$translations.website_general.404_msg}</h3>
				<p class="404reason">
				{$translations.website_general.404_txt_part_1}<br>
				{$translations.website_general.404_txt_part_2}<br>
				{$translations.website_general.404_txt_part_3}<br>
				{$translations.website_general.404_txt_part_4} <a href="{$BASE_URL}">{$translations.website_general.404_txt_part_5}</a> {$translations.website_general.404_txt_part_6}
				</p>
			</div>
		</div>
	</div>
</div>

{include file="1.5/layout/sjs-footer.tpl"}