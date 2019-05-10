<div class="content">
    <h1><?php print $view['title']; ?> </h1>
    <div>
        <h2>Dealers hand</h2>
        <?php foreach ($view['dealer'] as $card): ?>
            <span>
                <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
            </span>
        <?php endforeach; ?>
    </div>
    <div>
        <h2>Your hand</h2>
        <?php foreach ($view['your'] as $card): ?>
            <span>
                <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
            </span>
        <?php endforeach; ?>
    </div>
</div>