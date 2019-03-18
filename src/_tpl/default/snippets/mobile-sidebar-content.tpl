<div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">

               <!-- JOB TYPES -->
                <li class="sidebar-brand">
                  <a>{$translations.searchbar.job_types}</a>
                </li>
                {if ! isset($hide_filter)}
                {section name=tmp loop=$types}
                          {if $type_name == $types[tmp].var_name}
                          <li id="{$types[tmp].var_name}" class="{if $type_name == $types[tmp].var_name}sidemenu_selected{/if}">
                            <a href="{$BASE_URL}{$URL_JOBS}/{$types[tmp].var_name}/">{$types[tmp].name} <span class="bracket bracket-active">({$types[tmp].job_count})</span></a>
                          </li>
                          {else}
                          <li id="{$types[tmp].var_name}" class="{if $type_name == $types[tmp].var_name}sidemenu_selected{/if}">
                            <a href="{$BASE_URL}{$URL_JOBS}/{$types[tmp].var_name}/">{$types[tmp].name} <span class="bracket">({$types[tmp].job_count})</span></a>
                          </li>
                          {/if}
                {/section}
                {/if}
                <!-- ######### -->

                {if $dropdown_cats}
                  <!-- JOB CATS -->
                  <li class="sidebar-brand">
                    <a>{$translations.alljobs.jobs_categories}</a>
                  </li>

                  {foreach from=$dropdown_cats key=name item=obj}
                  {if $current_category_name == $name}
                    <li class="sidemenu_selected"><a href="/{$URL_JOBS}/{$obj->url}">{$name} <span class="bracket bracket-active">({$obj->jobs})</span> </a></li>
                  {else}
                     <li><a href="/{$URL_JOBS}/{$obj->url}">{$name} <span class="bracket">({$obj->jobs})</span> </a></li>
                  {/if}
                  {/foreach}
                {/if}

                {if $REMOTE_PORTAL == 'deactivated'}
                  {if $dropdown_countries}
                  <!-- CITIES -->
                  <li class="sidebar-brand">
                    <a>{$translations.alljobs.cities}</a>
                  </li>
                  {foreach from=$dropdown_countries key=name item=obj}
                  {if $current_city == $name}
                    <li class="sidemenu_selected"><a href="/{$URL_JOBS_IN_CITY}/{$obj->url}">{$name} <span class="bracket bracket-active">({$obj->jobs_count})</span> </a></li>
                  {else}
                    <li><a href="/{$URL_JOBS_IN_CITY}/{$obj->url}">{$name} <span class="bracket">({$obj->jobs_count})</span> </a></li>
                  {/if}
                  {/foreach}
                   {/if}
                {/if}

            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
</div>