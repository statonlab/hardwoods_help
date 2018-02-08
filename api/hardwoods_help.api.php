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