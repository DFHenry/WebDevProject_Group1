<?php
    $pageTitle = "Dashboard";
?>

<?php 
    require_once('components/header.php'); 
?>


<!-- end of header -->

<h2>Dashboard</h2>

<p>Welcome, <?=$_SESSION['email']?><p>

<h3>Menu Items</h3>

<div class="itemGrid" id="menuItems">

</div>

<h3>Catering Options</h3>

<div class="itemGrid" id="cateringItems">
    
</div>

<div id="logout">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

<!-- beginning of footer -->
<php? include_once('components/footer.php') ?>