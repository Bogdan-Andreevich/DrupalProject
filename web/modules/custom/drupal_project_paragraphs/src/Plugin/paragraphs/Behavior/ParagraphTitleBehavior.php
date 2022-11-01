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
use Drupal\Component\Utility;

/**
 *  Class ParagraphTitleBehavior
 *
 * @ParagraphsBehavior(
 *   id = "drupal_project_paragraphs_paragraph_title",
 *   label = @Translation("Custom titles for Paragraphs"),
 *   description = @Translation("Allows to add custom titles to Paragraphs"),
 *  weight = 0,
 * )
 */
class ParagraphTitleBehavior extends ParagraphsBehaviorBase {

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

  }

  /**
   * {@inheritdoc}
   */
  public function preprocess(&$variables)
  {
    /** @var \Drupal\paragraphs\ParagraphInterface $paragraph */
    $paragraph = $variables['paragraph'];
    $variables['title_wrapper'] = $paragraph->getBehaviorSetting($this->getPluginId(), 'title_wrapper', 'h2');
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
    if ($paragraph->hasField('field_tittle')){
      $form['title_wrapper'] = [
        '#type' => 'select',
        '#title' => $this->t('Custom title for Paragraph'),
        '#options' => $this->getCustomTemplateForTitle(),
        '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'title_wrapper', 'h2'),
      ];
    }

    return $form;
  }

  public function getCustomTemplateForTitle()
  {
    return [
      'h1' => 'h1',
      'h2' => 'h2',
      'h3' => 'h3',
      'h4' => 'h4',
      'div' => 'div',
    ];
  }
}
