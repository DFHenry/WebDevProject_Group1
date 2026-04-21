<?php
    //set page title
    $pageTitle = "Dashboard | Three Dudes Bakery";
    $itemId = 0;
?>

<?php 
    //get header component
    require_once('components/header.php'); 
?>

<?php
    //redirect if session is null (ie. go to login if user attempts to go to dashboard without logging in first)
    if($_SESSION['id'] == null)
    {
        header('Location: login.php');
    }
?>

<?php
    //get all menu items
    $menuQuery = 'SELECT name, id, category, image_href, description, price FROM menu_items ORDER BY category, name';

    //prepare sql statement
    $menuStmt = $db->query($menuQuery);

    //get result and place into an array
    $menuResult = $menuStmt->fetch_all(MYSQLI_ASSOC);

?>


<!-- end of header -->

<h2 class="mb-2">Dashboard</h2>

<p class="mb-4">Welcome, <?=$_SESSION['email']?></p>

<h3 class="mb-3">Menu Items</h3>


<a href="/add-item.php"><button class="btn btn-success">Add New Menu Item</button></a>

<div class="itemGrid mt-3" id="menuItems">
    <?php $currentCategory = ''; ?>
    <!-- for each item in the menu_items table, display data in it's own menuItem container -->
    <?php foreach($menuResult AS $item) : ?>
        <?php if($currentCategory !== $item['category']) : ?>
            <?php $currentCategory = $item['category']; ?>
            <div class="menuCategoryHeader mt-3 mb-2" style="grid-column: 1 / -1;">
                <h3 class="mb-1"><?= htmlspecialchars($currentCategory) ?></h3>
            </div>
        <?php endif; ?>
        <div class="menuItem card border-0 shadow-sm rounded-3">
            <h3 class="menuItemName"><?php echo $item['name'] ?></h3>
            <p class="menuItemCat text-muted"><?php echo $item['category'] ?></p>
            <img class="menuItemImage img-fluid rounded" src="<?= $item['image_href'] ?>" alt="<?= $item['description'] ?>" width="100%">
            <p class="menuItemPrice mb-2">Current Price: $<?php echo $item['price'] ?></p>
            <a href="item-details.php?id=<?= $item['id'] ?>"><button class="btn btn-outline-primary">View Item</button></a>
        </div>
    <?php endforeach ?>
</div>

<h3>Catering Options</h3>

<div class="itemGrid" id="cateringItems">
    <!-- TODO: create an itemGrid for catering items -->
</div>

<div id="logout">
    <form action="logout.php" method="post">
        <button type="submit" class="btn btn-outline-danger">Logout</button>
    </form>
</div>

<!-- beginning of footer -->
<?php include_once('components/footer.php'); ?>