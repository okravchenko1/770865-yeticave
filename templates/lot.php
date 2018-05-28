<nav class="nav">
    <ul class="nav__list container">
        <?php if (isset ($categories) && is_array($categories)) { ?>
            <?php foreach ($categories as $val) {
                ?>
                <?php if (isset($val['category_name'])) { ?>
                    <li class="nav__item">
                        <a href="all-lots.html"><?= htmlspecialchars($val['category_name']); ?></a>
                    </li>
                <?php }
            }
        } ?>
    </ul>
</nav>
<section class="lot-item container">
    <?php if (isset($product['name'], $product['description'], $product['start_price'], $product['image'], $product['category_id'], $categories[$product['category_id']]['category_name'])) { ?>
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $product['image']; ?>" width="730" height="548" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <p class="lot-item__category">Категория:
                <span><?= htmlspecialchars($categories[$product['category_id'] - 1]['category_name']) ?></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($product['description']) ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?= lot_expire(); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= htmlspecialchars($userBet); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= htmlspecialchars($userBet) ?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                    <p class="lot-item__form-item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="number" name="cost" placeholder="<?=htmlspecialchars($userBet)?>">
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <div class="history">
                <h3>История ставок (<span><?=$bet_counter;?></span>)</h3>
                <table class="history__list">
                    <?php if (isset ($bet) && is_array($bet)) { ?>
                    <?php foreach($bet as $val): ?>
                    <?php if (isset($val['user_name'], $val['bet_sum'], $val['date'])) { ?>
                        <tr class="history__item">
                            <td class="history__name"><?=htmlspecialchars($val['user_name']); ?></td>
                            <td class="history__price"><?=htmlspecialchars($val['bet_sum']); ?></td>
                            <td class="history__time"><?=htmlspecialchars($val['date']); ?></td>
                        </tr><?php }?>
                    <?php endforeach ?>
                    <?php }?>
                </table>
            </div>
        </div>
    </div>
    <?php }?>
</section>
