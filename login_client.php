<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Easymenu</title>
</head>
<body>

    <?php

        require_once __DIR__ . '/database/client_repository.php';

        session_start();

        if (isset($_POST['clientEmail']) && isset($_POST['clientPassword'])) {
            try {
                $client = ClientRepository::validate($_POST['clientEmail'], isset($_POST['clientPassword']));
                $clientId = $client->getId();
                ClientRepository::logClient($clientId, 1);
                $_SESSION['clientId'] = $clientId;
                header("Location: index.php");
            } catch (PDOException $e) {
                echo "<strong>Error: Email or password was incorrect.</strong>";
            }
        }
        
    ?>

    <form method="post">

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