{include file="header.tpl"}
		
<div class="admin-content">
 <div class="admin-wrap-content">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
	<label class="admin-label">SJS CUSTOMIZER</label>
	<div class="subheading">Build your landing page</div>
	<p>(<a style="opacity: 0.8;" href="{$BASE_URL_ADMIN}customizer/">&larr;go back</a>)</p>
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt25">
	    <form method="post" action="{$BASE_URL_ADMIN}customize-homepage" role="form" enctype="multipart/form-data">

			<div class="form-group" >
			   <label class="customizer-headline">HEADER SECTION</label> <br /><br />

			   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mb25">

			   		<label>Background image</label><br />

				   	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<label id="bannerLabel" for="general_homepage_bgimage_path">Upload new</label>
					 	<input type="file" name="general_homepage_bgimage_path" id="general_homepage_bgimage_path" class="form-control inputfile minput" />
					 	<div class="textarea-feedback" >[recommended size ratio 1600x567]</div>
			 	
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<img width="250" src="{$BASE_URL}{$customizer_data.general_homepage_bgimage_path}" />
					</div>

				</div>
				<br /><br /><br />

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
				   <label>Logo width (use "%" or "px")</label>
				   <input value="{$customizer_data.general_homepage_logo_w}" class="form-control" type="text" name="general_homepage_logo_w" id="general_homepage_logo_w" size="100" />
				   <br />

				   <label>Logo margin</label>
				   <input value="{$customizer_data.general_homepage_logo_margin}" class="form-control" type="text" name="general_homepage_logo_margin" id="general_homepage_logo_margin" size="100" />
				   <br />

				   <label>Title</label>
				   <input value="{$customizer_data.header_title}" class="form-control" type="text" name="header_title" id="header_title" size="200" />
				   <br />

				   
				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">

				   <label>Subtitle</label>
				   <input value="{$customizer_data.header_subtitle}" class="form-control" type="text" name="header_subtitle" id="header_subtitle" size="200" />
				   <br />

					<label>What title</label>
				   <input value="{$customizer_data.header_what_title}" class="form-control" type="text" name="header_what_title" id="header_what_title" size="200" />
				   <br />

				   <label>What placeholder</label>
				   <input value="{$customizer_data.header_what_placeholder}" class="form-control" type="text" name="header_what_placeholder" id="header_what_placeholder" size="200" />
				   <br />

				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
				  <label>Where title</label>
				   <input value="{$customizer_data.header_where_title}" class="form-control" type="text" name="header_where_title" id="header_where_title" size="200" />
				   <br />

				   <label>Search button label</label>
				   <input value="{$customizer_data.header_search_btn_title}" class="form-control" type="text" name="header_search_btn_title" id="header_search_btn_title" size="200" />
				   <br />
				</div>

				<br /><br />

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">CANDIDATES SECTION</label><br />
					   <input type="checkbox" name="candidates_on_flag" id="candidates_on_flag" data-size="mini" {if $customizer_data.candidates_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Title</label>
					   <input value="{$customizer_data.candidates_headline}" class="form-control cms-input" type="text" name="candidates_headline" id="candidates_headline" />
					   <br />
					 </div>

					  <div class="col-8-12 col-md-8 col-sm-12 col-xs-12 mlpl0">
						   <label>Subtitle</label>
						   <input value="{$customizer_data.candidates_subheadline}" class="form-control cms-input" type="text" name="candidates_subheadline" id="candidates_subheadline" size="200" />
						   <br />
					   </div>
					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						<label>First column title</label>
					   <input value="{$customizer_data.candidates_firstcol_headline}" class="form-control cms-input" type="text" name="candidates_firstcol_headline" id="candidates_firstcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>First column subtitle</label>
					   <input value="{$customizer_data.candidates_firstcol_subheadline}" class="form-control cms-input" type="text" name="candidates_firstcol_subheadline" id="candidates_firstcol_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Second column title</label>
					   <input value="{$customizer_data.candidates_secondcol_headline}" class="form-control cms-input" type="text" name="candidates_secondcol_headline" id="candidates_secondcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>Second column subtitle</label>
					   <input value="{$customizer_data.candidates_secondcol_subheadline}" class="form-control cms-input" type="text" name="candidates_secondcol_subheadline" id="candidates_secondcol_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Third column title</label>
					   <input value="{$customizer_data.candidates_thirdcol_headline}" class="form-control cms-input" type="text" name="candidates_thirdcol_headline" id="candidates_thirdcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>Third column subtitle</label>
					   <input value="{$customizer_data.candidates_thirdcol_subheadline}" class="form-control cms-input" type="text" name="candidates_thirdcol_subheadline" id="candidates_thirdcol_subheadline" size="200" />
					   <br />
					   </div>



					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip title</label>
					   <input value="{$customizer_data.candidates_strip_headline}" class="form-control cms-input" type="text" name="candidates_strip_headline" id="candidates_strip_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip subtitle</label>
					   <input value="{$customizer_data.candidates_strip_subheadline}" class="form-control cms-input" type="text" name="candidates_strip_subheadline" id="candidates_strip_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip button label</label>
					   <input value="{$customizer_data.candidates_strip_btn_title}" class="form-control cms-input" type="text" name="candidates_strip_btn_title" id="candidates_strip_btn_title" size="200" />
					   <br />
					   </div>

					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">EMPLOYER SECTION</label><br />
					   <input type="checkbox" name="employers_on_flag" id="employers_on_flag" data-size="mini" {if $customizer_data.employers_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Title</label>
					   <input value="{$customizer_data.employers_headline}" class="form-control cms-input" type="text" name="employers_headline" id="employers_headline" />
					   <br />
					 </div>

					  <div class="col-8-12 col-md-8 col-sm-12 col-xs-12 mlpl0">
						   <label>Subtitle</label>
						   <input value="{$customizer_data.employers_subheadline}" class="form-control cms-input" type="text" name="employers_subheadline" id="employers_subheadline" size="200" />
						   <br />
					   </div>
					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						<label>First column title</label>
					   <input value="{$customizer_data.employers_firstcol_headline}" class="form-control cms-input" type="text" name="employers_firstcol_headline" id="employers_firstcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>First column subtitle</label>
					   <input value="{$customizer_data.employers_firstcol_subheadline}" class="form-control cms-input" type="text" name="employers_firstcol_subheadline" id="employers_firstcol_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Second column title</label>
					   <input value="{$customizer_data.employers_secondcol_headline}" class="form-control cms-input" type="text" name="employers_secondcol_headline" id="employers_secondcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>Second column subtitle</label>
					   <input value="{$customizer_data.employers_secondcol_subheadline}" class="form-control cms-input" type="text" name="employers_secondcol_subheadline" id="employers_secondcol_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Third column title</label>
					   <input value="{$customizer_data.employers_thirdcol_headline}" class="form-control cms-input" type="text" name="employers_thirdcol_headline" id="employers_thirdcol_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
					   <label>Third column subtitle</label>
					   <input value="{$customizer_data.employers_thirdcol_subheadline}" class="form-control cms-input" type="text" name="employers_thirdcol_subheadline" id="employers_thirdcol_subheadline" size="200" />
					   <br />
					   </div>



					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip title</label>
					   <input value="{$customizer_data.employers_strip_headline}" class="form-control cms-input" type="text" name="employers_strip_headline" id="employers_strip_headline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip subtitle</label>
					   <input value="{$customizer_data.employers_strip_subheadline}" class="form-control cms-input" type="text" name="employers_strip_subheadline" id="employers_strip_subheadline" size="200" />
					   <br />
					   </div>

					   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Strip button label</label>
					   <input value="{$customizer_data.employers_strip_btn_title}" class="form-control cms-input" type="text" name="employers_strip_btn_title" id="employers_strip_btn_title" size="200" />
					   <br />
					   </div>

					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">ABOUT SECTION</label><br />
					   <input type="checkbox" name="about_on_flag" id="about_on_flag" data-size="mini" {if $customizer_data.about_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Title</label>
					   <input value="{$customizer_data.about_headline}" class="form-control cms-input" type="text" name="about_headline" id="about_headline" />
					   <br />
					 </div>

					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Button label</label>
					   <input value="{$customizer_data.about_readmore_btn_title}" class="form-control cms-input" type="text" name="about_readmore_btn_title" id="about_readmore_btn_title" />
					   <br />
					 </div>

					  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mlpl0">
						   <label>Subtitle</label>
						   <input value="{$customizer_data.about_subheadline}" class="form-control cms-input" type="text" name="about_subheadline" id="about_subheadline" size="200" />
						   <br />
					   </div>

					   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
					   		<label>Left column text</label><br />
					   		<textarea name="about_leftcol" id="about_leftcol" rows="5" cols="110" class="grayTa noTinymceTA">{$customizer_data.about_leftcol}</textarea>
					   		<br /> <br />
					   </div>

					   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
					   		<label>Right column text</label><br />
					   		<textarea name="about_rightcol" id="about_rightcol" rows="5" cols="110" class="grayTa noTinymceTA">{$customizer_data.about_rightcol}</textarea>
					   		<br /> <br />
					   </div>
			
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">TESTIMONIALS SECTION</label><br /><br />
					   <div class="subheading">Only headline can be changed here as there can be many images and texts rotating. Open "_tpl/default/index.tpl" in file manager and look for "TESTIMONIAL". You can change the content in file directly. </div>
					   <input type="checkbox" name="test_on_flag" id="test_on_flag" data-size="mini" {if $customizer_data.test_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Title</label>
					   <input value="{$customizer_data.test_headline}" class="form-control cms-input" type="text" name="test_headline" id="test_headline" />
					   <br />
					 </div>

				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">PARTNERS SECTION</label><br />
					   <input type="checkbox" name="partners_on_flag" id="partners_on_flag" data-size="mini" {if $customizer_data.partners_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
			   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mb25">

			   		<label>Partners image</label><br />

				   	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<label id="partnersBannerLabel" for="partners_bgimage_path">Upload new</label>
					 	<input type="file" name="partners_bgimage_path" id="partners_bgimage_path" class="form-control inputfile minput" />
					 	<div class="textarea-feedback" >[tip: add 1 image with all company images in it]</div>
			 	
					</div>

					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						<img width="250" src="{$BASE_URL}{$customizer_data.partners_bgimage_path}" />
					</div>

				</div>
				<br /><br /><br />

					 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
					   <label>Title</label>
					   <input value="{$customizer_data.partners_headline}" class="form-control cms-input" type="text" name="partners_headline" id="partners_headline" />
					   <br />
					 </div>

				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">TAKE ACTION SECTION</label><br />
					   <input type="checkbox" name="ta_on_flag" id="ta_on_flag" data-size="mini" {if $customizer_data.ta_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

					 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
					   <label>Employers title</label>
					   <input value="{$customizer_data.ta_emp_headline}" class="form-control cms-input" type="text" name="ta_emp_headline" id="ta_emp_headline" />
					   <br />
					 </div>

					  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						   <label>Employers button label</label>
						   <input value="{$customizer_data.ta_emp_btn_label}" class="form-control cms-input" type="text" name="ta_emp_btn_label" id="ta_emp_btn_label" size="200" />
						   <br />
					   </div>

					 <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mlpl0">
					   <label>Employers subtitle</label>
					   <input value="{$customizer_data.ta_emp_subheadline}" class="form-control cms-input" type="text" name="ta_emp_subheadline" id="ta_emp_subheadline" />
					   <br />
					 </div>

					 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
					   <label>Candidates title</label>
					   <input value="{$customizer_data.ta_can_headline}" class="form-control cms-input" type="text" name="ta_can_headline" id="ta_can_headline" />
					   <br />
					 </div>

					  <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
						   <label>Candidates button label</label>
						   <input value="{$customizer_data.ta_can_btn_label}" class="form-control cms-input" type="text" name="ta_can_btn_label" id="ta_can_btn_label" size="200" />
						   <br />
					   </div>

					 <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 mlpl0">
					   <label>Candidates subtitle</label>
					   <input value="{$customizer_data.ta_can_subheadline}" class="form-control cms-input" type="text" name="ta_can_subheadline" id="ta_can_subheadline" />
					   <br />
					 </div>
			
					</div>
				</div>


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">STATS SECTION</label><br />
					   <input type="checkbox" name="stats_on_flag" id="stats_on_flag" data-size="mini" {if $customizer_data.stats_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
		
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
							 <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mlpl0">
								   <label>Headline</label>
								   <input value="{$customizer_data.stats_headline}" class="form-control cms-input" type="text" name="stats_headline" id="stats_headline"  />
								   <br />
							  </div>
						</div>
					 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">

						  <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
							   <label>First column number</label>
							   <input value="{$customizer_data.stats_first_numb}" class="form-control cms-input" type="text" name="stats_first_numb" id="stats_first_numb" />
							   <br />
						  </div>

						 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						   <label>First column title</label>
						   <input value="{$customizer_data.stats_first_col}" class="form-control cms-input" type="text" name="stats_first_col" id="stats_first_col" />
						   <br />
						 </div>

						 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
							   <label>Second column number</label>
							   <input value="{$customizer_data.stats_second_numb}" class="form-control cms-input" type="text" name="stats_second_numb" id="stats_second_numb"  />
							   <br />
						  </div>

						 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						   <label>Second column title</label>
						   <input value="{$customizer_data.stats_sec_col}" class="form-control cms-input" type="text" name="stats_sec_col" id="stats_sec_col" />
						   <br />
						 </div>

						 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
							   <label>Third column number</label>
							   <input value="{$customizer_data.stats_third_numb}" class="form-control cms-input" type="text" name="stats_third_numb" id="stats_third_numb" />
							   <br />
						  </div>

						 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						   <label>Third column title</label>
						   <input value="{$customizer_data.stats_third_col}" class="form-control cms-input" type="text" name="stats_third_col" id="stats_third_col" />
						   <br />
						 </div>

						 <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mlpl0">
							   <label>Fourth column number</label>
							   <input value="{$customizer_data.stats_fourth_numb}" class="form-control cms-input" type="text" name="stats_fourth_numb" id="stats_fourth_numb" />
							   <br />
						  </div>

						 <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mlpl0">
						   <label>Fourth column title</label>
						   <input value="{$customizer_data.stats_fourth_col}" class="form-control cms-input" type="text" name="stats_fourth_col" id="stats_fourth_col" />
						   <br />
						 </div>
			
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0 mt40">
					<div class="form-group" >
					   <label class="customizer-headline">LISTINGS SECTION</label><br /><br />

					   <div class="subheading">Titles here come from <a href="{$BASE_URL_ADMIN}translations/" target="_blank">translations</a>. Rest is dynamically generated.</div>

					   <input type="checkbox" name="listings_on_flag" id="listings_on_flag" data-size="mini" {if $customizer_data.listings_on_flag == '1'}checked{/if} /><label style="margin-left: 10px;" class="switch-label mt25">Turn ON/OFF</label>
					</div>
					<br />
				</div>

			</div>
			<br /><br />

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mlpl0">
 				<button style="margin-top: 30px;" type="submit"  class="btn btn-default btn-primary mbtn" name="submit" id="submit" class="mt25" >SAVE</button>
 			</div>

		</form>
    </div>

    </div>
</div>

{literal}
<script type="text/javascript">
		$(document).ready(function() {

		$('#general_homepage_bgimage_path').change(function() {
			var fname = $('input[type=file]').val().split('\\').pop();
			if( fname )
				$('#bannerLabel').html(fname);
			else
				$('#bannerLabel').html($('#bannerLabel').html());
        });

        $('#partners_bgimage_path').change(function() {
			var fname = $('input[type=file]#partners_bgimage_path').val().split('\\').pop();
			if( fname )
				$('#partnersBannerLabel').html(fname);
			else
				$('#partnersBannerLabel').html($('#partnersBannerLabel').html());
        });

        });
</script>
{/literal}

{if $updated == 'true'}
<script type="text/javascript">
   setTimeout(function(){
   	jobberBase.messages.add('Design updated');
   }, 1000);
</script>
{/if}

{include file="footer.tpl"}