<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
</head>
<body>
    
    <?php
    
        require_once '/database/item_repository.php';
        
        $item = null;
        
        try {
            $item = Item::fromPost();    
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        if (isset($item) && $item->getId() != 0) {
            updateItem($item);
        } else if (isset($item)) {
            insertItem($item);
        } 
        
    ?>
    
    <form method="post">

        <div>
            <label for="itemName">
                <input type="text" name="itemName" id="itemName" placeHolder="Name">
            </label>
        </div>

        <div>
            <label for="itemDescription">
                <input type="text" name="itemDescription" id="itemDescription" placeHolder="Description">
            </label>
        </div>

        <div>
            <label for="itemPrice">
                <input type="text" name="itemPrice" id="itemPrice" placeHolder="Price">
            </label>
        </div>

        <div>
            <label for="itemImageUrl">
                <input type="text" name="itemImageUrl" id="itemImageUrl" placeHolder="Image Address">
            </label>
        </div>

        <div>
            <input type="submit" value="Send">
        </div>

    </form>
</body>
</html>