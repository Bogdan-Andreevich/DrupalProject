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
 *  Class ParagraphClassBehavior
 *
 * @ParagraphsBehavior(
 *   id = "drupal_project_paragraphs_remote_video",
 *   label = @Translation("Custom remote video for Paragraphs"),
 *   description = @Translation("Allows to add custom remote video to Paragraphs"),
 *  weight = 0,
 * )
 */
class RemoteVideoBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type)
  {
     return $paragraphs_type->id() == 'remote_video_';
  }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $video_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'video_size', 'full');
    $paragraph_view_mode = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);

    $build['#attributes']['class'][] = Utility\Html::getClass($paragraph_view_mode. '-video-size-' . $video_size);
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {
    $form['video_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Video size'),
      '#description' => $this->t('Resize for video.'),
      '#options' => [
        'full' => '100%',
        '720p' => '720p',
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'video_size', 'full'),
    ];

    return $form;
  }
}
