const authContainer = document.getElementById("authContainer");
const showSignIn = document.getElementById("showSignIn");
const showSignUp = document.getElementById("showSignUp");

showSignIn.addEventListener("click", () => {
  authContainer.classList.add("active");
});

showSignUp.addEventListener("click", () => {
  authContainer.classList.remove("active");
});

const toggleButtons = document.querySelectorAll(".toggle-password");

toggleButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const input = button.previousElementSibling;

    if (input.type === "password") {
      input.type = "text";
      button.textContent = "Show";
    } else {
      input.type = "password";
      button.textContent = "Hide";
    }
  });
});