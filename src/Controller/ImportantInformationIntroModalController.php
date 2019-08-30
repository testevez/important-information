<?php

/**
 * @file
 * ImportantInformationIntroModalController class.
 */

namespace Drupal\important_information\Controller;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Drupal\Core\Controller\ControllerBase;

class ImportantInformationIntroModalController extends ControllerBase {

  public function modal() {

    // Load content config.

    $config = $this->config('important_information.content');
    $value = $config->get('important_information_intro_value');
    $format = $config->get('important_information_intro_format');
    $title = $config->get('acknowledgement_modal_title');

    $information = array(
      '#type' => 'processed_text',
      '#text' => $value,
      '#format' => $format,
    );

    $options = [
      'dialogClass' => 'popup-dialog-class',
      'width' => '50%',  // TODO: Make this configurable
    ];
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand(t($title), render($information), $options));

    return $response;
  }
}