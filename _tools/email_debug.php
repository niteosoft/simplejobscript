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

	/*
	 EMAIL TEMPLATE DEBUGING CLASS. EMAIL AND TEXT IS HARDCODED
	*/

	$m = new Mailer();

	$EMAIL = 'your.email@mailprovider.com';
	$HASH = 'abchash';

	# application email to applicant
	$job_data = array();
	$job_data['id'] = "99";
	$job_data['title'] = "PHP Developer";
	$job_data['company'] = "Microsoft";
	$job_data['url_title'] = "php-developer-at-microsoft";
	$job_data['location_asci'] = "london";

	$m->sendAppliedEmail($job_data, $EMAIL);
	// #########

	// # registration confirmation
	$m->sendConfirmationEmail($EMAIL, $HASH);
	// #########

	// # contact email
	$m->sendContactEmail('John Goodman', 'john.good@gmail.com', 'Contact message');
	// ##################

	// # APPLICATION FOR EMPLOYER JOB
	$job = array();
	$job['title'] = "Zend Developer";
	$app = array();
	$app['name'] = "John Goodman";
	$app['phone'] = "4498743214";
	$app['email'] = "john@gmail.com";
	$app['skills'] = "#php #html #css";
	$app['location'] = "London";
	$app['website'] = "www.john.com";
	$app['message'] = "I need to work";

	$m->sendEmployerNewApplicationEmail($app, $job, $EMAIL);
	// #########################

	// # goodbye subscriber email
	$m->sendGoodbyeSubscriberMail($EMAIL);
	// ##################

	// # password recovery email
	$m->sendPasswordRecoveryEmail($EMAIL, $HASH, URL_RESET_PASSWORD_APPLICANTS);
	// ########

	// # user job published / activated email
	$data = array('id' => 35, 'url_title' => 'wp-designer', 'title' => 'WP Designer');
	$m->employerJobActivated($data, MAIN_URL, $EMAIL);
	// #####################

	// # Subscriber not confirmed email
	$m->subscriberNotConfirmedEmail($EMAIL, $HASH);
	// ###############

	// # Subscription updated
	$m->subscriptionUpdated($EMAIL);
	// ###############

	// # Tell a friend
	$m->tellAFriend($EMAIL, $EMAIL, 'Hey. Checkout this job !');
	// ##############

	// # welcome subscriber
	$m->welcomeSubscriber($EMAIL, $HASH);
	// ##############

	// # welcome subscriber
	$m->applicantRegisteredWelcome($EMAIL);
	// ##############

	$m->notifyDeletedCandidate($EMAIL, 'John');


	$m->reviewCandidateApplication($EMAIL, $job_data);


	$m->rejectCandidateApplication($EMAIL, $job_data);

	$m->hiredCandidateApplication($EMAIL, $job_data);



	/* JOB ALERT NEWSLETTER EMAIL TEST. THIS SENDS AN EMAIL TO ALL SUBSCRIBED AND CONFIRMED USERS OF YOUR JOB BOARD*/

	$EMAILS_IN_BATCH = 2;
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


	echo "Emails have been sent";
	die();

	?>