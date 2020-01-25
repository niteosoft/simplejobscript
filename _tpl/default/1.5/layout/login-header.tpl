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
  <meta property="og:url" content="{$PROTOCOL_URL}" />
  <meta property="og:site_name" content="{$SITE_NAME}" />
  <meta property="og:image" content="{$PROTOCOL_URL}share-image.png" />

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
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/style.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/reset.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/font-awesome.min.css">

  <link href="{$BASE_URL}js/tags/tagl/assets/css/taggle.css" rel="stylesheet">
  <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/dev.css" rel="stylesheet">

  <noscript>{$translations.website_general.noscript_msg}</noscript>
  
<style type="text/css">
{$custom_css}
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

<style type="text/css">
.back-arrow a, .login-page .make-account, .checkbox-custom:checked:after {
  color: {$CUSTOMIZER_COLOR} !important;
}
.btn {
  background: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.btn:hover {
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}

.register-employer-page .row .tos input, #logoLabel, #logoLabel:hover{
  color: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
</style>

</head>

<body>
<div class="page-loader"></div>

<!-- enclosed in the footer -->
<div id="wrapper">

{if $PLAIN_SITE == 'true'}
<ul class="nav-back nav navbar-nav pull-left back-arrow" >
  <li><a href="{$BASE_URL}{$URL_SIGN_UP}"><i class="fa fa-chevron-circle-left"></i>&nbsp; {$translations.dashboard_recruiter.back}</a></li>
</ul>
{/if}

{if $PLAIN_SITE_REGISTER == 'true'}
<ul class="nav-back nav navbar-nav pull-left back-arrow" >
  <li><a href="{$BASE_URL}{$URL_SIGN_UP}"><i class="fa fa-chevron-circle-left"></i>&nbsp; {$translations.dashboard_recruiter.back}</a></li>
</ul>
{/if}
