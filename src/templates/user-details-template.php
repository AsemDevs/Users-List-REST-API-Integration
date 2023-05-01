<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
</head>

<body>
    <h1>User Details</h1>
    <p>ID: <?php echo esc_html($id); ?></p>
    <p>Name: <?php echo esc_html($name); ?></p>
    <p>Username: <?php echo esc_html($username); ?></p>
    <p>Email: <?php echo esc_html($email); ?></p>
</body>

</html>