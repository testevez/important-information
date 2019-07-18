<?php
/**
 * @file
 */
namespace Drupal\important_information\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\views\Views;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an Important Information block for a sidebar region.
 *
 * @Block(
 *   id = "important_sidebar",
 *   admin_label = @Translation("Important Information: Sidebar"),
 *   category = @Translation("PoC")
 * )
 */
class ImportantSidebar extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $config = $this->getConfiguration();
    // TODO: get $information from config
    $information = '<h2>Read this</h2>';
    $information .= '<h3 id="why-sticky-sidebar-is-awesome">Why sticky sidebar is awesome?</h3>';
    $information .= '<ul>
  <li>It does not re-calculate all dimensions when scrolling, just neccessary dimensions.</li>
  <li>Super smooth without incurring scroll lag or jank and no page reflows.</li>
  <li>Integrated with resize sensor to re-calculate all dimensions of the plugin when the size of sidebar and its container is changed.</li>
  <li>It has event trigger on each affix type to hook your code under particular situations.</li>
  <li>Handle the sidebar when it is tall or too short compared to the rest of the container.</li>
  <li>Zero dependencies and super simple to setup.</li>
</ul>';

    $variables = array(
      '#type' => 'markup',
      '#theme' => 'important_information_sidebar',
      '#information' => '<h3 id="why-sticky-sidebar-is-awesome">Why sticky sidebar is awesome?</h3><ul>
  <li>It does not re-calculate all dimensions when scrolling, just neccessary dimensions.</li>
  <li>Super smooth without incurring scroll lag or jank and no page reflows.</li>
  <li>Integrated with resize sensor to re-calculate all dimensions of the plugin when the size of sidebar and its container is changed.</li>
  <li>It has event trigger on each affix type to hook your code under particular situations.</li>
  <li>Handle the sidebar when it is tall or too short compared to the rest of the container.</li>
  <li>Zero dependencies and super simple to setup.</li>
</ul>',
      '#attached' => array(
        'library' => array('important_information/importantInformationSidebar'),
      ),
    );
    //$variables['#attached']['drupalSettings']['atsnj_ads']['landscapeAdsBlock']['interval'] = isset($config['interval']) ? $config['interval'] : '2500';
    return $variables;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['placeholder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Time Interval'),
      '#default_value' => isset($config['placeholder']) ? $config['placeholder'] : 'placeholder',
      '#description' => $this->t('Placeholder.'),
    ];

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
