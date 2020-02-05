<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{if $seo_title}{$seo_title}{else}{$html_title}{/if}</title>
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
  <meta name="twitter:site" content="@brand"/>
  --> 
  <meta name="twitter:domain" content="{$SITE_NAME}"/>
  <meta name="twitter:image" content="{$MAIN_URL}share-image.png" />
  
  <!-- RSS -->
  <link rel="alternate" type="application/rss+xml" title="{$SITE_NAME} RSS Feed" href="{$BASE_URL}rss">
 
	<link rel="canonical" href="http://{$BASE_URL}home" />

  <!-- IF ALL STYLES ARE REMOVED EXCEPT BOOTSTRAP, UNCOMMENT THIS STYLE, TO KEEP THE BASIC, WORKING WEB. READY TO BE CUSTOMIZED 
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/css/saveStructure.css" type="text/css" /> -->
  <!-- ######################################################################################################################## -->
	
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/style.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/reset.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/font-awesome.min.css">
  <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/sjs-updates.css" rel="stylesheet">

  <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/dev.css" rel="stylesheet">
<!--   <link href="{$BASE_URL}_tpl/{$THEME}/1.5/css/customizer.css" rel="stylesheet"> -->

	<noscript>{$translations.website_general.noscript_msg}</noscript>

<style type="text/css">
{$custom_css}

div.header { background-image: url('{$BASE_URL}{$general_homepage_bgimage_path}') !important; }
/* color customizer */
#future, #opportunity, .sign-up-section, .btn, .btn-subc, .btn-home-jobs  {
  background: {$CUSTOMIZER_COLOR} !important;
  border-color: {$CUSTOMIZER_COLOR} !important;
}
.btn:hover, .btn-subc:hover, .btn-subc:focus, .btn:focus{
  background: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}
.navbar-ur-lp ul li .sign-up-btn {
  border: 2px solid {$CUSTOMIZER_COLOR} !important;
}
.navbar-ur-lp ul li .sign-up-btn, a.sign-up-btn:hover, a.sign-up-btn:focus, #candidates h3, #about h3, #employers h3, #stats h3 {
  color: {$CUSTOMIZER_COLOR} !important;
}
.btn-view-jobs {
  background-color: #fff !important;
}
.btn-read-more {
  background-color: #fff !important;
  color: {$CUSTOMIZER_COLOR} !important;
}
.btn-read-more:hover, .btn-read-more:focus {
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
}
.testimonial .icon-prev, .testimonial .icon-next, .c-header-right ul li a:hover, .c-header-right ul li a:focus, .footer ul li a:hover, .footer ul li a:focus {
  color: {$CUSTOMIZER_COLOR} !important;
}
.latest-jobs button:hover, .latest-jobs button:focus {
  background: #fff !important;
}
.navbar-toggle {
  background: {$CUSTOMIZER_COLOR} !important;
  color: #fff !important;
  border-color: {$CUSTOMIZER_COLOR} !important; 
}
.navbar-inverse .navbar-toggle .icon-bar {
  background-color: #fff !important;
}
.side-collapse, .navbar-inverse .navbar-nav>.open>a:hover, .navbar-inverse .navbar-nav>.open>a:focus {
  background: {$CUSTOMIZER_COLOR} !important;
}
@media only screen and (max-device-width: 767px) and (min-device-width: 240px){
  .nav > li {
    border-color: rgba{$CUSTOMIZER_COLOR_RGBA} !important;
  }
}
.form-group.position input#landing_title{
    box-sizing: border-box;
    height: 46px; 
    padding: 0 10px;
}
</style>

{literal}
<script type="text/javascript">
    window.cookieconsent_options = {"message":"{/literal}{$translations.cookie.message}{literal}","dismiss":"{/literal}{$translations.cookie.accept_message}{literal}","learnMore":"{/literal}{$translations.cookie.more_info}{literal}","link":"/privacy-policy","theme":"light-bottom"};
