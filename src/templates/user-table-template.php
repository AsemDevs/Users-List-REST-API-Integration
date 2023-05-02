<?php

declare(strict_types=1);

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="user-table container mt-5">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_data as $user) : ?>
                    <tr data-user-id="<?php echo $user['id']; ?>">
                        <td><a href="<?php echo home_url("/user-details/{$user['id']}"); ?>"><?php echo $user['id']; ?></a></td>
                        <td><a href="<?php echo home_url("/user-details/{$user['id']}"); ?>"><?php echo $user['name']; ?></a></td>
                        <td><a href="<?php echo home_url("/user-details/{$user['id']}"); ?>"><?php echo $user['username']; ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="user-details-container" class="container">
        <!-- User details will be displayed here -->
    </div>
    <div id="error-container" class="error-message container mt-3"></div>

    <?php wp_footer(); ?>
</body>

</html>
