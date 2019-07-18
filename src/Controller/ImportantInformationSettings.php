<?php
/**
 * @file
 * Contains \Drupal\important_information\Controller\ImportantInformationSettings.
 */

namespace Drupal\important_information\Controller;

class ImportantInformationSettings {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('This will be a settings form later'),
    );
  }

}