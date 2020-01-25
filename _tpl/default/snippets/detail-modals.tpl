<!-- REPORT -->
<div id="reportModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title modal-strong">{$translations.detail_sidebar.modal_report}</h3>
      </div>

      <div class="modal-body modal-body-fix">
              <form role="form">
                       <label for="reportarea">{$translations.detail_sidebar.modal_report_desc}</label>
                       <br /><br />
                       <input type="hidden" name="jobid" id="jobid" value="{$job_id}">
                       <textarea class="mb10" maxlength="999" rows="5" id="reportarea" name="reportarea"></textarea>
               </form>
               <div id="report-empty" class="red pt3p displayNone">{$translations.detail_sidebar.modal_feedback_empty}</div>
               <div id="report-positive" class="green pt3p displayNone">{$translations.detail_sidebar.modal_feedback_pos}</div>
               <div id="report-negative" class="red pt3p displayNone">{$translations.detail_sidebar.modal_feedback_neg}</div>
      </div>

      <div class="modal-footer preview-footer">
        <div class="modal-ajax-popups">
          <i id="fspinner" class="displayNone fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner"></i>
         </div>

        <button type="button" class="btn btn-modal-a bh50" onclick="SimpleJobScript.ReportSpam();" data-dismiss="modal">{$translations.detail_sidebar.modal_submit}</button>

        <button type="button" class="btn btn-modal-c bh50" data-dismiss="modal">{$translations.job_detail_section.close}</button>
      </div>
    </div>

  </div>
</div>

<div id="emailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title modal-strong">{$translations.detail_sidebar.modal_emailshare}</h3>
      </div>

      <div class="modal-body modal-body-fix">
              <form role="form">
                      
                  <input class="mb25" placeholder="{$translations.detail_sidebar.modal_email_from}" required type="email" name="emailfrom" id="emailfrom" >

                  <input class="mb25" placeholder="{$translations.detail_sidebar.modal_email_to}" required type="email" name="emailto" id="emailto" >

                  <textarea class="mb25" maxlength="999" rows="5" id="emailtext" name="emailtext">{$translations.detail_sidebar.modal_email_text}{"\n\n"}{$job_url}</textarea>


           <div id="email-empty" class="red displayNone">{$translations.detail_sidebar.modal_feedback_email_empty}</div>
           <div id="email-positive" class="green displayNone">{$translations.detail_sidebar.modal_feedback_email_pos}</div>
           <div id="email-negative" class="red displayNone">{$translations.detail_sidebar.modal_feedback_email_neg}</div>

               </form>
      </div>

      <div class="modal-footer preview-footer">
        <div class="modal-ajax-popups">
         <i id="tellfriendspinner" class="displayNone fa fa-refresh fa-spin fa-lg fa-fw refresh-spinner"></i>
         </div>

        <button type="button" class="btn btn-modal-a bh50" onclick="SimpleJobScript.TellAFriend();" data-dismiss="modal">{$translations.detail_sidebar.modal_submit}</button>

        <button type="button" class="btn btn-modal-c bh50" data-dismiss="modal">{$translations.job_detail_section.close}</button>
      </div>
    </div>

  </div>
</div>