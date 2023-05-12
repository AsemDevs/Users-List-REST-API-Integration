jQuery(document).ready(function ($) {
  $("tbody").on("click", "tr[data-user-id] a", function (event) {
    event.preventDefault();
    const userId = $(this).data("user-id");
    displayUserDetails(userId);
  });

  function displayUserDetails(userId) {
    const errorContainer = $("#error-container");
    errorContainer.html(""); // Clear any previous error messages

    const userDetailsTemplate = $("#hidden-user-details-template").html();
    showUserDetails(userId, userDetailsTemplate);
  }

  function showUserDetails(userId, userDetailsTemplate) {
    const data = new FormData();
    data.append("action", "get_user_details");
    data.append("user_id", userId);

    fetch(ajax_object.ajaxurl, {
      method: "POST",
      body: data,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.success) {
          const userDetails = result.data;
          const userDetailsContainer = $("#user-details-container");

          userDetailsContainer.html(userDetailsTemplate);

          userDetailsContainer.find(".user-id").text(userDetails.id);
          userDetailsContainer.find(".user-name").text(userDetails.name);
          userDetailsContainer
            .find(".user-username")
            .text(userDetails.username);
          userDetailsContainer.find(".user-email").text(userDetails.email);
          userDetailsContainer.find(".user-phone").text(userDetails.phone);
          userDetailsContainer.find(".user-website").text(userDetails.website);

          userDetailsContainer
            .find(".user-street")
            .text(userDetails.address.street);
          userDetailsContainer
            .find(".user-suite")
            .text(userDetails.address.suite);
          userDetailsContainer
            .find(".user-city")
            .text(userDetails.address.city);
          userDetailsContainer
            .find(".user-zipcode")
            .text(userDetails.address.zipcode);
          userDetailsContainer
            .find(".user-lat")
            .text(userDetails.address.geo.lat);
          userDetailsContainer
            .find(".user-lng")
            .text(userDetails.address.geo.lng);

          userDetailsContainer
            .find(".user-company-name")
            .text(userDetails.company.name);
          userDetailsContainer
            .find(".user-catchPhrase")
            .text(userDetails.company.catchPhrase);
          userDetailsContainer.find(".user-bs").text(userDetails.company.bs);
        } else {
          alert(result.data);
        }
      });
  }
});
