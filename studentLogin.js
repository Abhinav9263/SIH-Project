// Get the form element
const form = document.getElementById("login-form");

// Handle form submission
form.addEventListener("submit", (event) => {
  event.preventDefault();

  // Gather data from the form fields
  const formData = new FormData(form);

  // Validate the data
  let isValid = true;
  for (const [key, value] of formData) {
    if (value === "" || value === null || value === undefined) {
      console.error(`Error: Field "${key}" is required.`);
      isValid = false;
    }
  }

  // If validation passes, submit the form
  if (isValid) {
    fetch("/your-endpoint", {
      // Replace with your actual server endpoint
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (response.ok) {
          // Redirect to the dashboard or another page on success
          console.log("Login successful!");
        } else {
          console.error("Login failed.");
        }
      })
      .catch((error) => {
        console.error("Error during login:", error);
      });
  }
});

// Handle "Forgot application number?" link click
const forgotLink = document.querySelector(".forgot-link");
forgotLink.addEventListener("click", (event) => {
  event.preventDefault();
  // Redirect to find.html
  window.location.href = "find.html";
});
