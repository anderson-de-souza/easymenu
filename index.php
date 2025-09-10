</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easy Menu</title>
    <style>
    
        body {
            font-family: Arial, sans-serif;
        }
        
        .item {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 8px;
            max-width: 500px;
        }
        
        .item img {
            width: 100px;
            height: auto;
            border-radius: 6px;
        }
        
        .item h1 {
            font-size: 18px;
            margin: 4px 0;
        }
        
        .item p {
            margin: 4px 0;
            color: #555;
        }
        
    </style>
</head>
<body>
    
<?php

require_once '/database/item_repository.php';
$items = getAllItems();

foreach ($items as $item) {
    echo "
        <div class='item'>
            <div>
                <img src='{$item->getImageUrl()}' alt='{$item->getName()}'>
            </div>
            <div>
                <h1>{$item->getName()}</h1>
                <h1>R$ " . number_format($item->getPrice(), 2, ',', '.') . "</h1>
                <p>{$item->getDescription()}</p>
            </div>
        </div>
    ";
}

?>

</body>
</html>