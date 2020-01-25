<!doctype html>
<html lang="en">
<head>
	<title>{if $smarty.const.SITE_NAME}{$smarty.const.SITE_NAME} | Admin{else}Job board Admin{/if}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="{$meta_description}" />
	<meta name="keywords" content="{$meta_keywords}" />
	<link rel="shortcut icon" href="{$BASE_URL}favicon.ico" type="image/x-icon" />

	<link rel="stylesheet" href="{$BASE_URL}js/bootstrap/css/bootstrap.min.css" type="text/css" /> 
	<link href="{$BASE_URL}js/bootstrap/css/flat-ui.css" rel="stylesheet">
	<link href="{$BASE_URL}js/admin/lib/style.css" rel="stylesheet">
	
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<script src="{$BASE_URL}js/jquery-1.11.2.min.js"></script>
	<script src="{$BASE_URL}js/bootstrap/js/bootstrap.min.js"></script>
	<script src="{$BASE_URL}js/admin/js/functions.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/main.js" type="text/javascript"></script>
	<script src="{$BASE_URL}js/admin/js/overlay.js" type="text/javascript"></script>

<style type="text/css">

.form-control, input[type="text"] {
	height: 50px;
	padding: 0px 6px 0px 20px;
}

.form-box img.logo {
margin-bottom: 15px !important; }

img.adminLogo {
    width: 25%;
    margin: 0 auto;
    margin-top: 5%;

}

.form-box {
text-align: center;
width: 100%;
margin: 0 auto;
padding: 50px 15px 50px; }

.login-recruiter-headline {
height: auto;
margin-top: 10px;
padding-top: 15px;
border-top-left-radius: 5px;
border-top-right-radius: 5px;
background-color: rgba(54, 57, 66, 0.75);
color: #ffffff !important;
text-align: center;
 }


.login-form-title {
font-size: 2em;
padding-bottom: 5px;
opacity: 0.95; }

.subheadline {
margin: 0px;
padding: 5px;
font-size: 19px;
opacity: 0.75;
margin-top: -20px;
padding-bottom: 10px; }

@media screen and (min-width: 500px) {
	  .form-box {
width: 395px !important; }
}	
</style>

</head>

<body>
	

	