</script>
{/literal}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>


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
              <li><a href="{$BASE_URL}{$URL_JOBS}" >{$translations.website_general.top_menu_jobs}</a></li>
              <li><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}" >{$translations.dashboard_recruiter.top_menu_postajob}</a></li>
              {if $PROFILES_PLUGIN == 'true'}
              <li><a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}" >{$translations.website_general.top_menu_addcv}</a></li>
              {/if}
              <li><a href="{$BASE_URL}{$ABOUT_URL}" >{$translations.apply.about}</a></li>
              <li><a href="{$BASE_URL}{$URL_SIGN_UP}" >{$translations.website_general.top_menu_register_label}</a></li>
            </ul>
          </nav>
        </div>
      </div>
</header> <!-- main-menu-->

<div class="header">
  <div class="navbar-ur-lp">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6 col-xs-12 c-header-left">
          <a href="{$BASE_URL}"><img class="site-logo" src="{$BASE_URL}{$SITE_LOGO_PATH}" style="width: {$general_homepage_logo_w}; margin: {$general_homepage_logo_margin};" alt="Website's Logo"></a>
        </div>
        <div class="col-md-6 col-xs-12 c-header-right">
          <ul>
            <li><a href="{$BASE_URL}{$URL_JOBS}" >{$translations.website_general.top_menu_jobs}</a></li>
            <li><a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_POST}" >{$translations.dashboard_recruiter.top_menu_postajob}</a></li>
            {if $PROFILES_PLUGIN == 'true'}
            <li><a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}" >{$translations.website_general.top_menu_addcv}</a></li>
            {/if}
            <li><a href="{$BASE_URL}{$ABOUT_URL}" >{$translations.apply.about}</a></li>
            <li><a href="{$BASE_URL}{$URL_SIGN_UP}"  class="sign-up-btn">{$translations.website_general.top_menu_register_label}</a></li>                
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="header-content">
    <div class="container">
      <div class="row">
        <h1>{$customizer_data.header_title}</h1>
        <h2 class="lps">{$customizer_data.header_subtitle}</h2>
        <div class="row header-filter">
          <div class="col-md-12 col-xs-12">

            <form method="post" action="{$BASE_URL}{$URL_LANDING_SEARCHED}" role="form">

              <div class="hf">
                <div class="form-group position">
                  <label>{$customizer_data.header_what_title}</label>
                  <input placeholder="{$customizer_data.header_what_placeholder}" id="landing_title" name="landing_title" type="text" class="form-control">
                </div>

                {if $REMOTE_PORTAL == 'deactivated'}
                <div class="form-group location">
                  <label>{$customizer_data.header_where_title}</label>
                   <form>
                     <select id="landing_location" name="landing_location">
                        {foreach from=$cities key=id item=value}
                        <option value="{$id}">{$value}</option>
                        {/foreach}
                     </select>   
                   </form>

                </div>
                {/if}

                <button type="submit" class="btn btn-subc ">{$customizer_data.header_search_btn_title}</button>

              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- header-->

<!-- ///////////// MAIN-CONTENT ///////////// -->

{if $more_jobs}
      <div id="candidates">
            <h2>{$translations.alljobs.all_jobs}</h2>
      </div>

      {include file="snippets/homepage-jobs.tpl"}
      <div class="col-md-12 col-xs-12">
        <a href="{$BASE_URL}{$URL_JOBS}" ><button type="button" class="btn btn-subc ">{$translations.companies.view_jobs}</button></a>
      </div>
{/if}


{if $customizer_data.candidates_on_flag == '1'}
<div id="candidates">
  <div class="container">
    <div class="row">
      <h2>{$customizer_data.candidates_headline}</h2>
      <p>{$customizer_data.candidates_subheadline}
      </p>
      
      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand01.png">
        <h3>{$customizer_data.candidates_firstcol_headline}</h3>
        <h4>{$customizer_data.candidates_firstcol_subheadline}</h4>
      </div>

      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand02.png">
        <h3>{$customizer_data.candidates_secondcol_headline}</h3>
        <h4>{$customizer_data.candidates_secondcol_subheadline}</h4>
      </div>

      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand05.png">
        <h3>{$customizer_data.candidates_thirdcol_headline}</h3>
        <h4>{$customizer_data.candidates_thirdcol_subheadline}</h4>
      </div>
    </div>
  </div>
</div>

