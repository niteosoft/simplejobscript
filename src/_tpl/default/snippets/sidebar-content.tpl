<div class="row search-filter">
	<div class="col-md-3 col-md-3 col-sm-12 col-xs-12">
		
		<!-- JOB TYPES -->
		{if !isset($hide_filter) and $types}
		<div class="search-content">
			<h5 class="job-heading">{$translations.searchbar.job_types}</h5>
			<div class="filter-menu {if count($types) > 8} scrollbar {/if}">
				<div class="filter-title">
					<h2>{$translations.searchbar.select}</h2>
					<i class="fa fa-angle-down" aria-hidden="true"></i>
				</div>
				<div class="filter-slide displayNone" >
 
					{section name=tmp loop=$types}

						{if $type_name == $types[tmp].var_name}
							<label><input type="checkbox" id="check_{$types[tmp].var_name}" name="act" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$types[tmp].var_name}_ctype' data='{$types[tmp].name}' data-id='{$types[tmp].var_name}'>{$types[tmp].name}</p>" class="checkbox-green filtervariable" value="{$types[tmp].var_name}_ctype" /><h6>{$types[tmp].name} <span class="bracket bracket-active">({$types[tmp].job_count})</span></h6></label><br />
						{else}
							<label><input type="checkbox" id="check_{$types[tmp].var_name}" name="act" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$types[tmp].var_name}_ctype' data='{$types[tmp].name}' data-id='{$types[tmp].var_name}'>{$types[tmp].name}</p>" class="checkbox-green filtervariable" value="{$types[tmp].var_name}_ctype" /> <h6>{$types[tmp].name} <span class="bracket">({$types[tmp].job_count})</span></h6></label><br />
						{/if}

					{/section}

				</div>
			</div>
			<br />
		</div>
		{/if}

		<!-- CATEGORIES -->
		<div class="search-content">
			<h5 class="job-heading">{$translations.alljobs.jobs_categories}</h5>
			<div class="filter-menu {if count($types) > 8} scrollbar {/if}">
				<div class="filter-title">
					<h2>{$translations.searchbar.select}</h2>
					<i class="fa fa-angle-down" aria-hidden="true"></i>
				</div>
				<div class="filter-slide displayNone" >
				
				{foreach from=$dropdown_cats key=name item=obj}
			
					{if $current_category_name == $name}
						<label><input type="checkbox" id="check_{$obj->url}" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$obj->url}_catgry' data='{$name}' data-id='{$obj->url}'>{$name}</p>" class="checkbox-green filtervariable actcat" value="{$obj->url}_catgry" /><h6>{$name} <span class="bracket bracket-active">({$obj->jobs})</span></h6></label><br />
					{else}
						<label><input type="checkbox" id="check_{$obj->url}" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$obj->url}_catgry' data='{$name}' data-id='{$obj->url}'>{$name}</p>" class="checkbox-green filtervariable" value="{$obj->url}_catgry" /><h6>{$name} <span class="bracket">({$obj->jobs})</span></h6></label><br />
					{/if}
 
			  	{/foreach}

				</div>
			</div>
			<br />
		</div>

		<!-- LOCATION -->
		<div class="search-content">
			<h5 class="job-heading">{$translations.alljobs.cities}</h5>
			<div class="filter-menu {if count($types) > 8} scrollbar {/if}">
				<div class="filter-title">
					<h2>{$translations.searchbar.select}</h2>
					<i class="fa fa-angle-down" aria-hidden="true"></i>
				</div>
				<div class="filter-slide displayNone" >
				
				{foreach from=$dropdown_countries key=name item=obj}
			
					{if $current_city == $name}
						<label><input type="checkbox" id="check_{$obj->url}" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$obj->url}_loctn' data='{$name}' data-id='{$obj->url}'>{$name}</p>" class="checkbox-green filtervariable actloc" value="{$obj->url}_loctn" /><h6>{$name} <span class="bracket bracket-active">({$obj->jobs_count})</span></h6></label><br />
					{else}
						<label><input type="checkbox" id="check_{$obj->url}" data-url="/{$URL_JOBS}/" data="<p class='type_searchrd' id='{$obj->url}_loctn' data='{$name}' data-id='{$obj->url}'>{$name}</p>" class="checkbox-green filtervariable" value="{$obj->url}_loctn" /><h6>{$name} <span class="bracket">({$obj->jobs_count})</span></h6></label><br />
					{/if}
 
			  	{/foreach}

				</div>
			</div>
			<br />
		</div>

		<!-- JOB ALERT SUBSCRIPTION -->
		<div class="search-content search-content-custom">
			<h5 class="job-heading">{$subscribe_msg}</h5>

			<input type="hidden" id="subscategory" name="subscategory" value="{$current_category_id}" />
			<input required name="subscribe_email" id="subscribe_email" placeholder="{$translations.detail_sidebar.control_email}" maxlength="100" type="email"  class="form-control subscribe-desktop">

			<button type="submit" class="btn btn-subsc" name="subscribe-btn" id="subscribe-btn" onclick="return SimpleJobScript.Subscribe();">{$translations.subscriptions.subscribe_submit}</button>

			 <div class="search-content search-content-custom">
				 <div class="loading">
				 	<img id="fspinner_subscribe" class="reload-spinner displayNone" src="{$BASE_URL}_tpl/{$THEME}/img/reload.gif" alt="ajax loader">

				 		<div id="subscribe-pos" class="jobalert-pos displayNone">{$translations.subscriptions.positive_feedback}</div>
						<div id="subscribe-neg" class="jobalert-neg displayNone">{$translations.subscriptions.negative_feedback}</div>
						<div id="subscribe-wrongemail" class="jobalert-neg displayNone">{$translations.subscriptions.wrongemail_feedback}</div>
						<div class="clear"></div>
				 </div>
			</div>

		</div>

		<!-- BANNERS AND ADSENSE -->
		<div class="search-content search-content-custom">
			{if $smarty.const.BANNER_MANAGER == 'true'}
				{include file="$banners_side_rectangle"}
			{/if}

			{if $smarty.const.ADSENSE == 'true'}
				{include file="$adsense_side_rectangle"}
			{/if}
		</div>

	</div>