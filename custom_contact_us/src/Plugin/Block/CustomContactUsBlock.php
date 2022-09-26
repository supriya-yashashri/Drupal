<?php


namespace Drupal\custom_contact_us\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\UserInterface;

/**
 * Provides a block.
 *
 * @Block(
 *   id = "custom_contact_us_block",
 *   admin_label = @Translation("Custom Contact Us"),
 *   category = @Translation("Custom")
 * )
 */

class CustomContactUsBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build(){
    //$form = \Drupal::formBuilder()->getForm('Drupal\custom_contact_us\Form\CustomContactUsForm');
    $form = \Drupal::formBuilder()->getForm('Drupal\custom_contact_us\Form\CustomContactUsForm');
    return $form;
  }
}