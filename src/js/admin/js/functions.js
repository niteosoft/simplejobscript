(function() 
{
	Jobber = {
		
		jobber_admin_url: "",
		jobber_base_url: "",
		sm_profiles: [],
		
		pagesExternalSwitched: function(val) {
			if (val == false) {
				$('#url-block').removeClass('displayNone');
 				$('#keywords-block').removeClass('displayNone');
 				$('#desc-block').removeClass('displayNone');
 				$('#content-block').removeClass('displayNone');
 				$('#external-page-block').addClass('displayNone');
 			} else {
 				$('#url-block').addClass('displayNone');
 				$('#keywords-block').addClass('displayNone');
 				$('#desc-block').addClass('displayNone');
 				$('#content-block').addClass('displayNone');
 				$('#external-page-block').removeClass('displayNone');
 			}
		},

		validatePasswords: function() {
			if ($('#register_pass1').val().length < 6
    			|| $('#register_pass2').val().length < 6
    			|| $('#register_pass1').val() != $('#register_pass2').val()) {

				$('#err-reg-pass2').removeClass('displayNone');
				return false;

    		} else {
    			$('#err-reg-pass2').addClass('displayNone');
    		}
		},

		addExternalLink: function() {
			
			var links = parseInt($('#external_links').val());

			if (links < 4) {

				var newVal = links + 1;
				$('#external_links').val(newVal);

				// FORM GROUP
				var html = '<div id="sm_fg_' + newVal + '" class="form-group mb30">';


				html += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl0 ml0 mb20">';

				// INPUT
				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml0">';
				html += '<input placeholder="' + 'http://SM.com/user_id' + '" id="sm_url_' + newVal + '" name="sm_url_' + newVal + '" type="text"  class="form-control minput" />';
				html += '</div>';

				// SELECT
				var options = '';

				for (var i = 0; i <= Jobber.sm_profiles.length - 1; i++) {
					options += '<option value="' + Jobber.sm_profiles[i].id + '">' + Jobber.sm_profiles[i].name + '</option>';
				};

				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml0">';
				html += '<select id="sm_select_' + newVal + '" name="sm_select_' + newVal + '" class="form-control minput">' + options + '</select>';
				html +=  '</div>';

				// CLOSE
				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml0">';
				html += '<a id="sm_close_' + newVal + '" href="#" onclick="return Jobber.removeSMentry(' + newVal + ');"><i class="fa fa-close mt12" aria-hidden="true"></i></a></div>';
				html += '</div>';

				html += '</div>';


				// FORM GROUP close
				html += '</div>';

				$('#addLinkBlock').append(html);


				// disable previous close icons

				if (links > 0) {
					if ($('#sm_close_' + links).length) {
						$('#sm_close_' + links).addClass('displayNone');
					}		
				}


			} 

			if (links == 3) {
				$('#addLink').html('').html('Limit reached');
			}
		
			return false;
		},

		removeSMentry: function(entry_id) {

			if (entry_id > 1) {
				var lastClose = entry_id - 1;
				$('#sm_close_' + lastClose).removeClass('displayNone');	
			}

			$('#sm_fg_' + entry_id).fadeOut(200, "linear", function(){
				$(this).remove();
			});

			var links_count = parseInt($('#external_links').val());

			if (links_count > 0)
				links_count = links_count - 1;
			else
				links_count = 0;

			$('#external_links').val(links_count);

			if (links_count < 4) {
				$('#addLink').html('').html('Add social media [ + ]');
			}

			return false;

		},

		createProfileValidationAdmin: function (cv_size) {

			if ($('#pass1').val().length < 6
    			|| $('#pass2').val().length < 6
    			|| $('#pass1').val() != $('#pass2').val()) {

				$('#feedback-err').removeClass('displayNone');
				return false;

    		} else {
    			$('#feedback-err').addClass('displayNone');
    		}

			setTimeout(function(){

				var file = $('#cv').val();
				
				if (file != '' && file != null) {
					var fileSize = $('#cv')[0].files[0].size;
					//check type and size
					var extension = file.split('.').pop().toLowerCase();
					if($.inArray(extension, ['doc','docx','pdf']) == -1 || fileSize > cv_size) {
		   				 $('#err').removeClass('displayNone');
		   				 return false;
					} else {
						$('#err').addClass('displayNone');
					}
				}

				return true;
			}, 500);

		},

		HandleLocationOutsideRo: function()
		{
			if (document.getElementById("location_outside_ro").style.display == "none")
			{
				document.getElementById("city_id").setAttribute("disabled", "disabled");
				$("div#location_outside_ro").show();
				document.getElementById("location_outside_ro_where").focus();
				$("a#other_location_label").html(Jobber.I18n.js.location_pick_from_list);
			}
			else
			{
				document.getElementById("city_id").removeAttribute("disabled");
				$("div#location_outside_ro").hide();
				$("a#other_location_label").html(Jobber.I18n.js.location_other);
			}
		},
		DeactivateLink: function(job_id)
		{
			var url = Jobber.jobber_admin_url+'deactivate/';
			Jobber.Deactivate(url, job_id);
		},
		ActivateLink: function(job_id)
		{
			var url = Jobber.jobber_admin_url+'activate/';
			Jobber.Activate(url, job_id, 0);
		},
		Activate: function(url, job_id, is_first_page)
		{
			$.ajax({
			  type: "POST",
			  url: url,
			  data: "job_id=" + job_id,
			  success: function(msg) {
			   	if (msg != "0")
					{
						var currentRowId = 'item'+job_id;
						var currentLinkId = 'activateLink'+job_id;
						if(is_first_page == 1)
						{
							$("#"+currentRowId).css({ display: "none" });
						}
						else
						{
							var deactivateJobFunction = function()
							{
								Jobber.DeactivateLink(job_id);
							};
							
							var linkElement = document.getElementById(currentLinkId);
							linkElement.setAttribute('title', 'Deactive this job');
							linkElement.setAttribute('onclick', deactivateJobFunction);
							linkElement.onclick = deactivateJobFunction;
							linkElement.innerHTML = '<i class="fa fa-circle fa-lg green-fa" aria-hidden="true"></i>';
							linkElement.id = 'deactivateLink'+job_id;
							jobberBase.messages.add('Job has been activated!');
						}	
					}
			  }
			});
		},
		
		DeactivateCvdb: function(url, emp_id, urlLink) {
			$.ajax({
			  type: "POST",
			  url: url,
			  data: "emp_id=" + emp_id,
			  success: function(msg) {
			   	if (msg != "0")
					{
						var currentLinkId = 'cvdb-icon-activated';
						
						var activateJobFunction = function()
						{
							Jobber.ActivateCvdb(urlLink, emp_id, url);
						};
						
						var linkElement = document.getElementById(currentLinkId);
						linkElement.setAttribute('title', 'Grant access');
						linkElement.setAttribute('onclick', activateJobFunction);
						linkElement.onclick = activateJobFunction;
						linkElement.innerHTML = '<i class="fa fa-circle-o fa-lg green-fa" aria-hidden="true"></i>';
						linkElement.id = 'cvdb-icon-deactivated';
						jobberBase.messages.add('Access removed!');
					}
			  }
			});
		},

		ActivateCvdb: function(url, emp_id, urlLink) {
			$.ajax({
			  type: "POST",
			  url: url,
			  data: "emp_id=" + emp_id,
			  success: function(msg) {
			   	if (msg != "0")
					{
						var currentLinkId = 'cvdb-icon-deactivated';
						
						var activateJobFunction = function()
						{
							Jobber.DeactivateCvdb(urlLink, emp_id, url);
						};
						
						var linkElement = document.getElementById(currentLinkId);
						linkElement.setAttribute('title', 'Grant access');
						linkElement.setAttribute('onclick', activateJobFunction);
						linkElement.onclick = activateJobFunction;
						linkElement.innerHTML = '<i class="fa fa-circle fa-lg green-fa" aria-hidden="true"></i>';
						linkElement.id = 'cvdb-icon-activated';
						jobberBase.messages.add('Access granted!');
					}
			  }
			});
		},

		Deactivate: function(url, job_id)
		{
			$.ajax({
			  type: "POST",
			  url: url,
			  data: "job_id=" + job_id,
			  success: function(msg) {
			   	if (msg != "0")
					{
						var currentLinkId = 'deactivateLink'+job_id;
						
						var activateJobFunction = function()
						{
							Jobber.ActivateLink(job_id);
						};
						
						var linkElement = document.getElementById(currentLinkId);
						linkElement.setAttribute('title', 'Activate this job');
						linkElement.setAttribute('onclick', activateJobFunction);
						linkElement.onclick = activateJobFunction;
						linkElement.innerHTML = '<i class="fa fa-circle-o fa-lg green-fa" aria-hidden="true"></i>';
						linkElement.id = 'activateLink'+job_id;
						jobberBase.messages.add('Job has been deactivated!');
					}
			  }
			});
		},
		
		DeactivateSpotlight: function(job_id)
        {
            var url = Jobber.jobber_admin_url+'deactivate-spotlight/';
            Jobber.SpotlightDeactivate(url, job_id);
        },
        ActivateSpotlight: function(job_id)
        {
            var url = Jobber.jobber_admin_url+'activate-spotlight/';
            Jobber.SpotlightActivate(url, job_id);
        },
        SpotlightActivate: function(url, job_id)
        {
            $.ajax({
              type: "POST",
              url: url,
              data: "job_id=" + job_id,
              success: function(msg) {
                   if (msg != "0")
                    {
                        var currentLinkId = 'activateSpotlight'+job_id;
                       
                        var deactivateSpotlightFunction = function()
						{
							Jobber.DeactivateSpotlight(job_id);
						};
						
						var linkElement = document.getElementById(currentLinkId);
						linkElement.setAttribute('title', 'Turn spotlight off');
                        linkElement.setAttribute('onclick', deactivateSpotlightFunction);
                        linkElement.onclick = deactivateSpotlightFunction; 
                        linkElement.innerHTML = '<i class="fa fa-star fa-lg" aria-hidden="true"></i>';
                        linkElement.id = 'deactivateSpotlight'+job_id;
                        jobberBase.messages.add('Spotlight has been activated!');
                    }
              }
            });
        },
        
        SpotlightDeactivate: function(url, job_id)
        {
            $.ajax({
              type: "POST",
              url: url,
              data: "job_id=" + job_id,
              success: function(msg) {
                   if (msg != "0")
                    {
                        var currentLinkId = 'deactivateSpotlight'+job_id;
                        var activateSpotlightFunction = function()
						{
							Jobber.ActivateSpotlight(job_id);
						};
						
						var linkElement = document.getElementById(currentLinkId);
						linkElement.setAttribute('title', 'Turn spotlight on');							
                        linkElement.setAttribute('onclick', activateSpotlightFunction);
                        linkElement.onclick = activateSpotlightFunction;
                        linkElement.innerHTML = '<i class="fa fa-star-o fa-lg" aria-hidden="true"></i>';
                        linkElement.id = 'activateSpotlight'+job_id;
                         jobberBase.messages.add('Spotlight has been deactivated!');
                    }
              }
            });
        },
		
		Delete: function(url, job_id)
		{

            if (Jobber.I18n.js.delete_job_confirmation_question === undefined) {
            	Jobber.I18n.js.delete_job_confirmation_question = "Are you sure you want to delete this job?";
            }

			if(confirm(Jobber.I18n.js.delete_job_confirmation_question))
			{
				$.ajax({
				  type: "POST",
				  url: url,
				  data: "job_id=" + job_id,
				  success: function(msg) {
				   	if (msg != "0")
						{
							var currentJobId = 'item'+job_id;
							$("#"+currentJobId).css({ display: "none" });
							jobberBase.messages.add('Job has been deleted');
						}
				  }
				});
			}
			else
				return false;
		},

		EscapeHTML: function(text)
		{
			return text
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}
	}
})();
