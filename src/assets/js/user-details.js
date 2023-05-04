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
    const userId = $(this).data("user-id");
    displayUserDetails(userId);
  });

  function displayUserDetails(userId) {
    const errorContainer = $("#error-container");
    errorContainer.html(""); // Clear any previous error messages

    showUserDetails(userId);
  }

  async function showUserDetails(userId) {
    const data = new FormData();
    data.append("action", "get_user_details");
    data.append("user_id", userId);

    const response = await fetch(ajax_object.ajaxurl, {
      method: "POST",
      body: data,
    });
    const result = await response.json();

    if (result.success) {
      const userDetails = result.data;
      const userDetailsContainer = $("#user-details-container");

      userDetailsContainer.html(userDetailsTemplate);

      $("#user-id").text(userDetails.id);
      $("#user-name").text(userDetails.name);
      $("#user-username").text(userDetails.username);
      $("#user-email").text(userDetails.email);
    } else {
      // Handle error, for example, show an alert with the error message.
      alert(result.data);
    }
  }
});
