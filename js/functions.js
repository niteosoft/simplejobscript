(function() 
{
	SimpleJobScript = {

		simplejobscript_url: "",
		sm_profiles: [],

		

		ShowCpColor: function(){
		
			alert($("#cp").spectrum("get").toHexString());

		},

		PerformSearch: function(url, keywords)
		{	
			//console.log('PerformSearch');
			clearTimeout(window.search_timer);
			var keysCheck = '';


			 if (!String.prototype.includes) {
			     String.prototype.includes = function() {
			         'use strict';
			         return String.prototype.indexOf.apply(this, arguments) !== -1;
			     };
			 }

			keysCheck = keywords;			

			$('#job-listings').load(url + encodeURIComponent(keysCheck) + '/');	
			setTimeout(function(){
				$('#jobs-loader').addClass('displayNone');
				$('#pagination-id').addClass('displayNone');
			}, 200);
			
		},

		translateTaggle: function() { 
			$('#taggleId').html('').html(SimpleJobScript.I18n.js.skills_label);
		},

		addToFavourites: function(job_id, img_url, el) {
 			
 			$.ajax({ url: '/add_favourites_ajax.php',
 		         data: "job_id=" + job_id,
 		         type: 'post'
 			}).done(function(msg) {
 				$('#' + el + 'favourites-block-' + job_id).html('<a href="#" onclick="return SimpleJobScript.removeFromFavourites(' + job_id + ',\'' + img_url + '\', \'' + el + '\');"><i class="fa fa-heart fa-lg ml10" aria-hidden="true"></i></a>');
 			});
 			return false;
 		},

 		showSMfields: function() {
 			$('#showSMfieldsBlockId').toggleClass('displayNone');
 		},

		addProfileSMLink: function() {
			var links = parseInt($('#external_links').val());

			if (links < 4) {

				var newVal = links + 1;
				$('#external_links').val(newVal);	
	
				// generate HTML
				var html = '<div id="sm_fg_' + newVal + '" class="form-group mb30">';

				html += '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pl0 ml0 mb20">';

				// input
				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml0">';
				html += '<input placeholder="' + SimpleJobScript.I18n.js.social_media_placeholder + '" id="sm_url_' + newVal + '" name="sm_url_' + newVal + '" type="text"  class="form-control minput" />';
				html += '</div>';

				// SELECT
				var options = '';

				for (var i = 0; i <= SimpleJobScript.sm_profiles.length - 1; i++) {
					options += '<option value="' + SimpleJobScript.sm_profiles[i].id + '">' + SimpleJobScript.sm_profiles[i].name + '</option>';
				};

				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml20">';
				html += '<select id="sm_select_' + newVal + '" name="sm_select_' + newVal + '" class="form-control minput">' + options + '</select>';
				html += '</div>';

				// close
				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">';
				html += '<a id="sm_close_' + newVal + '" href="#" class="green" onclick="return SimpleJobScript.removeProfileSMfield(' + newVal + ');"><i class="fa fa-close mt18" aria-hidden="true"></i></a></div>';
				html += '</div>';

				html += '</div></div>';

				$('#SMsubBlock').append(html);

				if (links > 0) {
					if ($('#sm_close_' + links).length) {
						$('#sm_close_' + links).addClass('displayNone');
					}		
				}
			}

			if (links == 3) {
				$('#addSMLink').html('').html('<span class=\"limr\">' + SimpleJobScript.I18n.js.limit_reached + '</span>');
			}
		
			return false;
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
				html += '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pl0 ml0">';
				html += '<input class="SMInput" placeholder="' + SimpleJobScript.I18n.js.social_media_placeholder + '" id="sm_url_' + newVal + '" name="sm_url_' + newVal + '" type="text"  />';
				html += '</div>';

				// SELECT
				var options = '';

				for (var i = 0; i <= SimpleJobScript.sm_profiles.length - 1; i++) {
					options += '<option value="' + SimpleJobScript.sm_profiles[i].id + '">' + SimpleJobScript.sm_profiles[i].name + '</option>';
				};

				html += '<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pl0 ml20-desk">';
				html += '<select id="sm_select_' + newVal + '" name="sm_select_' + newVal + '" class="form-control minput">' + options + '</select>';
				html +=  '</div>';

				// CLOSE
				html += '<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">';
				html += '<a id="sm_close_' + newVal + '" href="#" class="green" onclick="return SimpleJobScript.removeSMentry(' + newVal + ');"><i class="fa fa-close mt18-desk" aria-hidden="true"></i></a></div>';
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
				$('#addLink').html('').html('<span class=\"limr\">' + SimpleJobScript.I18n.js.limit_reached + '</span>');
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
				$('#addLink').html('').html(SimpleJobScript.I18n.js.add_social_media);
			}

			return false;

		},

		removeProfileSMfield: function(entry_id){

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
				$('#addSMLink').html('').html(SimpleJobScript.I18n.js.add_social_media);
			}

			return false;
		},

 		subsctractCvDownload: function(emp_id, payment_mode) {
 			
 			if (payment_mode == '3') {
	 			$.ajax({ url: '/ajax_substract_cv_download.php',
	 		         data: "emp_id=" + emp_id,
	 		         type: 'post'
	 			}).done(function() {});
 			}

 		},
 
 		removeFromFavourites: function(job_id, img_url, el) {
 
 			$.ajax({ url: '/remove_favourites_ajax.php',
 		         data: "job_id=" + job_id,
 		         type: 'post'
 			}).done(function(msg) {
 				$('#' + el + 'favourites-block-' + job_id).html('<a href="#" onclick="return SimpleJobScript.addToFavourites(' + job_id + ',\'' + img_url + '\', \'' + el + '\');"><i class="fa fa-heart-o fa-lg ml10" aria-hidden="true"></i></a>');
 			});
 			return false;
 		},

 		HybridSearch: function(url, url_indeed, keywords, location, city, jobtype) {

 			// STANDARD SEACH
			clearTimeout(window.search_timer);
			var keysCheck = '';

			 if (!String.prototype.includes) {
			     String.prototype.includes = function() {
			         'use strict';
			         return String.prototype.indexOf.apply(this, arguments) !== -1;
			     };
			 }

			keysCheck = keywords;			

			$('#job-listings').load(url + encodeURIComponent(keysCheck) + '/');	
			setTimeout(function(){
				//$('#jobs-loader').addClass('displayNone');

					// INDEED
					var callURL = null;
					var append = null;

					if (location.length > 1) {
						append = '/loc|' + location;
					} else if (city.length > 1) {
						append = '/cit|' + city;
					} else if (jobtype.length > 1) {
						append = '/type|' + jobtype;
					}

					if (location.length > 1 || city.length > 1 || jobtype.length > 1) {
						callURL = url_indeed + encodeURIComponent(keysCheck) + append;
					} else {
						callURL = url_indeed + encodeURIComponent(keysCheck);
					}

					$('#indeed-listings').load(callURL);
					setTimeout(function(){
						$('#jobs-loader').addClass('displayNone');
						$('#indeed-listing-headline').removeClass('displayNone');
					}, 200);

			}, 200);
			// ---------------------------------------------------

 		},

		IndeedQuerySearch: function(url, keywords, location, city, jobtype) {

			clearTimeout(window.search_timer);	

			var keysCheck = '';

			if (!String.prototype.includes) {
			     String.prototype.includes = function() {
			         'use strict';
			         return String.prototype.indexOf.apply(this, arguments) !== -1;
			     };
			 }

			keysCheck = keywords;
			
			var callURL = null;
			var append = null;

			if (location.length > 1) {
				append = '/loc|' + location;
			} else if (city.length > 1) {
				append = '/cit|' + city;
			} else if (jobtype.length > 1) {
				append = '/type|' + jobtype;
			}

			if (location.length > 1 || city.length > 1 || jobtype.length > 1) {
				callURL = url + encodeURIComponent(keysCheck) + append;
			} else {
				callURL = url + encodeURIComponent(keysCheck);
			}
	
			$('#indeed-listings').load(callURL);
			setTimeout(function(){
				$('#jobs-loader').addClass('displayNone');
				$('#indeed-listing-headline').removeClass('displayNone');
			}, 200);
		},


		IndeedLandingSearch: function(url, p, location, title, filtersArr) {

			clearTimeout(window.search_timer);	
			var query = '';var locationQuery = ''; var titleQuery = '';
			var titleFlag = 0; var locFlag = 0;

			if (location != "" && location !== undefined){
				locationQuery = '&co=' + location;
				locFlag = 1;
			}

			if (title != "" && title !== undefined){
				titleQuery = '&query=' + title;
				titleFlag = 1;
			}

			var finalQuery = query + '/?p=' + p + locationQuery + titleQuery;

			//console.log(url + finalQuery);
			$('#indeed-listings').load(url + finalQuery);

			setTimeout(function(){
				$('#jobs-loader').addClass('displayNone');

				//console.log(filtersArr);

				if (locFlag == 1 && titleFlag == 0) 
					if ($('#indeed-hdln')) $('#indeed-hdln').html('').html('# ' + filtersArr[1]);
				else if (locFlag == 1 && titleFlag == 1)
					if ($('#indeed-hdln')) $('#indeed-hdln').html('').html('# ' + filtersArr[0] + ' ' + SimpleJobScript.I18n.js.in + ' ' + filtersArr[1]);
				else if (locFlag == 0 && titleFlag == 1)
					if ($('#indeed-hdln')) $('#indeed-hdln').html('').html('# ' + filtersArr[0]);

				$('#indeed-listing-headline').removeClass('displayNone');
			}, 500);
		},

		IndeedSearch: function(url, p, jobtype, location, city, filtersArr) {

			clearTimeout(window.search_timer);	
			var query = '';var locationQuery = ''; var cityQuery = '';
			var swt = 0;
			if (jobtype.length > 1 && jobtype != "" && jobtype !== undefined) {
				query = '/' + jobtype;
				$('#indeed-jt-tab').css('display', 'block');
				swt = 1;
			}

			if (location.length > 1 && location != "" && location !== undefined) {
				locationQuery = '&co=' + location;
				$('#indeed-co-tab').css('display', 'block');
				swt = 2;
			}

			if (city.length > 1 && city != "" && city !== undefined) {
				cityQuery = '&city=' + city;
				$('#indeed-ci-tab').css('display', 'block');
				swt = 3;
			}

			var finalQuery = query + '/?p=' + p + locationQuery + cityQuery;

			$('#indeed-listings').load(url + finalQuery);

			setTimeout(function(){
				$('#jobs-loader').addClass('displayNone');

				if (swt == 1)
					$('#indeed-hdln').html('').html('# ' + filtersArr[0]);
				else if (swt == 2) 
					$('#indeed-hdln').html('').html('# ' + filtersArr[1]);
				else if (swt == 3)
					$('#indeed-hdln').html('').html('# ' + filtersArr[2]);

				$('#indeed-listing-headline').removeClass('displayNone');
			}, 500);
		},

		accountPlanSelectChanged: function(package_id) {

			$.ajax({ url: '/ajax_get_package_features.php',
 		         data: "package_id=" + package_id,
 		         type: 'post'
 			}).done(function(result) {

 				var result = JSON.parse(result);
 	
 				$('#ajax-plan-name').html('').html(result.data.name);
 				$('#ajax-plan-jp').html('').html(result.data.job_period);
 				$('#ajax-plan-jl').html('').html(result.data.jobs_left);
 				$('#ajax-plan-cvdl').html('').html(result.data.cv_downloads);

 				$('#ajax-price').html('').html(result.price);

 				if ($('#ajax-vat'))
 					$('#ajax-vat').html('').html(result.vat);
 				if ($('#ajax-price-vat'))
 					$('#ajax-price-vat').html('').html(result.price_vat);
 			});

		},

		toggleUserForm: function() {
			$('#userForm').toggleClass('displayNone');
		},

		filterByType: function(el) {
				window.location = el.value;
		},

		validateDesc: function() {
			if (tinymce.activeEditor.getContent() == "") {
						alert(SimpleJobScript.I18n.js.job_desc_err);
						return false;
			} else return true;
		},

		companyPublicProfileSwitched: function(val) {
 			if (val == false) {
 				$('#public-profile-block').addClass('displayNone');
 			} else {
 				$('#public-profile-block').removeClass('displayNone');
 			}
 		},

 		initPP: function(){
 			//logo check
 			$("#pp_file").change(function (e) {
 		   	 if(this.disabled) return alert(SimpleJobScript.I18n.js.file_upload_notsupported);
 		   	 //validation
 			 readImagePP( this.files[0] );
 
 			});	
 
 			function readImagePP(file) {
 
 			    var reader = new FileReader();
 			    var image  = new Image();
 
 			    reader.readAsDataURL(file);  
 			    reader.onload = function(_file) {
 			        image.src    = _file.target.result;
 			        image.onload = function() {
 			            var w = this.width,
 			                h = this.height;

 			             var allowed_ext = ["jpeg", "png", "bmp", "gif"];
 			             var type = file.type.split('/')[1];
 			             if ($.inArray(type, allowed_ext) == -1) {
 			             	$('#pp-err').removeClass('displayNone');
 			             	$('#submit').attr('disabled','disabled');
 							return;
 			             }
 
 			             //check file size
 			             if (file.size > 3000000) {
 							$('#pp-err').removeClass('displayNone');
 			             	$('#submit').attr('disabled','disabled');
 			             	return;
 			             }
 
 
 			             $('#pp-err').addClass('displayNone');
 			             $('#submit').removeAttr("disabled");
 			             $('#uploadPreviewPP').html('');
 			             $('#uploadPreviewPP').append('<img style="width: 50%; height: 50%;" src="'+ this.src +'">');
 			        };
 			        image.onerror= function() {
 			            alert('Invalid file type: '+ file.type);
 			        };      
 			    };
 
 			}
 		},
 		
 		cr: function(ver){
			if (ver == 'free') {
				$('#library-loads').html('<p>Powered by &nbsp;<a href=\"https://simplejobscript.com/\" target=\"_blank\">SJS</a></p>');
			} 
		},

		applyChanged: function(val){
			if (val == false) {
				$('#apply-desc-block').removeClass('displayNone');
			} else {
				$('#howtoTA').val('');
				$('#apply-desc-block').addClass('displayNone');
			}
		},

		backAndEdit: function() {
			//delete tmp job to supress duplicate creations and go back
			$.ajax({ url: '/delete_tmpjob_ajax.php',
			         data: "job_id=" + $('#job_id').val(),
			         type: 'post'
				}).done(function() {
				});

			window.history.back();
		},

		hideLoginFields: function() {
				$('#incorrect-login-err').toggleClass('displayNone');
				$('#forgotpassblockid').css('margin-bottom', '30px');
				$('#forgotten-zone').toggle();
				$('#submit-block').toggleClass('displayNone');
				$('#login-email-fg').toggleClass('displayNone');
				$('#login-pass-fg').toggleClass('displayNone');
				$('#login_head').toggleClass('displayNone');
				$('#sign-up-link').toggleClass('displayNone');
	
		},

		initJobApplicationsSelect: function(theme) {
			if ($('#job_select').val() != 0)
				SimpleJobScript.GetAjaxApplications(theme);

			$('#job_select').on('change', function() {
  				SimpleJobScript.GetAjaxApplications(theme);
			});
		},

		GetAjaxApplicationsUnderReview: function(theme) {

				if ($('#ur-job-title').hasClass('displayNone'))
					$('#ur-job-title').removeClass('displayNone');

				$('#review-id').addClass('displayNone');
				$('#hire-id').removeClass('displayNone');


				$('#apps_spinner').removeClass('displayNone');

				$.ajax({ url: '/get_job_applications_under_review_ajax.php',
			         data: "job_id=" + $('#job_select').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);

					if (json.result == '0'){
						$('#ajax-content').html('');
						$('#apps_spinner').addClass('displayNone');
						return;
					}

					var data = json.result;

					var html = '';
					$('#apps-modals').html('');
					for(var obj in json.result) {

						var cv, path;

						SimpleJobScript.CreateModals(data[obj]);

						var NOCV = false;
						if (data[obj].cv_path == ''){
							cv = '-';
							NOCV = true;
						}
						else {
							cv = data[obj].cv_path;
						}

						var e = cv.split('.').pop();
						if (e.indexOf("pdf") != -1)
							path = 'fa fa-file-pdf-o fa-lg pdf-el';
						else
							path = 'fa fa-file-word-o fa-lg word-el';

						var loc = '';
						if (data[obj].location != '')
							loc = data[obj].location;
						else
							loc = '-';
						
						html += '<tr id=\"tr-' + data[obj].id + '\">';
						html += '<td><a target="_blank" href="' + data[obj].job_url + '">' + data[obj].job_name + '</a></td>';
						html += '<td>' + data[obj].name + '</td>';
						html += '<td>' + data[obj].occupation + '</td>';
						html += '<td><ul class=\"tags jatul\">' + data[obj].skills_formated + '</ul></td>';
						html += '<td>' + loc + '</td>';
						if (NOCV)
							html += '<td>-</td>';
						else
							html += '<td><a href=\"../' + cv + '\" download=\"' + cv +'\"><i class=" ' + path + '" aria-hidden="true"></i></td>';
						html += '<td><a data-toggle=\"modal\" data-target=\"#applicant_modal_' + data[obj].id + '\" href=\"#\" >' + '<i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '<td><a name=\"' + data[obj].id  +'\" id=\"hire-' + data[obj].id + '\" href=\"#\">' + '<i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '<td><a name=\"' + data[obj].id  +'\" id=\"app-' + data[obj].id + '\" href=\"#\">' + '<i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '</tr>'; //id=\"deleteAppConfirm-' + data[obj].id  + '\"
						///delete-application/' + data[obj].id + '

					}
					$('#ajax-content').html(html);

					//asign confirm modals
					for(var obj in json.result) { 
						$("#hire-" + data[obj].id).confirm({
						    text: SimpleJobScript.I18n.js.hired_text,
						    confirm: function(el) {
						        //application id = el[0].name
						        var id = el[0].name;
						        $.ajax({ url: '/hire_applicant_ajax.php',
							         data: "app_id=" + id,
							         type: 'post'
								}).done(function(msg) {
									var js = JSON.parse(msg);
									if (js.result == "1") {
										$('#tr-' + id).fadeOut("slow");
										setTimeout(function(){ 
											window.location.reload();
										}, 500);
									}
								});

						    },
						    cancel: function() {
						    },
						    confirmButton: SimpleJobScript.I18n.js.yes_i_do,
						    cancelButton: SimpleJobScript.I18n.js.text_no,
						    confirmButtonClass: "btn-primary",
						    cancelButtonClass: "btn-warning"
						});
					}


					for(var obj in json.result) { 
						$("#app-" + data[obj].id).confirm({
						    text: SimpleJobScript.I18n.js.delete_application_text,
						    confirm: function(el) {
						        //application id = el[0].name
						        var id = el[0].name;
						        $.ajax({ url: '/reject_application_ajax.php',
							         data: "app_id=" + id,
							         type: 'post'
								}).done(function(msg) {
									var js = JSON.parse(msg);
									if (js.result == "1") {
										$('#tr-' + id).fadeOut("slow");
										setTimeout(function(){ 
											window.location.reload();
										}, 500);
									}
								});

						    },
						    cancel: function() {
						    },
						    confirmButton: SimpleJobScript.I18n.js.yes_i_do,
						    cancelButton: SimpleJobScript.I18n.js.text_no,
						    confirmButtonClass: "btn-primary",
						    cancelButtonClass: "btn-warning"
						});
					}

					$('#apps_spinner').addClass('displayNone');
				});

		},

		GetAjaxApplications: function(theme) {


				if (!$('#ur-job-title').hasClass('displayNone'))
					$('#ur-job-title').addClass('displayNone');

				if ($('#job_select').val() == 1) {
					SimpleJobScript.GetAjaxApplicationsUnderReview(theme);
					return;
				}

				$('#review-id').removeClass('displayNone');
				$('#hire-id').addClass('displayNone');
	
				$('#apps_spinner').removeClass('displayNone');

				$.ajax({ url: '/get_job_applications_ajax.php',
			         data: "job_id=" + $('#job_select').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);

					if (json.result == '0'){
						$('#ajax-content').html('');
						$('#apps_spinner').addClass('displayNone');
						return;
					}

					var data = json.result;

					var html = '';
					$('#apps-modals').html('');
					for(var obj in json.result) {

						var cv, path;

						SimpleJobScript.CreateModals(data[obj]);

						var NOCV = false;
						if (data[obj].cv_path == ''){
							cv = '-';
							NOCV = true;
						}
						else {
							cv = data[obj].cv_path;
						}

						var e = cv.split('.').pop();
						if (e.indexOf("pdf") != -1)
							path = 'fa fa-file-pdf-o fa-lg pdf-el';
						else
							path = 'fa fa-file-word-o fa-lg word-el';

						var loc = '';
						if (data[obj].location != '')
							loc = data[obj].location;
						else
							loc = '-';

						html += '<tr id=\"tr-' + data[obj].id + '\">';
						html += '<td>' + data[obj].name + '</td>';
						html += '<td>' + data[obj].occupation + '</td>';
						html += '<td><ul class=\"tags jatul\">' + data[obj].skills_formated + '</ul></td>';
						html += '<td>' + loc + '</td>';
						if (NOCV)
							html += '<td>-</td>';
						else
							html += '<td><a href=\"../' + cv + '\" download=\"' + cv +'\"><i class=" ' + path + '" aria-hidden="true"></i></td>';
						html += '<td><a data-toggle=\"modal\" data-target=\"#applicant_modal_' + data[obj].id + '\" href=\"#\" >' + '<i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '<td><a name=\"' + data[obj].id  +'\" id=\"review-' + data[obj].id + '\" href=\"#\">' + '<i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '<td><a name=\"' + data[obj].id  +'\" id=\"app-' + data[obj].id + '\" href=\"#\">' + '<i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true"></i>' + '</a></td>';
						html += '</tr>'; //id=\"deleteAppConfirm-' + data[obj].id  + '\"
						///delete-application/' + data[obj].id + '

					}
					$('#ajax-content').html(html);

					//asign confirm modals
					for(var obj in json.result) { 
						$("#app-" + data[obj].id).confirm({
						    text: SimpleJobScript.I18n.js.delete_application_text,
						    confirm: function(el) {
						        //application id = el[0].name
						        var id = el[0].name;
						        $.ajax({ url: '/reject_application_ajax.php',
							         data: "app_id=" + id,
							         type: 'post'
								}).done(function(msg) {
									var js = JSON.parse(msg);
									if (js.result == "1") {
										$('#tr-' + id).fadeOut("slow");
										setTimeout(function(){ 
											window.location.reload();
										}, 500);

									}
								});

						    },
						    cancel: function() {
						    },
						    confirmButton: SimpleJobScript.I18n.js.yes_i_do,
						    cancelButton: SimpleJobScript.I18n.js.text_no,
						    confirmButtonClass: "btn btn-green",
						    cancelButtonClass: "btn btn-gray"
						});
					}

					for(var obj in json.result) { 
						$("#review-" + data[obj].id).confirm({
						    text: SimpleJobScript.I18n.js.review_application_text,
						    confirm: function(el) {
						        //application id = el[0].name
						        var id = el[0].name;
						        $.ajax({ url: '/review_application_ajax.php',
							         data: "app_id=" + id,
							         type: 'post'
								}).done(function(msg) {
									var js = JSON.parse(msg);
									if (js.result == "1") {
										$('#tr-' + id).fadeOut("slow");
										setTimeout(function(){ 
											window.location.reload();
										}, 500);
									}
								});

						    },
						    cancel: function() {
						    },
						    confirmButton: SimpleJobScript.I18n.js.yes_i_do,
						    cancelButton: SimpleJobScript.I18n.js.text_no,
						    confirmButtonClass: "btn btn-green",
						    cancelButtonClass: "btn btn-gray"
						});
					}

					$('#apps_spinner').addClass('displayNone');
				});
		},

		CreateModals: function(app) {

			var linkToShow = '';
			if (app.website != '') {
					if (app.website.length > 30) {
				linkToShow = app.website.substring(0, 30) + '...';
				} else {
					linkToShow = app.website;
				}		
			}

			var sm_content = '';
			for (var obj in app.sm_links) {
			  if (app.sm_links.hasOwnProperty(obj))
			    if (app.sm_links[obj].whatsapp == true)
			    	sm_content += '<a class=\"mr12\" href=\"tel:' + app.sm_links[obj].whatsapp_numb + '\" target=\"_blank\"><i class=\"fa fa-' + app.sm_links[obj].icon + ' fa-lg mt10\" aria-hidden=\"true\"></i></a>';
			    else
			    	sm_content += '<a class=\"mr12\" href=\"' + app.sm_links[obj].linkToShow + '\" target=\"_blank\"><i class=\"fa fa-' + app.sm_links[obj].icon + ' fa-lg mt10\" aria-hidden=\"true\"></i></a>';
				
			}		

			var content = '';
			content += '<div id=\"applicant_modal_' + app.id + '\" class=\"modal fade\" role=\"dialog\">';
			content += '<div class=\"modal-dialog\">';
			content += '<div class=\"modal-content\">';
			content += '<div class=\"modal-header\">';
			content += '<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>';
			content += '<h4 class=\"modal-title mb10\">' + SimpleJobScript.I18n.js.candidate_profile + '</h4>';
			content += '</div>';
			content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.applied_label + '</div>' + app.date_formated + '</div>';
			content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.email_label + '</div>' + app.email + '</div>';
			if (app.phone != '')
				content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.phone_label + '</div><a href=\"tel:' + app.phone + '\">' + app.phone + '</a></div>';
			if (app.website != '')
				content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.website_label + '</div><a href=\"http://' + app.website + '\" target=\"_blank\">' + linkToShow + '</a></div>';

			if (sm_content != '') {
				content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.social_media_label + '</div>' + sm_content + '</div>';
			}
			content += '<div class=\"modal-body\"><div class=\"modal-label mb10\">' + SimpleJobScript.I18n.js.application_message + '</div><br /> ' + app.message + '</div>';
			content += '<div class=\"modal-footer\"><button type=\"button\" class=\"btn btn-green\" data-dismiss=\"modal\">' + SimpleJobScript.I18n.js.close + '</button></div></div></div></div>';
			$('#apps-modals').append(content);
		},

		InitSubscribeTabs: function() {
			 $("#subscribe-tabs a").click(function(e){
		    	e.preventDefault();
		    	$(this).tab('show');
		    });
		},

		passwordRecoveryValidation: function(){

    		if ($('#forget_pass').val().length < 6
    			|| $('#forget_pass2').val().length < 6
    			|| $('#forget_pass').val() != $('#forget_pass2').val()) {

				$('#recovery-pass-err').removeClass('displayNone');
				return false;

    		} else {
				$('#recovery-pass-err').addClass('displayNone');
    		}
    		return true;
		},

		applicantPasswordValidation: function(){

    		if ($('#pass1').val().length < 6
    			|| $('#pass2').val().length < 6
    			|| $('#pass1').val() != $('#pass2').val()) {

    			$('#forget-pass-fg').addClass('has-error');
    			$('#forget-pass-fg2').addClass('has-error');
				$('#passrecovery-feedback-err').removeClass('displayNone');
				return false;

    		} else {
    			$('#forget-pass-fg').removeClass('has-error');
    			$('#forget-pass-fg2').removeClass('has-error');
				$('#passrecovery-feedback-err').addClass('displayNone');
    		}
    		return true;
		},

		passwordRecovery: function(){

			if ($('#forget_email').val() == "") {
				alert("Please, fill in your email");
				return false;
			} 

			$('#fspinner').removeClass('displayNone');
			$.ajax({ url: '/password_recovery_ajax.php',
			         data: "email=" + $('#forget_email').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					$('#fspinner').addClass('displayNone');

					if (json.result == "1") {
						$('#passrecovery-feedback-ok').removeClass('displayNone');
						$('#passrecovery-feedback-err').addClass('displayNone');
						$('#passrecovery-feedback-err2').addClass('displayNone');
					} else if (json.result == "3"){
						$('#passrecovery-feedback-err').addClass('displayNone');
						$('#passrecovery-feedback-ok').addClass('displayNone');
						$('#passrecovery-feedback-err2').removeClass('displayNone');
					} else {
						$('#passrecovery-feedback-err').removeClass('displayNone');
						$('#passrecovery-feedback-ok').addClass('displayNone');
						$('#passrecovery-feedback-err2').addClass('displayNone');
					}
			});
				return false;
		},

		passwordRecoveryApplicants: function(){


			if ($('#forget_email').val() == "") {
				alert("Please, fill in your email");
				return false;
			} 

			$('#fspinner').removeClass('displayNone');
			$.ajax({ url: '/password_recovery_applicants_ajax.php',
			         data: "email=" + $('#forget_email').val(),
			         type: 'post'
				}).done(function(msg) {
					console.log(msg);
					var json = JSON.parse(msg);
					$('#fspinner').addClass('displayNone');

					if (json.result == "1") {
						$('#passrecovery-feedback-ok').removeClass('displayNone');
						$('#passrecovery-feedback-err').addClass('displayNone');
						$('#passrecovery-feedback-err2').addClass('displayNone');
					} else if (json.result == "3"){
						$('#passrecovery-feedback-err').addClass('displayNone');
						$('#passrecovery-feedback-ok').addClass('displayNone');
						$('#passrecovery-feedback-err2').removeClass('displayNone');
					} else {
						$('#passrecovery-feedback-err').removeClass('displayNone');
						$('#passrecovery-feedback-ok').addClass('displayNone');
						$('#passrecovery-feedback-err2').addClass('displayNone');
					}
			});
				return false;
		},

		initApplyValidation: function() {
			var text_max = 500;
		    $('#textarea_feedback').html(text_max + ' ' + SimpleJobScript.I18n.js.chars_remaining);
		    $('#apply_msg').keyup(function() {
		        var text_length = $('#apply_msg').val().length;
		        var text_remaining = text_max - text_length;

		        $('#textarea_feedback').html(text_remaining + ' ' + SimpleJobScript.I18n.js.chars_remaining);
		    });
		},

		initRegisterFormStep2Validation: function() {
			var text_max = 1000;

		    $('#textarea_feedback').html(text_max + ' ' + SimpleJobScript.I18n.js.chars_remaining);
		    $('#company_desc').keyup(function() {
		        var text_length = $('#company_desc').val().length;
		        var text_remaining = text_max - text_length;

		        $('#textarea_feedback').html(text_remaining + ' ' + SimpleJobScript.I18n.js.chars_remaining);
		    });

		    //logo check
			$("#company_logo").change(function (e) {
		   	 if(this.disabled) return alert(SimpleJobScript.I18n.js.file_upload_notsupported);
		   	 //validation
			 readImage( this.files[0] );

			});

			function readImage(file) {

			    var reader = new FileReader();
			    var image  = new Image();

			    reader.readAsDataURL(file);  
			    reader.onload = function(_file) {
			        image.src    = _file.target.result;              // url.createObjectURL(file);
			        image.onload = function() {
			            var w = this.width,
			                h = this.height;
			                //n = file.name,
			                //s = ~~(file.size/1024) +'KB';
			                
			             // if (Math.abs(w - h) > 75 || w < 100 || h < 100) {
			             // 	$('#logo-ok').addClass('displayNone');
			             // 	$('#logo-err2').removeClass('displayNone');
			             // 	$('#logo-err2').append('. Your dimensions are ' + w + 'x' + h);
			             // 	$('#submit').attr('disabled','disabled');
			             // 	return;
			             // }
			             //check extensions
			             var allowed_ext = ["jpeg", "png", "bmp", "gif"];
			             var type = file.type.split('/')[1];
			             if ($.inArray(type, allowed_ext) == -1) {
			             	$('#logo-ok').addClass('displayNone');
			             	$('#logo-err2').addClass('displayNone');
			             	$('#logo-err').removeClass('displayNone');
			             	$('#submit').attr('disabled','disabled');
							return;
			             }

			             //check file size
			             if (file.size > 3000000) {
			             	$('#logo-ok').addClass('displayNone');
			             	$('#logo-err2').addClass('displayNone');
			             	$('#logo-err').removeClass('displayNone');
			             	$('#submit').attr('disabled','disabled');
			             	return;
			             }

			             //otherwise ok
			             $('#logo-ok').removeClass('displayNone');
			             $('#logo-err2').addClass('displayNone');
			             $('#logo-err').addClass('displayNone');
			             $('#submit').removeAttr("disabled");
			             $('#uploadPreview').html('');
			             $('#uploadPreview').append('<img style="width: 75%; height: 75%;" src="'+ this.src +'">');
			        };
			        image.onerror= function() {
			            alert('Invalid file type: '+ file.type);
			        };      
			    };

			}

		},

		loginFormValidation: function() {
			 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		 
    		 if (!filter.test($('#signin_email').val())) {
    			$('#login-email-fg').addClass('has-error');
				$('#err-login-email').removeClass('displayNone');
				return false;
    		 } else {
    		 	$('#err-login-email').addClass('displayNone');
    		 	$('#login-email-fg').removeClass('has-error');
    		 }

			if ($('#signin_pass').val().length < 6) {
				$('#login-pass-fg').addClass('has-error');
				$('#err-login-pass').removeClass('displayNone');
				return false;
			} else {
				$('#login-pass-fg').removeClass('has-error');
				$('#err-login-pass').addClass('displayNone');
			}

			$('#login-form').submit();
			return true;
		},

		registerFormValidation: function() {
			 var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

//(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+)\])

			 if ($('#register_name').val().length < 3) {
			 	$('#reg-name-fg').addClass('has-error');
				$('#err-reg-name').removeClass('displayNone');
				return false;
			} else {
				$('#reg-name-fg').removeClass('has-error');
				$('#err-reg-name').addClass('displayNone');
			}

		  	 if (!filter.test($('#register_email').val())) {
    			$('#reg-email-fg').addClass('has-error');
				$('#err-reg-email').removeClass('displayNone');
				return false;
    		 } else {
    		 	$('#err-reg-email').addClass('displayNone');
    		 	$('#login-reg-fg').removeClass('has-error');
    		 }

    		if ($('#register_pass1').val().length < 6
    			|| $('#register_pass2').val().length < 6
    			|| $('#register_pass1').val() != $('#register_pass2').val()) {

    			$('#reg-pass1-fg').addClass('has-error');
    			$('#reg-pass2-fg').addClass('has-error');
				$('#err-reg-pass2').removeClass('displayNone');
				return false;

    		} else {
    			$('#reg-pass1-fg').removeClass('has-error');
    			$('#reg-pass2-fg').removeClass('has-error');
				$('#err-reg-pass2').addClass('displayNone');
    		}

    		 return true;

		},

		checkIfEmailExists: function() {
				var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

				$.ajax({ url: '/email_verification_ajax.php',
			         data: "email=" + $('#register_email').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					if (json.result == "1") {
						$('#reg-email-fg').addClass('has-error');
						$('#err-reg-email').html('').html(SimpleJobScript.I18n.js.email_registered_err_message);
						$('#err-reg-email').removeClass('displayNone');
						// block the form
						$('#proceedToStep2btnId').attr('disabled', true);

					} else {
						$('#err-reg-email').addClass('displayNone');
						$('#reg-email-fg').removeClass('has-error');
						$('#proceedToStep2btnId').attr('disabled', false);
						//test email again for syntax
						if (!filter.test($('#register_email').val())) {
			    			$('#reg-email-fg').addClass('has-error');
			    			$('#err-reg-email').html('').html(SimpleJobScript.I18n.js.invalid_email_err_message);
							$('#err-reg-email').removeClass('displayNone');
							$('#proceedToStep2btnId').attr('disabled', true);
							return false;
			    		 } else {
			    		 	$('#err-reg-email').addClass('displayNone');
			    		 	$('#login-reg-fg').removeClass('has-error');
			    		 	$('#proceedToStep2btnId').attr('disabled', false);
			    		 }
					}
				});

		},

		initPlaceholderSetup: function() {
			$('[placeholder]').focus(function() {
			  var input = $(this);
			  if (input.val() == input.attr('placeholder')) {
			    input.val('');
			    input.removeClass('placeholder');
			  }
			}).blur(function() {
			  var input = $(this);
			  if (input.val() == '' || input.val() == input.attr('placeholder')) {
			    input.addClass('placeholder');
			    input.val(input.attr('placeholder'));
			  }
			}).blur();

			    $('[placeholder]').parents('form').submit(function() {
			  $(this).find('[placeholder]').each(function() {
			    var input = $(this);
			    if (input.val() == input.attr('placeholder')) {
			      input.val('');
			    }
			  })
			});
		},

		toggleChevron: function(e) {
			 $(e.target)
	        .prev('.panel-heading')
	        .find("i.indicator")
	        .toggleClass('glyphicon-chevron-down glyphicon-chevron-right');
		},
		
		Subscribe: function() {

			if ($('#subscribe_email').val() == '') {
				 $('#subscribe-neg').removeClass('displayNone');
				 $('#subscribe-pos').addClass('displayNone');
				 $('#subscribe-wrongemail').addClass('displayNone');
				 return false;
			} else {
				$('#subscribe-neg').addClass('displayNone');
			}

			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		 
		 	//clear registration form
    		 if (!filter.test($('#subscribe_email').val())) {
    		 	$('#subscribe-wrongemail').removeClass('displayNone');
    		 	$('#subscribe-neg').addClass('displayNone');
    		 	$('#subscribe-pos').addClass('displayNone');
    
    		 	return false;
    		 } else {
    		 		$('#subscribe-wrongemail').addClass('displayNone');
    		 }

    		 $('#fspinner_subscribe').removeClass('displayNone');
    		 $.ajax({ url: '/subscribe_ajax.php',
			         data: "data=" + $('#subscribe_email').val() +  '|' + $('#subscategory').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					console.log(json);
					$('#fspinner_subscribe').addClass('displayNone');
					if (json.result == '1') {
						$('#subscribe-pos').removeClass('displayNone');
						$('#subscribe-neg').addClass('displayNone');
						$('#subscribe-wrongemail').addClass('displayNone');

					} else {
						$('#subscribe-pos').addClass('displayNone');
						$('#subscribe-neg').removeClass('displayNone');
						$('#subscribe-wrongemail').addClass('displayNone');
					}
				
					$('#subscribe_email').val('');
					return true;
			});

		},

		SubscribeMobile: function() {

			if ($('#subscribe_email_mobile').val() == '') {
				 $('#subscribe-neg-mob').removeClass('displayNone');
				 $('#subscribe-pos-mob').addClass('displayNone');
				 $('#subscribe-wrongemail-mob').addClass('displayNone');

				 return false;
			} else {
				$('#subscribe-neg-mob').addClass('displayNone');
			}

			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		 
		 	//clear registration form
    		 if (!filter.test($('#subscribe_email_mobile').val())) {
    		 	$('#subscribe-wrongemail-mob').removeClass('displayNone');
    		 	$('#subscribe-neg-mob').addClass('displayNone');
    		 	$('#subscribe-pos-mob').addClass('displayNone');
    		 	return false;
    		 } else {
    		 		$('#subscribe-wrongemail-mob').addClass('displayNone');
    		 }

    		 $('#fspinner_subscribe-mob').removeClass('displayNone');
    		 $.ajax({ url: '/subscribe_ajax.php',
			         data: "data=" + $('#subscribe_email_mobile').val() +  '|' + $('#subscategory').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					console.log(json);
					$('#fspinner_subscribe-mob').addClass('displayNone');
					if (json.result == '1') {
						$('#subscribe-pos-mob').removeClass('displayNone');
						$('#subscribe-neg-mob').addClass('displayNone');
						$('#subscribe-wrongemail-mob').addClass('displayNone');

					} else {
						$('#subscribe-pos-mob').addClass('displayNone');
						$('#subscribe-neg-mob').removeClass('displayNone');
						$('#subscribe-wrongemail-mob').addClass('displayNone');
					}
				
					$('#subscribe_email_mobile').val('');
					return true;
			});

		},

		ShareApplicant: function() {
			if ($('#emailto').val() == '' ||
				$('#emailtext').val() == '') {
					$('#email-empty').removeClass('displayNone');
					return false;
			} else {
				$('#email-empty').addClass('displayNone');
			}

			//validate emails
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		 
		 	//clear registration form
    		 if (!filter.test($('#emailto').val())) { 
    		 	 	$('#email-empty').removeClass('displayNone');
    		 	    return false;
    		 } else  {
    		 	$('#email-empty').addClass('displayNone');
    		 }
    		 $('#tellfriendspinner').removeClass('displayNone');

			var cv = $('#cv_path_hidden').val();

			$.ajax({ url: '/share_applicant_ajax.php',
			         data: "data=" + cv + '|' + $('#emailto').val() + '|' + $('#emailtext').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					setTimeout(function(){
						if (json.result == '1') {
							$('#email-positive').removeClass('displayNone');
							$('#email-negative').addClass('displayNone');
						} else {
							$('#email-positive').addClass('displayNone');
							$('#email-negative').removeClass('displayNone');
						}

						$('#tellfriendspinner').addClass('displayNone');
						$('#emailto').val('');
					}, 500);
					return true;
			});
			return false;
		},

		TellAFriend: function() {
			if ($('#emailfrom').val() == '' || 
				$('#emailto').val() == '' ||
				$('#emailtext').val() == '') {
					$('#email-empty').removeClass('displayNone');
					return false;
			} else {
				$('#email-empty').addClass('displayNone');
			}

			//validate emails
			var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    		 
		 	//clear registration form
    		 if (!filter.test($('#emailfrom').val())
    		 	 || !filter.test($('#emailto').val())) { 
    		 	 	$('#email-empty').removeClass('displayNone');
    		 	    return false;
    		 } else  {
    		 	$('#email-empty').addClass('displayNone');
    		 }
    		 $('#tellfriendspinner').removeClass('displayNone');

			$.ajax({ url: '/tell_friend_ajax.php',
			         data: "data=" + $('#emailfrom').val() + '|' + $('#emailto').val() + '|' + $('#emailtext').val(),
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					setTimeout(function(){
						if (json.result == '1') {
							$('#email-positive').removeClass('displayNone');
							$('#email-negative').addClass('displayNone');
						} else {
							$('#email-positive').addClass('displayNone');
							$('#email-negative').removeClass('displayNone');
						}

						$('#tellfriendspinner').addClass('displayNone');
						$('#emailfrom').val('');
						$('#emailto').val('');
					}, 500);
					
					return true;
			});
			return false;
		},

		createProfileValidation: function (cv_size) {

			  if ($('#pass1').val().length < 6
    			|| $('#pass2').val().length < 6
    			|| $('#pass1').val() != $('#pass2').val()) {

				$('#feedback-err').removeClass('displayNone');
				$('#pass1').focus();
				return false;

    		} else {
    			$('#feedback-err').addClass('displayNone');
    		}

			setTimeout(function(){
				//captcha check
				if ($('#captcha').val() == '') {
					($('#captcha_err')).removeClass('displayNone');
					return false;
				}

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

		Apply: function(cv_size, mode) {

			$('#fspinner_apply').removeClass('displayNone');
			var flag = null;

			if (mode == 'existing') {
				if ($('#apply_pass_existing').length) {
					if ($('#apply_pass_existing').val().length < 6) {
						$('#err-existing-pass').removeClass('displayNone');
						return false;
					} else {
						$('#err-existing-pass').addClass('displayNone');
					}
				}
			} else if (mode == 'new') {
				// test only when public profile is checked
				if ($('#public_profile').is(':checked') == true) {
					if ($('#xuser_password').val().length < 6) {
						$('#fspinner_apply').addClass('displayNone');
						$('#err-new-pass').removeClass('displayNone');
						return false;
					} else {
						$('#err-new-pass').addClass('displayNone');
					}		
				}
			}

			setTimeout(function(){

				//captcha check
				if ($('#captcha').val() == '') {
					($('#captcha_err')).removeClass('displayNone');
					$('#fspinner_apply').addClass('displayNone');
					return false;
				}

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

				$('#fspinner_apply').addClass('displayNone');
				return true;
			}, 500);

		},

		ReportSpam: function()
		{ 
			var jobid = $('#jobid').val();
			var text = $('#reportarea').val();

			if (text.length < 1) {
				$('#report-empty').removeClass('displayNone');
				return false;
			} else {
				$('#report-empty').addClass('displayNone');
			}

			$('#fspinner').removeClass('displayNone');
			$.ajax({ url: '/report_spam_ajax.php',
			         data: "msg_id=" + text + '|' + jobid,
			         type: 'post'
				}).done(function(msg) {
					var json = JSON.parse(msg);
					setTimeout(function(){
						if (json.result == '1') {
							$('#report-positive').removeClass('displayNone');
							$('#report-negative').addClass('displayNone');
						} else {
							$('#report-positive').addClass('displayNone');
							$('#report-negative').removeClass('displayNone');
						}

						$('#fspinner').addClass('displayNone');
						$('#reportarea').val('');
					}, 500);
					
					return true;
			});
			return false;
		},

		InitEditor: function(theme) {
			tinymce.init({selector:'textarea:not(.noTinymceTA)', content_css : "/_tpl/" + theme + "/1.5/css/custom-editor.css", height : 300, resize: 'both' , theme: 'modern', toolbar1: 'insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image', toolbar2: 'preview media | forecolor emoticons', plugins: ["paste advlist autolink lists link image charmap preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars media nonbreaking save table contextmenu directionality emoticons template textcolor colorpicker textpattern imagetools"], paste_retain_style_properties: "color font-style font-size",paste_webkit_styles: "color font-style font-size" });
		},

		InitSearchBoxes: function(jobs_url, latestJobsTrans) { 

				$(document).on("click",".type_searchrd",function() {
		        var jobsurl = jobs_url;

		        $('.clearallfilters').css('display', 'block');
		        $('#jobs-loader').removeClass('displayNone');
		        $('.listings-block').css('display', 'none');
		        var data_val_remove = $(this).attr('id');
		        var jobtype_val_remove = $(this).attr('data');        
		        var jobtype_remove_id = $(this).attr('data-id');
		        //alert(jobtype_remove_id);        
		        $('#'+$(this).attr('id')).remove();
		        $('#check_'+$(this).attr('data-id')).attr('checked', false);
		        var dataval = [];
		        var jobtypeval = [];
		        $(".type_searchrd").each(function() {
		           dataval.push($(this).attr('id'));
		           jobtypeval.push($(this).attr('data'));
		        });                
		        //dataval = $.grep(dataval, function(value) {return value != data_val_remove;});
		        //jobtypeval = $.grep(jobtypeval, function(value) {return value != jobtype_val_remove;});        
		        var data_url_val = jobs_url;
		        var postData = {srch_location_val: dataval, job_type_value : jobtypeval, remove_id : jobtype_remove_id};
		                jQuery.ajax({
		                        type: "GET",
		                        url: jobsurl,
		                        async: true,
		                        data: postData,
		                        cache: false,
		                       success: function(res)
		                        {                            
		                            $('#jobs-loader').addClass('displayNone');
		                           $('.listings-block').css('display', 'block');
		                            var serch_typee = $(res).find('div.search_typee').html();
		                            if (!$.trim(serch_typee)){   
		                                $('.clearallfilters').css('display', 'none');
		                                $("#jobtypee").html(latestJobsTrans);
		                            }
		                            else{   
		                                //alert("What follows is not blank: " + serch_typee);
		                            } 
		                            var removeid = $(res).find('div.remove_idd').html();                          
		                            $(".remove_idd").html(removeid);
		                            var resultt = $(res).find('ul.search-ajax-content').html();
		                            $("#showres").html(resultt);  
                          
		                        }
		                });        
		     	});	
		// ---------------------------------------------------------------------------------------------

				 $(".filtervariable").click(function(){
			     var jobsurl = jobs_url;
			     var data_val = $(this).attr('data');
			     var data_url_val = jobs_url;

			    $('.clearallfilters').css('display', 'block');
			    $('#jobs-loader').removeClass('displayNone');

			    // TODO
			    if ($('#pagination-id').hasClass('displayNone')) 
		           $('#pagination-id').removeClass('displayNone');   

			    $('.listings-block').css('display', 'none');
			     var dataval = [];
			     var jobtypeval = [];
			     $(".filtervariable:checked").each(function(){
			           dataval.push($(this).val());
			           jobtypeval.push($(this).attr('data'));
			         });        
			        var postData = {srch_location_val: dataval, job_type_value : jobtypeval};

			        $('#filterHeadlineId').addClass('displayNone');
			     // console.log('AJAX DATA:');
			     // console.log(postData);
			     // console.log('------------------');

			        $.ajax({
			                type: "GET",
			                url: jobsurl,
			                async: true,
			                data: postData,
			                cache: false,
			               success: function(res)
			                {                            
			                    $('#jobs-loader').addClass('displayNone'); 

			                    $('.listings-block').css('display', 'block');
			                    var serch_typee = $(res).find('div.search_typee').html();                            
			                     if (!$.trim(serch_typee)){ 
			                            $('.clearallfilters').css('display', 'none');
			                            $("#jobtypee").html(latestJobsTrans);
			                        }else{
			                            $("#jobtypee").html(serch_typee);
			                        }
			                    var resultt = $(res).find('ul.search-ajax-content').html();
			                    $("#showres").html(resultt);                                
			                }
			        });        
			   });

		// ---------------------------------------------------------------------------------------------

				$(".clearallfilters").click(function(){

					    var jobsurl = jobs_url;
					     var data_val = $(this).attr('data');
					     var data_url_val = jobs_url;
					    $('.clearallfilters').css('display', 'block');
					    $('#jobs-loader').removeClass('displayNone');
		    		    if ($('#pagination-id').hasClass('displayNone'))
                        	$('#pagination-id').removeClass('displayNone');   

					    $('.listings-block').css('display', 'none');
					     var dataval = [];
					     var jobtypeval = [];
					     $(".typeval:checked").each(function(){
						           //dataval.push($(this).val());
						           //jobtypeval.push($(this).attr('data'));
						 });

						var postData = {srch_type_val: dataval, job_type_value : jobtypeval};
				        jQuery.ajax({
				                type: "GET",
				                url: jobsurl,
				                async: true,
				                data: postData,
				                cache: false,
				               success: function(res)
				                {                            
				                   $('#jobs-loader').addClass('displayNone');
				                   $('.listings-block').css('display', 'block');
				                   $('.clearallfilters').css('display', 'none');
				                    var serch_typee = $(res).find('div.search_typee').html();  

				                    $("#jobtypee").html(latestJobsTrans);
				                    var resultt = $(res).find('ul.search-ajax-content').html();
				                    $("#showres").html(resultt);
				                    $('.filtervariable').attr('checked', false);                               
				                }
				        });        
				  });

		}

	}
           
})();
