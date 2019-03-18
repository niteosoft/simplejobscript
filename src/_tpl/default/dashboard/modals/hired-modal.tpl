
{if $HIRED_APPS_DATA}
  {section name=index loop=$HIRED_APPS_DATA}
    <div id="hired_modal_{$HIRED_APPS_DATA[index].id}" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title mb10">{$translations.js.candidate_profile}</h4>
          </div>

          {if $HIRED_APPS_DATA[index].date_formated and $HIRED_APPS_DATA[index].date_formated != '-'}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.applied_label}</div>
            {$HIRED_APPS_DATA[index].date_formated}
          </div>
          {/if}

          {if $HIRED_APPS_DATA[index].email and $HIRED_APPS_DATA[index].email != '-'}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.email_label}</div>
            {$HIRED_APPS_DATA[index].email}
          </div>
          {/if}

          {if $HIRED_APPS_DATA[index].phone and $HIRED_APPS_DATA[index].phone != '-'}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.phone_label}</div>
            {$HIRED_APPS_DATA[index].phone}
          </div>
          {/if}

          {if $HIRED_APPS_DATA[index].website and $HIRED_APPS_DATA[index].website != '-'}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.website_label}</div>
             <a href="http://{$HIRED_APPS_DATA[index].website}" target="_blank">{$HIRED_APPS_DATA[index].link_to_show}</a>
          </div>
          {/if}

          {if $HIRED_APPS_DATA[index].sm_links}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.social_media_label}</div>
             {foreach $HIRED_APPS_DATA[index].sm_links as $SM_OBJ}
                 <a class="mr12" href="{if $SM_OBJ->whatsapp == 'true'}tel:{$SM_OBJ->whatsapp_numb}{else}{$SM_OBJ->linkToShow}{/if}" target="_blank"><i class="fa fa-{$SM_OBJ->icon} fa-lg mt10" aria-hidden="true"></i></a>
             {/foreach}
          </div>
          {/if}

          {if $HIRED_APPS_DATA[index].application_message and $HIRED_APPS_DATA[index].application_message != '-'}
          <div class="modal-body">
            <div class="modal-label mb10">{$translations.js.application_message}</div>
            {$HIRED_APPS_DATA[index].message}
          </div>
          {/if}

          <div class="modal-footer">
            <button type="button" class="btn btn-green" data-dismiss="modal">
                {$translations.js.close}
            </button>
          </div>

        </div>
      </div>
    </div>

  {/section}
{/if}