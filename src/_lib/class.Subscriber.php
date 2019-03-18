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

class Subscriber {
	protected $_id;
	protected $_email;
	protected $_auth;
	protected $_cats;
	protected $_confirmed;

	public function __construct($email, $cats, $override_subscriber = false, $send_email = true)
	{
		global $db;
		$this->_email =  (string) $email;
		$this->_auth = self::generateAuthCode();

		$sql = 'SELECT id, confirmed, categories FROM '.DB_PREFIX.'subscriptions WHERE email = "' . $email . '"';
		$result = $db->query($sql);

		if ($result->num_rows > 0)
		{

			$result = $result->fetch_assoc();

			$this->_id = $result['id'];
			$this->_confirmed = intval($result['confirmed']);

			if ($override_subscriber)
				$newCats = (string) $cats;
			else
				$newCats = $result['categories'] . ',' . (string) $cats;

			$sql = 'UPDATE '.DB_PREFIX.'subscriptions SET categories="' . $newCats . '" WHERE id = "' . $this->_id . '"';
			$result = $db->query($sql);

			if ($this->_confirmed == 0) {
			   //update auth and send new confirmation
			   $this->_updateAuthForUser();
			} else {
				//get hash, for unsubscribe link in template
				$sql = 'SELECT auth FROM '.DB_PREFIX.'subscribers WHERE email = "' . $email . '"';
				$result = $db->QueryRow($sql);

				if ($send_email) {
					//send subscription update email
					$mailer = new Mailer();
					$mailer->subscriptionUpdated($this->_email, $result['auth']);		
				}

			}
			
		}
		else
		{

			$sql = 'INSERT INTO '.DB_PREFIX.'subscriptions (email, categories, confirmed)
						   VALUES ("' . $email . '", "' . $cats . '", "0")';
			if($db->Execute($sql))
			{
				$this->_id = $db->getConnection()->insert_id;
				$this->_confirmed = 0;
			}
			$this->_createNewAuthorization($send_email);
		 }
	}

	public static function unsubscribe($auth) {
			global $db;

			$sql = 'SELECT email FROM '.DB_PREFIX.'subscribers WHERE auth = "' . $auth . '"';
			$result = $db->QueryRow($sql);

			if (!$result) {
				return false;
			} else {
				$email = $result['email'];
				//first
				$sql = 'DELETE FROM '.DB_PREFIX.'subscribers WHERE auth = "' . $auth . '"';
				$db->query($sql);

				$sql = 'DELETE FROM '.DB_PREFIX.'subscriptions WHERE email = "' . $email . '"';
				$db->query($sql);

				$class = new Mailer();
				$class->sendGoodbyeSubscriberMail($email);

				return true;
			}

	}

	public static function confirmSubscriberByEmail($email) {
		global $db;
		$sql = 'UPDATE subscriptions SET confirmed = 1 WHERE email = "' . $email . '"';
		$db->query($sql);
	}

	public static function confirmSubscriber($hash) {
		global $db;

		$sql = 'SELECT email
               FROM '.DB_PREFIX.'subscribers
               WHERE auth = "' . $hash . '"';

         $result = $db->query($sql);

         if (($result->num_rows > 0)) {
         	 $assoc = $result->fetch_assoc();
         	 $email = $assoc['email'];
         	
         	$sql = 'UPDATE '.DB_PREFIX.'subscriptions SET confirmed="' . 1 . '"  WHERE email = "' . $email . '"';
            $result = $db->query($sql);
         
            return $result;

         } else {
         	//activation failed
         	return false;
         }
	}

	private function _updateAuthForUser() {
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'subscribers SET auth="' . $this->_auth . '" WHERE email="' . $this->_email .'"';
		if($db->Execute($sql)) { 
	 	    $mailer = new Mailer();
			$mailer->subscriberNotConfirmedEmail($this->_email, $this->_auth);
		}
				
	}

	private function _createNewAuthorization($send_email) {
		global $db;
		$sql = 'INSERT INTO '.DB_PREFIX.'subscribers (email, auth)
						   VALUES ("' . $this->_email . '", "' . $this->_auth . '")';
		if($db->Execute($sql) && $send_email) {
			//send welcome/auth confirmation email
			$mailer = new Mailer();
			$mailer->welcomeSubscriber($this->_email, $this->_auth);
		}
	}

	public function getSubscriberData() {
		global $db;
		$s = new stdClass;
		$s->email = $this->_email;
		$s->confirmed = $this->_confirmed;
		$s->cats = $this->_cats;
		return $s;
	}


	protected static function generateAuthCode()
	{
		$auth = md5(uniqid() . time());
		return $auth;
	}
}
?>