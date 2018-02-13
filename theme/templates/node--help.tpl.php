<div class="row">
    <div class="col-lg-auto">
        <ul class="nav flex-column" role="tablist">
          <?php
          $i = 0;
          foreach ($fields as $field):
            $i++;
            ?>
              <li class="nav-item">
                  <a class="nav-link<?php print $i == 1 ? ' active' : ''; ?>"
                     data-toggle="tab"
                     role="tab"
                     href="<?php print "#help-tabs--tab_{$field->id}" ?>">
                    <?php print $field->title ?>
                  </a>
              </li>
          <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-lg">
        <div class="tab-content">
          <?php
          $i = 0;
          foreach ($fields as $field):
            $i++;
            ?>
              <div class="help-tab-pane tab-pane fade<?php print $i === 1 ? ' show active' : ''; ?>"
                   role="tabpanel"
                   id="<?php print "help-tabs--tab_{$field->id}" ?>">
                  <div class="tab-pane-title">
                      <h2 class="font-weight-light mb-3"><?php print "{$field->title}" ?></h2>
                  </div>
                <?php print check_markup($field->content->value, $field->content->format) ?>
              </div>
          <?php endforeach; ?>
        </div>
    </div>
</div>
