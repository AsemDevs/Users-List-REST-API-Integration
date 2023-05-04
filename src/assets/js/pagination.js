document.addEventListener("DOMContentLoaded", async function () {
  const apiResponse = await fetch(
    `${window.location.origin}${UserSpotlightPro.customEndpoint}?json=1`
  );
  const allUsersData = await apiResponse.json();
  const allUsers = Array.from(document.querySelectorAll("tbody tr"));
  const usersPerPage = parseInt(UserSpotlightPro.usersPerPage);
  const totalPages = Math.ceil(allUsersData.length / usersPerPage);

  renderUsers(1, allUsers);
  setupPagination(totalPages);

  function renderUsers(page, allUsers) {
    const start = (page - 1) * usersPerPage;
    const end = start + usersPerPage;

    allUsers.forEach((user, index) => {
      if (index >= start && index < end) {
        user.style.display = "table-row";
      } else {
        user.style.display = "none";
      }
    });
  }

  function setupPagination(totalPages) {
    const paginationContainer = document.getElementById("pagination-container");
    let paginationHTML = '<ul class="pagination justify-content-center">';

    for (let i = 1; i <= totalPages; i++) {
      paginationHTML += `<li class="page-item"><a href="#" class="page-link" data-page="${i}">${i}</a></li>`;
    }

    paginationHTML += "</ul>";

    paginationContainer.innerHTML = paginationHTML;

    const pageLinks = document.querySelectorAll(".page-link");
    pageLinks.forEach((link) => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const page = parseInt(link.dataset.page);
        renderUsers(page, allUsers);
      });
    });
  }
});
