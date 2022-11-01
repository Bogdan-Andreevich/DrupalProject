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
 *  Class GalleryBehavior
 *
 * @ParagraphsBehavior(
 *   id = "drupal_project_paragraphs_remote_video_gallery",
 *   label = @Translation("Remote video gallery settings"),
 *   description= @Translation("Settings for remote video gallery paragraph type."),
 *   weight = 0,
 * )
 */
class RemoteVideoGalleryBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
      return $paragraphs_type->id() == 'remote_video_gallery';
    }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $videos_per_row = $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4);
    $paragraph_view_mode = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);
    $build['#attributes']['class'][] = Utility\Html::getClass($paragraph_view_mode . '--videos-per-row-' . $videos_per_row);
  }



  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
    $form['items_per_row'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of videos per row'),
      '#options' => [
        '2' => $this->formatPlural(2, '1 video per row', '@count videos per row'),
        '3' => $this->formatPlural(3, '1 video per row', '@count videos per row'),
        '4' => $this->formatPlural(4, '1 video per row', '@count videos per row'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 4),
    ];
    return $form;
  }
}
