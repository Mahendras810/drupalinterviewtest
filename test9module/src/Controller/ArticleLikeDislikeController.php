<?php

namespace Drupal\test9module\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleLikeDislikeController extends ControllerBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Entity Type Manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $pageCacheKillSwitch;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Helper Function to perform article like/dislike.
   */
  public function likeDislike($nid, $type) {
    $like_dislike_status = '';
    $uid = $this->currentUser()->id();
    $like_count = $dislike_count = 0;
    if (!empty($nid) && !empty($type)) {
      $node = $this->entityTypeManager->getStorage('node')->load($nid);
      if (is_object($node)) {
        $like_dislike_paragraphs = $node->get('field_like_dislike')->referencedEntities();
        $liked_by_user_data = $liked_by_uids = [];
        $like_count = $dislike_count = 0;
        if (!empty($like_dislike_paragraphs)) {
          $liked_user_uid = $liked_value = '';
          foreach ($like_dislike_paragraphs as $like_dislike_paragraph) {
            $liked_user_uid = $like_dislike_paragraph->get('field_user')->target_id ?? 0;
            $liked_value = $like_dislike_paragraph->get('field_like_dislike')->value ?? 'none';
            // Like Counts.
            if ($liked_value == 'like') {
              $like_count++;
            }
            // Dislike Counts.
            elseif ($liked_value == 'dislike') {
              $dislike_count++;
            }
            $liked_by_uids[] = $liked_user_uid;
            $liked_by_user_data[] = [
              'uid' => $liked_user_uid ?? 0,
              'paragraph_id' => $like_dislike_paragraph->id() ?? 0,
              'value' => $liked_value,
            ];
          }
        }

        $changed = FALSE;
        // Case 1- Insert new paragraph.
        if (!in_array($uid, $liked_by_uids)) {
          $changed = TRUE;
          $para_info = [
            'type' => 'like_dislike',
            'field_user' => ['target_id' => $uid],
            'field_like_dislike' => 'like',
          ];
          $paragraph = $this->entityTypeManager->getStorage('paragraph')->create($para_info);
          $paragraph->save();

          $node->field_like_dislike->appendItem($paragraph);
          $node->save();

        }
        // Case 2- Update value;
        elseif (in_array($uid, $liked_by_uids)) {
          if (!empty($liked_by_user_data)) {
            foreach ($liked_by_user_data as $user_data) {
              $user_id = $user_data['uid'];
              if (!empty($user_id) && $user_id == $uid) {
                $paragraph_id = $user_data['paragraph_id'];
                $paragraph_load = $this->entityTypeManager->getStorage('paragraph')->load($paragraph_id);
                if (!empty($paragraph_load)) {
                  $liked_by_user = $user_data['value'];
                  if ($liked_by_user !== $type) {
                    $changed = TRUE;
                    $paragraph_load->set('field_like_dislike', $type);
                    $paragraph_load->save();
                  }
                }
              }
            }
          }
          $paragraph_load = $this->entityTypeManager->getStorage('paragraph')->load($paragraph_id);
          $liked_by_user = $paragraph_load->get('field_like_dislike')->value;
          if ($liked_by_user !== $type) {
            $paragraph_load->set('field_like_dislike', $type);
            $paragraph_load->save();
          }
        }
      }
      if ($changed) {
        if ($type == 'like') {
          $like_count++;
        }
        elseif ($type == 'dislike') {
          $like_count--;
        }
      }
      return new JsonResponse([
        'nid' => $nid,
        'like_count' => $like_count,
      ]);
    }
  }
}
