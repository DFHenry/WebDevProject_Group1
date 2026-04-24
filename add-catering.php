<?php 
    $pageTitle = "Add Catering Order | Three Dudes Bakery";
?>
<?php require_once('components/header.php'); ?>

<?php
if(!isset($_SESSION['id']))
{
    header("Location: login.php"); // Redirect to login page if the user is not authenticated
    exit();
}    
?>

<?php
if(isset($_POST['submit']))
{
    $isValid = true;
    if(empty($_POST['event_date']) || empty($_POST['guest_count']) || empty($_POST['event_type']) || empty($_POST['order_status']))
    {
        $isValid = false;
    }
    elseif(($_POST['is_delivery']))
    {
        if(empty($_POST['delivery_address']))
        {
            $isValid = false;
        }
    }

    if($isValid)
    {
        $eventDate = trim($_POST['event_date']);
        $guestCount = intval($_POST['guest_count']);
        $eventType = trim($_POST['event_type']);
        $isDelivery = isset($_POST['is_delivery']);
        $customerName = $_POST['customer_name'];
        $customerEmail = $_POST['customer_email'];
        $customerTelephone = intval($_POST['customer_telephone']);
        $deliveryAddress = trim($_POST['delivery_address']);
        $specialInstructions = trim($_POST['special_instructions']);
        $orderStatus = trim($_POST['order_status']);
      
        //prepare statement and insert into db
        $query = "INSERT INTO catering_orders (event_date, guest_count, event_type, is_delivery, customer_name, customer_email, customer_telephone, delivery_address, special_instructions, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sisississs',
            $eventDate,
            $guestCount,
            $eventType,
            $isDelivery,
            $customerName,
            $customerEmail,
            $customerTelephone,
            $deliveryAddress,
            $specialInstructions,
            $orderStatus
        );
        if($stmt->execute() == false)
        {
            echo "Execute failed: " . $stmt->error;
        }
        else
        {
            $_SESSION['success'] = "New catering order has been added successfully!";
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<h1 class="mb-3">Add a New Catering Order</h1>

<a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a> <!-- Button to navigate back to the dashboard -->  
<div class="mb-3">
    <?php if(isset($isValid) && $isValid == false) : ?>
        <div class="alert alert-danger" role="alert"> <!-- Bootstrap alert class for error messages -->
            Please fill in all required fields correctly.
        </div>
    <?php endif; ?>

    <p>Use the form below to add a new catering order.</p>
</div>

<div class="addEditMenuItemBox">
  <form class="card border-0 shadow-sm rounded-3" action="add-catering.php" method="post">
    <div>
      <label for="event_date" class="form-label">Event Date:</label>
      <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
    </div>
    
    <div>
      <label for="guest_count" class="form-label">Guest Count:</label>
      <input type="number" class="form-control" id="guest_count" name="guest_count" step="1" min="1" required>
    </div>

    <div>
      <label for="event_type" class="form-label">Event Type:</label> 
      <input type="text" class="form-control" id="event_type" name="event_type" required>
    </div>

    <div>
      <label for="customer_name" class="form-label">Customer Name: </label>
      <input type="text" class="form-control" id="customer_name" name="customer_name">
    </div>

    <div>
      <label for="customer_email" class="form-label">Customer Email Address: </label>
      <input type="text" class="form-control" id="customer_email" name="customer_email">
    </div>

    <div>
      <label for="customer_telephone" class="form-label">Customer Phone Number: </label>
      <input type="text" class="form-control" id="customer_telephone" name="customer_telephone">
    </div>

    <div>
      <label for="delivery_address" class="form-label mt-2">Delivery Address (if applicable):</label>
      <input type="text" class="form-control" id="delivery_address" name="delivery_address">
    </div>

    <div>
      <input type="hidden" name="is_delivery" value="0">
      <label for="is_delivery" class="form-label">Requires Delivery?</label>
      <input type="checkbox" class="form-check-input" id="is_delivery" name="is_delivery" value="1">
    </div>

    <div>
      <label for="special_instructions" class="form-label">Special Instructions:</label>
      <textarea class="form-control" id="special_instructions" name="special_instructions" rows="5"></textarea>
    </div>

    <div>
      <label for="order_status" class="form-label">Order Status:</label>
      <input type="text" class="form-control" id="order_status" name="order_status" required>
    </div>

    <div>
      <input type="submit" class="btn btn-primary" value="Add Catering Order" name="submit">
    </div>
  </form>
</div>

<?php require_once('components/footer.php'); ?>