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
      '#theme' => 'important_information_footer',
      '#information' => $information,
      '#attached' => array(
        'library' => array(
          'important_information/importantInformationFooter',
        ),
      ),
    );

    // Load block Config.
    $config = $this->getConfiguration();
    // Check for full size button
    if ($config['full_size_button'] || TRUE) {
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
