<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= $category['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form form--add-lot container <?= !empty($errors) ? 'form--invalid' : ''; ?>" action="add.php" method="post"
      enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?= isset($errors['name']) ? $error_class : ''; ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="product[name]" placeholder="Введите наименование лота"
                   value="<?= htmlspecialchars($product['name']); ?>">
            <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
        </div>
        <? $sform = isset($errors['category_id']) ? "" : $product['category_id']; ?>
        <div class="form__item <?= isset($errors['category_id']) ? "form__item--invalid" : ""; ?>">
            <label for="category">Категория</label>
            <select id="category" name="product[category_id]">
                <option value="">Выберите категорию</option>
                <? foreach ($categories as $category): ?>
                    <?php if (isset($category['id'], $category['category_name'])){ ?>
                        <option value="<?=$category['id']; ?>" <?= $sform == $category['id'] ? "selected" : ""; ?>>
                            <?= htmlspecialchars($category['category_name']); ?></option>
                    <?php }?>
                <? endforeach; ?>
            </select>
            <span class="form__error"><?= $errors['category_id']; ?></span>
        </div>
    </div>
    <div class="form__item form__item--wide <?= isset($errors['description']) ? $error_class : ''; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="product[description]"
                  placeholder="Напишите описание лота"><?= htmlspecialchars($product['description']); ?></textarea>
        <span class="form__error"><span
                class="form__error"><?= isset($errors['description']) ? $errors['description'] : ''; ?></span></span>
    </div>
    <div class="form__item <?= isset($errors['file']) || !is_uploaded_file($_FILES['lot_img']['tmp_name']) ?
        "form__item--file" : "form__item--uploaded";
    echo isset($errors['file']) ? " form__item--invalid" : ""; ?>"> <!--  form__item--uploaded-->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?= $product['img_source']; ?>" width="113" height="113" alt="Изображение лота">
            </div>

        </div>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" value="" name="lot_img">

            <label for="photo2">
                <span>+ Добавить</span>
            </label>

        </div>
        <span class="form__error"><?= isset($errors['file']) ? $errors['file'] : ''; ?></span>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?= isset($errors['start_price']) ? $error_class : ''; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="product[start_price]" placeholder="0" value="<?= htmlspecialchars($product['start_price']); ?>">
            <span class="form__error"><span
                    class="form__error"><?= isset($errors['start_price']) ? $errors['start_price'] : ''; ?></span></span>
        </div>
        <div class="form__item form__item--small <?= isset($errors['lot_step']) ? $error_class : ''; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="product[lot_step]" placeholder="0" value="<?= htmlspecialchars($product['lot_step']); ?>">
            <span class="form__error"><?= isset($errors['lot_step']) ? $errors['lot_step'] : ''; ?></span>
        </div>
        <div class="form__item <?= isset($errors['end_date']) ? $error_class : ''; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="product[end_date]" type="date" name="product[end_date]"
                   value="<?= htmlspecialchars($product['end_date']); ?>">
            <span class="form__error"><?= isset($errors['end_date']) ? $errors['end_date'] : ''; ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>