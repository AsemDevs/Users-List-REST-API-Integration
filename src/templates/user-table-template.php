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
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-center mb-4">User List</h1>
                <table id="user-table" class="table table-striped table-hover">
                    <caption class="text-center">Users List</caption>
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
                                <td>
                                    <a data-user-id="<?php echo $user['id']; ?>"
                                    href="<?php echo home_url("/user-details/{$user['id']}"); ?>">
                                        <?php echo $user['id']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a data-user-id="<?php echo $user['id']; ?>"
                                    href="<?php echo home_url("/user-details/{$user['id']}"); ?>">
                                        <?php echo $user['name']; ?>
                                    </a>
                                </td>
                                <td>
                                    <a data-user-id="<?php echo $user['id']; ?>"
                                    href="<?php echo home_url("/user-details/{$user['id']}"); ?>">
                                        <?php echo $user['username']; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination-container">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                            <li class="page-item <?php echo $current_page === $i ? 'active' : ''; ?>">
                                <a class="page-link"
                                href="<?php echo esc_url(add_query_arg('page', $i)); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div id="user-details-container">
                    <div id="hidden-user-details-template" style="display:none;">
                        <?php include __DIR__ . '/user-details-template.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>

</html>