<div id="future">
  <div class="container">
    <div class="row">   
      <div class="col-md-12 col-xs-12 c-box">
        <h1>{$customizer_data.candidates_strip_headline}</h1>
        <h2>{$customizer_data.candidates_strip_subheadline}</h2>
        <a href="{$BASE_URL}{$URL_JOBS}" ><button type="button" class="btn btn-subc btn-view-jobs">{$customizer_data.candidates_strip_btn_title}</button></a>
      </div>
    </div>
  </div>
</div>
{/if}

{if $customizer_data.employers_on_flag == '1'}
<div id="employers">
  <div class="container">
    <div class="row">
      <h2>{$customizer_data.employers_headline}</h2>
      <p>{$customizer_data.employers_subheadline}
      </p>
      
      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand04.png">
        <h3>{$customizer_data.employers_firstcol_headline}</h3>
        <h4>{$customizer_data.employers_firstcol_subheadline}</h4>
      </div>

      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand06.png">
        <h3>{$customizer_data.employers_secondcol_headline}</h3>
        <h4>{$customizer_data.employers_secondcol_subheadline}</h4>
      </div>

      <div class="col-md-4 col-xs-12 c-box">
        <img src="{$BASE_URL}_tpl/default/1.5/images/emp-cand03.png">
        <h3>{$customizer_data.employers_thirdcol_headline}</h3>
        <h4>{$customizer_data.employers_thirdcol_subheadline}</h4>
      </div>
    </div>
  </div>
</div>

<div id="opportunity">
  <div class="container">
    <div class="row">   
      <div class="col-md-12 col-xs-12 c-box">
        <h1>{$customizer_data.employers_strip_headline}</h1>
        <h2>{$customizer_data.employers_strip_subheadline}</h2>
        <a href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" ><button type="button" class="btn btn-subc btn-view-jobs">{$customizer_data.employers_strip_btn_title}</button></a>
      </div>
    </div>
  </div>
</div>
{/if}

{if $customizer_data.about_on_flag == '1'}
<div id="about">
  <div class="container">
    <div class="row">
      <h2>{$customizer_data.about_headline}</h2>
      <p>{$customizer_data.about_subheadline}
      </p>
      
      <div class="col-md-5 col-xs-12 c-box">
        <h4>{$customizer_data.about_leftcol}</h4>
      </div>

      <div class="col-md-2 col-xs-12 c-box">
        <img src="{$BASE_URL}{$SITE_LOGO_PATH}">
      </div>

      <div class="col-md-5 col-xs-12 c-box">
        <h4>{$customizer_data.about_rightcol}</h4>
      </div>

       <div class="col-md-12 col-xs-12">
        <a href="{$BASE_URL}{$ABOUT_URL}" ><button type="button" class="btn btn-subc btn-read-more">{$customizer_data.about_readmore_btn_title}</button></a>
      </div>

    </div>
  </div>
</div>
{/if}

{if $customizer_data.test_on_flag == '1'}
<div class="testimonial">
  <div class="container">
  <h2>{$customizer_data.test_headline}</h2>

    <div id="testimonial-carousel" class="carousel slide">

      <ol class="carousel-indicators">
        <li data-target="#testimonial-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#testimonial-carousel" data-slide-to="1"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <div class="container">
            <div class="carousel-caption">
              <img src="{$BASE_URL}_tpl/default/1.5/images/tst-m.png">
              <br>
              <!-- TESTIMONIAL - change here -->
              <p>Maecenas lorem ligula, placerat et risus condimentum, porta porttitor eros.</p>
              <!-- TESTIMONIAL AUTHOR - change here-->
              <h3>Thomas Smith</h3>
            </div>
          </div>
        </div>
        <div class="item">
          <div class="container">
            <div class="carousel-caption">
              <img src="{$BASE_URL}_tpl/default/1.5/images/tst-w.png">
              <br>
               <!-- TESTIMONIAL - change here -->
              <p>Nunc imperdiet massa vel quam molestie, eu sagittis felis lobortis. Curabitur auctor tellus facilisis.</p>
               <!-- TESTIMONIAL AUTHOR - change here-->
              <h3>Zoe Allen</h3>
            </div>
          </div>
        </div>
      </div>

      <a class="left carousel-control" href="#testimonial-carousel" data-slide="prev">
        <span class="icon-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
      </a>
      <a class="right carousel-control" href="#testimonial-carousel" data-slide="next">
        <span class="icon-next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
      </a>  
    </div>

  </div>
