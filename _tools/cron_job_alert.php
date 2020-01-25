<?php


	/**
	*  Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
	*
	*  @author     Niteosoft s.r.o. (ltd)
	*  @license    MIT
	*  @website    simplejobscript.com
	*
	*  There are no license limitations, modifications nor restrictions placed upon 
	*  and no rights have been transfered to all third-party software parts of this product. You are granted to use these libraries
	*  and sub-parts while following their individual license specifications and terms of service
	*
	*/

	require_once '../_config/cron_config.php';

	$EMAILS_IN_BATCH = 4;
	echo "******* STARTING THE JOB ALERT *********". "\r\n";
	echo "DATE and TIME : " . date('Y-m-d H:i:s') . "\r\n";
	$class = new Newsletter();
	$class->createQueue();

	global $db;
	$sql = 'SELECT email FROM '.DB_PREFIX.'email_queue limit ' . $EMAILS_IN_BATCH;

	// sends out 96 emails daily - 4 emails at the time - free SMTP providers have a limit of 100 emails / day
	// to send more sign up for a better SMTP plan and increase the $EMAILS_IN_BATCH above
	do {
	    $result = $db->query($sql);

	    $result_assoc = $result->fetch_assoc();
	    $QUEUE_NOTEMPTY = !empty($result_assoc);

	    if ($QUEUE_NOTEMPTY) {
	    	echo "SENDING " . $EMAILS_IN_BATCH . " emails ". "\r\n";;
	    	$class->sendNewsletter($EMAILS_IN_BATCH);
	    }

	} while ($QUEUE_NOTEMPTY);

	echo "******* JOB ALERT DONE *********". "\r\n";
	exit;

?>
