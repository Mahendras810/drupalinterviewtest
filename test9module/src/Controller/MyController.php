<?php
namespace Drupal\test9module\Controller;
use Drupal\Core\Controller\ControllerBase;
class MyController extends ControllerBase {
  public function content() {
    $a=1;
    $b=2;
    $a= $a+$b;
    $b=$a-$b;
    $a= $a-$b;
    return array(
      '#markup' => 'After Swaping' . $a." and " . $b,
    );
  }
}
