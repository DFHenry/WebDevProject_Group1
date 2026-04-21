<?php 
    $pageTitle = "Update Menu Item | Three Dudes Bakery";
?>
<?php require_once('components/header.php'); ?>

<?php
if(!isset($_SESSION['id']))
    {
        header("Location: login.php"); // Redirect to login page if the user is not authenticated
        exit();
    }

if(!isset($_GET['id']) || !is_numeric($_GET['id']))
    {
        header("Location: dashboard.php"); // Redirect to dashboard if the blog post ID is not provided or is not a valid number
        exit();
    }
?>

<?php
// get menu items for the logged-in user from database
$query = 'SELECT id, name, description, price, category, image_href, date_created FROM menu_items WHERE user_id = ? AND id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$itemId = intval($_GET['id']);
$stmt->bind_param('ii', $userId, $itemId);
if($stmt->execute() == false)
    {
        echo "Execute failed: " . $stmt->error;
    }
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

if(empty($items)) {
    header("Location: dashboard.php"); // Redirect to dashboard if the menu item is not found
    exit();
}

// end of menu item authentication and retrieval logic

$item = $items[0]; // Extract the single menu item from the array

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
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category = trim($_POST['category']);
            $imageurl = null;
            if(!empty($_POST['image'])) $imageurl = trim($_POST['image']);
            $query = "UPDATE menu_items SET name = ?, image_href = ?, description = ?, price = ?, category = ? WHERE user_id = ? AND id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('sssdsii',
                $name,
                $imageurl,
                $description,
                $price,
                $category,
                $userId,
                $itemId
            );
            if($stmt->execute() == false)
                {
                    echo "Execute failed: " . $stmt->error;
                }
            else
                {
                    $_SESSION['success'] = "Menu item has been updated successfully!"; // Set a success message in the session
                    header("Location: item-details.php?id=" . $_GET['id']);
                    exit();
                }
        }
}
?>

<h1 class="mb-3">Update Menu Item</h1>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="item-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a></li>
    <li class="breadcrumb-item active" aria-current="page">Update</li>
  </ol>
</nav>

<div class="mb-3">
    <?php if(isset($isValid) && $isValid == false) : ?>
        <div class="alert alert-danger" role="alert"> <!-- Bootstrap alert class for error messages -->
            Please fill in all required fields correctly, and use a valid URL if you add an image.
        </div>
    <?php endif; ?>

    <p>Use the form below to update your menu item. Image is optional.</p>
</div>

<div class="addEditMenuItemBox">
    <form class="addEditMenuItemForm card border-0 shadow-sm rounded-3" action="update-item.php?id=<?= $item['id'] ?>" method="post">
        <div class="addEditMenuItemNameContainer">
            <label for="name" class="form-label">Menu Item Name:</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($item['name']) ?>">
        </div>  

        <div class="addEditMenuItemDescLabelContainer">
            <label for="description" class="form-label">Menu Item Description:</label>  
        </div>

        <div class="addEditMenuItemDescFieldContainer">
            <textarea class="form-control" id="description" name="description" rows="5" required><?= htmlspecialchars($item['description']) ?></textarea>
        </div>

        <div class="addEditMenuItemPriceContainer">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" min="0" required value="<?= $item['price'] ?>">
        </div>

        <div class="addEditMenuItemCatContainer">
            <label for="category" class="form-label">Category:</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Select category</option>
                <option value="Pastries & Croissants" <?= $item['category'] == 'Pastries & Croissants' ? 'selected' : '' ?>>Pastries & Croissants</option>
                <option value="Cookies, Squares & Tarts" <?= $item['category'] == 'Cookies, Squares & Tarts' ? 'selected' : '' ?>>Cookies, Squares & Tarts</option>
                <option value="Muffins, Scones & Tea Biscuits" <?= $item['category'] == 'Muffins, Scones & Tea Biscuits' ? 'selected' : '' ?>>Muffins, Scones & Tea Biscuits</option>
                <option value="Cakes & Loafs" <?= $item['category'] == 'Cakes & Loafs' ? 'selected' : '' ?>>Cakes & Loafs</option>
                <option value="Beverages" <?= $item['category'] == 'Beverages' ? 'selected' : '' ?>>Beverages</option>
            </select>
        </div>

        <div class="addEditMenuItemImgContainer">
            <label for="image" class="form-label">Image URL:</label>
            <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($item['image_href'] ?? '') ?>">
        </div>

        <div class="addEditMenuItemBtnContainer">
            <input type="submit" class="btn btn-primary" value="Update Menu Item" name="submit">
        </div>
    </form>
</div>
<?php require_once('components/footer.php'); ?>