<?php

/**
 * Get fields for a node.
 *
 * @param $nid
 *
 * @return mixed
 */
function hardwoods_help_get_fields($nid) {
  $fields = db_query('SELECT * FROM {hardwoods_help} 
                        WHERE nid = :nid 
                        ORDER BY weight ASC, id ASC', [
    ':nid' => $nid,
  ])->fetchAll();

  return array_map(function ($field) {
    $field->content = json_decode($field->content);

    return $field;
  }, $fields);
}

/**
 * Get the floating button items.
 *
 * @return array
 */
function hardwoods_help_get_help_menu_items() {
  $items = [];

  $nodes = db_query('SELECT DISTINCT (HH.nid), node.title 
                      FROM {hardwoods_help} HH
                      INNER JOIN {node} ON node.nid = HH.nid
                      ORDER BY HH.nid ASC')->fetchAll();

  foreach ($nodes as $node) {
    $items[] = [
      'node' => $node,
      'topics' => db_query('SELECT id, title FROM {hardwoods_help} WHERE nid = :nid', [
        'nid' => $node->nid,
      ])->fetchAll(),
    ];
  }

  return $items;
}
