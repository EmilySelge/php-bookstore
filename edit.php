<?php
require_once('./connection.php');

$id = $_GET['id'];

if (isset($_POST['action']) && $_POST['action'] == 'Salvesta') {
    $stmt = $pdo->prepare('UPDATE books SET title = :title, price = :price WHERE id = :id');
    $stmt -> execute(['id' => $id, 'title' => $_POST['title'], 'price' => $_POST['price']]);
    header("Location: ./book.php?id={$id}");
}

if (isset($_POST['action']) && $_POST['action'] == 'remove_author') {
    $stmt = $pdo->prepare('DELETE FROM book_authors WHERE book_id = :book_id AND author_id = :author_id;');
    $stmt -> execute(['book_id' => $id, 'author_id' => $_POST['author_id']]);
    header("Location: ./book.php?id={$id}");
}

$stmt = $pdo->prepare('SELECT * FROM books WHERE id = :id');
$stmt -> execute(['id' => $id]);
$book = $stmt->fetch();



$stmt = $pdo->prepare('SELECT * FROM book_authors ba LEFT JOIN authors a ON ba.author_id = a.id WHERE ba.book_id = :id');
$stmt -> execute(['id' => $id]);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="./edit.php?id=<?= $id; ?>" method="post">
        <label for="title">pealkiri</label>
        <input type="text" name="title" value="<?=$book['title'];?>">
        <label for="price">hind</label>
        <input type="text" name="price" value="<?=$book['price'];?>">
        <input type="submit" value="Salvesta" name="action">

    </form>

    <br>
    Autorid:
    <ul>
        <?php while ($author = $stmt->fetch()) { ?>
            <li >
                <form action="./edit.php?id=<?= $id; ?>" method="post">
                    <?= $author['first_name'];?>
                    <?= $author['last_name'];?>
                    <button type="submit" name="action" value="remove_author" style="border: solid 1px; background-color: light-grey; margin-left: 10px; visiblilty: hidden; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" style="vertical-align: text-top;" width="16" height="16" viewBox="0 0 24 24">
                            <path d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z"></path>
                        </svg>
                    </button>
                    
                    <input type="hidden" name="author_id" value="<?= $author['id'];?>">
                </form>
            </li>
        <?php } ?>
    </ul>
    
</body>
</html>

