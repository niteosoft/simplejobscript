<div class="row">
    <div class="col-md-12 col-sm-12 mb20">
        <p class="profile-subheadline">
            {$translations.profile.apps_desc}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
    {section name=application loop=$apps}
        <div class="profile-listing">
            

                <div class="col-md-8 col-sm-8 tal">

                    <div class="row">
                        <a href="{$BASE_URL}{$URL_JOB}/{$apps[application].url_title}/{$apps[application].job_id}" target="_blank">
                        {$apps[application].job_title} @ {$apps[application].job_company}
                        </a>
                    </div>
                    <br />

                     <div class="row">
                        <i class="fa fa-calendar list-fa fa-lg" aria-hidden="true"></i>
                        {$apps[application].created_on}
                     </div>
              
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="listing-type">
                        {if $apps[application].status == '0'}
                            <span class="profile-pending hideMobile">{$translations.profile.pending_label}</span>
                        {else if $apps[application].status == '1'}
                            <span class="profile-rejected hideMobile">{$translations.profile.rejected_label}</span>
                        {else if $apps[application].status == '3'}
                            <span class="profile-reviewed hideMobile">{$translations.profile.hired_label}</span>
                        {else}
                            <span class="profile-reviewed hideMobile">{$translations.profile.review_label}</span>
                        {/if}
                    </div>  
                </div>

        </div>
    {/section}
    </div>
</div>