jQuery(document).ready(function ($) {
  let userDetailsTemplate = $("#hidden-user-details-template").html();

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

  function showUserDetails(userId) {
    fetch(`/wp-json/user_spotlight_pro/v1/user/${userId}`, {
      method: "GET",
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((userDetails) => {
        const userDetailsContainer = $("#user-details-container");

        userDetailsContainer.html(userDetailsTemplate);

        userDetailsContainer.find(".user-id").text(userDetails.id);
        userDetailsContainer.find(".user-name").text(userDetails.name);
        userDetailsContainer.find(".user-username").text(userDetails.username);
        userDetailsContainer.find(".user-email").text(userDetails.email);
        userDetailsContainer.find(".user-phone").text(userDetails.phone);
        userDetailsContainer.find(".user-website").text(userDetails.website);

        userDetailsContainer.find(".user-street").text(userDetails.address.street);
        userDetailsContainer.find(".user-suite").text(userDetails.address.suite);
        userDetailsContainer.find(".user-city").text(userDetails.address.city);
        userDetailsContainer.find(".user-zipcode").text(userDetails.address.zipcode);
        userDetailsContainer.find(".user-lat").text(userDetails.address.geo.lat);
        userDetailsContainer.find(".user-lng").text(userDetails.address.geo.lng);

        userDetailsContainer.find(".user-company-name").text(userDetails.company.name);
        userDetailsContainer.find(".user-catchPhrase").text(userDetails.company.catchPhrase);
        userDetailsContainer.find(".user-bs").text(userDetails.company.bs);
      })
      .catch((error) => {
        // Check if the error.message property exists
        let message = error.message ? error.message : JSON.stringify(error);
        showError(message);
      });
  }


  function showError(message) {
    const userDetailsContainer = $("#user-details-container");
    userDetailsContainer.html('<p class="alert alert-danger">' + message + '</p>');
  }

});
