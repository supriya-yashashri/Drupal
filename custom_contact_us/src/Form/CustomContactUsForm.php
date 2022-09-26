<?php

/**
 * @file
 * Contains \Drupal\custom_contact_us\Form\CustomContactUsForm.
 */
namespace Drupal\custom_contact_us\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomContactUsForm extends FormBase {
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_contact_us_form';
  }

  /**
   * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = array();
    $form['text']['#markup'] = "<h1>Leave a Message</h1>";

    $form['#prefix'] = '<div id="custom-contact-us">'; 
    $form['#suffix'] = '</div>';


    $form['first_name'] = array(
      '#type' => 'textfield',
      '#title' => t('First Name:'),
      '#required' => TRUE,
    );
    $form['last_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Last Name:'),
      '#required' => TRUE,
    );
    $form['user_email'] = array (
        '#type' => 'email',
        '#title' => t('Email'),
        '#required' => TRUE,
      );
    $form['user_phone_number'] = array (
      '#type' => 'tel',
      '#title' => t('Phone Number'),
      '#required' => TRUE,
    );
    $form['user_message'] = array (
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
    );
    
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
    $form['#attached']['library'][] = 'custom_contact_us/custom_contact_us';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
 	
    $phone = $form_state->getValue('user_phone_number');
    //Validating Phone field.
    if(!preg_match('/^[0-9]{10}+$/', $phone)) {
    $form_state->setErrorByName ('phone','Please enter a valid phone number.');
}
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      /** @var \Drupal\Core\Database\Connection $connection */

      $connection = \Drupal::service('database');
      $result = $connection->insert('custom_contact_us')
      ->fields([
        'first_name' => $form_state->getValue('first_name'),
        'last_name' =>  $form_state->getValue('last_name'),
        'user_email' => $form_state->getValue('user_email'),
        'user_phone_number' => $form_state->getValue('user_phone_number'),
        'user_message' => $form_state->getValue('user_message'),
        'timestamp' => \Drupal::time()->getRequestTime(),
        'user_domain' => $_SERVER['HTTP_HOST']
      ])
      ->execute();
      $name = $form_state->getValue('first_name') . ' ' .$form_state->getValue('last_name');
      $f_name = $form_state->getValue('first_name');
      $l_name = $form_state->getValue('last_name');
      $u_mail = $form_state->getValue('user_email');
      $u_phone = $form_state->getValue('user_phone_number');
      $u_message = $form_state->getValue('user_message');

      //Sending E-mail to Customer
      $mailManager = \Drupal::service('plugin.manager.mail');

      $key= 'contact_us';
      $module = 'custom_contact_us';
      $params['message'] = '<table bgcolor="#000000" border="0" cellpadding="3" cellspacing="0" style="color:#fff; font-size:14px; font-family:arial; margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="left" style="float:left; line-height:20px; padding:10px 1% 10px 1%" width="47%"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/phone-icon.jpg" style="width:7px; height:20px; float:left" />&nbsp;1800-123-1234</td>
          <td align="right" style="float:right; height:20px; line-height:16px; padding:10px 1% 10px 1%"><a href="#" style="float:left; margin:4px 0 0 7px; line-height: 16px;" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/facebook-icon.jpg" style="margin:0; width:9px; height:13px; vertical-align:middle;" /></a><a href="#" style=" float:left; margin:5px 0 0 7px; line-height: 16px;" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/instagram.jpg" style=" margin:0; width:14px; height:12px;  vertical-align:middle;" /></a></td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="center" style="padding:10px 40px"><a href="" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/logo.png" style="width: 106px; margin:20px 0 10px 0;" /></a></td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="font-family:arial; font-size:14px; color:#000000; padding:0px; margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="center" style="padding:10px 40px">
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; text-align:center; width:600px; word-wrap: break-word; width:100%; float:left; ">Hi '.$name.'</p>
    
          <p style="margin:0 0 20px 0; font-family: Arial; font-size:14px; color:#000; text-align:ccenter; width:100%; float:left;">Thank you for contacting us. We will get back to you soon.</p>
    
          <p style="margin:0 ; font-family: Arial; font-size:14px; color:#000; text-align:center; width:100%; float:left;">Thank you,</p>
    
          <p style="margin:0 0 8px 0; font-family: Arial; font-size:14px; color:#000; text-align:center; width:100%; float:left;font-weight:bold">Boutpets</p>
          </td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" class="hero-image" style="margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr class="image-main" style="display:block">
          <td align="center" style="display:block; margin:50px auto; padding:0px">
          <p style="margin:10px 0 0 0;"><img alt="" class="fix" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/email-promotion-img.jpg" style="margin:0px; padding:0px; width:100%; float:left" /></p>
          </td>
        </tr>
        <tr class="image-mobile" style="display:none">
          <td align="center" style="display:block; margin:50px auto; padding:0px">
          <p style="margin:10px 0 0 0;"><img alt="" class="fix" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/email-promotion-img.jpg" style="margin:0px; padding:0px; width:100%; float:left" /></p>
          </td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" style="color:#fff; font-size:11px; font-family:arial; margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="center" style="padding:13px 10px 6px 10px"><a href="https://dev-boutpets-dev.pantheonsite.io/contact-us" style="color:#fff; font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;" target="_blank">Contact Us &nbsp;&Iota; </a><a href="https://dev-boutpets-dev.pantheonsite.io/faq" style="color:#fff;font-family: Arial,Helvetica,sans-serif; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;" target="_blank">FAQ&#39;s &nbsp;&Iota;</a> <a href="https://dev-boutpets-dev.pantheonsite.io/privacy-policy" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;" target="_blank">Privacy Policy &nbsp;&Iota; </a> <a href="https://dev-boutpets-dev.pantheonsite.io/mobilesite-app" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;" target="_blank">Mobile Site &amp; App &nbsp;&Iota; </a> <a href="https://dev-boutpets-dev.pantheonsite.io/support" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none; margin:0 5px 0 0; line-height:16px;" target="_blank">Support</a></td>
        </tr>
        <tr>
          <td align="center" style="padding:0 10px 13px 10px">
          <p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; color:#fff; text-align:center; margin:0;">All rights reserved @ 2021, Developed By Sphere</p>
          </td>
        </tr>
      </tbody>
    </table>.';

      $langcode = $lang;
      $send = true;
      $toMail = $form_state->getValue('user_email');
      $result = $mailManager->mail($module, $key, $toMail, $langcode, $params, NULL, $send);
      if ($result['result'] !== true) {
        \Drupal::messenger()->addMessage(t('There was a problem sending your message and it was not sent.'),);
      }
      else {
        \Drupal::messenger()->addMessage(t('Your message has been sent.'),);
      }
      //Sending E-mail to Admin
      $key= 'contact_us';
      $module = 'custom_contact_us';
      $params['message'] = '<table bgcolor="#000000" border="0" cellpadding="3" cellspacing="0" style="color:#fff; font-size:14px; font-family:arial; margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="left" style="float:left; line-height:20px; padding:10px 1% 10px 1%" width="47%"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/phone-icon.jpg" style="width:7px; height:20px; float:left" />&nbsp;1800-123-1234</td>
          <td align="right" style="float:right; height:20px; line-height:16px; padding:10px 1% 10px 1%"><a href="#" style="float:left; margin:4px 0 0 7px; line-height: 16px;" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/facebook-icon.jpg" style="margin:0; width:9px; height:13px; vertical-align:middle;" /></a><a href="#" style=" float:left; margin:5px 0 0 7px; line-height: 16px;" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/instagram.jpg" style=" margin:0; width:14px; height:12px;  vertical-align:middle;" /></a></td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr>
          <td align="left" style="padding:10px 40px;"><a href="" target="_blank"><img alt="" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/logo.png" style="width: 106px; margin:20px 0 10px 0;" /></a></td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" style="font-family:arial; font-size:14px; color:#000000; padding:0; margin:0 auto; width:600px; " width="600">
      <tbody>
        <tr>
          <td align="left" style="padding:10px 40px;">
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; text-align:left; width:600px; word-wrap: break-word; width:100%; float:left;padding:20px 0 5px 0;font-weight:bold; ">Contact us submitted by below details.</p>
    
          <!-- <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; text-align:center; width:100%; float:left;">[webform_submission:values]</p> -->
    
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; width:600px; word-wrap: break-word; width:100%; float:left; text-align:left;">
            <b style="width:22%; float:left; text-align:left; padding-right:40px;">First Name:</b>&nbsp; 
          <span style="float:left; width:67%; text-align:left;word-break: break-all;">'.$f_name.'<br/></span></p>
    
          
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; width:600px; word-wrap: break-word; width:100%; float:left; text-align:left;">
            <b style="width:22%; float:left; text-align:left; padding-right:40px; ">Last Name:</b>&nbsp; 
          <span style="float:left; width:67%; text-align:left;word-break: break-all;">'.$l_name.'<br/></span></p>
          
    
          
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; width:600px; word-wrap: break-word; width:100%; float:left; text-align:left;">
            <b style="width:22%; float:left; text-align:left; padding-right:40px; ">Email:</b>&nbsp; 
          <span style="float:left; width:67%; text-align:left;word-break: break-all;">'.$u_mail.'<br/></span></p>
          
    
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; width:600px; word-wrap: break-word; width:100%; float:left; text-align:left;">
            <b style="width:22%; float:left; text-align:left; padding-right:40px; ">Phone Number:</b>&nbsp; 
          <span style="float:left; width:67%; text-align:left;word-break: break-all;">'.$u_phone.'<br/></span></p>
    
          
          <p style="margin:0 0 10px 0; font-family: Arial; font-size:14px; color:#000; width:600px; word-wrap: break-word; width:100%; float:left; text-align:left;">
            <b style="width:22%; float:left; text-align:left;  padding-right:40px;">Message:</b>&nbsp; 
          <span style="float:left; width:67%; text-align:left;word-break: break-all;">'.$u_message.'<br/></span></p>
          
    
          <p style="margin:0 ; font-family: Arial; font-size:14px; color:#000; text-align:left; width:100%; float:left;">Thank you,</p>
    
          <p style="margin:0 0 8px 0; font-family: Arial; font-size:14px; color:#000; text-align:left; width:100%; float:left;font-weight:bold"> Bout Pets</p>
          </td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#f1f1f1" border="0" cellpadding="0" cellspacing="0" class="hero-image" style="margin:0 auto; width:600px;" width="600">
      <tbody>
        <tr class="image-main" style="display:block">
          <td align="center" style="display:block; margin:50px auto; padding:0px">
          <p style="margin:10px 0 0 0;"><img alt="" class="fix" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/email-promotion-img.jpg" style="margin:0px; padding:0px; width:100%; float:left" /></p>
          </td>
        </tr>
        <tr class="image-mobile" style="display:none">
          <td align="center" style="display:block; margin:50px auto; padding:0px">
          <p style="margin:10px 0 0 0;"><img alt="" class="fix" src="https://dev-boutpets-dev.pantheonsite.io/themes/custom/boutpets/images/email-promotion-img.jpg" style="margin:0px; padding:0px; width:100%; float:left" /></p>
          </td>
        </tr>
      </tbody>
    </table>
    
    <table bgcolor="#000000" border="0" cellpadding="0" cellspacing="0" style="color:#fff; font-size:11px; font-family:arial; margin:0 auto; width:600px;" width="600">
      <tbody>
      <tr>
          <td align="center" style="padding:13px 10px 6px 10px"><a target="_blank" href="https://dev-boutpets-dev.pantheonsite.io/contact-us" style="color:#fff; font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;">Contact Us &nbsp;&Iota; </a><a target="_blank" href="https://dev-boutpets-dev.pantheonsite.io/faq" style="color:#fff;font-family: Arial,Helvetica,sans-serif; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;">FAQ&#39;s &nbsp;&Iota;</a> <a target="_blank" href="https://dev-boutpets-dev.pantheonsite.io/privacy-policy" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;">Privacy Policy &nbsp;&Iota; </a> <a target="_blank" href="https://dev-boutpets-dev.pantheonsite.io/mobilesite-app" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none;margin:0 5px 0 0;line-height:16px;">Mobile Site &amp; App &nbsp;&Iota; </a> <a target="_blank" href="https://dev-boutpets-dev.pantheonsite.io/support" style="color:#fff;font-family: Arial; font-size:11px; text-decoration:none; margin:0 5px 0 0; line-height:16px;">Support</a></td>
        </tr>
        <tr>
          <td align="center" style="padding:0 10px 13px 10px">
          <p style="font-family: Arial, Helvetica, sans-serif; font-size:11px; color:#fff; text-align:center; margin:0;">All rights reserved @ 2021, Developed By Sphere</p>
          </td>
        </tr>
      </tbody>
    </table>';

      $langcode = $lang;
      $send = true;
      $toMail = \Drupal::config('system.site')->get('mail');
      $result = $mailManager->mail($module, $key, $toMail, $langcode, $params, NULL, $send);
  }


}