<?php
/**
 * @file
 * Contains \Drupal\important_information\Plugin\Block\AcknowledgeImportant.
 */

namespace Drupal\important_information\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Component\Serialization\Json;

/**
 * Provides a 'Modal' Block that checks for acknowledgement of the II
 *
 * @Block(
 *   id = "acknowledge_important",
 *   admin_label = @Translation("Important Information: Acknowledgement Modal"),
 * )
 */
class AcknowledgeImportant extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $link_url = Url::fromRoute('important_information.intro_modal');
    $link_url->setOptions([
      'attributes' => [
        'class' => ['use-ajax', 'button', 'button--small'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode(['width' => 400]),
      ]
    ]);

    return array(
      '#type' => 'markup',
      '#markup' => Link::fromTextAndUrl(t('Open modal'), $link_url)->toString(),
      '#attached' => [
        'library' => [
          'core/drupal.dialog.ajax',
          'important_information/importantInformationAcknowledge'
        ],

      ]
    );
  }
}