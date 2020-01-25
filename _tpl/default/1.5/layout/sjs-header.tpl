<!doctype html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
	<title>{if $seo_title}{$seo_title}{else}{$html_title}{/if}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

  <meta name="description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}" />
  <meta name="keywords" content="{if $seo_keys}{$seo_keys}{else}{$meta_keywords}{/if}" />

    <!-- 
   Chrome and Opera Icons - to add support create your icon with different resolutions. Default is 192x192
     <link rel="icon" sizes="192x192" href="{$BASE_URL}fav.png" >
    <link rel="icon" sizes="144x144" href="{$BASE_URL}fav-144.png" >
    <link rel="icon" sizes="96x96" href="{$BASE_URL}fav-96.png" >
    <link rel="icon" sizes="48x48" href="{$BASE_URL}fav-48.png" >
  -->
  <link rel="icon" href="{$BASE_URL}fav.png" >
  <!-- 
   Apple iOS icons
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
  -->
  <link rel="apple-touch-icon" href="{$BASE_URL}fav-ios.png">
  <!-- iOS startup image -->
  <link rel="apple-touch-startup-image"  href="{$BASE_URL}fav-startup.png">
  <!-- Apple additional meta tags -->
  <meta name="apple-mobile-web-app-title" content="{if $seo_title}{$seo_title}{else}{$html_title}{/if}">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <!-- Android web app capable -->
  <meta name="mobile-web-app-capable" content="yes">
  <!-- IE & Windows phone pin icons. Almost same size like ios so it is reused -->
  <meta name="msapplication-square150x150logo" content="fav-ios.png">

  <!-- facebook meta tags for sharing -->

{if $job_url}
  <meta property="og:type"  content="website" />
  <meta property="og:url"  content="{$job_url}" />
  <meta property="og:title" content="{$seo_title}" />
  <meta property="og:description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}" />
  <meta property="og:site_name" content="{$SITE_NAME}"/>
  <meta property="og:image" content="{$PROTOCOL_URL}{$job.company_logo_path}" />
{else}
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{if $seo_title}{$seo_title}{else}{$html_title}{/if}" />
  <meta property="og:description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}" />
  <meta property="og:url" content="{$PROTOCOL_URL}" />
  <meta property="og:site_name" content="{$SITE_NAME}" />
  <meta property="og:image" content="{$PROTOCOL_URL}share-image.png" />
{/if}

  <!-- twitter metatags -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}"/>
  <meta name="twitter:title" content="{if $seo_title}{$seo_title}{else}{$html_title}{/if}"/>
  <!-- add your twitter site 
  <meta name="twitter:site" content="@yourbrand"/>
  --> 
  <meta name="twitter:domain" content="{$SITE_NAME}"/>
  <meta name="twitter:image" content="{$PROTOCOL_URL}share-image.png" />
  <meta http-equiv="X-UA-Compatible" content="IE=11">

  <!-- RSS -->
  <link rel="alternate" type="application/rss+xml" title="{$SITE_NAME} RSS Feed" href="{$BASE_URL}rss">
  

  <!-- CSS -->

  <!--
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> -->

  <!-- Attached CSS -->
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/pricing/price-tables.css" type="text/css" />
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/style.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/reset.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/font-awesome.min.css">

  <link href="{$BASE_URL}js/tags/tagl/assets/css/taggle.css" rel="stylesheet">
  <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/dev.css" rel="stylesheet">
  <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/sjs-updates.css" rel="stylesheet">

  <noscript>{$translations.website_general.noscript_msg}</noscript>
  
<style type="text/css">
{$custom_css}

.splash { background-image: url('{$BASE_URL}{$jobs_subheader_bg_path}') !important; }
/* color customizer */
.static-page strong, .footer ul li a:hover, .footer ul li a:focus, .nav-menu ul li a:hover, .nav-menu ul li a:focus, .nav-reg ul li a:hover, .nav-reg ul li a:focus, .navbar-ur .row .nav-menu .fa, #package-wrapper .trial, #package-wrapper li::before, .rss-ul li a, .green, .signup-page .si-emp:hover, .signup-page .si-emp:focus, .checkbox-custom:checked:after, .action-req .caution p span, .search-filter .filter-menu .fa, div.filterHeadline, a.btn-ns:hover, a.btn-ns:focus, a.btn-eu:hover, a.btn-eu:focus, .detail-font strong, .limr, #applicantCvLabel:hover, #applicantCvLabel:focus, #applicantCvLabel {
  color: {$CUSTOMIZER_COLOR} !important;
}
.navbar-ur .row .nav-reg ul #sign-up-btn, .checkbox-custom, .create-profile .row .tos input, #jobpopup .tos input, .subscribe-tos input, #applicantCvLabel:hover, #applicantCvLabel:focus, #applicantCvLabel {
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.contact-us .btn, #pricing-btn, .btn, .signup-page .su-emp, .checkbox-green:checked {
  background: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}

