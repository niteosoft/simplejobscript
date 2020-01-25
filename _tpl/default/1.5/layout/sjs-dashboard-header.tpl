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
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="{if $seo_title}{$seo_title}{else}{$html_title}{/if}" />
  <meta property="og:description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}" />
  <meta property="og:url" content="{$MAIN_URL}" />
  <meta property="og:site_name" content="{$SITE_NAME}" />
  <meta property="og:image" content="{$MAIN_URL}share-image.png" />

  <!-- twitter metatags -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:description" content="{if $seo_desc}{$seo_desc}{else}{$meta_description}{/if}"/>
  <meta name="twitter:title" content="{if $seo_title}{$seo_title}{else}{$html_title}{/if}"/>
  <!-- add your twitter site 
  <meta name="twitter:site" content="@yourbrand"/>
  --> 
  <meta name="twitter:domain" content="{$SITE_NAME}"/>
  <meta name="twitter:image" content="{$MAIN_URL}share-image.png" />

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

/* color customizer */
.candidate-v2 .col-md-2 li.active, .candidate-v2 .col-md-2 li:hover, .candidate-v2 .col-md-2 li:focus {
  background-color: rgba{$CUSTOMIZER_COLOR_RGBA} !important;
}
.nav-reg ul li a:hover, .nav-reg ul li a:focus, .employer-dashboard .activity .boxes h5, #editCompanyLabel, .action-req .caution p span, .caution .fa-check, .job-table a:hover, .job-table a:focus, .job-table a:focus, .applications-table a:hover, .applications-table a:focus, .job-process .acceptance input.checkbox-custom, .green {
  color: {$CUSTOMIZER_COLOR} !important;
}
.side-collapse, .candidate-v2 .col-md-2, .tag {
  background: {$CUSTOMIZER_COLOR} !important;
}
.btn, .checkbox-green, .checkbox-green:checked {
  background: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.btn:hover, .btn:focus {
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}
.btn-green:hover, .btn-green:focus {
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
  border: 1px solid {$CUSTOMIZER_COLOR} !important;
}
.btn-gray {
  background: #EEEEEE !important;
}
.btn-gray:hover, .btn-gray:focus {
  background: #EEEEEE !important;
  color: #4A4A4A !important;
}

#pagination-id .btn {
  background: #C7C7C7 !important;
}

#pagination-id .active {
  background: {$CUSTOMIZER_COLOR} !important;
}

#pagination-id .btn-next, #pagination-id .btn-more {
  border: 2px solid {$CUSTOMIZER_COLOR} !important;
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
}

#pagination-id .btn:hover {
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
}

#pagination-id .btn-next:hover, #pagination-id .btn-more:hover {
  border: 2px solid {$CUSTOMIZER_COLOR} !important;
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}

.navbar-toggle {
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.navbar-inverse .navbar-toggle .icon-bar, .job-process .btn-tab {
  background-color: #fff !important;
}
.employer-dashboard .activity .boxes, #editCompanyLabel, .action-req .caution, .job-process .btn-tab, .checkbox-custom {
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.checkbox-custom:checked, .checkbox-custom:checked:after, #ppLabel {
  color: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.taggle_list .taggle, .job-process .btn-primary {
  background: {$CUSTOMIZER_COLOR} !important;
}

.taggle_list .taggle:hover, .taggle_list .taggle:focus {
   color: {$CUSTOMIZER_COLOR} !important;
   border-color: {$CUSTOMIZER_COLOR} !important;
}
.applications-table a:hover, .applications-table a:focus {
  color: {$CUSTOMIZER_COLOR} !important;
}
.job-process .btn-primary:hover, ul.jatul li a:hover {
  color: #fff !important;
}

@media only screen and (max-device-width: 767px) and (min-device-width: 240px){
  .nav > li {
    border-color: rgba{$CUSTOMIZER_COLOR_RGBA} !important;
  }
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

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{$BASE_URL}js/jquery.confirm.min.js"></script>

</head>

<body>

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
              <li><a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}">{$translations.dashboard_recruiter.top_menu_postajob}</a></li>

              <li><a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_JOBS}">{$translations.dashboard_recruiter.top_menu_myjobs}</a></li>

              <li><a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_APPLICATIONS}">{$translations.dashboard_recruiter.top_menu_applications}{if $NOTIFICATION}<span class="badge notification">{$translations.job_detail_section.new}</span>{/if}</a></li>

              {if $PAYMENT_MODE == '2' or $PAYMENT_MODE == '3'}
               {if $SHOW_INVOICE_MENU}
                  <li><a href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_INVOICES}">&nbsp;&nbsp;&nbsp;{$translations.dashboard_recruiter.top_menu_invoices}{if $NEW_INVOICE}<span class="badge notification">{$translations.job_detail_section.new}</span>{/if}</a></li>
                {/if}
              {/if}

              <li><a class="dash-menu-a" href="/{$URL_LOGOUT}" >{$translations.dashboard_recruiter.top_menu_logout}</a></li>
              
            </ul>
          </nav>
        </div>
      </div>
</header> <!-- main-menu-->

<div class="navbar-ur navbar-ur1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 col-xs-12 nav-menu">
        <img class="site-logo" src="{$BASE_URL}{$SITE_LOGO_PATH}" alt="Website's Logo">
      </div>
      <div class="col-md-6 col-xs-12 nav-reg nav-reg-dash">
        <ul>

          <li><a class="dash-menu-a" href="/{$URL_LOGOUT}" >{$translations.dashboard_recruiter.top_menu_logout}</a></li>

          {if $PAYMENT_MODE == '2' or $PAYMENT_MODE == '3'}
           {if $SHOW_INVOICE_MENU}
               <li><a class="dash-menu-a" href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_INVOICES}" >&nbsp;&nbsp;&nbsp;{$translations.dashboard_recruiter.top_menu_invoices}{if $NEW_INVOICE}<span class="badge notification">{$translations.job_detail_section.new}</span>{/if}</a></li>
            {/if}
          {/if}

          <li><a class="dash-menu-a" href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_APPLICATIONS}" >{$translations.dashboard_recruiter.top_menu_applications}{if $NOTIFICATION}<span class="badge notification">{$translations.job_detail_section.new}</span>{/if}</a></li>

          <li><a class="dash-menu-a" href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_JOBS}" >{$translations.dashboard_recruiter.top_menu_myjobs}</a></li>

          <li><a class="dash-menu-a" href="/{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}" >{$translations.dashboard_recruiter.top_menu_postajob}</a></li>

        </ul>
      </div>
    </div>
  </div>
</div>

<div class="responsive-logo row">
<img src="{$BASE_URL}{$SITE_LOGO_PATH}" alt="Website's Logo">
</div>