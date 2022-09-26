<?php

namespace Drupal\task\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class TaskConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(){
	return 'task_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames(){
	return ['task_config_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('task_config_form.settings');

	$form['country'] = [
	'#type' => 'textfield',
	'#title' => $this->t('Country'),
	'#default_value' => $config->get('country'),
	];

	$form['city'] = [
	'#type' => 'textfield',
	'#title' => $this->t('City'),
	'#default_value' => $config->get('city'),
	];

	$form['timezone'] = [
	'#type' => 'select',
	'#title' => $this->t('Options in the select list'),
	'#default_value' => $config->get('timezone'),
	'#options' => [
		'America/Chicago' => $this->t('America/Chicago'),
		'America/New_York' => $this->t('America/New_York'),
		'Asia/Tokyo' => $this->t('Asia/Tokyo'),
		'Asia/Dubai' => $this->t('Asia/Dubai'),
		'Asia/Kolkata' => $this->t('Asia/Kolkata'),
		'Europe/Amsterdam' => $this->t('Europe/Amsterdam'),
		'Europe/Oslo' => $this->t('Europe/Oslo'),
		'Europe/London' => $this->t('Europe/London'),
	],
	];

  return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	$this->config('task_config_form.settings')
	->set('country', $form_state->getValue('country'))
	->set('city', $form_state->getValue('city'))
	->set('timezone', $form_state->getValue('timezone'))
	->save();
	parent::submitForm($form, $form_state);
  }
}
