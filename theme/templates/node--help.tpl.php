<div class="row">
    <div class="col-lg-auto">
      <?php
      $i = 0;
      foreach ($fields as $field):
        $i++;
        ?>
          <ul class="nav flex-column">
              <li class="nav-item">
                  <a class="nav-link<?php print $i == 1 ? ' active' : ''; ?>"
                     href="javascript:void(0);">
                    <?php print $field->title . " $i"; ?>
                  </a>
              </li>
          </ul>
      <?php endforeach; ?>
    </div>
    <div class="col-lg">
        <div class="tab-content">
          <?php
          $i = 0;
          foreach ($fields as $field):
            $i++;
            ?>
              <div class="tab-pane fade<?php print $i === 1 ? ' show active' : ''; ?>">
                <?php print check_markup($field->content->value, $field->content->format) ?>
              </div>
          <?php endforeach; ?>
        </div>
    </div>
</div>
