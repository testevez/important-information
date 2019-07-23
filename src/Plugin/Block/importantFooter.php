<?php
/**
 * @file
 */
namespace Drupal\important_information\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\views\Views;
use Drupal\Core\Form\FormStateInterface;

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
      '#theme' => 'important_information_footer',
      '#information' => $information,
      '#attached' => array(
        'library' => array(
          'important_information/importantInformationFooter',
        ),
      ),
    );
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
