<?php
    $pageTitle = 'Home | Three Dudes Bakery';
?>

<?php 
    require_once('components/front-head.php');
?>

<?php
    //get the latest 6 menu items
    $latestQuery = 'SELECT name, id, category, image_href, description, price, date_created FROM menu_items ORDER BY date_created DESC LIMIT 3';
    //prepare sql statement
    $latestStmt = $db->query($latestQuery);
    //get result and place into an array
    $latestResult = $latestStmt->fetch_all(MYSQLI_ASSOC);

    //get 6 pastries/crossants 
    $pastryQuery = 'SELECT name, id, category, image_href, description, price FROM menu_items WHERE category = "Pastries & Croissants" LIMIT 6';
    $pastryStmt = $db->query($pastryQuery);
    $pastryResult = $pastryStmt->fetch_all(MYSQLI_ASSOC);

    $cateringQuery = 'SELECT name, id, category, image_href, description, price FROM menu_items WHERE category = "Catering" LIMIT 3';
    $cateringStmt = $db->query($cateringQuery);
    $cateringResult = $cateringStmt->fetch_all(MYSQLI_ASSOC);
?>

<h1 id="mainTitle">THREE DUDES BAKERY</h1>

<section id="hero">
    <img src="assets/img/hero_bakery.jpg" alt="a front desk of a bakery">
    <div id="hero-text">
        <h2>OUR GRAND OPENING!</h2>
        <p>Let's see what three guys can bake together!</p>
    </div>
</section>
<br>
<div id="latestItems">
    <h2>LATEST ITEMS</h2>
    <div class="frontItemGrid">
        <?php foreach($latestResult AS $item) : ?>
            <div class="frontMenuItem card border-0 shadow-sm rounded-3">
                <h3 class="frontItemName"><?php echo $item['name'] ?></h3>
                <p class="frontItemCat"><?php echo $item['category'] ?></p>
                <img class="frontItemImage" src="<?php echo $item['image_href']?>" alt="" width="250px">
                <p class="frontItemPrice">$<?php echo $item['price'] ?></p>
                <?php if($item['category'] == 'Catering'): ?>
                    <a href="catering-item.php?id=<?= $item['id'] ?>"><button class="btn btn-outline-primary">Place Order</button></a>
                <?php endif; ?>
                <?php if($item['category'] != 'Catering'): ?>
                    <a href="menu-item.php?id=<?= $item['id'] ?>"><button class="btn btn-outline-primary">View Item</button></a>
                <?php endif ?>

            </div>
        <?php endforeach ?>
    </div>
</div>
<br>
<div id="pastries">
    <h2>PASTRIES & CROISSANTS</h2>
    <div class="frontItemGrid">
        <?php foreach($pastryResult AS $item) : ?>
            <div class="frontMenuItem card border-0 shadow-sm rounded-3">
                <h3 class="frontItemName"><?php echo $item['name'] ?></h3>
                <p class="frontItemCat"><?php echo $item['category'] ?></p>
                <img class="frontItemImage" src="<?php echo $item['image_href']?>" alt="" width="250px">
                <p class="frontItemPrice">$<?php echo $item['price'] ?></p>
                <a href="menu-item.php?id=<?= $item['id'] ?>"><button class="btn btn-outline-primary">View Item</button></a>
            </div>
        <?php endforeach ?>
    </div>
</div>
<br>
<div id="catering">
    <h2>CATERING OPTIONS</h2>
    <div class="frontItemGrid">
        <?php foreach($cateringResult AS $catering) : ?>
            <div class="frontMenuItem card border-0 shadow-sm rounded-3">
                <h3 class="frontItemName">Event Type: <?= $catering['name'] ?></h3>
                <p class="frontItemCat"><?php echo $catering['category'] ?></p>
                <img class="frontMenuItem" src="<?php echo $catering['image_href'] ?>" alt="" width="250px">
                <p class="frontItemPrice">$<?php echo $item['price'] ?></p>
                <a href="catering-item.php?id=<?= $catering['id'] ?>"><button class="btn btn-outline-primary">Place Order</button></a>
            </div>
        <?php endforeach ?>
</div>


<?php require_once('components/footer.php'); ?>