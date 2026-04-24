<?php 
    $pageTitle = "Add Catering Items to Order";
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
// Get the menu_item names & prices from the database to populate the dropdown
$query = 'SELECT id, name, price FROM menu_items WHERE user_id = ?';
$stmt = $db->prepare($query);
$userId = intval($_SESSION['id']);
$stmt->bind_param('i', $userId);
if($stmt->execute() == false)
{
  echo "Execute failed: " . $stmt->error;
}
$result = $stmt->get_result();
$menuItems = $result->fetch_all(MYSQLI_ASSOC);

if(isset($_POST['submit']))
{
    $isValid = true;
    if(empty($_POST['order_id']) || empty($_POST['item_id']) || empty($_POST['quantity']) || empty($_POST['price_at_booking']))
    {
        $isValid = false;
    }
    elseif(!is_numeric($_POST['quantity']) || intval($_POST['quantity']) < 1)
    {
        $isValid = false;
    }
    elseif(!is_numeric($_POST['price_at_booking']) || floatval($_POST['price_at_booking']) < 0)
    {
        $isValid = false;
    }

    if($isValid)
    {
        $orderId = intval($_GET['id']);
        $itemId = intval($_POST['item_id']);
        $quantity = intval($_POST['quantity']);
        $priceAtBooking = floatval($_POST['price_at_booking']);
        $itemNotes = trim($_POST['item_notes']);

        $query = "INSERT INTO catering_order_items (order_id, item_id, 
                              quantity, price_at_booking, item_notes) 
                              VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iiids',
            $orderId,
            $itemId,
            $quantity,
            $priceAtBooking,
            $itemNotes
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

<h1 class="mb-3">Add Items to Catering Order</h1>

  <?= var_dump($_POST); ?>

<a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a> <!-- Button to navigate back to the dashboard -->  
<div class="mb-3">
    <?php if(isset($isValid) && $isValid == false) : ?>
        <div class="alert alert-danger" role="alert"> <!-- Bootstrap alert class for error messages -->
            Please fill in all required fields correctly.
        </div>
    <?php endif; ?>

    <p>Use the form below to add items to catering order # <?= $_GET['id']; ?>.</p>
</div>

<div class="addEditMenuItemBox">
  <form class="card border-0 shadow-sm rounded-3" action="add-catering-items.php?id=<?= $_GET['id'] ?>" method="post">
    <input type="hidden" name="order_id" value="<?= $_GET['id']; ?>">
    <div class="mb-3">
      <label for="item_id" class="form-label">Menu Item Name:</label>
      <select class="form-control" id="item_id" name="item_id" required>
        <option value="">Select a menu item</option>
        <?php foreach($menuItems as $item) : ?>
          <option value="<?= $item['id']; ?>"><?= htmlspecialchars($item['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity:</label>
      <input type="number" class="form-control" id="quantity" name="quantity" required>
    </div>
    <div class="mb-3">
      <label for="price_at_booking" class="form-label">Price at Booking:</label>
      <input type="number" step="0.01" class="form-control" id="price_at_booking" name="price_at_booking" required>
    </div>
    <div class="mb-3">
      <label for="item_notes" class="form-label">Item Notes (optional):</label>
      <textarea class="form-control" id="item_notes" name="item_notes"></textarea>
    </div> 
    
    <div>
      <input type="submit" class="btn btn-primary" value="Add Items" name="submit">
    </div>
  </form>
</div>

<script>

// JavaScript to auto-populate the price_at_booking field based on the selected menu item
document.getElementById('item_id').addEventListener('change', function() {
    var selectedItemId = this.value;
    var menuItems = <?= json_encode($menuItems); ?>;

    var priceField = document.getElementById('price_at_booking');
    priceField.value = ''; // Clear the price field if no item is selected

    if(selectedItemId) {
        var selectedItem = menuItems.find(function(item) {
            return item.id == selectedItemId;
        });

        if(selectedItem) {
            priceField.value = selectedItem.price; // Set the price field to the selected item's price
        }
    }
});
</script>

<?php require_once('components/footer.php'); ?>