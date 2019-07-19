<?php
/**
 * @file
 */
namespace Drupal\important_information\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\views\Views;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an Important Information block for a sidebar region.
 *
 * @Block(
 *   id = "important_sidebar",
 *   admin_label = @Translation("Important Information: Sidebar"),
 *   category = @Translation("Important Information")
 * )
 */
class ImportantSidebar extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    // Load block Config.
    $config = $this->getConfiguration();
    // Load content config.
    $content = \Drupal::config('important_information.settings');
    $body = $content->get('body');
    $information = array(
      '#type' => 'processed_text',
      '#text' => $body['value'],
      '#format' => $body['format'],
    );
    $variables = array(
      '#type' => 'markup',
      '#theme' => 'important_information_sidebar',
      '#information' => $information,
      '#attached' => array(
        'library' => array('important_information/importantInformationSidebar'),
      ),
    );
    //$variables['#attached']['drupalSettings']['atsnj_ads']['landscapeAdsBlock']['interval'] = isset($config['interval']) ? $config['interval'] : '2500';
    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Time Interval'),
      '#default_value' => isset($config['placeholder']) ? $config['placeholder'] : 'placeholder',
      '#description' => $this->t('Placeholder.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration = $values;
  }

}
