<div class="content">
    <h1><?php print $view['title']; ?> </h1>
    <h2>Your balance:<?php print $view['balance']; ?> </h2>
    <?php if ($view['message'] ?? false): ?>
        <h3>Your balance:<?php print $view['message']; ?> </h3>
    <?php endif; ?>
    <?php if ($view['content'] ?? false): ?>
        <section>
            <?php print $view['content']; ?>
        </section>
    <?php endif; ?>
</div>