{include file="1.5/layout/sjs-dashboard-header.tpl"}

<div class="candidate-v2 mobileMT10">
  <div class="row">

      <div class="col-md-2 col-sm-12">
        <ul>

            <a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_OVERVIEW}"><li id="dashboard-li"><i class="fa fa-tachometer" aria-hidden="true"></i> 
              {$translations.dashboard_recruiter.left_menu_dashboard}</li></a>

            <a target="_blank" href="/{$URL_JOBS}"><li><i class="fa fa-laptop" aria-hidden="true"></i>
                    {$translations.dashboard_recruiter.gotoweb}</li></a>

            <a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_SETTINGS}"><li id="settings-li"><i class="fa fa-cogs" aria-hidden="true"></i>
                {$translations.dashboard_recruiter.left_menu_settings}</li></a>

            <a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_EDIT_COMPANY}"><li id="company-li"><i class="fa fa-building" aria-hidden="true"></i>
                  {$translations.dashboard_recruiter.left_menu_company_details}</li></a>

            {if $PROFILES_PLUGIN == 'true'}
            <a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_CVDATABASE}"><li id="cvdb-li"><i class="fa fa-file-text" aria-hidden="true"></i>
                    {$translations.dashboard_recruiter.top_menu_browse_applicants}</li></a>
            {/if}

            {if $PAYMENT_MODE == '3'}
              <a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_ACCOUNT}"><li id="account-li"><i class="fa fa-cubes" aria-hidden="true"></i>
                {$translations.dashboard_recruiter.left_menu_myaccount}</li></a>
            {/if}

         </ul>

          {if $smarty.const.BANNER_MANAGER == 'true'}
            {include file="$banners_backoffice_rectangle"}
          {/if}

          {if $smarty.const.ADSENSE == 'true'}
            {include file="$adsense_backoffice_rectangle"}
          {/if}

        </div>

        <div class="col-md-10 col-sm-12">
         <div class="employer-dashboard">
          <div class="container">

            {include file="dashboard/views/$view"}
           
           </div>
          </div>
        </div>
  </div>

</div>

{if $init_modal_popups == '1'}
<div class="dash-modal">
  {include file="dashboard/modals/applicant-modal.tpl"}
</div>
{/if}

{if $init_modal_popup_preview == '1'}
<div class="dash-modal">
  {include file="dashboard/modals/preview-modal.tpl"}
</div>
{/if}

{if $init_modal_popup_jobs == '1'}
<div class="dash-modal">
  {include file="dashboard/modals/jobinfo-modal.tpl"}
</div>
{/if}

{if $applications_modal_init == '1'}
<div class="dash-modal">
  {include file="dashboard/modals/applications-modal.tpl"}
</div>
{/if}

{if $HIRED_APPS =='true'}
<div class="dash-modal">
  {include file="dashboard/modals/hired-modal.tpl"}
</div>
{/if}

{include file="1.5/layout/sjs-footer.tpl"}

