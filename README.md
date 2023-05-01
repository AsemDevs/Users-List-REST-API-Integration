# User Spotlight Pro

User Spotlight Pro is a WordPress plugin that fetches and displays a table of users from an external API. It also allows you to view individual user details by clicking on the user's name.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Development](#development)
- [License](#license)

## Requirements

- PHP 8.0 or higher
- WordPress 5.0 or higher
- Composer for managing PHP dependencies
- Inpsyde PHP Coding Standards (already included in the `composer.json` file)

## Installation

1. Clone or download the repository to the `wp-content/plugins` directory in your WordPress installation.
2. Run `composer install` inside the plugin directory to install the required dependencies.
3. Log in to your WordPress admin dashboard, go to the Plugins menu, and activate the "User Spotlight Pro" plugin.

## Usage

1. After activating the plugin, visit the `/user-list` endpoint on your WordPress site to see a table of users fetched from the external API.
2. Click on a user's name to view their details on the `/user-details/{user_id}` endpoint.

## Development

This plugin follows the Inpsyde PHP coding standards. To check your code against these standards, run the following commands:

- `composer run phpcs` to check your code for compliance with the coding standards.
- `composer run phpcbf` to automatically fix any issues that can be fixed.

## License

This plugin is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
