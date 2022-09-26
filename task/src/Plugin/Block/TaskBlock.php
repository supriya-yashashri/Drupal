<?php

namespace Drupal\task\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Block.
 *
 * @Block(
 *   id = "task_block",
 *   admin_label = @Translation("Task block")
 * )
 */
class TaskBlock extends BlockBase implements ContainerFactoryPluginInterface{

  /**
   * Stores the configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Creates a Block instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('config.factory'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
  $config = $this->configFactory->get('task_config_form.settings');
 	$country = $config->get('country');
 	$city = $config->get('city');
 	$placeholder = crc32('a placeholder string');

 	$timezone = [
 		'#lazy_builder' => ['task.timezone:getTimeZone', [$placeholder]],
 		'#create_placeholder' =>TRUE
 	];
    return [
      '#theme' => 'task_theme_block',
      '#city' => $city,
      '#country' => $country,
      '#timezone' => $timezone,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
     return Cache::mergeTags(parent::getCacheTags(), ['config:task_config_form.settings']);
  }

}
