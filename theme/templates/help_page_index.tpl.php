<?php foreach ($items as $item): ?>
    <a href="<?php print "/node/{$item['node']->id}"; ?>">
        <h4>
          <?php print $item['node']->title ?>
        </h4>
    </a>

  <?php foreach ($item['topics'] as $topic): ?>
        <ul>
            <li>
                <a href="<?php print "help-tab__tab_{$topic->id}" ?>">
                    <?php print $topic->title ?>
                </a>
            </li>
        </ul>
  <?php endforeach; ?>

<?php endforeach; ?>
