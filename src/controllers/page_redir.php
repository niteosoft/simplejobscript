<?php 
	$cl = new Campaign();
	$url = $cl->getCampaignUrlAndIncreaseClicks($id);

	$link = '';
	if (strpos($url, "http://") !== false)
		$link = substr($url, 7, strlen($url) - 1);
	else if (strpos($url, "https://") !== false)
		$link = substr($url, 8, strlen($url) - 1);
	else if (strpos($url, "www.") !== false)
		$link = substr($url, 4, strlen($url) - 1);
	else
		$link = $url;

	if ($url != NULL)
		redirect_to('http://' . $link);
	else
		redirect_to('/');
?>