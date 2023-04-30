document.addEventListener('DOMContentLoaded', function () {
    const userLinks = document.querySelectorAll('tbody tr[data-user-id] a');

    userLinks.forEach((link) => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const userId = link.closest('tr[data-user-id]').dataset.userId;

            fetchUserDetails(userId);
        });
    });
});

function fetchUserDetails(userId) {
    const userDetailsUrl = `${window.location.origin}/user-details/${userId}?json=1`;

    fetch(userDetailsUrl)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error fetching user details');
            }
            return response.json();
        })
        .then((userDetails) => {
            displayUserDetails(userDetails);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function displayUserDetails(userDetails) {
    const userDetailsContainer = document.getElementById('user-details-container');

    // Create a new div for the user details
    const newUserDetailsDiv = document.createElement('div');
    newUserDetailsDiv.classList.add('user-details');

    // Create the HTML structure for the user details
    const userDetailsHTML = `
        <h1>User Details</h1>
        <p>ID: ${userDetails.id}</p>
        <p>Name: ${userDetails.name}</p>
        <p>Username: ${userDetails.username}</p>
        <p>Email: ${userDetails.email}</p>
    `;

    // Set the innerHTML of the new div to the generated HTML structure
    newUserDetailsDiv.innerHTML = userDetailsHTML;

    // Replace the existing user details with the new one
    userDetailsContainer.replaceChild(newUserDetailsDiv, userDetailsContainer.firstChild);
}

