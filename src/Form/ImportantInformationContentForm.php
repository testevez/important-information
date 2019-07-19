<?php

namespace Drupal\important_information\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure important_information content.
 */
class ImportantInformationContentForm extends ConfigFormBase {
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
    $body = $config->get('body');
    $form['body'] = array(
      '#type' => 'text_format',
      '#title' => 'Important Information',
      '#format' => $body['format'],
      '#default_value' => $body['value'],
      '#description'  => $this->t('Set the Important Information markup.'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->configFactory->getEditable('important_information.settings')
      // Set the submitted configuration setting
      ->set('body', $form_state->getValue('body'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}