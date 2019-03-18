<?php

	require_once '../_lib/class.Stats.php';
	$stats = new Stats();
	$smarty->assign('payment_reports', $stats->GetPaymentReports());
	$smarty->assign('keywordz', $stats->Keywords());
	$smarty->assign('spam_reports', $stats->GetSpamReports());
	$smarty->assign('job_stats', $stats->getJobStats());
	$smarty->assign('app_stats', $stats->getApplicationStats());
	$smarty->assign('user_stats', $stats->getUserStats());
	$template = 'stats.tpl';
?>
