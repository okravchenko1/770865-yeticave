
<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
        снаряжение.</p>
    <ul class="promo__list">
        <li class="promo__item promo__item--boards">
            <a class="promo__link" href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="promo__item promo__item--attachment">
            <a class="promo__link" href="all-lots.html">Крепления</a>
        </li>
        <li class="promo__item promo__item--boots">
            <a class="promo__link" href="all-lots.html">Ботинки</a>
        </li>
        <li class="promo__item promo__item--clothing">
            <a class="promo__link" href="all-lots.html">Одежда</a>
        </li>
        <li class="promo__item promo__item--tools">
            <a class="promo__link" href="all-lots.html">Инструменты</a>
        </li>
        <li class="promo__item promo__item--other">
            <a class="promo__link" href="all-lots.html">Разное</a>
        </li>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php if (isset($products) && is_array($products)) { ?>
            <?php foreach ($products as $key => $item) { ?>
                <?php if (isset($item['name'], $item['cat'], $item['price'], $item['url'])) { ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= $item['url']; ?>" width="350" height="260" alt="<?= htmlspecialchars($item['name']); ?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= htmlspecialchars($item['cat']) ; ?></span>
                            <h3 class="lot__title"><a class="text-link" href="lot.html"><?= htmlspecialchars($item['name']); ?></a>
                            </h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?= format_price((int)$item['price']); ?></span>
                                </div>
                                <div class="lot__timer timer">

                                </div>
                            </div>
                        </div>
                    </li>

                <?php }
            }
        } ?>
    </ul>
</section>