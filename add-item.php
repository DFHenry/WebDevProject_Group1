<?php 
    $pageTitle = "Add Menu Item";
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
    if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category']))
    {
        $isValid = false;
    }
    elseif(!is_numeric($_POST['price']) || floatval($_POST['price']) < 0)
    {
        $isValid = false;
    }
    elseif(!empty($_POST['image']) && filter_var($_POST['image'], FILTER_VALIDATE_URL) == false)
    {
        $isValid = false;
    }

    if($isValid)
    {
        $userId = intval($_SESSION['id']);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        $imageurl = null;
        if(!empty($_POST['image'])) $imageurl = trim($_POST['image']);
        $query = "INSERT INTO menu_items (user_id, name, description, price, category, image_href) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issdss',
            $userId,
            $name,
            $description,
            $price,
            $category,
            $imageurl
        );
        if($stmt->execute() == false)
        {
            echo "Execute failed: " . $stmt->error;
        }
        else
        {
            $_SESSION['success'] = "New menu item has been added successfully!";
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>

<h1>Add a New Menu Item</h1>

<a href="dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a> <!-- Button to navigate back to the dashboard -->  
<div class="mb-3">
    <?php if(isset($isValid) && $isValid == false) : ?>
        <div class="alert alert-danger" role="alert"> <!-- Bootstrap alert class for error messages -->
            Please fill in all required fields correctly, and use a valid URL if you add an image.
        </div>
    <?php endif; ?>

    <p>Use the form below to add a new menu item. Image is optional.</p>
</div>
<form action="add-item.php" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Menu Item Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>  

    <div class="mb-3">
        <label for="description" class="form-label">Menu Item Description:</label>
        <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price:</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Category:</label>
        <select class="form-control" id="category" name="category" required>
            <option value="">Select category</option>
            <option value="Pastries & Croissants">Pastries & Croissants</option>
            <option value="Cookies, Squares & Tarts">Cookies, Squares & Tarts</option>
            <option value="Muffins, Scones & Tea Biscuits">Muffins, Scones & Tea Biscuits</option>
            <option value="Cakes & Loafs">Cakes & Loafs</option>
            <option value="Beverages">Beverages</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image URL:</label>
        <input type="text" class="form-control" id="image" name="image">
    </div>

    <input type="submit" class="btn btn-primary" value="Add Menu Item" name="submit">
</form>

<?php require_once('components/footer.php'); ?>