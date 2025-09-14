<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Easymenu</title>
</head>
<body>

    <?php

        require_once __DIR__ . '/database/client_repository.php';

        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $client = Client::fromPost();
            $clientId = insertClient($client);
            $_SESSION['clientId'] = $clientId;
            header("Location: index.php");
        }
        
    ?>

    <form method="post">

        <div>
            <label for="clientName">
                <input type="text" name="clientName" id="clientName" placeholder="Name">
            </label>
        </div>

        <div>
            <label for="clientEmail">
                <input type="text" name="clientEmail" id="clientEmail" placeholder="E-mail">
            </label>
        </div>

        <div>
            <label for="clientPassword">
                <input type="password" name="clientPassword" id="clientPassword" placeholder="Password">
            </label>
        </div>

        <input type="submit" value="Send">

    </form>
</body>
</html>