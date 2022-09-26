<?php
namespace Drupal\custom_contact_us\Controller;

use Drupal\core\Controller\ControlBase;
use Drupal\Core\Link;
use Drupal\Core\Url;


class CustomContactUsExportController {
    public function contact_us_export() {
    $output = '';

    $keys = array(t('SUBMITTED DATE/TIME'), t('First Name'),t('Last Name'),t('User Mail'),t('User Phone Number'),t('User Message'),t('User Domain'),);
    $output .= implode("\t", $keys) . "\n";
    $result = \Drupal::database()->select('custom_contact_us', 'n')->fields('n', array('timestamp','first_name', 'last_name', 'user_email', 'user_phone_number', 'user_message','user_domain'))->condition('user_domain', $_SERVER['HTTP_HOST'])->execute()->fetchAllAssoc('timestamp');
    foreach ($result as $row => $content) {
        $output .= date("Y-m-d H:i:s") . ',' . $content->first_name . ',' . $content->last_name . ',' . $content->user_email . ',' . $content->user_phone_number . ',' . $content->user_message . ',' . $content->user_domain ."\n";
      }
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      ob_clean();
        print $output;
        exit;  
  }
}