jQuery(document).ready(function ($) {
  let userDetailsTemplate = "";

  $("tbody").on("click", "tr[data-user-id] a", function (event) {
    event.preventDefault();
    const link = event.target;
    const userId = link.parentNode.parentNode.dataset.userId;
    displayUserDetails(userId);
  });

  function displayUserDetails(userId) {
    const errorContainer = $("#error-container");
    errorContainer.html(""); // Clear any previous error messages

    if (!userDetailsTemplate) {
      const userDetailsTemplateUrl = `${window.location.origin}/user-details`;
      console.log(userDetailsTemplateUrl);
      // Fetch the user details template using AJAX
      $.ajax({
        url: userDetailsTemplateUrl,
        dataType: "html",
        success: function (templateContent) {
          userDetailsTemplate = templateContent;
          getUserDetails(userId);
        },
        error: function () {
          console.error("Error fetching user details template");
          errorContainer.html("Error fetching user details template");
        },
      });
    } else {
      getUserDetails(userId);
    }
  }

  function getUserDetails(userId) {
    const userDetailsUrl = `${window.location.origin}/user-details/${userId}/?json=1`;
    $.ajax({
      url: userDetailsUrl,
      dataType: "json",
      success: function (userDetails) {
        const userDetailsContainer = $("#user-details-container");

        // Use the fetched user details template
        userDetailsContainer.html(userDetailsTemplate);

        // Update the user details in the template
        $(".user-details #user-id").text(userDetails.id);
        $(".user-details #user-name").text(userDetails.name);
        $(".user-details #user-username").text(userDetails.username);
        $(".user-details #user-email").text(userDetails.email);
      },
      error: function (jqXHR) {
        let errorMessage = "Error fetching user details";

        // Provide more specific error messages based on the status code
        if (jqXHR.status === 404) {
          errorMessage = "User not found";
        } else if (jqXHR.status === 500) {
          errorMessage = "Internal server error";
        }

        console.error("Error:", errorMessage);
        errorContainer.html(errorMessage); // Display the error message to the user
      },
    });
  }
});
