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
?>

<h1 id="mainTitle">Three Dudes Bakery</h1>

<section id="hero">
    <img src="assets/img/hero_bakery.jpg" alt="a front desk of a bakery">
    <div id="hero-text">
        <h2>Our Grand Opening!</h2>
        <p>Let's see what three guys can bake together!</p>
    </div>
</section>
<br>
<div id="latestItems">
    <h2>Latest Items</h2>
    <div class="frontItemGrid">
        <?php foreach($latestResult AS $item) : ?>
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
<br>
<div id="pastries">
    <h2>Pastries & Croissants</h2>
    <div class="frontItemGrid">
        <?php foreach($pastryResult AS $item) : ?>
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
<br>
<div id="catering">
    <h2>Catering</h2>
    <!-- CATERING WILL GO HERE -->
</div>


<?php require_once('components/footer.php'); ?>