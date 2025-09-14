<?php

    session_start();

    if (!isset($_SESSION['clientId'])) {
        header("Location:index.php");
        exit;
    }