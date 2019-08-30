<?php

/**
 * @file
 * ImportantInformationModalController class.
 */

namespace Drupal\important_information\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;

class ImportantInformationModalController extends ControllerBase {

  public function modal() {

    // Load content config.
    $content = \Drupal::config('important_information.content');
    $body = $content->get('important_formation');
    $information = array(
      '#type' => 'processed_text',
      '#text' => $body['value'],
      '#format' => $body['format'],
    );

    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '50%',
    ];
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(t('Modal title'), render($information), $options));

    return $response;
  }
}