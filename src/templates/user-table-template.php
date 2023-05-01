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
<style>
    /* Center the table */
    .user-table {
        padding-top: 2rem;
    }
    .user-table table {
        margin: 0 auto;
    }

    /* Add border to the table */
    .user-table table {
        border-collapse: collapse;
        border: 1px solid #ccc;
    }

    .user-table th,
    .user-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }
    .user-table a {
        text-decoration: none;
    }
</style>

<body <?php body_class(); ?>>
    <div class="user-table">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
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
    <div id="user-details-container" style="display: flex; justify-content: center;">
        <!-- User details will be displayed here -->
    </div>

    <?php wp_footer(); ?>
</body>

</html>