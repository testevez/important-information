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
    $settings = $this->config('important_information.settings');
/*
    $force_intro = $settings->get('force_intro');
    $append_bottom = $settings->get('append_bottom');
    $append_bottom_hide_sidebar = $settings->get('append_bottom_hide_sidebar');
    $append_bottom_hide_footer = $settings->get('append_bottom_hide_footer');
    $vertical_offset = $settings->get('vertical_offset');
    $attach_to = $settings->get('attach_to');

    $form['intro'] = array(
      '#type' => 'details',
      '#title' => $this->t('Important Information intro details'),
      '#collapsible' => TRUE,
    );
    // TODO: make cookie duration configurable
    $form['intro']['force_intro'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Intro Modal'),
      '#default_value' => isset($force_intro) ? $force_intro : FALSE,
      '#description' => $this->t('Presents first-time visits to site the Important Information intro in a modal. Acknowledging the modal  will  set a cookie to remember  the user  for 7  days.'),
    );
    $form['leave_site'] = array(
      '#type' => 'details',
      '#title' => $this->t('Important Information exit details'),
      '#collapsible' => TRUE,
    );
    $form['leave_site']['interstitial'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Exit Modal'),
      '#default_value' => isset($force_intro) ? $force_intro : FALSE,
      '#description' => $this->t('Users leaving  the site via in-site navigation will be  presented the Important Information interstitial in a modal.'),
    );
/*
    $form['footer'] = array(
      '#type' => 'details',
      '#title' => $this
        ->t('Append Important Information (a.ka. II) to Bottom'),
      '#collapsible' => TRUE,
    );
    $options = array(
      IMPORTANT_INFORMATION_APPEND_BOTTOM_NEVER => 'Never',
      IMPORTANT_INFORMATION_APPEND_BOTTOM_ALWAYS => 'When either the footer or the sidebar is on the page',
      IMPORTANT_INFORMATION_APPEND_BOTTOM_FOOTER => 'Only when the footer block is on the page',
      IMPORTANT_INFORMATION_APPEND_BOTTOM_SIDEBAR => 'Only when the sidebar block is on the page',
    );
    $form['footer']['append_bottom'] = array (
      '#type' => 'radios',
      '#title' => $this->t('Append to Page Bottom'),
      '#default_value' => isset($append_bottom) ? $append_bottom : 'Never',
      '#multiple' => FALSE,
      '#options' => $options,
      '#description' => $this->t('Appends the II to the bottom of the page.'),
    );
    $form['footer']['append_bottom_hide_sidebar'] = array (
      '#type' => 'checkbox',
      '#title' => $this->t('Hide sidebar when II Bottom is in the viewport.'),
      '#default_value' => isset($append_bottom_hide_sidebar) ? $append_bottom_hide_sidebar : FALSE,
    );
    $form['footer']['append_bottom_hide_footer'] = array (
      '#type' => 'checkbox',
      '#title' => $this->t('Hide footer when II Bottom is in the viewport.'),
      '#default_value' => isset($append_bottom_hide_footer) ? $append_bottom_hide_footer : FALSE,
    );
    $form['footer']['vertical_offset'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Vertical Offset.'),
      '#default_value' => isset($vertical_offset) ? $vertical_offset : 0,
      '#description' => $this->t('This value adjusts the detection of when to append the II to the bottom of the page. 40 is a good number for this value.'),
    );
    $form['footer']['attach_to'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Attach to'),
      '#default_value' => isset($attach_to) ? $attach_to : '',
      '#description' => $this->t('Selector that determines to which object in the DOM to append() the II to.'),
    );
*/
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('important_information.settings')
      // Set the submitted configuration setting
      //->set('force_intro', $form_state->getValue('force_intro'))
      ->save();
    parent::submitForm($form, $form_state);

  }
}