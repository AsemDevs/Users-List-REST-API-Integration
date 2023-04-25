<?php
// Dummy user data
$user_data = [
    [
        'id' => 1,
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
    ],
    [
        'id' => 2,
        'name' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
    ],
];
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user_data as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
