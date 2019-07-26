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
    $content = \Drupal::config('important_information.content');
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


    // Check if we need to append the II to the bottom of the page
    $settings = \Drupal::config('important_information.settings');
    $append_bottom = $settings->get('append_bottom');
    switch ($append_bottom) {
      case IMPORTANT_INFORMATION_APPEND_BOTTOM_ALWAYS :
      case IMPORTANT_INFORMATION_APPEND_BOTTOM_FOOTER :

      // Load the rest of the details
      $append_bottom_hide_sidebar = ($settings->get('append_bottom_hide_sidebar') === NULL);
      $append_bottom_hide_footer = ($settings->get('append_bottom_footer') === NULL);
      $vertical_offset = $settings->get('vertical_offset');

      // Format information via TPL
      $render_array = array(
        '#type' => 'markup',
        '#theme' => 'important_information_bottom',
        '#information' => $information,
      );

      // Add more scripts
      $variables['#attached']['drupalSettings']['important_information']['importantInformationBottom'] = array(
        'markup' => render($render_array),
        'container' => '.layout-container',
        'verticalOffset' => $vertical_offset,
        'hideSidebar' => $append_bottom_hide_sidebar,
        'hideFooter' => $append_bottom_hide_footer,
      );
      $variables['#attached']['library'][] = 'important_information/importantInformationBottom';
    }

    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['modal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Full-size Modal'),
      '#default_value' => isset($config['modal']) ? $config['modal'] : FALSE,
      '#description' => $this->t('Provides a button to present the Important Information in a full screen modal.'),
    ];
    $form['hide_at_bottom'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Hide at Page Bottom'),
      '#default_value' => isset($config['hide_at_bottom']) ? $config['hide_at_bottom'] : FALSE,
      '#description' => $this->t('Hides the II Sidebar in the event that the user has scrolled to the bottom of the page and an see the II there. Please note that there is a separate config that enables the II to appear at the bottom of the page (currently %status).', array('%status' => 'disabled')),
    ];
    unset($form['body']);


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
