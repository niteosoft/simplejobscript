{if $INDEED == 'deactivated' OR $INDEED_BOTH_JOBS_FLAG}
<div id="listing">
  <div class="container">
  <h2>{$translations.website_general.listings}</h2>
  <div class="homepage-by">{$translations.website_general.by}</div><br /><br />

    <div class="row">
      <div class="col-md-4 col-xs-6 c-box">
        <h4>{$translations.searchbar.job_types}</h4>
        <ul>
          {section name=tmp loop=$types}
              <li><a href="{$BASE_URL}{$URL_JOBS}/{$types[tmp].var_name}/" target="_blank">{$types[tmp].name} <span class="bracket">({$types[tmp].job_count})</span></a></li>
           {/section}
        </ul>
      </div>

      {if $dropdown_cats}
      <div class="col-md-4 col-xs-6 c-box">
      <h4>{$translations.alljobs.jobs_categories}</h4>
        <ul>
           {foreach from=$dropdown_cats key=name item=obj}
            <li><a href="/{$URL_JOBS}/{$obj->url}" target="_blank">{$name} <span class="bracket">({$obj->jobs})</span> </a></li>
           {/foreach}
        </ul>
      </div>
      {/if}

      {if $REMOTE_PORTAL == 'deactivated'}
        {if $dropdown_countries}
        <div class="col-md-4 col-xs-6 c-box">
        <h4>{$translations.alljobs.cities}</h4>
          <ul>
               {foreach from=$dropdown_countries key=name item=obj}
                <li><a href="/{$URL_JOBS_IN_CITY}/{$obj->url}" target="_blank">{$name} <span class="bracket">({$obj->jobs_count})</span> </a></li>
              {/foreach}
          </ul>
        </div>
        {/if}
      {/if}

    </div>
  </div>
</div>
{/if}