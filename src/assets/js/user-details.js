document.addEventListener("DOMContentLoaded", function () {
  const userLinks = document.querySelectorAll("tbody tr[data-user-id] a");

  userLinks.forEach((link) => {
    link.addEventListener("click", async function (event) {
      event.preventDefault();
      const userId = link.parentNode.parentNode.dataset.userId;
      await displayUserDetails(userId);
    });
  });
});

async function displayUserDetails(userId) {
  const errorContainer = document.getElementById("error-container");
  errorContainer.innerHTML = ""; // Clear any previous error messages

  try {
    const userDetailsUrl = `${window.location.origin}/user-details/${userId}/?json=1`;
    const response = await fetch(userDetailsUrl);

    if (!response.ok) {
      let errorMessage = "Error fetching user details";

      // Provide more specific error messages based on the status code
      if (response.status === 404) {
        errorMessage = "User not found";
      } else if (response.status === 500) {
        errorMessage = "Internal server error";
      }

      throw new Error(errorMessage);
    }

    const userDetails = await response.json();
    const userDetailsContainer = document.getElementById(
      "user-details-container"
    );

    const userDetailsHTML = `
        <div class="user-details mt-5">
            <h1 class="text-center">User Details</h1>
            <div class="details-container card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>ID:</strong> ${userDetails.id}</li>
                        <li class="list-group-item"><strong>Name:</strong> ${userDetails.name}</li>
                        <li class="list-group-item"><strong>Username:</strong> ${userDetails.username}</li>
                        <li class="list-group-item"><strong>Email:</strong> ${userDetails.email}</li>
                    </ul>
                </div>
            </div>
        </div>
          `;

    userDetailsContainer.innerHTML = userDetailsHTML;
  } catch (error) {
    console.error("Error:", error);
    errorContainer.innerHTML = error.message; // Display the error message to the user
  }
}
