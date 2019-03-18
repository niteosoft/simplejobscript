<!doctype html>
<html lang="en">
<head>
	<title>{if $smarty.const.SITE_NAME}{$smarty.const.SITE_NAME} | Admin{else}Job board admin{/if}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{$meta_description}" />
	<meta name="keywords" content="{$meta_keywords}" />
	<link rel="shortcut icon" href="{$BASE_URL}fav.png" type="image/x-icon" />

	<link rel="stylesheet" href="{$BASE_URL}js/bootstrap/css/bootstrap.min.css" type="text/css" /> 
	<link href="{$BASE_URL}js/bootstrap/css/flat-ui.css" rel="stylesheet">
	<link href="{$BASE_URL}js/admin/lib/style.css" rel="stylesheet">
	<link href="{$BASE_URL}js/admin/lib/flat-green.css" rel="stylesheet">
    <link href="{$BASE_URL}js/tags/tagl/assets/css/taggle.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{$BASE_URL}js/cp/spectrum.css" rel="stylesheet">
    <link href="{$BASE_URL}_tpl/default/1.5/css/sjs-updates.css" rel="stylesheet">

<!-- 
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/style.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/reset.css">
  <link rel="stylesheet" href="{$BASE_URL}_tpl/{$THEME}/1.5/css/font-awesome.min.css"> -->
  

	<script src="{$BASE_URL}js/jquery-1.11.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/bootstrap/js/bootstrap.min.js"></script>

	<script src="{$BASE_URL}js/admin/js/functions.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/main.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/categories.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/translations.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/messages.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/overlay.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/types.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/lib/app.js" type="text/javascript"></script>
    <script src="{$BASE_URL}js/cp/spectrum.js" type="text/javascript"></script>

	{if $editor}
	<script src="{$BASE_URL}js/tinymce/tinymce.min.js"></script>
	{/if}

<style type="text/css">
.fa-lg {
    font-size: 1.7em;
}
.dropdown-menu > li > a {
    font-size: 16px;
}

#pagination-id button {
    border-radius: 21px;
}

.pagination-cl {
  margin-bottom: 5%;
  margin-top: 3%;
}

.pagination-cl .col-md-12 {
      padding: 0;
}

.pagination-cl .btn-next, .pagination-cl .btn-more {
    float: right;
    color: #fff;
    background: #46CAC6;
    width: 8%;
    font-size: 16px;
}

.pagination-cl .btn-next:hover, .pagination-cl .btn-more:hover {
    border: 2px solid #46CAC6;
    background: #fff;
    color: #46CAC6;
    padding: 0;
}

.pagination-cl .btn-more {
    float: left;
}

#pagination-id .btn {
  display: table;
  margin: 1% auto;
}

.pagination-cl .center-btn {
      width: 90%;
    text-align: right;
}

.pagination-cl .center-btn .btn-pg, .pagination-cl .center-btn .btn {
    width: 4%;
    padding: 1% 0%;
    margin: 1.2% 0.5% 1% 0%;
    float: right;
    background: #C7C7C7;
    border: none;
    color: #FFFFFF;
}

.pagination-cl .center-btn .btn-pg:hover, .pagination-cl .center-btn .btn:hover, .pagination-cl .center-btn .btn-pg.active,  .pagination-cl .center-btn .active.btn, .pagination-cl .center-btn .btn-pg:hover, .pagination-cl .center-btn .btn:hover, .pagination-cl .center-btn .btn-pg.active, .pagination-cl .center-btn .active.btn {
  background: #46CAC6;
}
</style>

</head>

