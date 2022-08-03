<?php

namespace Drupal\debugpause\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class debugpauseSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'debugpause_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    // Form constructor
    parent::buildForm($form, $form_state);
    // Default settings
    $config = $this->config('debugpause.settings');

    $form['pausein'] = [
      '#type' => 'number',
      '#title' => $this->t('Amount of time before it pauses'),
      '#default_value' => $config->get('pausein'),
      '#description' => $this->t('Amount of time in Miliseconds before it pauses.')
    ];

    $form['submit_button'] = [
      '#type' => 'submit',
      '#title' => $this->t('Submit'),
      '#value' => $this->t('Submit')
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config('debugpause.settings');
    $config->set('pausein', $form_state->getValue('pausein'));
    $config->save();
    \Drupal::service('cache.render')->invalidateAll();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {

  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'debugpause.settings'
    ];
  }

}
