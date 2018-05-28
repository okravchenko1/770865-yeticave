<main>
    <nav class="nav">
        <ul class="nav__list container">
            <? foreach ($categories as $val): ?>
                <li class="nav__item">
                    <a href="/all_lots.php?cat=<?= $value['id']; ?>"><?= $value['category_name']; ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    </nav>
    <form class="form container" action="/login.php" method="post" enctype="multipart/form-data">
        <!-- form__item--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : ""; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="login[email]" placeholder="Введите e-mail"
                   value="<?= $login['email']; ?>">
            <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item form__item--last <?= isset($errors['password']) ? "form__item--invalid" : ""; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="login[password]" placeholder="Введите пароль">
            <span class="form__error">Введите пароль</span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>