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
    try {
      const userDetailsUrl = `${window.location.origin}/user-details/${userId}?json=1`;
      const response = await fetch(userDetailsUrl);
  
      if (!response.ok) {
        // TODO: Improve error handling by providing more specific error messages
        // and handling different types of HTTP errors.
  
        throw new Error("Error fetching user details");
      }
  
      const userDetails = await response.json();
      const userDetailsContainer = document.getElementById(
        "user-details-container"
      );
  
      const userDetailsHTML = `
            <div class="user-details">
                <h1>User Details</h1>
                <div class="details-container card">
                  <p>ID: ${userDetails.id}</p>
                  <p>Name: ${userDetails.name}</p>
                  <p>Username: ${userDetails.username}</p>
                  <p>Email: ${userDetails.email}</p>
              </div>
            </div>
          `;
  
      userDetailsContainer.innerHTML = userDetailsHTML;
    } catch (error) {
      console.error("Error:", error);
    }
  }
  