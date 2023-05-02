<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <?php wp_head(); ?>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">User Details</h1>
        <div class="card">
            <div class="card-header">
                <h3><?php echo esc_html($name); ?></h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID:</strong> <?php echo esc_html($id); ?></li>
                    <li class="list-group-item"><strong>Name:</strong> <?php echo esc_html($name); ?></li>
                    <li class="list-group-item"><strong>Username:</strong> <?php echo esc_html($username); ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo esc_html($email); ?></li>
                </ul>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>

</html>
