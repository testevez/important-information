<?php

namespace Drupal\important_information\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure important_information content.
 */
class ImportantInformationSettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'important_information_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'important_information.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('important_information.settings');
    $append_bottom = $config->get('append_bottom');
    $form['append_bottom'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Append to Page Bottom'),
      '#default_value' => isset($append_bottom) ? $append_bottom : FALSE,
      '#description' => $this->t('Appends the II to the bottom of the page.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->configFactory->getEditable('important_information.settings')
      // Set the submitted configuration setting
      ->set('append_bottom', $form_state->getValue('append_bottom'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}