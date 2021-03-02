<?php
    require_once 'classes/QueryBuilder.php';

    $db = new QueryBuilder(Connection::make());

    if (isset($_GET['search']))
    {
        $error = 0;
        $search = $_GET['search'];

        if ($search == '')
        {
            $error = 'Задан пустой поисковый запрос.';
        }
        else if ($search != '' && strlen($search) < 3)
        {
            $error = 'Введите не менее 3 символов для поиска.';
        }
        else
        {
            $searchValues = explode(' ', $search);
            $posts = $db->search($searchValues);
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $results ? "Результат поиска - $search" : "Поиск"; ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container">
        <form class="search__form" action="">
            <div class="search__block">
                <input type="text" class="search__input" name="search" placeholder="Поиск" value="<?= $search; ?>"><button class="search__submit" type="submit">Поиск</button>
            </div>
            <?= $error ? '<p class="search__error">' . $error . '</p>' : ""; ?>
        </form>
        <?php if ($posts): ?>
            <ul class="search__list">
                <?php foreach ($posts as $post): ?>
                    <li class="search__item">
                        <b><?= $post['title']; ?></b>
                        <ul class="search__item-comments">
                            <?php $comments = $db->select($searchValues, $post['id']); ?>
                            <?php foreach ($comments as $comment): ?>
                                <li class="search__item-comment">
                                    <p class="name"><?= $comment['name']; ?> (<small><?= $comment['email']; ?></small>)</p>
                                    <p class="body"><?= str_replace($searchValues, explode('|', '<b>'.implode('</b>|<b>', $searchValues).'</b>'), $comment['body']); ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>