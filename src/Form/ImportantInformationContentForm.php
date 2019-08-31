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
    return 'important_information_content';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'important_information.content',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('important_information.content');

    // Acknowledgement Modal
    $form['acknowledgement_modal'] = array(
      '#type' => 'details',
      '#title' => $this->t('Important Information Acknowledgement Modal'),
      '#collapsible' => TRUE,
      '#description' => $this->t('Content for the acknowledgement modal'),
    );
    $title = $config->get('acknowledgement_modal_title');
    $form['acknowledgement_modal']['acknowledgement_modal_title'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Modal Title'),
      '#default_value' => isset($title) ? $title : '',
    );
    $value = $config->get('important_information_intro_value');
    $format = $config->get('important_information_intro_format');
    $form['acknowledgement_modal']['important_information_intro'] = array(
      '#type' => 'text_format',
      '#title' => 'Important Information in Acknowledgement Modal',
      '#format' => $format ? $format : NULL,
      '#default_value' => $value,
      '#description'  => $this->t('Set the Important Information acknowledgement modal.'),
    );

    // Main
    $form['main'] = array(
      '#type' => 'details',
      '#title' => $this->t('Important Information Content'),
      '#collapsible' => TRUE,
    );
    $value = $config->get('important_information_value');
    $format = $config->get('important_information_format');
    $form['main']['important_information'] = array(
      '#type' => 'text_format',
      '#title' => 'Important Information',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set the Important Information markup.'),
    );

    // Sticky Sidebar
    $form['sticky_sidebar'] = array(
      '#type' => 'details',
      '#title' => $this->t('Additional Content for Sticky Sidebar'),
      '#collapsible' => TRUE,
    );
    $value = $config->get('sidebar_prefix_value');
    $format = $config->get('sidebar_prefix_format');
    $form['sticky_sidebar']['sidebar_prefix'] = array(
      '#type' => 'text_format',
      '#title' => 'Sticky Sidebar Prefix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed before the Important Information when displayed in the Sticky Sidebar.'),
    );
    $value = $config->get('sidebar_suffix_value');
    $format = $config->get('sidebar_suffix_format');
    $form['sticky_sidebar']['sidebar_suffix'] = array(
      '#type' => 'text_format',
      '#title' => 'Sticky Sidebar Suffix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed after the Important Information when displayed in the Sticky Sidebar.'),
    );
    // Floating Container
    $form['floating_container'] = array(
      '#type' => 'details',
      '#title' => $this->t('Additional Content for Floating Container'),
      '#collapsible' => TRUE,
    );
    $value = $config->get('container_prefix_value');
    $format = $config->get('container_prefix_format');
    $form['floating_container']['container_prefix'] = array(
      '#type' => 'text_format',
      '#title' => 'Floating Container Prefix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed before the Important Information when displayed in the Floating Container.'),
    );
    $value = $config->get('container_suffix_value');
    $format = $config->get('container_suffix_format');
    $form['floating_container']['container_suffix'] = array(
      '#type' => 'text_format',
      '#title' => 'Floating Container Suffix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed after the Important Information when displayed in the Floating Container.'),
    );
    // Embedded Bottom
    $form['embedded_bottom'] = array(
      '#type' => 'details',
      '#title' => $this->t('Additional Content for Embedded Bottom'),
      '#collapsible' => TRUE,
    );
    $value = $config->get('bottom_prefix_value');
    $format = $config->get('bottom_prefix_format');
    $form['embedded_bottom']['bottom_prefix'] = array(
      '#type' => 'text_format',
      '#title' => 'Embedded Bottom Prefix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed before the Important Information when displayed in the Embedded Bottom.'),
    );
    $value = $config->get('bottom_suffix_value');
    $format = $config->get('bottom_suffix_format');
    $form['embedded_bottom']['bottom_suffix'] = array(
      '#type' => 'text_format',
      '#title' => 'Embedded Bottom Suffix',
      '#format' => $format,
      '#default_value' => $value,
      '#description'  => $this->t('Set additional markup to be displayed after the Important Information when displayed in the Embedded Bottom.'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration

    $important_information_intro = $form_state->getValue('important_information_intro');
    $important_information_intro_value = $important_information_intro['value'];
    $important_information_intro_format = $important_information_intro['format'];

    $important_information = $form_state->getValue('important_information');
    $important_information_value = $important_information['value'];
    $important_information_format = $important_information['format'];

    // Sticky Sidebar
    $sidebar_prefix = $form_state->getValue('sidebar_prefix');
    $sidebar_prefix_value = $sidebar_prefix['value'];
    $sidebar_prefix_format = $sidebar_prefix['format'];

    $sidebar_suffix = $form_state->getValue('sidebar_suffix');
    $sidebar_suffix_value = $sidebar_suffix['value'];
    $sidebar_suffix_format = $sidebar_suffix['format'];

    // Floating Container
    $container_prefix = $form_state->getValue('container_prefix');
    $container_prefix_value = $container_prefix['value'];
    $container_prefix_format = $container_prefix['format'];

    $container_suffix = $form_state->getValue('container_suffix');
    $container_suffix_value = $container_suffix['value'];
    $container_suffix_format = $container_suffix['format'];

    // Embedded Bottom
    $bottom_prefix = $form_state->getValue('bottom_prefix');
    $bottom_prefix_value = $bottom_prefix['value'];
    $bottom_prefix_format = $bottom_prefix['format'];

    $bottom_suffix = $form_state->getValue('bottom_suffix');
    $bottom_suffix_value = $bottom_suffix['value'];
    $bottom_suffix_format = $bottom_suffix['format'];

    $acknowledgement_modal_title = $form_state->getValue('acknowledgement_modal_title');

    $this->configFactory->getEditable('important_information.content')
      // Set the submitted configuration setting
      ->set('important_information_intro_value', $important_information_intro_value)
      ->set('important_information_intro_format', $important_information_intro_format)
      ->set('important_information_value', $important_information_value)
      ->set('important_information_format', $important_information_format)
      ->set('sidebar_prefix_value', $sidebar_prefix_value)
      ->set('sidebar_prefix_format', $sidebar_prefix_format)
      ->set('sidebar_suffix_value', $sidebar_suffix_value)
      ->set('sidebar_suffix_format', $sidebar_suffix_format)
      ->set('container_prefix_value', $container_prefix_value)
      ->set('container_prefix_format', $container_prefix_format)
      ->set('container_suffix_value', $container_suffix_value)
      ->set('container_suffix_format', $container_suffix_format)
      ->set('bottom_prefix_value', $bottom_prefix_value)
      ->set('bottom_prefix_format', $bottom_prefix_format)
      ->set('bottom_suffix_value', $bottom_suffix_value)
      ->set('bottom_suffix_format', $bottom_suffix_format)
      ->set('acknowledgement_modal_title', $acknowledgement_modal_title)
      ->save();
    parent::submitForm($form, $form_state);
  }
}