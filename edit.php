<?php

require_once('connection.php');

$id = $_GET['id'];

if ( isset($_POST['edit']) && $_POST['edit'] == 'Salvesta' ) {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, stock_saldo = :stock_saldo, price = :price, pages = :pages, summary = :summary,  cover_path  = :cover_path, type  = :type, language  = :language  WHERE id = :id');
    $stmt->execute(['title' => $_POST['title'], 'stock_saldo' => $_POST['stock-saldo'], 'price' => str_replace(',', '.', $_POST['price']), 'pages' => $_POST['pages'], 'summary' => $_POST['summary'], 'cover_path' => $_POST['cover_path'], 'type' => $_POST['type'], 'language' => $_POST['language'], 'id' => $id]); //nt str replace asendab koma punktiga

    $stmt = $pdo->prepare('UPDATE book_authors SET author_id = :author_id  WHERE book_id = :book_id');
    $stmt->execute(['author_id' => $_POST['author_id'], 'book_id' => $id]);

    header('Location: book.php?id=' . $id);
}

// SELECT * FROM 'authors'
//     <main>
// <ul> 
// <?php while ($book = $stmt->fetch()) { ?//>
//  <li>
//          <a href="book.php?id=<?=$book['id'];?//>"><?=$book['title'];?//></a>
//    </li>
// <?php } ?//>
// </ul>
// </main>

$stmtBook = $pdo->prepare('SELECT * FROM books b LEFT JOIN book_authors ba ON b.id=ba.book_id WHERE b.id = :id');
$stmtBook->execute(['id' => $id]);
$book = $stmtBook->fetch();

// var_dump($book);

// $stmtBookAuthors = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON a.id=ba.author_id  WHERE ba.book_id = :book_id');
// $stmtBookAuthors->execute(['book_id' => $id]);

$stmtAuthors = $pdo->query('SELECT * FROM authors ORDER BY first_name, last_name');

$stmtLanguages = $pdo->query('SELECT distinct language FROM books');
// $stmtAuthors->execute(['book_id' => $id]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <title><?=$book['title'];?></title>
</head>
<body>
    
<form action="edit.php?id=<?=$id;?>" method="POST">
    <label for="title">Pealkiri:</label> <input type="text" name="title" value="<?=$book['title'];?>" style="width: 320px;">
    <br>

    <!-- Pane pilt siia -->

    <label for="title">Pildi link:</label> <input type="text" name="cover_path" value="<?=$book['cover_path'];?>">
    <br>

    <!-- Liiguta autorid siia -->

    <!-- Pane avaldamise kuupäev siia -->

    <!-- Pane keel kuupäev siia -->

    <!-- Pane kokkuvõte siia -->

    <label for="title">Summary:</label> <input type="text" name="summary" value="<?=$book['summary'];?>">
    <br>

    <label for="title">Hind (€):</label> <input type="text" name="price" value="<?=number_format(round($book['price'], 2), 2, ',');?>">
    <br>

    <label for="title">Laos:</label> <input type="text" name="stock-saldo" value="<?=$book['stock_saldo'];?>">
    <br>
    
    <label for="title">Leheküljed:</label> <input type="text" name="pages" value="<?=$book['pages'];?>">
    <br>

    <!-- Pane tüüp siia
    <option value=""></option
    -->



    <label for="title">Tüüp:</label> 
    <select name="type">
        <option value="new" <?=$book['type'] == 'new' ? 'selected' : '';?>>Uus</option>
        <option value="used" <?=$book['type'] == 'used' ? 'selected' : '';?>>Kasutatud</option>
        <option value="ebook" <?=$book['type'] == 'ebook' ? 'selected' : '';?>>E-raamat</option>
    </select>

    <br>



    <br>
    <br>


    <div>Muuda autorit:</div>
    <select name="author_id">
        <?php while ($author = $stmtAuthors->fetch()) { ?>
            <option value="<?=$author['id'];?>" <?=$author['id'] == $book['author_id'] ? 'selected' : '';?>>
                <?=$author['first_name'];?> <?=$author['last_name'];?>
            </option>
        <?php } ?>
    </select>

    <div>Muuda keelt:</div>
    <select name="language">
        <?php while ($language = $stmtLanguages->fetch()) { ?>
            <option value="<?=$language['language'];?>" <?=$language['language'] == $book['language'] ? 'selected' : '';?>>
                <?=$language['language'];?>
            </option>
        <?php } ?>
    </select>

<!--    <div>Lisa autor:</div>
    <option value=""></option>
    <select name="authors" id="author-dd">
        <//?php while ($author = $stmtAuthors->fetch()) { ?>
            <option value="<//?=$author['id'];?>" <//?=$author['id'] == $book[];?>>
                <//?=$author['first_name'];?> <//?=$author['last_name'];?>
            </option>
        <//?php } ?>
    </select>
    <br>
    <br>
    <div>Autor(id) hetkel:</div>
    <//?php while ($bookAuthor = $stmtBookAuthors->fetch()) { ?>
        <div class="author-row">
            <span class="author-name">
                <//?=$bookAuthor['first_name'];?> <//?=$bookAuthor['last_name'];?>
            </span>
            <span class="material-symbols-outlined" style="font-size: 16px; vertical-align: text-bottom;">delete</span>
            <input class="author-id" type="hidden" name="author[]" value="<//?=$bookAuthor['id'];?>">
        </div>
    <//?php } ?>
 -->

    <br>
    <!--  tingimus ? echo "T" echo "F", = võrdusmärk HTML'is juba ütleb ära, et hakkab boolean toimuma ig -->
    <input type="submit" value="Salvesta" name="edit">
</form>
 <script src="app.js"></script>
</body>
</html>
