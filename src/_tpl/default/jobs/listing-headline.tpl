
<div class="listing-headline" >
{if $favourites_jobs}
		<div id="jobtypee" class="search_typee filterHeadline">
            {if $current_jobtype}{$current_jobtype} {else if $current_category_name} {$current_category_name} {else if $city_name} {$city_name} {else} {$translations.alljobs.favourites_label}{/if}                 
    </div>
    <div class="clearallfilters"> 
    	<span> {$translations.website_general.clear}</span>
    </div>
	{else}
	      {if $landing_searched}
		    {if $landing_searched_msg}
		  		<div id="jobtypee" class="search_typee filterHeadline">
            	{if $jobs or $INDEED == 'deactivated'}{$landing_searched_msg}{/if} {if $current_jobtype}/ {$current_jobtype}{else if $current_category_name} # {$current_category_name} {else if $city_name} # {$city_name}{/if}                 
            </div>
            <div class="clearallfilters">
            	<span> {$translations.website_general.clear}</span>
           	</div>
		  	{else}
		  		{$translations.alljobs.all_jobs} {if $current_jobtype} # {$current_jobtype}{}{/if}
		  	{/if}
		  {else}
			<div id="jobtypee" class="search_typee filterHeadline">
            	{if $jobs or $INDEED == 'deactivated'}{if not $current_jobtype}{$current_jobtype_search}{/if}{/if} {if $current_jobtype} # {$current_jobtype}{else if $current_category_name} # {$current_category_name}{else if $city_name} # {$city_name}{/if}                 
            </div>
            <div class="clearallfilters">
            	<span> {$translations.website_general.clear}</span>
           	</div>
		  {/if}
	{/if}
</div>