</div>
{/if}

{if $customizer_data.partners_on_flag == '1'}
<div id="partner">
  <div class="container">
  <h2>{$customizer_data.partners_headline}</h2>
  <img src="{$BASE_URL}{$customizer_data.partners_bgimage_path}">
  </div>
</div>
{/if}

{if $customizer_data.ta_on_flag == '1'}
<div class="sign-up-section">
  <div class="container">
    <div class="row">

      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div id="employers-signup">
          <div class="row">   
            <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12 c-box">
              <h1>{$customizer_data.ta_emp_headline}</h1>
              <h2>{$customizer_data.ta_emp_subheadline}</h2>
              <a href="{$BASE_URL}{$URL_REGISTER_RECRUITERS}" ><button type="button" class="btn btn-subc btn-view-jobs">{$customizer_data.ta_emp_btn_label}</button></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div id="candidates-signup">
          <div class="row">   
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 c-box">

               {if $PROFILES_PLUGIN == 'true'}
                      <h1>{$customizer_data.ta_can_headline}</h1>
                      <h2>{$customizer_data.ta_can_subheadline}</h2>
                      <a href="{$BASE_URL}{$URL_REGISTER_APPLICANTS}" ><button type="button" class="btn btn-subc btn-view-jobs">{$customizer_data.ta_can_btn_label}</button></a>
               {else}
                      <h1>{$customizer_data.ta_can_headline}</h1>
                      <h2>{$customizer_data.ta_can_subheadline}</h2>
                       <a href="{$BASE_URL}{$URL_JOBS}" ><button type="button" class="btn btn-subc btn-view-jobs">{$translations.companies.view_jobs}</button></a>
               {/if}

            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
{/if}

{if $customizer_data.stats_on_flag == '1'}
<div id="stats">
  <div class="container">
  <h2>{$customizer_data.stats_headline}</h2>

    <div class="row">
      <div class="col-md-3 col-xs-6 c-box">
        <h5><i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
        <h3><div class="counter" data-count="{$customizer_data.stats_first_numb}">{$customizer_data.stats_first_numb}</div></h3>
        <h4>{$customizer_data.stats_first_col}</h4>
      </div>

      <div class="col-md-3 col-xs-6 c-box">
        <h5><i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
        <h3><div class="counter" data-count="{$customizer_data.stats_second_numb}">{$customizer_data.stats_second_numb}</div></h3>
        <h4>{$customizer_data.stats_sec_col}</h4>
      </div>

      <div class="col-md-3 col-xs-6 c-box">
        <h5><i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
        <h3><div class="counter" data-count="{$customizer_data.stats_third_numb}">{$customizer_data.stats_third_numb}</div></h3>
        <h4>{$customizer_data.stats_third_col}</h4>
      </div>

      <div class="col-md-3 col-xs-6 c-box">
        <h5><i class="fa fa-check-circle-o" aria-hidden="true"></i></h5>
        <h3><div class="counter" data-count="{$customizer_data.stats_fourth_numb}">{$customizer_data.stats_fourth_numb}</div></h3>
        <h4>{$customizer_data.stats_fourth_col}</h4>
      </div>

    </div>
  </div>
</div>
{/if}

{if $customizer_data.listings_on_flag == '1'}
{include file="snippets/listing-sitemap.tpl"}
{/if}

<script src="{$BASE_URL}_tpl/{$THEME}/1.5/js/jquery.min.js"></script>
<script src="{$BASE_URL}_tpl/{$THEME}/1.5/js/bootstrap.min.js"></script>


<script src="{$BASE_URL}js/landing/landing.js"></script>

{literal}
<script type="text/javascript">
	$('.counter').each(function() {

  var $this = $(this),
      countTo = $this.attr('data-count');

  $({ countNum: $this.text()}).animate({
    countNum: countTo
  },

  {
    duration: 10000,
    easing:'linear',
    step: function() {
      $this.text(Math.floor(this.countNum));
    },
    complete: function() {
      $this.text(this.countNum);
    }

  });  
});
</script>
{/literal}

{include file="1.5/layout/sjs-footer.tpl"}
</body>
</html>