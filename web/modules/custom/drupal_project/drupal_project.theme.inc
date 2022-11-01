<?php

/**
 * @file
 * Maim file for preprocessing custom theme hooks.
 */

/**
 * Implements template_preprocess_HOOK() for drupal-project-previous-next.html.twig.
 */
function template_preprocess_drupal_project_previous_next(&$variables)
{
  /** @var  \Drupal\Core\Entity\EntityInterface $entity */
 $entity = $variables['entity'];
 $variables['next'] = [];
 $variables['previous'] = [];

 /** @var \Drupal\Core\Entity\EntityStorageInterface $entity_storage */
 $entity_storage = \Drupal::entityTypeManager()->getStorage($entity->getEntityTypeId());

 //Getting next entity ID.
  $next_entity_id = $entity_storage->getQuery()
    ->condition('type', $entity->bundle())
    ->condition('created' , $entity->getCreatedTime(), '>')
    ->range(0, 1)
    ->sort('created', 'ASC')
    ->execute();

  if(!empty($next_entity_id)){
    $next_entity = $entity_storage->load($next_entity_id);

    $variables['next']['label'] = $next_entity->label();
    $variables['next']['url'] = $next_entity->toUrl()->toRenderArray();
  }



}

