<div class="casino">
    <h1>IN SPIN WE TRUST 3x3</h1>
    <div class="slotmachine">
        <?php foreach ($view['state'] as $column): ?>        
            <div class="row">
                <?php foreach ($column as $col_data): ?>
                    <div class="element element-<?php print $col_data; ?>"></div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
