<?php
namespace Drupal\custom_contact_us\Controller;

use Drupal\core\Controller\ControlBase;
use Drupal\Core\Link;
use Drupal\Core\Url;


class CustomContactUsController {
    public function contact_us() {
    $result = \Drupal::database()->select('custom_contact_us', 'n')->fields('n', array('timestamp','first_name', 'last_name', 'user_email', 'user_phone_number', 'user_message','user_domain'))->condition('user_domain', $_SERVER['HTTP_HOST'])->execute()->fetchAllAssoc('timestamp');
    //create the row element.
    $rows = array();
    foreach ($result as $row => $content)
    {
        $rows[] = array(
        'data' => array(date("Y-m-d H:i:s",$content->timestamp),$content->first_name,$content->last_name,$content->user_email,$content->user_phone_number,$content->user_message,$content->user_domain));
    }
    //Create Header.
    $header = array('Submitted Date/Time','First Name','Last Name','User Mail','User Phone Number','User Message','User Domain');
    $output = array(
        '#theme' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        '#prefix' => '<div id="custom-contact-list-download"><a href="export-custom-contact-us-data"> Download List</a>',
        '#suffix' => '</div>',
        '#attached' => ['library' => ['custom_contact_us/custom_contact_us']]
    );
    return $output;
  }
}