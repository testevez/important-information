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
    $content = \Drupal::config('important_information.content');
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
        'library' => array(
          'important_information/importantInformationSidebar',
        ),
      ),
    );

    // Load block Config.
    $config = $this->getConfiguration();

    // Add block config to settings

    $variables['#attached']['drupalSettings']['important_information']['importantInformationSidebar'] = array(
      'sidebarParent' => isset($config['essential']['parent']) ? $config['essential']['parent'] : '',
      'sidebarContainer' => isset($config['essential']['container']) ? $config['essential']['container'] : '',
    );

    // load more stuff if we need a modal
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
      case IMPORTANT_INFORMATION_APPEND_BOTTOM_SIDEBAR :

        // Load the rest of the details
        $append_bottom_hide_sidebar = ($settings->get('append_bottom_hide_sidebar') === NULL);
        $append_bottom_hide_footer = ($settings->get('append_bottom_footer') === NULL);
        $vertical_offset = $settings->get('vertical_offset');
        $attach_to = $settings->get('attach_to');

        // Format information via TPL
        $render_array = array(
          '#type' => 'markup',
          '#theme' => 'important_information_bottom',
          '#information' => $information,
        );

        // Add more scripts
        $variables['#attached']['drupalSettings']['important_information']['importantInformationBottom'] = array(
          'markup' => render($render_array),
          'attach_to' => $attach_to,
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

    $form['instructions'] = [
      '#markup' => '<h2>Instructions</h2><p>This is not a standard block. Turning on the <em>Display title</em> may have some unintended effect.</em></p>',
    ];


    $config = $this->getConfiguration();
    $form['essential'] = array(
      '#type' => 'fieldset',
      '#title' => $this
        ->t('Essential Fields'),
      '#description' => $this->t('This block will not behave properly without these fields being set.'),

    );
    $form['essential']['parent'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Parent'),
      '#default_value' => isset($config['essential']['parent']) ? $config['essential']['parent'] : '',
      '#description' => $this->t('See https://abouolia.github.io/sticky-sidebar/#usage for more information.'),
    ];
    $form['essential']['container'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Container'),
      '#default_value' => isset($config['essential']['container']) ? $config['essential']['container'] : '',
      '#description' => $this->t('See https://abouolia.github.io/sticky-sidebar/#usage for more information.'),
    ];
    /*
    $form['additional_markup'] = array(
      '#type' => 'fieldset',
      '#title' => $this
        ->t('Additional Markup'),
      '#description' => $this->t('Markup for this block, in addition the the markup set in the Important Information content form.'),
    );
    $before = $config['additional_markup']['before'];
    $form['additional_markup']['before'] = array(
      '#type' => 'text_format',
      '#title' => 'Before',
      '#format' => $before['format'],
      '#default_value' => $before['value'],
    );

    $after = $config['additional_markup']['after'];
    $form['additional_markup']['after'] = array(
      '#type' => 'text_format',
      '#title' => 'After',
      '#format' => $after['format'],
      '#default_value' => $after['value'],
    );
    */
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
