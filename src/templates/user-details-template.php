<div class="container">
    <h1 class="text-center mb-4">User Details</h1>
    <div class="card">
        <div class="card-header">
            <h3 class="user-name"></h3>
        </div>
        <div class="card-body">
            <div class="accordion" id="userDetailsAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="basicInfoHeading">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#basicInfo" aria-expanded="true"
                        aria-controls="basicInfo">
                            Basic Info
                        </button>
                    </h2>
                    <div id="basicInfo" class="accordion-collapse collapse show"
                    aria-labelledby="basicInfoHeading" data-bs-parent="#userDetailsAccordion">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>ID:</strong> <span class="user-id"></span></li>
                                <li class="list-group-item"><strong>Name:</strong> <span class="user-name"></span></li>
                                <li class="list-group-item"><strong>Username:</strong> <span class="user-username"></span></li>
                                <li class="list-group-item"><strong>Email:</strong> <span class="user-email"></span></li>
                                <li class="list-group-item"><strong>Phone:</strong> <span class="user-phone"></span></li>
                                <li class="list-group-item"><strong>Website:</strong> <span class="user-website"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="addressHeading">
                        <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#address"
                        aria-expanded="false" aria-controls="address">
                            Address
                        </button>
                    </h2>
                    <div id="address" class="accordion-collapse collapse"
                    aria-labelledby="addressHeading" data-bs-parent="#userDetailsAccordion">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Street:</strong> <span class="user-street"></span></li>
                                <li class="list-group-item"><strong>Suite:</strong> <span class="user-suite"></span></li>
                                <li class="list-group-item"><strong>City:</strong> <span class="user-city"></span></li>
                                <li class="list-group-item"><strong>Zipcode:</strong> <span class="user-zipcode"></span></li>
                                <li class="list-group-item"><strong>Latitude:</strong> <span class="user-lat"></span></li>
                                <li class="list-group-item"><strong>Longitude:</strong> <span class="user-lng"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="companyHeading">
                        <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#company"
                        aria-expanded="false" aria-controls="company">
                            Company
                        </button>
                    </h2>
                    <div id="company" class="accordion-collapse collapse"
                    aria-labelledby="companyHeading" data-bs-parent="#userDetailsAccordion">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> <span class="user-company-name"></span></li>
                                <li class="list-group-item"><strong>Catch Phrase:</strong> <span class="user-catchPhrase"></span></li>
                                <li class="list-group-item"><strong>Business:</strong> <span class="user-bs"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
