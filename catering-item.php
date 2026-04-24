<?php
    $pageTitle = 'View Item | Three Dudes Bakery';
?>

<?php 
    require_once('components/front-head.php');
?>

<?php
    //get catering item from bd
    $query = "SELECT * FROM menu_items WHERE id = ? LIMIT 1";
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

    //post catering details
    if(isset($_POST['submit']))
    {
        //form validation
        $isValid = true;

        if(empty($_POST['event_date']) ||
            empty($_POST['guest_count']) ||
            empty($_POST['customer_name']) ||
            empty($_POST['customer_email']) ||
            empty($_POST['customer_telephone']) ||
            empty($_POST['delivery_address']) )
        {
            $isValid = false;
            var_dump($_POST);
        }

        //if validation is successful
        if($isValid)
        {
            //prep variables from post data
            $eventDate = $_POST['event_date'];
            $guestCount = intval($_POST['guest_count']);
            $eventType = $_POST['event_type'];
            $isDelivery = intval($_POST['is_delivery']);
            $customerName = $_POST['customer_name'];
            $customerEmail =$_POST['customer_email'];
            $customerTelephone = $_POST['customer_telephone'];
            $customerAddress = $_POST['delivery_address'];
            $specialInstructions = $_POST['special_instructions'];
            
            //query and update database
            $orderQuery = "INSERT INTO catering_orders (event_date, guest_count, event_type, is_delivery, customer_name, customer_email, customer_telephone, delivery_address, special_instructions) VALUES (?,?,?,?,?,?,?,?,?)";
            $orderStmt = $db->prepare($orderQuery);
            $orderStmt->bind_param('sisisssss',
                $eventDate,
                $guestCount,
                $eventType,
                $isDelivery,
                $customerName,
                $customerEmail,
                $customerTelephone,
                $customerAddress,
                $specialInstructions
            );

            if($orderStmt->execute() == false)
            {
                echo "Execute Failed: " + $stmt->error;
            }
            else
            {
                header("Location: index.php");
            }
        }
    }
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

<br>
<div class="addEditMenuItemBox">
    <form class="addEditMenuItemForm card border-0 shadow-sm rounded-3" method="post" style="background-color: #fff6d7">
        
        <label for="event_date">Event Date: </label>
        <input type="datetime-local" name="event_date" id="event_date">
        
        <label for="guest_count">Number of Guests: </label>
        <input type="number" id="guest_count" name="guest_count">

        <input type="hidden"id="event_name" value="<?= $item['name'] ?>" name="event_type">

        <label for="is_delivery">For Delivery: </label>
        <input type="checkbox" name="is_delivery" id="is_delivery">

        <label for="customer_name">Name: </label>
        <input type="text" name="customer_name" id="customer_name">

        <label for="customer_email">Email Address: </label>
        <input type="text" name="customer_email" id="customer_email">

        <label for="customer_telephone">Telephone Number: </label>
        <input type="text" name="customer_telephone" id="customer_telephone">

        <label for="delivery_address">Event Location: </label>
        <input type="text" name="delivery_address" id="delivery_address">

        <label for="special_instructions">Special Instructions: </label>
        <input type="textarea" name="special_instructions" id="special_instructions">

        <input type="submit" class="btn btn-primary" value="Add Catering Order" name="submit">
    </form>
</div>
<br>

<a href="index.php"><button class="btn btn-success">Return To Store</button></a>

<!-- FOOTER STARTS HERE -->

<?php require_once('components/footer.php'); ?>