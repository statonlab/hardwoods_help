<?php

/**
 * Implements hook_node_form().
 */
function hardwoods_help_form($node, &$form_state) {
  $form = node_content_form($node, $form_state);

  $tab_count = 1;
  if (isset($form_state['values'])) {
    $tab_count = isset($form_state['values']['tab_count']) ? $form_state['values']['tab_count'] : 1;
  }

  $form['tab_count'] = [
    '#type' => 'hidden',
    '#value' => $tab_count,
  ];

  for ($i = 0; $i < $tab_count; $i++) {
    $form["fieldset_$i"] = [
      '#type' => 'fieldset',
      '#title' => t('Tab ' . ($i + 1)),
    ];

    $form["fieldset_$i"]["tab_title__$i"] = [
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#description' => t('This will appear as a tab on the left'),
    ];

    $form["fieldset_$i"]["tab_content__$i"] = [
      '#type' => 'text_format',
      '#title' => t('Tab Content'),
    ];

    $form["fieldset_$i"]["tab_weight__$i"] = [
      '#type' => 'select',
      '#title' => t('Tab Weight'),
      '#options' => drupal_map_assoc(range(-50, 50, 1)),
      '#default_value' => 1,
      '#suffix' => t('<p style="color: #777">To remove a tab, delete the the title and the content then submit the form.</p>')
    ];


  }

  $form['add_tab_button'] = [
    '#type' => 'button',
    '#value' => '+ Add Tab',
    '#ajax' => []
  ];

  return $form;
}