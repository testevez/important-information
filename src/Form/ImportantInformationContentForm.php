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
/*
    // Floating Container
    $form['floating_container'] = array(
      '#type' => 'details',
      '#title' => $this->t('Additional Content for Floating Container'),
      '#collapsible' => TRUE,
    );
    $prefix = $config->get('container_prefix');
    $suffix = $config->get('container_suffix');
    $form['floating_container']['container_prefix'] = array(
      '#type' => 'text_format',
      '#title' => 'Floating Container Prefix',
      '#format' => $prefix['format'],
      '#default_value' => $prefix['value'],
      '#description'  => $this->t('Set additional markup to be displayed before the Important Information when displayed in the Floating Container.'),
    );
    $form['floating_container']['container_suffix'] = array(
      '#type' => 'text_format',
      '#title' => 'Floating Container Suffix',
      '#format' => $suffix['format'],
      '#default_value' => $suffix['value'],
      '#description'  => $this->t('Set additional markup to be displayed after the Important Information when displayed in the Floating Container.'),
    );

    // Appended Bottom
    $form['footer'] = array(
      '#type' => 'details',
      '#title' => $this->t('Additional Content for Footer  /  Page Bottom'),
      '#collapsible' => TRUE,
    );
    $prefix = $config->get('footer_prefix');
    $suffix = $config->get('footer_suffix');
    $form['footer']['footer_prefix'] = array(
      '#type' => 'text_format',
      '#title' => 'Footer  /  Page Bottom Prefix',
      '#format' => $prefix['format'],
      '#default_value' => $prefix['value'],
      '#description'  => $this->t('Set additional markup to be displayed before the Important Information when displayed in the Page Bottom.'),
    );
    $form['footer']['footer_suffix'] = array(
      '#type' => 'text_format',
      '#title' => 'Footer  /  Page Bottom Suffix',
      '#format' => $suffix['format'],
      '#default_value' => $suffix['value'],
      '#description'  => $this->t('Set additional markup to be displayed after the Important Information when displayed in the Page Bottom.'),
    );
*/
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

    $sidebar_prefix = $form_state->getValue('sidebar_prefix');
    $sidebar_prefix_value = $sidebar_prefix['value'];
    $sidebar_prefix_format = $sidebar_prefix['format'];

    $sidebar_suffix = $form_state->getValue('sidebar_suffix');
    $sidebar_suffix_value = $sidebar_suffix['value'];
    $sidebar_suffix_format = $sidebar_suffix['format'];

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
      ->set('acknowledgement_modal_title', $acknowledgement_modal_title)
      ->save();
    parent::submitForm($form, $form_state);
  }
}