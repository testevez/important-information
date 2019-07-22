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
 * Provides an Important Information block for a footer region.
 *
 * @Block(
 *   id = "important_footer",
 *   admin_label = @Translation("Important Information: Footer"),
 *   category = @Translation("Important Information")
 * )
 */
class ImportantFooter extends BlockBase {
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
    if ($config['full_size_button']) {
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
        '#markup' => Link::fromTextAndUrl(t('Open modal'), $link_url)->toString(),
      );
      $variables['#attached']['library'][] = ['core/drupal.dialog.ajax'];
    }

    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['body'] = array(
      '#type' => 'text_format',
      '#title' => 'Body',
      '#format' => 'full_html',
      '#default_value' => '<p>The quick brown fox jumped over the lazy dog.</p>',
      '#description' => t(''),
    );


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
