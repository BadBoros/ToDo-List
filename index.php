<?php

require_once 'init.php';

$itemsQuery = $db->prepare("
  SELECT id, name, done
  FROM items
  WHERE user = :user
");

$itemsQuery->execute([
  'user' => $_SESSION['user_id']
]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];

?>

<!DOCTYPE html>
<html lang="it">
  <head>

    <meta name="author" content="Enrico Pais">
    <meta charset="utf-8">
    <title>WID</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light+Two" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="checklist.png">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  </head>

  <body>

    <div class="list">

      <h1 class="header">To Do</h1>

      <?php if(!empty($items)): ?>

      <ul class="items">
        <?php foreach ($items as $item): ?>
        <li>
          <span class="item<?php echo $item['done'] ? '-done' : '' ?>"><?php echo $item['name']; ?></span>
          <?php if(!$item['done']): ?>
            <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="done-button">Mark as done</a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>

      </ul>

    <?php else: ?>
      <p>You haven't added any items yet.</p>
    <?php endif; ?>

      <form class="item-add" action="add.php" method="post">
          <input type="text" name="name" placeholder="Type a new item here." class="input" autocomplete="off" required>
          <input type="submit" value="Add" class="submit">
      </form>

    </div>

  </body>

</html>
