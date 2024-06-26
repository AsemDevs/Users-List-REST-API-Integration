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
- Improve accessibility and responsiveness for more presentable design. ✅
- Automated testing. ✅
- Add Bootstrap for better design. ✅
- Better Design for the table and the user details. ✅
- Add new pagination feature in case the list of users excceed a specific number to handle it into several pages. ✅
- Refactor the `ApiService` class into more classes to be more readable and maintainable. ✅
- Make the endpoint customizable via options. ✅
- Make the pagination depend on the custom endpoint. ✅
- Use the defual endpoint after reactivating the plugin. ✅
- Flush rewrite rules to happen automatically when the endpoint is changed. ✅
- Make the Number of users per page customizable via options. ✅
- Make The Caching time customizable via options.
- Use REST API for the custom endpoint instead of AJAX. ✅
- Add a button in the plugin options page to clear the cache. ✅
- Add a new feature to display the user's posts in the user details page.
- Documentation. ✅

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
- Fixed Trailing slash issue in the custom endpoint for user-details to prevent duplicated requests, noticed in Network tab in Chrome DevTools.
- I have implemented the Ajax request using Ajax Jquery and not the Fetch API.
- I prefered to use Ajax Jquery because it is more compatible with older browsers.
- I have swtiched to display the data from the HTML in js variable to solve a warning in debug.log so i keep the user-details-template.php dedicated for its custom endpoint.
- The endpoint can be customized via settings > User Spotlight Pro.
- The Endpoint is now customizable via options but there should be more updates for the pagination as it depends on the custom endpoint.
- Process the AJAX request in the backend, fetch user details from the external API, it's better for caching and security.
- Removed the rewrite rule for user details as it is not necessary and used the template with full user details.
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
        - Assets.php
        - UserApi.php
      - templates/
        - user-table-template.php
        - user-details-template.php
      - Settings/
        - PluginOptions.php
      - assets/
        - js/
          - user-details.js
          - pagination.js
        - css/
          - styles.css
      - UserSpotlightPro.php
    - composer.json
    - tests/
      - ApiServiceTest.php
      - bootstrap.php
    - README.md
    - user-spotlight-pro.php

## Challenges and Solutions

- A 404 error was encountered when trying to access the custom endpoint. This was **resolved** by adjusting the rewrite rule and tag registration, as well as flushing the rewrite rules by saving permalink settings in the WordPress admin dashboard.
- Challenge: Integrating Fetch API with the custom user-details endpoint
**Solution:** Initially, the user details were fetched using the custom user-details endpoint, and it was required to return JSON data instead of HTML. To achieve this, a query parameter `?json=1` was appended to the user-details URL, and the corresponding PHP code was updated to check for this query parameter. If the parameter was present and set to '1', the PHP code would return JSON data instead of rendering the HTML template. This allowed the Fetch API in the user-details.js script to request and receive user details in JSON format, enabling the plugin to display user details asynchronously without reloading the page.
- Challenge: PHP Fatal error with trim() function is deprecated in wp-coding-standards/wpcs when using PHP 8.0 or later
**Solution:** The issue is caused by a bug in the wp-coding-standards/wpcs package, which is a dependency of the inpsyde/php-coding-standards package. There are two possible solutions: downgrade PHP to version 7.4, which is compatible with the inpsyde/php-coding-standards package, or wait for a new release of wp-coding-standards/wpcs that includes the fix for the trim() function bug.

## Improvements and Future Work

- Enhance error handling by providing more detailed error messages.
- Unit testing (To Add more test scenarios).
- Documentation
- Improve accessibility and responsiveness for more presentable design.
