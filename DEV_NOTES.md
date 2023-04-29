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
- These user’s details fetching requests must be asynchronous (AJAX).
- The user details must be shown without reloading the page.
- Test Using phpunit and inpsyde coding standards.

## Implementation

- Create the plugin's main file, `user-spotlight-pro.php`, and initialize the `UserSpotlightPro` class.
- Set up the necessary namespaces and class structure for the plugin, such as `UserSpotlightPro\REST_API\ApiService`.
- Implement the `ApiService` class to handle the custom endpoint `/user-list/`.
  - Register a rewrite rule and rewrite tag for the custom endpoint.
  - Render the template with dummy data when visiting the custom endpoint.
- Flush the rewrite rules by saving permalink settings in the WordPress admin dashboard.
- Created a custom endpoint for user-details
- Implemented fetch_user_details method to retrieve user data from the API
- Updated user-table-template.php with links to user-details endpoint
- Created a user-details-template.php to display user information
- Plugin Structure
  - users-list-plugin/
    - src/
      - REST_API/
        - ApiService.php
      - templates/
        - user-table-template.php
      - UserSpotlightPro.php
    - composer.json
    - user-spotlight-pro.php

## Challenges and Solutions

- A 404 error was encountered when trying to access the custom endpoint. This was **resolved** by adjusting the rewrite rule and tag registration, as well as flushing the rewrite rules by saving permalink settings in the WordPress admin dashboard.

## Improvements and Future Work

- Cache
- Error handling
- Unit testing
- Documentation
