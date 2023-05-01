# Developer Notes

This file contains my thoughts, clarifications, and pseudocode while working on the project. I will use this space to keep track of my progress, challenges faced, and any potential improvements I come across.

## Table of Contents

1. [Planning and Design](#planning-and-design)
2. [Implementation](#implementation)
3. [Challenges and Solutions](#challenges-and-solutions)
4. [Improvements and Future Work](#improvements-and-future-work)

## Planning and Design

- I have set up the repo for the plugin, which will contain all plugin related developments, documnetations, and required files. ✅
- I will create a separate github repo for a dockerized wordpress environment for testing the plugin and any developments could be needed.✅
  - This Repo will be shared in the technical interview to showcase my work in a clean wordpress environment.
- Installing or Updating Composer. ✅
- Chose the name of the plugin to be `User Spotlight Pro` ✅
- Create the plugin information header. ✅
- Initiate composer.json config file ✅
- Installing phpuinit with composer `composer require --dev phpunit/phpunit` ✅
- Prepare The custom endpoint ✅
- Get familiar with API endpoints and the API [documentation](https://jsonplaceholder.typicode.com/guide/) ✅
- Test Displaying Dummy data in the custom endpoint. ✅
- Create needed function to fetch the data from the API. ✅
- Fetch the data from the API and display it in the custom endpoint. ✅
- Each row in the HTML table will show the details for a user in a custom endpoint called "user-details". ✅
- The content of three mandatory columns must be a link. ✅
- These user's details fetching requests must be asynchronous (AJAX). ✅
- The user details must be shown without reloading the page. ✅
- Check Inpsyde coding standards and apply them. ✅
- More optimizations and improvements could be done. ✅
- Implement caching for API requests. ✅
- Improve error handling. ✅
- Improve accessibility and responsiveness for more presentable design.
- Automated testing. ✅

## Implementation

- Create the plugin's main file, `user-spotlight-pro.php`, and initialize the `UserSpotlightPro` class.
- Set up the necessary namespaces and class structure for the plugin, such as `UserSpotlightPro\REST_API\ApiService`.
- Implement the `ApiService` class to handle the custom endpoint `/user-list/`.
  - Register a rewrite rule and rewrite tag for the custom endpoint.
  - Render the template with dummy data when visiting the custom endpoint.
- Flush the rewrite rules by saving permalink settings in the WordPress admin dashboard.
- Created a custom endpoint for `user-details`
- Implemented `fetch_user_details` method to retrieve user data from the API
- Updated `user-table-template.php` with links to user-details endpoint
- Created a `user-details-template.php` to display user information
- Implemented AJAX for user details fetching without page reload
- For testing and Inpsyde's coding standards, I have installed PHPUnit and Inpsyde code standard using composer and the following commands:

    ```zsh
  composer require inpsyde/php-coding-standards --dev
  composer run phpcs -- path
  composer run phpcbf -- path
  composer require --dev phpunit/phpunit
  composer require --dev brain/monkey
  composer run-script test
    ```

- Plugin Structure
  - users-list-plugin/
    - src/
      - REST_API/
        - ApiService.php
      - templates/
        - user-table-template.php
        - user-details-template.php
      - assets/
        - js/
          - user-details.js
      - UserSpotlightPro.php
    - composer.json
    - user-spotlight-pro.php

## Challenges and Solutions

- A 404 error was encountered when trying to access the custom endpoint. This was **resolved** by adjusting the rewrite rule and tag registration, as well as flushing the rewrite rules by saving permalink settings in the WordPress admin dashboard.
- Challenge: Integrating Fetch API with the custom user-details endpoint
**Solution:** Initially, the user details were fetched using the custom user-details endpoint, and it was required to return JSON data instead of HTML. To achieve this, a query parameter `?json=1` was appended to the user-details URL, and the corresponding PHP code was updated to check for this query parameter. If the parameter was present and set to '1', the PHP code would return JSON data instead of rendering the HTML template. This allowed the Fetch API in the user-details.js script to request and receive user details in JSON format, enabling the plugin to display user details asynchronously without reloading the page.

## Improvements and Future Work

- Cache
- Error handling
- Unit testing (in progress)
- Documentation
- Improve accessibility and responsiveness for more presentable design.
