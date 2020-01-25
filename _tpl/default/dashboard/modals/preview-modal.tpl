
 <div id="previewModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{$job_data.title}</h4>
      </div>

	    <div class="modal-body job-details">

                <ul class="preview-ul">
                  <li><span><i class="fa fa-building" aria-hidden="true"></i></span> {$job_data.company}</li>
                  <li><span><i class="fa fa-braille" aria-hidden="true"></i></span> {$job_data.job_type}</li>
                  {if $REMOTE_PORTAL == 'deactivated'}
                  <li><span><i class="fa fa-map-marker" aria-hidden="true"></i></span> {$job_data.location_asci}</li>
                  <li><span><i class="fa fa-calendar" aria-hidden="true"></i></span> {$job_data.created_on}</li>
                  {/if}
                </ul>

              <div class="clear-both"></div>

              <div class="detail-font" >
                <p>{$job_data.description}</p>
              </div>

            {if not $job_data.apply_online == 1}
              <p class="hta-p">{$job_data.apply_desc}</p>
              <br />
            {/if}

      </div>

      <div class="modal-footer preview-footer">
        {if $job_data.salary}<p class="price-apply">{$job_data.salary}</p>{/if}
        <button type="button" class="btn btn-green" data-dismiss="modal">{$translations.js.close}</button>
      </div>
    </div>

  </div>
</div>