<?php

/**
 * Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
 *
 * @author      Niteosoft s.r.o. (ltd)
 * @license     MIT
 *  @website    simplejobscript.com
 *
 *
 *  @Usage     Function acts as a wrapper over header('Location...') and performs an HTTP redirect
 *
 *  @param string $url      Location for the redirect
 */

function redirect_to($url, $status = '')
{
  switch($status) {
    case '404':
        header("HTTP/1.1 404 Not Found");
        header('Location: ' . $url);
        break;
    case '301':
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: ' . $url);
        break;
    default:
        header('Location: ' . $url);
        exit;
  }    
}

?>
