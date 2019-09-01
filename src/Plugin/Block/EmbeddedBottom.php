<?php
/**
 * @file
 */
namespace Drupal\important_information\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides an Important Information block that floats above the site, hugging
 * the bottom of the viewport.
 *
 * @Block(
 *   id = "embedded_bottom",
 *   admin_label = @Translation("Important Information: Embedded Bottom"),
 *   category = @Translation("Important Information")
 * )
 */
class EmbeddedBottom extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    // Load content config.
    $content = \Drupal::config('important_information.content');

    $important_information_value = $content->get('important_information_value');
    $important_information_format = $content->get('important_information_format');

    $prefix_value = $content->get('bottom_prefix_value');
    $prefix_format = $content->get('bottom_prefix_format');

    $suffix_value = $content->get('bottom_suffix_value');
    $suffix_format = $content->get('bottom_suffix_format');

    $info_prefix = array(
      '#type' => 'processed_text',
      '#text' => $prefix_value,
      '#format' => $prefix_format,
    );
    $information = array(
      '#type' => 'processed_text',
      '#text' => $important_information_value,
      '#format' => $important_information_format,
    );
    $info_suffix = array(
      '#type' => 'processed_text',
      '#text' => $suffix_value,
      '#format' => $suffix_format,
    );
    // Load block Config.
    $config = $this->getConfiguration();

    // Check for Modal
    if ($config['modal']) {
      $link_url = Url::fromRoute('important_information.modal');
      $link_url->setOptions([
        'attributes' => [
          'class' => ['use-ajax', 'button', 'button--small'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => Json::encode(['width' => 400]),
        ]
      ]);

      $variables['#modal'] =  array(
        '#type' => 'markup',
        '#markup' => Link::fromTextAndUrl(t('Full size'), $link_url)->toString(),
      );
      $variables['#attached']['library'][] = 'core/drupal.dialog.ajax';
    }
    // Load module settings
    $settings = \Drupal::config('important_information.settings');
    $container_hide = $settings->get('container_hide');

    // Format information via TPL
    $variables = array(
      '#type' => 'markup',
      '#theme' => 'important_information_bottom',
      '#information' => $information,
      '#info_prefix' => isset($prefix_value) ?  $info_prefix : FALSE,
      '#info_suffix' => isset($suffix_value) ?  $info_suffix : FALSE,
      '#attached' => array(
        'library' => array(
          'important_information/importantInformationBottom',
        ),
      ),
    );

    // Add block and module configuration to settings.
    $variables['#attached']['drupalSettings']['important_information']['importantInformationBottom'] = array(
      'showHideFloatingContainer' => $container_hide ? $container_hide : FALSE,
    );
    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Load  block configuration
    $config = $this->getConfiguration();

    $form['modal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Full-size Modal'),
      '#default_value' => isset($config['modal']) ? $config['modal'] : FALSE,
      '#description' => $this->t('Provides a button to present the Important Information in a full screen modal.'),
    ];

    // Load module settings
    $settings = \Drupal::config('important_information.settings');
    $container_hide = $settings->get('container_hide');
    $form['container_hide'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide/show Floating Container'),
      '#default_value' => isset($container_hide) ? $container_hide: FALSE,
      '#description' => $this->t('Hide Floating Container when Embedded bottom is in the viewport.'),
    ];
    unset($form['body']);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);

    $this->configFactory->getEditable('important_information.settings')
      // Set the submitted configuration setting
      //->set('sidebar_parent', $form_state->getValue('sidebar_parent'))
      //->set('sidebar_container', $form_state->getValue('sidebar_container'))
      ->set('container_hide', $form_state->getValue('container_hide'))
      ->save();

    $values = $form_state->getValues();
    $this->configuration = $values;
  }

}
