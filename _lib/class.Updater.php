<?php 


 	/**
	 * Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
	 *
	 * @author     Niteosoft s.r.o. (ltd)
	 * @license    Proprietary software license
	 * @website    simplejobscript.com
	 * 
	 * SJS UPDATER
	 */

class Updater
{ 

	protected $_EDD_URL = 'https://simplejobscript.com/';
	protected $_EDD_UPDATE_URL = 'https://simplejobscript.com/version-update/';
	protected $_EDD_RENEW_URL = 'https://simplejobscript.com/checkout/';

	protected $_p = array(
		'PRODUCT_ID' => '796',
		'LICENSE' => '',
		'SITE_URL' => ''
	);

	public function __construct($edd_license, $edd_site_url) {
		$this->_p['LICENSE'] = $edd_license;
		$this->_p['SITE_URL'] = $edd_site_url;
	}

	public function getUrl($edd_action)
    {
        return trim($this->_EDD_URL . '?edd_action=' . $edd_action . '&item_id=' . $this->_p['PRODUCT_ID'] . '&license=' . $this->_p['LICENSE'] . '&url=' . $this->_p['SITE_URL']);
    }

    public function getUpdateUrl($license_key, $site_url) {
    	return trim($this->_EDD_UPDATE_URL . '?lk=' . $license_key . '&u=' . $site_url);
    }

    public function getRenewUrl() {
    	return trim($this->_EDD_RENEW_URL . '?edd_license_key=' . $this->_p['LICENSE'] . '&download_id=' . $this->_p['PRODUCT_ID']);
    }

}

?>