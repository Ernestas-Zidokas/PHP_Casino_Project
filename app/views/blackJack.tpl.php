<div class="content">
    <?php if (isset($view['title'])): ?>
        <h1><?php print $view['title'] ?></h1>
    <?php endif; ?>
    <?php if (isset($view['status'])): ?>
        <h2><?php print $view['status'] ?></h2>
    <?php endif; ?>
    <?php if (isset($view['amount'])): ?>
        <h3><?php print $view['amount'] ?></h3>
    <?php endif; ?>
    <?php if (isset($view['dealer'])): ?> 
        <div>
            <h3>Dealers hand</h3>
            <?php foreach ($view['dealer'] as $card_idx => $card): ?>
                <?php if ($view['endgame'] == false && $card_idx == 1): ?>
                    <span>
                        <img class="card" src="/images/cards/Red_back.jpg">
                    </span>
                <?php else: ?>
                    <span>
                        <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($view['player'])): ?> 
        <div>
            <h3>Your hand</h3>
            <?php foreach ($view['player'] as $card): ?>
                <span>
                    <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>