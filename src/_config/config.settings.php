<?php

	/**
	 * General settings
	 */

	// Global settings definitions
	foreach ($settings as $k => $setting)
	{

		$k = strtoupper($k);
		define("{$k}", $setting);
	}

	foreach ($seoSettings as $x => $setting)
	{

		$x = strtoupper($x);
		define("{$x}", $setting);
	}

	foreach ($paymentSettings as $name => $setting) {
		$name = strtoupper($name);
		define("{$name}", $setting);
	}

?>
