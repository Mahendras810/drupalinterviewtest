<?php

namespace Drupal\test9module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CustomForm.
 */
class MyForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'myform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['limit_textarea'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Limit Textarea'),
      '#maxlength' => 100,
      '#suffix' => '<div id="characters-remaining">Characters Remaining 100</div>',
    ];
    $form['count_p_element'] = [
      '#type' => 'markup',
      '#markup' => '<div class="count-p"><span>Count : </span><p>Apple</p><p>Orange</p><p>Banana</p><p>Kiwi</p><p>Grapes</p><p>Mango</p></div>',
    ];

    $form['make_first_word_bold'] = [
      '#type' => 'markup',
      '#markup' => '<div class="make-bold-p"><p>PHP Exercises</p><p>WordPress Exercises</p><p>Drupal Exercises</p><p>Python Exercises</p><p>NET Exercises</p><p>Laravel Exercises</p><p>ReactJS Exercises</p></div>',
    ];
    $form['delete_p_except_first'] = [
      '#type' => 'markup',
      '#markup' => '<div id="exercises"><p>PHP Exercises</p><p>WordPress Exercises</p><p>Drupal Exercises</p><p>Python Exercises</p><p>.NET Exercises</p><p>Laravel Exercises</p><p>ReactJS Exercises</p></div>'
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    $form['#attached']['library'][] = 'test9module/myform';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage('Data Submitted Successfully.');
  }
}
