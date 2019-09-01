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
    // Sidebar
    $sidebar_parent = $settings->get('sidebar_parent');
    $sidebar_container = $settings->get('sidebar_container');
    $form['sidebar'] = array(
      '#type' => 'details',
      '#title' => $this->t('Sticky Sidebar Settings'),
      '#collapsible' => TRUE,
    );
    $form['sidebar']['sidebar_parent'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Parent'),
      '#default_value' => isset($sidebar_parent) ? $sidebar_parent: '',
      '#description' => $this->t('See https://abouolia.github.io/sticky-sidebar/#usage for more information.'),
    ];
    $form['sidebar']['sidebar_container'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Container'),
      '#default_value' => isset($sidebar_container) ? $sidebar_container: '',
      '#description' => $this->t('See https://abouolia.github.io/sticky-sidebar/#usage for more information.'),
    ];
*/
    // Floating Container
    $collapsed_percent = $settings->get('collapsed_percent');
    $expanded_percent = $settings->get('expanded_percent');
    $container_hide = $settings->get('container_hide');

    $form['container'] = array(
      '#type' => 'details',
      '#title' => $this->t('Floating Container Settings'),
      '#collapsible' => TRUE,
    );
    $form['container']['container_hide'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide/show Floating Container'),
      '#default_value' => isset($container_hide) ? $container_hide: FALSE,
      '#description' => $this->t('Hide Floating Container when Embedded Bottom is in the viewport.'),
    ];
    $form['container']['offset'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hide/show Offset'),
      '#default_value' => isset($offset) ? $offset: 0,
      '#description' => $this->t('Adjust the calibration of the Embedded Bottom detection; lower than zero makes it happen faster.'),
    ];
    $form['container']['collapsed_percent'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Percentage of viewport the collapsed Floating Container occupies'),
      '#default_value' => isset($collapsed_percent) ? $collapsed_percent: IMPORTANT_INFORMATION_FOOTER_COLLAPSED_PERCENT_DEFAULT,
      '#description' => $this->t('Numbers only, do not add the %.'),
    ];
    $form['container']['expanded_percent'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Percentage of viewport the expanded Floating Container occupies'),
      '#default_value' => isset($expanded_percent) ? $expanded_percent: IMPORTANT_INFORMATION_FOOTER_EXPANDED_PERCENT_DEFAULT,
      '#description' => $this->t('Numbers only, do not add the %.'),
    ];

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

*/
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('important_information.settings')
      // Set the submitted configuration setting
      //->set('sidebar_parent', $form_state->getValue('sidebar_parent'))
      //->set('sidebar_container', $form_state->getValue('sidebar_container'))
      ->set('container_hide', $form_state->getValue('container_hide'))
      ->save();

    parent::submitForm($form, $form_state);

  }
}