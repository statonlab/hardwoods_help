<?php

/**
 * Node form.
 *
 * Implements hook_node_form().
 *
 * @return array $form
 */
function hardwoods_help_form($node, &$form_state) {
  $form = [];

  $fields = [];
  if ($node && isset($node->nid)) {
    $fields = hardwoods_help_get_fields($node->nid);
    $form_state['tab_count'] = count($fields);
  }

  if (empty($form_state['tab_count'])) {
    $form_state['tab_count'] = 1;
  }

  $form['title'] = [
    '#type' => 'textfield',
    '#required' => TRUE,
    '#title' => t('Page Title'),
    '#default_value' => $node ? $node->title : '',
  ];

  $form['tabs'] = [
    '#type' => 'fieldset',
    '#title' => t('Tabs'),
    '#prefix' => '<div id="tabs-div">',
    '#suffix' => '</div>',
  ];

  $form['tabs']['count'] = [
    '#type' => 'hidden',
    '#value' => $form_state['tab_count'],
  ];

  for ($i = 0; $i < $form_state['tab_count']; $i++) {
    $form['tabs']["fieldset_$i"] = [
      '#type' => 'fieldset',
      '#title' => t('Tab ' . ($i + 1)),
    ];

    $form['tabs']["fieldset_$i"]["tab_title__$i"] = [
      '#type' => 'textfield',
      '#title' => t('Title'),
      '#description' => t('This will appear as a tab on the left'),
      '#default_value' => isset($fields[$i]) ? $fields[$i]->title : '',
    ];

    $form['tabs']["fieldset_$i"]["tab_content__$i"] = [
      '#type' => 'text_format',
      '#title' => t('Tab Content'),
      '#format' => isset($fields[$i]) ? $fields[$i]->content->format : 'full_html',
      '#default_value' => isset($fields[$i]) ? $fields[$i]->content->value : '',
    ];

    $form['tabs']["fieldset_$i"]["tab_weight__$i"] = [
      '#type' => 'select',
      '#title' => t('Tab Weight'),
      '#options' => drupal_map_assoc(range(-10, 10)),
      '#default_value' => isset($fields[$i]) ? $fields[$i]->weight : 0,
      '#suffix' => t('<p style="color: #777">To remove a tab, delete the the title and the content then submit the form.</p>'),
    ];
  }

  $form['tabs']['add_tab_button'] = [
    '#type' => 'submit',
    '#value' => '+ Add Tab',
    '#submit' => ['hardwoods_help_ajax_add_one'],
    '#ajax' => [
      'callback' => 'hardwoods_help_ajax_callback',
      'wrapper' => 'tabs-div',
    ],
  ];

  return $form;
}

/**
 * Ajax callback.
 *
 * @param array $form
 * @param array $form_state
 *
 * @return mixed
 */
function hardwoods_help_ajax_add_one($form, &$form_state) {
  $form_state['tab_count']++;
  $form_state['rebuild'] = TRUE;
}

/**
 * Ajax callback.
 *
 * @param array $form
 * @param array $form_state
 *
 * @return mixed
 */
function hardwoods_help_ajax_callback($form, &$form_state) {
  return $form['tabs'];
}

/**
 * Insert the node tabs.
 *
 * @param $node
 *
 * @throws \Exception
 */
function hardwoods_help_node_insert($node) {
  for ($i = 0; isset($node->{"tab_title__$i"}); $i++) {
    if (empty($node->{"tab_title__$i"}) || empty($node->{"tab_content__$i"})) {
      continue;
    }

    db_insert('hardwoods_help')->fields([
      'nid' => $node->nid,
      'title' => $node->{"tab_title__$i"},
      'content' => json_encode($node->{"tab_content__$i"}),
      'weight' => $node->{"tab_weight__$i"},
    ])->execute();
  }
}

/**
 * Update a node.
 *
 * @param $node
 *
 * @throws \Exception
 */
function hardwoods_help_node_update($node) {
  db_query('DELETE FROM {hardwoods_help} WHERE nid=:nid', [
    ':nid' => $node->nid,
  ]);

  hardwoods_help_node_insert($node);
}
