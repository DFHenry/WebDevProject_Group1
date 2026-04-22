<?php
    $pageTitle = 'View Item | Three Dudes Bakery';
?>

<?php 
    require_once('components/front-head.php');
?>

<?php
    //get selected menu item
    $query = 'SELECT id, name, description, price, category, image_href FROM menu_items WHERE id = ? LIMIT 1';
    $stmt = $db->prepare($query);
    $itemId = intval($_GET['id']);
    $stmt->bind_param('i', $itemId);
    if($stmt->execute() == false)
    {
        echo "Execute failed: " + $stmt->error;
    }
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);

    $item = $items[0];
?>

<!-- HEADER STARTS HERE -->

<h1 id="mainTitle">THREE DUDES BAKERY</h1>

<div class="frontItemDetails">
    <h2 class="frontItemDetailsName"><?= $item['name'] ?></h2>
    <div class="frontItemContainer">
        <img class="frontItemDetailsImg" src="<?= $item['image_href'] ?>" alt="">
        <h3 class="frontItemDetailsCat"><?= $item['category'] ?></h3>
        <p class="frontItemDetailsDesc"><?= $item['description'] ?></p>
        <p class="frontItemDetailsPrice">Cost: <?= $item['price'] ?></p>
    </div>
</div>

<a href="index.php"><button class="btn btn-success">Return To Store</button></a>

<?php require_once('components/footer.php'); ?>