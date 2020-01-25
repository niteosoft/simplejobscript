 
{if not $lock_post}
<div class="row board">
  <h2>{$translations.dashboard_recruiter.post_job_headline}</h2>
    {if $step == 1} 
        <p>{$translations.post_step1.infodesc_step1}{if $PAYMENT_MODE == '3'}</p><br /><div class="red">{$msg}</div>{/if}
    {elseif $step == 2}
        <p>{$translations.post_step2.infodesc_step2}</p>
    {elseif $step == 3}
        <p>{$translations.dashboard_recruiter.infodesc_step3}</p>
    {/if}
</div>

<div class="main-content job-process steps-wizard-mov">
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button" class="btn {if $step == 1}btn-primary{else}btn-default{/if} btn-tab btn-circle" disabled="disabled">1</a>
                    <p>{$translations.dashboard_recruiter.step_1}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button" class="btn {if $step == 2}btn-primary{else}btn-default{/if} btn-tab btn-circle" disabled="disabled">2</a>
                    <p>{$translations.dashboard_recruiter.step_2}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button" class="btn {if $step == 3}btn-primary{else}btn-default{/if} btn-tab btn-circle" disabled="disabled">3</a>
                    <p>{$translations.dashboard_recruiter.step_3}</p>
                </div>
            </div>
        </div>
</div>

{/if}

{if $step == 1 || $step == 2}
<div class="main-content job-process">
        {if $step == 1} 
            {include file="dashboard/views/post-first-step.tpl"}
        {elseif $step == 2}
            {include file="dashboard/views/post-second-step.tpl"}
        {/if}
</div>
{/if}


{if $step == 3} 
    <div class="col-md-12 col-xs-12" >
        <div class="row board mt0">
          <h2>{$translations.dashboard_recruiter.job_published_msg}</h2>
          <br /><br />
        </div>
    </div>

    <div class="col-md-6 col-xs-12 mlpl0">
        <div class="action-req success-msg dash-succ-box">

                <div class="row caution succ-box">
                    <div class="col-md-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-1 col-xs-12 mtm8">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                            <div class="col-md-11 col-xs-12">
                                <p class="pl10p"><span>{if $PAYMENT_MODE == '2'}{$paypal_result_message}{/if} {$published_msg} {if $PAYMENT_MODE == '2' and $paypal_result_message}{$new_invoice_msg} {/if}<span></p>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
{/if}