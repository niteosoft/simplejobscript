<?php 

$DIR_CONST = '';
if (defined('__DIR__'))
    $DIR_CONST = __DIR__;
else
    $DIR_CONST = dirname(__FILE__);

//delete website templates
$path = $DIR_CONST . '/../_tpl/' . $settings['theme']. '/_cache/';

if ($handle = opendir(  $path ))
{
    while (false !== ($file = readdir($handle)))
    {
		if ($file != '.' && $file != '..' && $file != '.gitignore') {
		  if( is_file( $path . $file) )
            {
                unlink($path . $file);
            }
		}
    }
    closedir($handle);
}

//delete settings from db cache
$target = $DIR_CONST . '/../_cache/';

if ($handle = opendir(  $target ))
{
    while (false !== ($file = readdir($handle)))
    {
	  if( is_file( $target . $file) )
        {
            unlink($target . $file);
        }
    }
    closedir($handle);
}

clear_admin_cache();

$smarty->assign('msg', "Cache has been cleared!");
$template = 'success/success.tpl';

?>