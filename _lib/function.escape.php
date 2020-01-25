<?php

/**
 * Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
 *
 * @author     Niteosoft s.r.o. (ltd)
 * @license    MIT
 * @website    simplejobscript.com
 * 
 *
 *  @Usage      Instead of doing extract($_POST), you can now
 *             escape fields like this: escape($_POST)
 *
 *  @param array $what         $_GET, $_POST or any other array
 *  @param array $dontStrip    an array of key names in $what, whose values should not be stripped of HTML
 */

function escape($what, $dontStrip=array())
{
	global $db;

	foreach ($what as $variable => $value)
	{
		if (is_string($value))
		{
			if (in_array($variable, $dontStrip))
			{
				$GLOBALS[$variable] = $db->getConnection()->real_escape_string($value);
			}
			else
			{
				$GLOBALS[$variable] = $db->getConnection()->real_escape_string(strip_tags($value));
			}
		}
		else
		{
			$GLOBALS[$variable] = $value;
		}
	}
}
?>
