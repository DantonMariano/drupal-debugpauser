<?php

namespace Drupal\debugpause\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides Settings Form for the Debug Pause Module.
 */
class DebugpauseSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'debugpause_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    // Form constructor.
    parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('debugpause.settings');

    $form['pausein'] = [
      '#type' => 'number',
      '#title' => $this->t('Amount of time before it pauses'),
      '#default_value' => $config->get('pausein'),
      '#description' => $this->t('Amount of time in Miliseconds before it pauses.'),
    ];

    $form['submit_button'] = [
      '#type' => 'submit',
      '#title' => $this->t('Submit'),
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('debugpause.settings');
    $config->set('pausein', $form_state->getValue('pausein'));
    $config->save();
    // Clears cache.
    drupal_flush_all_caches();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!is_numeric($form_state->getValue('pausein'))) {
      $form_state->setErrorByName('phone_number', $this->t('Please insert a valid number.'));
    }
    return parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return [
      'debugpause.settings',
    ];
  }

}
