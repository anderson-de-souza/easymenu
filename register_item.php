<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
</head>
<body>
    
    <?php
    
        require_once __DIR__ . '/database/item_repository.php';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $item = Item::from($_POST);

            if (isset($_FILES['itemImageFile']) && $_FILES['itemImageFile']['error'] === UPLOAD_ERR_OK) {

                $fileNameTmp = $_FILES['itemImageFile']['tmp_name'];
                $realFileName = basename($_FILES['itemImageFile']['name']);
                $targetDir = __DIR__ . '/item/image/';

                $fileExtension = strtolower(pathinfo($realFileName, PATHINFO_EXTENSION));
                $fileExtensionAllowed = ['jpg', 'jpeg', 'png'];

                if (!in_array($fileExtension, $fileExtensionAllowed)) {
                    echo "<strong>Error: File Extension is Not Valid: expected $fileExtensionAllowed, actual $fileExtension</strong>";
                    exit;
                }

                if (getimagesize($fileNameTmp) === false) {
                    echo "<strong>Error: File Uploaded Is Not Valid Image File</strong>";
                    exit;
                }

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $newName = uniqid("img_") . bin2hex(random_bytes(5)) . "." . $fileExtension;

                $finalFilePath = $targetDir . $newName;

                if (move_uploaded_file($fileNameTmp, $finalFilePath)) {
                    $item->setImageName($newName);
                }

            }
        
            if (isset($item) && $item->getId() != 0) {
                ItemRepository::update($item);
            } else if (isset($item)) {
                ItemRepository::insert($item);
            }

        }
        
    ?>
    
    <form method="post" enctype="multipart/form-data">

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
            <label for="itemQuantity">
                <input type="number" name="itemQuantity" id="itemQuantity" placeHolder="Quantity">
            </label>
        </div>

        <div>
            <label for="itemImageFile">
                <input type="file" name="itemImageFile" id="itemImageFile" accept="image/*" placeHolder="Upload Image File">
            </label>
        </div>

        <div>
            <input type="submit" value="Send">
        </div>

    </form>
</body>
</html>