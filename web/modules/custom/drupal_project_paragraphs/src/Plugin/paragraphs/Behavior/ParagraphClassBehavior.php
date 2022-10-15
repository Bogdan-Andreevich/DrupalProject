<?php

namespace Drupal\drupal_project_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\Html;
use Drupal\Core\StringTranslation\PluralTranslatableMarkup;
use Drupal\paragraphs\Annotation\ParagraphsBehavior;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 *  Class ParagraphClassBehavior
 *
 * @ParagraphsBehavior(
 *   id = "drupal_project_paragraphs_paragraph_class",
 *   label = @Translation("Custom classes for Paragraphs"),
 *   description = @Translation("Allows to add custom classes to Paragraphs"),
 *  weight = 0,
 * )
 */
class ParagraphClassBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type)
  {
     return TRUE;
  }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $classes_value = $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', '');
    //dump($classes_value);
    $classes = explode(" ", $classes_value);
    foreach ($classes as $class){
      $build['#attributes']['class'][] = $class;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
    $form['classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Classes'),
      '#description' => $this->t('Multiple classes separated by space.'),
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', ''),
    ];

    return $form;
  }
}