<body class="flat-green">
		{if $isAuthenticated == 1}
	<div class="app-container">
        <div class="row content-container">
            <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                <div class="container-fluid menuPadding">
                    <div class="navbar-header">
                        <button id="menuBtn" type="button" class="navbar-expand-toggle">
                           <i class="fa fa-th-list" aria-hidden="true"></i>
                        </button>
                        <ol class="breadcrumb navbar-breadcrumb">
                            <li class="active">Menu</li>
                        </ol>
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs visible-sm">
                               <i class="fa fa-align-justify" aria-hidden="true"></i>
                        </button>
                    </div>
                    <ul class="nav navbar-nav navbar-right" >
                        <button type="button" class="navbar-right-expand-toggle pull-right visible-xs visible-sm">
                            <i class="fa fa-close fa-lg" aria-hidden="true"></i>
                        </button>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle noHover" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fa fa-wrench fa-lg" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li class="title">
                                   <a href="{$BASE_URL_ADMIN}translations/edit/">Translations</a>
                                </li>
                                 <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}settings/">Settings</a>
                                </li>
                                <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}stats/">Statistics</a>
                                </li>
                                <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}customizer/">Customizer</a>
                                </li>
                            </ul>
                        </li>
 						<li class="dropdown">
                            <a href="#" class="dropdown-toggle noHover" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fa fa-address-card-o fa-lg" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li class="title">
                                   <a href="{$BASE_URL_ADMIN}subscribers/">Subscribers</a>
                                </li>
                                 <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}companies/">Companies</a>
                                </li>
                                {if $PROFILE_PLUGIN == '1'}
                                <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}candidates/">Candidates</a>
                                </li>
                                {/if}
                                <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}news/">News</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle noHover" data-toggle="dropdown" role="button" aria-expanded="false"> <i class="fa fa-home fa-lg" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu animated fadeInDown">
                                <li class="title">
                                   <a href="{$BASE_URL_ADMIN}clear-cache/">Clear cache</a>
                                </li>
                                 <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL}{$URL_JOBS}" target="_blank">Open web</a>
                                </li>
                                <li class="title" style="border-top: solid 1px #e6e6e6;">
                                   <a href="{$BASE_URL_ADMIN}logout/">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="side-menu sidebar-inverse">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="side-menu-container upc">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{$BASE_URL_ADMIN}">
                                 <i class="fa fa-arrow-circle-down ml12 mr15 fa-lg" aria-hidden="true"></i>
                                <div class="title" style="text-transform: none">admin</div>
                            </a>
                        </div>
                        <ul class="nav navbar-nav">
                            <li class="{if $ACTIVE == '1'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}{$URL_JOBS}/inactive/">
                                     <i class="fa fa-volume-off fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Inactive jobs</span>
                                </a>
                            </li>
                            <li class="panel panel-default dropdown {if $ACTIVE == '2'}active{/if}">
                                <a data-toggle="collapse" href="#dropdown-element">
                                    <i class="fa fa-volume-up fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Active jobs</span>
                                </a>
                                <!-- Dropdown level 1 -->
                                <div id="dropdown-element" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul class="nav navbar-nav">
                                            <li>
                                                <a href='{$BASE_URL_ADMIN}{$URL_JOBS}/all'>All</a>
                                            </li>
                                            {section name=tmp loop=$categories}
                                            <li>
		     									<a href='{$BASE_URL_ADMIN}{$URL_JOBS}/{$categories[tmp].var_name}/'>{$categories[tmp].name}</a>
		     								</li>
                                            {/section}
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="{if $ACTIVE == '3'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}job-applications/">
                                    <i class="fa fa-user-circle fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Job Applications</span>
                                </a>
                            </li>
                            <li class="{if $ACTIVE == '4'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}pages/">
                                    <i class="fa fa-file-text-o fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Pages</span>
                                </a>
                            </li>

                            <li class="{if $ACTIVE == '7'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}types/">
                                    <i class="fa fa-calendar-check-o fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Job Types</span>
                                </a>
                            </li>

                            <li class="{if $ACTIVE == '6'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}categories/">
                                    <i class="fa fa-tasks fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Job Categories</span>
                                </a>
                            </li>

                            <li class="{if $ACTIVE == '5'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}cities/list/">
                                    <i class="fa fa-map-marker fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Job Locations</span>
                                </a>
                            </li>

                            {if $smarty.const.BANNER_MANAGER == 'true'}
                            <li class="{if $ACTIVE == '8'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}advertisement/">
                                    <i class="fa fa-image fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Banners</span>
                                </a>
                            </li>
                            {/if}

                           {if $smarty.const.ADSENSE == 'true'}
                           <li class="{if $ACTIVE == '10'}active{/if}">
                                <a href="{$BASE_URL_ADMIN}adsense/">
                                    <i class="fa fa-file-image-o fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Adsense</span>
                                </a>
                            </li> 
                            {/if}

                            <li class="{if $ACTIVE == '12'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}cleaner/">
                                    <i class="fa fa-recycle fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Cleaner</span>
                                </a>
                            </li>
                            <li class="{if $ACTIVE == '11'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}seo/">
                                    <i class="fa fa-search fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">SEO</span>
                                </a>
                            </li>
                            {if $smarty.const.PAYPAL_PLUGIN == 'true'}
                            <li class="{if $ACTIVE == '77'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}payment-settings/">
                                    <i class="fa fa-money fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Payments</span>
                                </a>
                            </li>
                            {/if}
                            {if $smarty.const.INDEED_PLUGIN == 'true'}
                            <li class="{if $ACTIVE == '15'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}indeed/">
                                    <i class="fa fa-rocket fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Indeed</span>
                                </a>
                            </li>
                            {/if}
                            <li class="{if $ACTIVE == '50'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}feeder/">
                                    <i class="fa fa-share-alt fa-lg ml5 mr5" aria-hidden="true"></i><span class="title">Data Feeder</span>
                                </a>
                            </li>
                            <li class="{if $ACTIVE == '68'}active{/if}">
                            <a href="{$BASE_URL_ADMIN}updates/">
                                    <i class="fa fa-arrow-circle-o-up fa-lg ml5 mr5"></i><span class="title">Updates</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </nav>
            </div>
            <!-- Main Content -->
            <div class="container-fluid">

            </div>
        </div>
        <footer class="app-footer">
            <div class="wrapper">
                <span class="pull-right">SJS &nbsp; {$SJS_VERSION} &nbsp;&nbsp;<a href="#"><i class="fa fa-long-arrow-up"></i></a></span> &copy; {$SITE_NAME}
            </div>
        </footer>
		{/if}