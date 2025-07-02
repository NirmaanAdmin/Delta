<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="panel_s">
      <div class="panel-body">
        <div class="horizontal-scrollable-tabs">
          <nav>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <?php
              $i = 0;
              foreach($tab as $val) {
                ?>
                <li<?php if($i == 0){echo " class='active'"; } ?>>
                <a href="<?php echo admin_url('purchase/sales_dashboard?group='.$val); ?>" data-group="<?php echo html_entity_decode($val); ?>">
                  <?php echo _l($val); ?></a>
                </li>
                <?php $i++; 
              } ?>
            </ul>
          </nav>
        </div>
        </div>
      </div>
      <div class="panel_s">
        <div class="panel-body">
          
        </div>
      </div>
  </div>
</div>
<?php init_tail(); ?>
</body>
</html>
