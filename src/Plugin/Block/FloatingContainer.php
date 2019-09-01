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
 *   id = "floating_container",
 *   admin_label = @Translation("Important Information: Floating Container"),
 *   category = @Translation("Important Information")
 * )
 */
class FloatingContainer extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    // Load content config.
    $content = \Drupal::config('important_information.content');

    $important_information_value = $content->get('important_information_value');
    $important_information_format = $content->get('important_information_format');

    $prefix_value = $content->get('container_prefix_value');
    $prefix_format = $content->get('container_prefix_format');

    $suffix_value = $content->get('container_suffix_value');
    $suffix_format = $content->get('container_suffix_format');

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

    // Format information via TPL
    $variables = array(
      '#type' => 'markup',
      '#theme' => 'important_information_floating_container',
      '#information' => $information,
      '#info_prefix' => isset($prefix_value) ?  $info_prefix : FALSE,
      '#info_suffix' => isset($suffix_value) ?  $info_suffix : FALSE,
      '#attached' => array(
        'library' => array(
          'important_information/importantInformationFloatingContainer',
        ),
      ),
    );

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

    // Check for Expandability
    if ($config['expand']['expandable']) {

      $default_expand_markup = array(
        '#type' => 'processed_text',
        '#text' => $config['expand']['expand_button_markup']['value'],
        '#format' => $config['expand']['expand_button_markup']['format'],
      );

      $variables['#expandable'] = TRUE;
      $variables['#default_expand_markup'] = $default_expand_markup;
      $variables['#attached']['library'][] = 'core/drupal.dialog.ajax';

      $default_shrink_markup = array(
        '#type' => 'processed_text',
        '#text' => $config['expand']['shrink_button_markup']['value'],
        '#format' => $config['expand']['shrink_button_markup']['format'],
      );

      // Add more scripts
      $variables['#attached']['drupalSettings']['important_information']['importantInformationFloatingContainer'] = array(
        'expandable' => TRUE,
        'expandMarkup' => render($default_expand_markup),
        'shrinkMarkup' => render($default_shrink_markup),
        'expandAmount' => $config['expand']['expandable_amount'],
      );
    }
    else {
      $variables['#expandable'] = FALSE;
      $variables['#attached']['drupalSettings']['important_information']['importantInformationFloatingContainer'] = array('expandable' => FALSE);
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
    $form['expand'] = array(
      '#type' => 'fieldset',
      '#title' => $this
        ->t('Expandable Footer controls'),
    );
    $form['expand']['expandable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Expand Button'),
      '#default_value' => isset($config['expand']['expandable']) ? $config['expand']['expandable'] : FALSE,
      '#description' => $this->t('Allows the user to expand the footer to see more of the content.'),
    ];
    $form['expand']['expandable_amount'] = [
      '#type' => 'textfield',
      '#title' => $this->t('% of Screen for Expanded Footer'),
      '#default_value' => isset($config['expandable_amount']) ? $config['expand']['expandable_amount'] : IMPORTANT_INFORMATION_FOOTER_EXPANDED_PERCENT_DEFAULT,
      '#description' => $this->t('Percentage of the screen the expanded footer will cover.'),
    ];
    $expand_button_markup = $config['expand']['expand_button_markup'];
    $form['expand']['expand_button_markup'] =[
      '#type' => 'text_format',
      '#title' => 'Expand Button',
      '#format' => $expand_button_markup['format'] ? $expand_button_markup['format'] : NULL,
      '#default_value' => $expand_button_markup['value'] ? $expand_button_markup['value'] : $this->t('Expand'),
      '#description'  => $this->t('Set markup for the expand button.'),
    ];
    $shrink_button_markup = $config['expand']['shrink_button_markup'];
    $form['expand']['shrink_button_markup'] = [
      '#type' => 'text_format',
      '#title' => 'Un-expand button',
      '#format' => $shrink_button_markup['format'] ? $shrink_button_markup['format'] : NULL,
      '#default_value' => $shrink_button_markup['value'] ? $shrink_button_markup['value'] : $this->t('Collapse'),
      '#description'  => $this->t('Set markup for the un-expand button.'),
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
