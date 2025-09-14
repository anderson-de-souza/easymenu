<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
</head>
<body>

    <?php
    
        require_once __DIR__ . '/database/admin_register.php';
        
        $admin = null;
        
        try {
            $admin = Admin::fromPost();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        if (isset($admin) && $admin->getId() != 0) {
            updateAdmin($admin);
        } else if (isset($admin)) {
            insertAdmin($admin);
        }
        
    ?>

    <form method="post">

        <div>
            <label for="adminName">
                <input type="text" name="adminName" id="adminName" placeholder="Name">
            </label>
        </div>

        <div>
            <label for="adminEmail">
                <input type="text" name="adminEmail" id="adminEmail" placeholder="E-mail">
            </label>
        </div>

        <div>
            <label for="adminPassword">
                <input type="password" name="adminPassword" id="adminPassword" placeholder="Password">
            </label>
        </div>

        <input type="submit" value="Send">

    </form>
</body>
</html>