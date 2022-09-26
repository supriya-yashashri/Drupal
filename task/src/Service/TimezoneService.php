<?php

namespace  Drupal\task\Service;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TimezoneService implements TrustedCallbackInterface {

   /**
   * Stores the configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Creates a instance.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  public function  getTimeZone(){
 	$config = $this->configFactory->get('task_config_form.settings');
 	$timezone = $config->get('timezone');
 	$date = new DrupalDateTime('now', $timezone);

 	return [
 		'#markup' =>$date->format('jS F Y -h:i A'),
 		'#cache' =>['max_age' =>0],
 	];
  }

  public static function trustedCallbacks() {
 	return ['getTimeZone'];
  }

}