.contact-us .btn:hover, .contact-us .btn:focus, #pricing-btn:hover, #pricing-btn:focus, .btn:hover, .btn:focus, .signup-page .su-emp:hover, .signup-page .su-emp:focus, .btn-back, .btn-social {
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}
#package-wrapper .brilliant {
   color: {$CUSTOMIZER_COLOR} !important;
   border-color: {$CUSTOMIZER_COLOR} !important;
}
#package-wrapper .price {
 color: #565656 !important;
}
#package-wrapper .brilliant::before {
  border-color: {$CUSTOMIZER_COLOR} transparent transparent transparent !important;
}
.taggle_list .taggle, .side-collapse, .navbar-inverse .navbar-nav>.open>a:hover, .navbar-inverse .navbar-nav>.open>a:focus, .candidate-v2 .col-md-2 {
  background: {$CUSTOMIZER_COLOR} !important;
}
.taggle_list .taggle:hover, .taggle_list .taggle:focus, #cvLabel, .action-req .caution, .action-req .caution .fa-exclamation-triangle, .checkbox-green, div#jobtypee p, .clearallfilters span {
   color: {$CUSTOMIZER_COLOR} !important;
   border-color: {$CUSTOMIZER_COLOR} !important;
}
.pagination-cl .center-btn .btn-pg, .pagination-cl .center-btn .btn {
  background: #C7C7C7 !important;
}
.pagination-cl .center-btn .btn:hover, .pagination-cl .center-btn .btn:focus {
  color: #fff !important;
  background: {$CUSTOMIZER_COLOR} !important;
}

.pagination-cl .center-btn .active {
  background: {$CUSTOMIZER_COLOR} !important;
}
.btn-next, .btn-back:hover, .btn-back:focus, .btn-social:hover, .btn-social:focus, #jobpopup .btn-ns.active, #jobpopup .btn-eu.active, #jobpopup .btn-modal-a, .navbar-toggle {
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
  border-color: {$CUSTOMIZER_COLOR} !important; 
}
#jobpopup .btn-modal-c:hover , #jobpopup .btn-modal-c:focus {
  color: #4A4A4A !important;
}
.btn-next:hover, .btn-next:focus {
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}
#jobpopup .btn-modal-c {
  background: #EEEEEE !important;
}
.candidate-v2 .col-md-2 li.active, .candidate-v2 .col-md-2 li:hover, .candidate-v2 .col-md-2 li:focus  {
  background-color: rgba{$CUSTOMIZER_COLOR_RGBA} !important;
}
.navbar-inverse .navbar-toggle .icon-bar {
  background-color: #fff !important;
}

@media only screen and (max-device-width: 767px) and (min-device-width: 240px){
  .nav > li {
    border-color: rgba{$CUSTOMIZER_COLOR_RGBA} !important;
  }
}
input#keywords {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: 42px; 
    margin-bottom: 30px;
    padding: 0 20px;
}

input#subscribe_email{
  -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: 42px; 
    margin-bottom: 30px;
    padding: 0 20px;

}
.form-group.position input#landing_title{
    box-sizing: border-box;
    height: 46px; 
    padding: 0 10px;
}
</style>

<script src="{$BASE_URL}_tpl/{$THEME}/1.5/js/jquery.min.js"></script>
<script src="{$BASE_URL}_tpl/{$THEME}/1.5/js/bootstrap.min.js"></script>

  <!--
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->

  <!--fallback jquery
  <script>if (!window.jQuery) { document.write('<script src="{$BASE_URL}js/jquery-1.11.2.min.js"><\/script>'); }</script>-->
  
  <!--
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <!--fallback bootstrap-
  <script>$.fn.modal || document.write('<script src="{$BASE_URL}js/bootstrap/js/bootstrap.min.js"><\/script>')</script>->

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
  <!--[if lt IE 9]>
    <script src="{$BASE_URL}js/bootstrap/vendor/html5shiv.js"></script>
    <script src="{$BASE_URL}js/bootstrap/vendor/respond.min.js"></script>
  <![endif]-->

{literal}
<script type="text/javascript">
    window.cookieconsent_options = {"message":"{/literal}{$translations.cookie.message}{literal}","dismiss":"{/literal}{$translations.cookie.accept_message}{literal}","learnMore":"{/literal}{$translations.cookie.more_info}{literal}","link":"/privacy-policy","theme":"light-bottom"};
</script>
{/literal}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>

{if $INDEED == 'activated'}
<script type="text/javascript" src="https://gdc.indeed.com/ads/apiresults.js"></script>         
{/if}

</head>

<body itemscope itemtype="http://schema.org/Product">

<div class="page-loader"></div>

<!-- enclosed in the footer -->
<div id="wrapper">

<!-- //////////////// NAVBAR-UR ///////////// -->

