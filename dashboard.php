<?php
    //set page title
    $pageTitle = "Dashboard";
?>

<?php 
    //get header component
    require_once('components/header.php'); 
?>

<?php
    //redirect if session is null (ie. go to login if user attempts to go to dashboard without logging in first)
    if($_SESSION['email'] == null || $_SESSION['email'] == "")
    {
        header('Location: login.php');
    }
?>

<?php
    //get all menu items
    $menuQuery = 'SELECT * FROM menu_items';

    //prepare sql statement
    $menuStmt = $db->query($menuQuery);

    //get result and place into an array
    $menuResult = $menuStmt->fetch_all(MYSQLI_ASSOC);
?>


<!-- end of header -->

<h2>Dashboard</h2>

<p>Welcome, <?=$_SESSION['email']?><p>

<h3>Menu Items</h3>

<div class="itemGrid" id="menuItems">
    <!-- for each item in the menu_items table, display data in it's own menuItem container -->
    <?php foreach($menuResult AS $item) : ?>
        <div class="menuItem">
            <h3 class="menuItemName"><?php echo $item['name'] ?></h3>
            <p class="menuItemCat"><?php echo $item['category'] ?></p>
            <img class="menuItemImage" src="<?= $item['image_href'] ?>" alt="<?= $item['description'] ?>" width="100%">
            <p class="menuItemPrice">Current Price: $<?php echo $item['price'] ?></p>
            <button class="menuItemViewBtn">View Item</button>
        </div>
    <?php endforeach ?>
</div>

<h3>Catering Options</h3>

<div class="itemGrid" id="cateringItems">
    <!-- TODO: create an itemGrid for catering items -->
</div>

<div id="logout">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

<!-- beginning of footer -->
<?php include_once('components/footer.php'); ?>