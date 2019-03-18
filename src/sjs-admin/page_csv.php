<?php 

    $DIR_CONST = '';
    if (defined('__DIR__'))
        $DIR_CONST = __DIR__;
    else
        $DIR_CONST = dirname(__FILE__);

    $csvSQL = 'SELECT email FROM subscriptions WHERE confirmed = 1';
    $result = $db->query($csvSQL);
    $csvData = array();
    while ($row = $result->fetch_assoc()) {
        $csvData[] = $row;
    }

    try {

        $file = $DIR_CONST . '/../' . CSV_UPLOAD_DIR . 'subscribers.csv';
        if (file_exists($file)){ // delete old file if exists
            unlink($file);
        }

        $fp = fopen($file, 'w');
        foreach ($csvData as $email) {
            fputcsv($fp, $email);
        }
        fclose($fp);
        chmod($file, 0777);

    } catch (Exception $e) {
        $smarty->assign('err', 'There was a problem creating CSV file, export list of subscribers via phpMyAdmin, or contact support');
    }

    $smarty->assign('file_path',  BASE_URL_ORIG . CSV_UPLOAD_DIR . 'subscribers.csv');
    $smarty->assign('success', 'Your file is ready for download! Click the icon');
    $template = 'csv.tpl';
?>