<header role="banner" class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button data-toggle="collapse-side" data-target=".side-collapse" data-target-2=".side-collapse-container" type="button" class="navbar-toggle pull-left"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="side-collapse in">
          <nav role="navigation" class="navbar-collapse">
            <ul class="nav navbar-nav">


              <li><a id="mob-menu-jobs" data-toggle="dropdown" href="#">{$translations.website_general.top_menu_jobs} &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="mob-menu-jobs">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_JOBS}">{$translations.website_general.top_menu_all_jobs}</a></li>
                  {if $INDEED == 'deactivated' OR $INDEED_BOTH_JOBS_FLAG}
                    {if $FAVORITES_PLUGIN and $FAVORITES_PLUGIN == 'true'}
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_JOBS}/{$URL_FAVOURITES}">{$translations.website_general.top_menu_my_jobs}</a></li>
                    {/if}
                  {/if}
                </ul>
              </li>

              {if $INDEED == 'deactivated' OR $INDEED_BOTH_JOBS_FLAG}
               <li><a href="{$BASE_URL}{$URL_COMPANIES}">{$translations.website_general.top_menu_companies}</a></li>
              {/if}

              {if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
               <li><a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}">{$translations.website_general.top_menu_addcv}</a></li>
              {/if}

              {if not $SESSION_APPLICANT}
              <li><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}">{$translations.dashboard_recruiter.top_menu_postajob}</a></li>
              {/if}

              {if $SESSION_USERNAME or $SESSION_APPLICANT}
                {if $SESSION_APPLICANT}
                  <li><a href="{$BASE_URL}{$URL_PROFILE}">{$translations.website_general.goto_account_msg}</a></li>
                {/if}
                {if $SESSION_USERNAME}
                <li><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_OVERVIEW}">{$translations.website_general.goto_account_msg}</a></li>
                {/if}
              {else}
                <li><a id="mob-menu-sign-in" data-toggle="dropdown" href="#">{$translations.website_general.sign_in} &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="mob-menu-sign-in">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_LOGIN_RECRUITERS}">{$translations.website_general.top_menu_recruiters}</a></li>

                     {if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_LOGIN_APPLICANTS}">{$translations.website_general.top_menu_applicants}</a></li>
                    {/if}

                  </ul>
                </li>

                <li><a href="{$BASE_URL}{$URL_SIGN_UP}" id="sign-up-btn">{$translations.website_general.top_menu_register_label}</a></li>
              {/if}

            </ul>
          </nav>
        </div>
      </div>
</header> <!-- main-menu-->

<div class="navbar-ur navbar-ur1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 nav-menu">
        <a href="{$BASE_URL}"><img style="width: {$jobs_logo_width}; padding: {$jobs_logo_padding};" class="site-logo" src="{$BASE_URL}{$SITE_LOGO_PATH}" alt="Website's Logo"></a>
        <ul class="nm-ul">

          <li class="il-list">
          <a id="menu1" data-toggle="dropdown">{$translations.website_general.top_menu_jobs} &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_JOBS}">{$translations.website_general.top_menu_all_jobs}</a></li>
                  {if $INDEED == 'deactivated' OR $INDEED_BOTH_JOBS_FLAG}
                    {if $FAVORITES_PLUGIN and $FAVORITES_PLUGIN == 'true'}
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_JOBS}/{$URL_FAVOURITES}">{$translations.website_general.top_menu_my_jobs}</a></li>
                    {/if}
                  {/if}
            </ul>
          </li>

          {if $INDEED == 'deactivated' OR $INDEED_BOTH_JOBS_FLAG}
          <li class="il-list"><a href="{$BASE_URL}{$URL_COMPANIES}">{$translations.website_general.top_menu_companies}</a></li>
          {/if}

          {if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
          <li class="il-list"><a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}">{$translations.website_general.top_menu_addcv}</a></li>
          {/if}

          {if not $SESSION_APPLICANT}
          <li class="il-list"><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}">{$translations.dashboard_recruiter.top_menu_postajob}</a></li>
          {/if}

        </ul>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 nav-reg">
        <ul>

              {if $SESSION_USERNAME or $SESSION_APPLICANT}
                {if $SESSION_APPLICANT}
                  <li><a href="{$BASE_URL}{$URL_PROFILE}">{$translations.website_general.goto_account_msg}</a></li>
                {/if}
                {if $SESSION_USERNAME}
                <li><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_OVERVIEW}">{$translations.website_general.goto_account_msg}</a></li>
                {/if}
              {else}

                <li><a href="{$BASE_URL}{$URL_SIGN_UP}" id="sign-up-btn">{$translations.website_general.top_menu_register_label}</a></li>

                <li class="il-list">
                <a id="menu2" data-toggle="dropdown" id="sign-in-btn">{$translations.website_general.sign_in} &nbsp;<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="menu2">
                    <li class="r-m" role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_LOGIN_RECRUITERS}">{$translations.website_general.top_menu_recruiters}</a></li>

                    {if $PROFILES_PLUGIN == 'true' and $jobs_candidates_on_flag == '1'}
                    <li class="r-m" role="presentation"><a role="menuitem" tabindex="-1" href="{$BASE_URL}{$URL_LOGIN_APPLICANTS}">{$translations.website_general.top_menu_applicants}</a></li>
                    {/if}

                  </ul>
                </li>

              {/if}
          
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="responsive-logo row">
  <img style="width: {$jobs_logo_width_mobile}; padding: {$jobs_logo_padding};" src="{$BASE_URL}{$SITE_LOGO_PATH}" alt="Website's Logo">
</div>