jQuery(document).ready(function ($) {
  const userDetailsTemplate = `
    <div class="container user-details mt-5">
      <h1 class="text-center">User Details</h1>
      <div class="details-container card">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>ID:</strong> <span id="user-id"></span></li>
            <li class="list-group-item"><strong>Name:</strong> <span id="user-name"></span></li>
            <li class="list-group-item"><strong>Username:</strong> <span id="user-username"></span></li>
            <li class="list-group-item"><strong>Email:</strong> <span id="user-email"></span></li>
          </ul>
        </div>
      </div>
    </div>`;

  $("tbody").on("click", "tr[data-user-id] a", function (event) {
    event.preventDefault();
    const link = event.target;
    const userId = link.parentNode.parentNode.dataset.userId;
    displayUserDetails(userId);
  });

  function displayUserDetails(userId) {
    const errorContainer = $("#error-container");
    errorContainer.html(""); // Clear any previous error messages

    getUserDetails(userId);
  }

  function getUserDetails(userId) {
    const userDetailsUrl = `${window.location.origin}/user-details/${userId}/?json=1`;
    $.ajax({
      url: userDetailsUrl,
      dataType: "json",
      success: function (userDetails) {
        const userDetailsContainer = $("#user-details-container");

        // Use the static user details template
        userDetailsContainer.html(userDetailsTemplate);

        // Update the user details in the template
        $("#user-id").text(userDetails.id);
        $("#user-name").text(userDetails.name);
        $("#user-username").text(userDetails.username);
        $("#user-email").text(userDetails.email);
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
