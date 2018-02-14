<div class="row">
  <?php foreach ($items as $item): ?>
      <div class="col-md-6">
          <a href="<?php print "/node/{$item['node']->nid}"; ?>"
             class="link-darker">
              <h4>
                <?php print $item['node']->title ?>
              </h4>
          </a>
          <ul class="nav flex-column">
            <?php foreach ($item['topics'] as $topic): ?>
                <li class="nav-item">
                    <a href="<?php print "/node/{$item['node']->nid}?help_pane=help-tabs--tab_{$topic->id}" ?>"
                       class="nav-link">
                      <?php print $topic->title ?>
                    </a>
                </li>
            <?php endforeach; ?>
          </ul>
      </div>
  <?php endforeach; ?>
</div>
