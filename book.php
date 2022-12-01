<?php

require_once('connection.php');

$id = $_GET['id'];

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt->execute(['id' => $id]);
$book = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM authors LEFT JOIN book_authors ON authors.id=book_authors.author_id WHERE book_authors.book_id = :id');
$stmt->execute(['id' => $id]);

// var_dump($book);

header("refresh: 5;");

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$book['title'];?></title>
 </head>
 <body>
    <h1><?=$book['title'];?></h1>

    <img src="<?=$book['cover_path'];?>">

    <!-- <h3><span>Laos:</span> <span> <? #=$book['stock_saldo']; ?> </span></h3> -->

    <h3>Authors:</h3>
    <?php
    while ($author = $stmt->fetch())
    {
        echo '<li>' . $author['first_name'] . ' ' . $author['last_name'] . '</li>';
    }
    ?>
    
    <h3>Release date: <?=$book['release_date'];?></h3>
    <h3>Language: <?=$book['language'];?></h3>
    <h3>Summary: <?=$book['summary'];?></h3>
    <h3>Price: <?=number_format(round($book['price'], 2), 2, ',');?>€</h3>
    <h3>In stock: <?=$book['stock_saldo'];?></h3>
    <h3>Pages: <?=$book['pages'];?></h3>
    <h3>Type: <?=$book['type'];?></h3>


   <div>
      <span><a href="edit.php?id=<?=$id;?>">Muuda</a></span> 
         <!-- 
            <form action="edit.php" method="POST">
               <input type="hidden" name="id" value="<//?=$id?>">
               <input type="submit" value="Muuda" name="edit2">
            </form>
         -->

         <br>
         <br>

         <form action="delete.php" method="POST">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="submit" value="Kustuta" name="delete">
         </form>
   </div>

 </body>
 </html>
