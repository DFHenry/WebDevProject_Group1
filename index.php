<?php
    $pageTitle = 'Home | Three Dudes Bakery';
?>

<?php 
    require_once('components/front-head.php');
?>

<?php
    //get 6 menu menu items
    $menuQuery = 'SELECT name, id, category, image_href, description, price, date_created FROM menu_items ORDER BY date_created DESC LIMIT 6';

    //prepare sql statement
    $menuStmt = $db->query($menuQuery);

    //get result and place into an array
    $menuResult = $menuStmt->fetch_all(MYSQLI_ASSOC);
?>

<h1 id="mainTitle">Three Dudes Bakery</h1>

<section id="hero">
    <img src="assets/img/hero_bakery.jpg" alt="a front desk of a bakery">
    <div id="hero-text">
        <h2>Our Grand Opening!</h2>
        <p>Let's see what three guys can bake together!</p>
    </div>
</section>

<div id="latestItems">
    <h2>Latest Items</h3>
    <div class="frontItemGrid">
        <?php foreach($menuResult AS $item) : ?>
            <div class="frontMenuItem card border-0 shadow-sm rounded-3">
                <h3 class="frontItemName"><?php echo $item['name'] ?></h3>
                <p class="frontItemCat"><?php echo $item['category'] ?></p>
                <img class="frontItemImage" src="<?php echo $item['image_href']?>" alt="" width="250px">
                <p class="frontItemPrice">$<?php echo $item['price'] ?></p>
                <a href="#"><button class="btn btn-outline-primary">View Item</button></a>
            </div>
        <?php endforeach ?>
    </div>
</div>



<?php require_once('components/footer.php'); ?>