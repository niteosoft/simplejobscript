(function(){
	var jobberBase = window.jobberBase = function () {
		var _registered = {};
		return {
			init: function() {
				if (_registered.init) {
					$.each(_registered.init, function(nr, fn){
						fn.call();
					});
				}
			},
			extend: function(prop) {
				for (var i in prop) {
					if (prop[i] != undefined) {
						this[i] = prop[i];
					}
				}
			},

			paymentModeChanged: function (mode, base_url) {

				if (mode == 1) {
					$("#mode-desc").html('').html('Activate <strong>free</strong> mode. Companies can post jobs and access resume database without any restrictions.');
					$("#pm-btn-div").html('');
				} else if (mode == 2) {
					$("#mode-desc").html('').html('Activate <strong>fees</strong> mode. After activation set up the prices in the "Fees Settings" section. Companies will be charged flat fees to post jobs and access resume database.');
					$("#pm-btn-div").html('').html('<a href="' + base_url + 'payment-settings/fees"><button type="submit" class="btn btn-default btn-primary mbtn alizarinBtn" >Fees Settings</button></a>');
				} else if (mode == 3) {
					$("#mode-desc").html('').html('Activate <strong>packages</strong> mode. After activation set up the pricing plans in the "Packages Settings" section. Each company will be assigned an account plan with pre-defined resources (job ads, job ad duration, resume downloads).');
					$("#pm-btn-div").html('').html('<a href="' + base_url + 'payment-settings/packages"><button type="submit" class="btn btn-default btn-primary mbtn alizarinBtn" >Packages Settings</button></a>');
				}

			},

			changeCampaignStatus: function(checked, campaign_id, url) {
				var flag;
				if (checked)
					flag = 1;
				else
					flag = 0;

				$.ajax({
					  type: "POST",
					  url: url,
					  data: "data=" + campaign_id + ":" + flag,
					  success: function(msg) {
						var json = JSON.parse(msg);
						 if (json.result == '0'){
						 	jobberBase.messages.add(json.msg);
						 } else {
						 	jobberBase.messages.add(json.msg);
						 }
						
				}});
				
			},
			register: function(fn, type) {
				if (!_registered[type]) {
					_registered[type] = [];
				}
				_registered[type].push(fn);
			},
			template: function(tpl, callback) {
				return tpl.replace(/\{([\w-]+)(?:\:([\w\.]*)(?:\((.*?)?\))?)?\}/g, callback);
			},
			deleteCity: function(url, cityID)
			{
				if(confirm('Are you sure you want to delete this city?'))
				{
					$.ajax({
					  type: "POST",
					  url: url,
					  data: "cityID=" + cityID,
					  success: function(msg) {
						var json = JSON.parse(msg);
						if (json.result == '0'){
							alert('This city has jobs associated with it! Cannot be deleted!');
						} else {
							setTimeout(function(){
						   	 jobberBase.messages.add('City has been deleted');
						    }, 1000);
							var cityElementID = 'item'+cityID;
							$("#"+cityElementID).remove();
						}
					  }
					  
					});
				}
			},
			editor: {
				initialized: true,
				init: function(full) {
					if (typeof tinyMCE != 'object') {
						return;
					}
					tinyMCE.init({
						mode : "specific_textareas",
						theme : "advanced",
						plugins : full ? "advimage,advlink,contextmenu,paste,table" : "paste",
						theme_advanced_buttons1 : full ? "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,|,pastetext,pasteword" : "bold,italic,underline,strikethrough,|,bullist,numlist,|,outdent,indent,|,link,unlink,image,|,pastetext,pasteword,|,cleanup,code",
						theme_advanced_buttons2 : full ? "bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor" : "",
						theme_advanced_buttons3 : "",
						theme_advanced_toolbar_location : "top",
						theme_advanced_toolbar_align : "left",
						theme_advanced_statusbar_location : "bottom",
						editor_selector : "mceEditor"
					});
					this.initialized = true;
				},
				insertLink: function(path, text) {
					if (typeof tinyMCE != 'object') {
						return;
					}
					var inst = tinyMCE.selectedInstance;
					inst.contentWindow.focus();

					var elm = inst.selection.getNode();
					elm = inst.dom.getParent(elm, "A");
					inst.execCommand('mceBeginUndoLevel');
					var sel = inst.selection.getContent();
					if (elm == null) {
						if (sel != '') {
							inst.execCommand('mceInsertLink',text, path);
						} else {
							tinyMCE.execCommand(
								"mceInsertContent",
								false,
								' <a href="' + path + '">' + text + '</a> '
							);
						}
					} else {
						elm.setAttribute('href',path);
						elm.setAttribute('mce_href',path);
					}
					try {
						inst.selection.collapse(false);
					} catch (ex) {
					}
					inst.execCommand("mceEndUndoLevel");
				}
			}
		}
	}();
	$(jobberBase.init);
})();
