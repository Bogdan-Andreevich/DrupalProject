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
use Drupal\Core\Annotation\Translation;



/**
 *  Class GalleryBehavior
 *
 * @ParagraphsBehavior(
 *   id = "drupal_project_paragraphs_image_and_text",
 *   label = @Translation("Image and text settings"),
 *   description = @Translation("Settings for image and text paragraph type."),
 *  weight = 0,
 * )
 */
class ImageAndTextBehavior extends ParagraphsBehaviorBase {

  /**
   * {@inheritdoc}
   */
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
      return $paragraphs_type->id() == 'image_and_text_';
    }

  /**
   * Extends the paragraph render array with behavior.
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
  {
    $paragraph_view_mode = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);
    $image_position = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left');
    $image_size = $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12');

    $build['#attributes']['class'][] = Utility\Html::getClass($paragraph_view_mode . '--image-position-' . $image_position) ;
    $build['#attributes']['class'][] = Utility\Html::getClass($paragraph_view_mode . '--image-size-' . $image_size);

    if (isset($build['field_image']) && $build['field_image']['#formatter'] == 'media_thumbnail') {
      switch ($image_size) {
        case '4_12':
        default:
          $image_style = 'paragraph_image_text_4_of_12';
          break;

        case '6_12':
          $image_style = 'paragraph_image_text_6_of_12';
          break;

        case '8_12':
          $image_style = 'paragraph_image_text_8_of_12';
          break;
      }

      $build['field_image'][0]['#image_style'] = $image_style;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
  {

    $form['image_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Image position'),
      '#options' => [
        'left' => $this->t('Left'),
        'right' => $this->t('Right'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_position', 'left'),
    ];

    $form['image_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Image size'),
      '#description' => $this->t('Size of the image in grid.'),
      '#options' => [
        '4_12' => $this->t('4 columns of 12'),
        '6_12' => $this->t('6 columns of 12'),
        '8_12' => $this->t('8 columns of 12'),
      ],
      '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'image_size', '4_12'),
    ];

    return $form;

  }
}
