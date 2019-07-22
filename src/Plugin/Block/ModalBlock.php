<?php
/**
 * @file
 * Contains \Drupal\custom_modal\Plugin\Block\ModalBlock.
 */

namespace Drupal\custom_modal\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides a 'Modal' Block
 *
 * @Block(
 *   id = "modal_block",
 *   admin_label = @Translation("Modal block"),
 * )
 */
class ModalBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    // Load modal Config.
    // $config = $this->getConfiguration();
    // Load content config.
    $content = \Drupal::config('important_information.settings');
    $body = $content->get('body');
    $information = array(
      '#type' => 'processed_text',
      '#text' => $body['value'],
      '#format' => $body['format'],
    );

    $link_url = Url::fromRoute('important_information.modal');
    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 400]),
      ]
    ]);

    return array(
      '#type' => 'markup',
      '#theme' => 'important_information_modal',
      '#information' => $information,
      '#attached' => ['library' => ['core/drupal.dialog.ajax']]
    );
  }
}