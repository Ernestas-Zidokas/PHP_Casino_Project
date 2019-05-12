<div class="content">
    <h1><?php isset($view['title']) ? print $view['title'] : '' ?></h1>
    <h2><?php isset($view['status']) ? print $view['status'] : '' ?></h2>
    <h3><?php isset($view['amount']) ? print $view['amount'] : '' ?></h3>
    <div>
        <h3><?php isset($view['dealer']) ? print 'Dealers hand' : '' ?> </h3>
        <?php foreach (isset($view['dealer']) ? $view['dealer'] : [] as $card): ?>
            <span>
                <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
            </span>
        <?php endforeach; ?>
    </div>
    <div>
        <h3><?php isset($view['player']) ? print 'Your hand' : '' ?> </h3>
        <?php foreach (isset($view['player']) ? $view['player'] : [] as $card): ?>
            <span>
                <img class="card" src="/images/cards/<?php print $card->getNumber() . $card->getSuit(); ?>.jpg">
            </span>
        <?php endforeach; ?>
    </div>
</div>