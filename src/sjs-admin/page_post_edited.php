<?php 

escape($_POST);
$job = new Job();

if (REMOTE_PORTAL == 'deactivated' && isset($location_select))
	$city_id = intval($location_select);
else
	$city_id = 1;

$apply_online = (isset($apply_online_switch)) ? 1 : 0;

$HOW_TO_APPLY = $db->getConnection()->real_escape_string($_POST['howtoapply']);

if (strpos($HOW_TO_APPLY, "http://") !== false)
	$HOW_TO_APPLY = substr($HOW_TO_APPLY, 7, strlen($HOW_TO_APPLY) - 1);
else if (strpos($HOW_TO_APPLY, "https://") !== false)
	$HOW_TO_APPLY = substr($HOW_TO_APPLY, 8, strlen($HOW_TO_APPLY) - 1);
else if (strpos($HOW_TO_APPLY, "www.") !== false)
	$HOW_TO_APPLY = substr($HOW_TO_APPLY, 4, strlen($HOW_TO_APPLY) - 1);

$data = array(
	"type_id" => intval($type_select),
	"job_id" => intval($job_id),
	"category_id" => intval($cat_select),
	"title" => $title,
	"salary" => $salary,
	"description" => $db->getConnection()->real_escape_string($_POST['description']), //keed the tinymce characters
	"city_id" => $city_id,
	"apply_online" => $apply_online,
	"apply_desc" => $HOW_TO_APPLY
);

$result = $job->Edit($data);

if ($referer == 'inactive')
	redirect_to(BASE_URL . URL_JOBS . '/inactive/edited');
else
	redirect_to(BASE_URL . URL_JOBS . '/edited');

?>