const container = document.getElementById("container");
const registerbtn = document.getElementById("register");
const loginbtn = document.getElementById("login");

registerbtn.addEventListener("click", () => {
  container.classList.add("active");
});

loginbtn.addEventListener("click", () => {
  container.classList.remove("active");
});
function validateForm(event) {
  event.preventDefault(); // Prevent the form from submitting before validation

  // Get form fields
  const prenom = document.getElementById('prenom').value.trim();
  const email = document.getElementById('email').value.trim();
  const passe = document.getElementById('passe').value.trim();
  const confirmPassword = document.getElementById('password').value.trim();
  const titre = document.getElementById('titre').value;

  // Clear previous error messages
  clearErrors();

  // Initialize a flag for validation status
  let isValid = true;

  // Validate prenom (name)
  if (prenom === "") {
    isValid = false;
    document.getElementById('nomErreur').textContent = "Le prénom est requis.";
  }

  // Validate email
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!email.match(emailPattern)) {
    isValid = false;
    document.getElementById('emailErreur').textContent = "Entrez un email valide.";
  }

  // Validate password
  if (passe.length < 6) {
    isValid = false;
    document.getElementById('passErreur').textContent = "Le mot de passe doit contenir au moins 6 caractères.";
  }

  // Validate password confirmation
  if (passe !== confirmPassword) {
    isValid = false;
    document.getElementById('confirmErreur').textContent = "Les mots de passe ne correspondent pas.";
  }

  // If validation passes, show success message or submit the form
  if (isValid) {
    window.location="index.html"
    // Optionally, submit the form or send data to the server here
    // document.getElementById('form1').submit();
  }
}

// Function to validate login form
function validateForm1(event) {
  event.preventDefault(); // Prevent the form from submitting before validation

  // Get form fields
  const email = document.getElementById('mail').value.trim();
  const password = document.getElementById('password1').value.trim();

  // Clear previous error messages
  clearErrors();

  // Initialize a flag for validation status
  let isValid = true;

  // Validate email
  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!email.match(emailPattern)) {
    isValid = false;
    document.getElementById('mailErreur').textContent = "Entrez un email valide.";
  }

  // Validate password
  if (password.length < 6) {
    isValid = false;
    document.getElementById('motErreur').textContent = "Le mot de passe doit contenir au moins 6 caractères.";
  }

  // If validation passes, show success message or submit the form
  if (isValid) {
    window.location="index.html"
    // Optionally, submit the form or send data to the server here
    // document.getElementById('form2').submit();
  }
}

// Function to clear all error messages
function clearErrors() {
  document.getElementById('nomErreur').textContent = "";
  document.getElementById('emailErreur').textContent = "";
  document.getElementById('passErreur').textContent = "";
  document.getElementById('confirmErreur').textContent = "";
  document.getElementById('mailErreur').textContent = "";
  document.getElementById('motErreur').textContent = "";
}

// Switch between login and signup forms
document.getElementById("register").addEventListener("click", function () {
  document.querySelector(".sign-in").style.display = "none";
  document.querySelector(".sign-up").style.display = "block";
  document.querySelector(".toogle-left").classList.add("active");
  document.querySelector(".toogle-right").classList.remove("active");
});

document.getElementById("login").addEventListener("click", function () {
  document.querySelector(".sign-in").style.display = "block";
  document.querySelector(".sign-up").style.display = "none";
  document.querySelector(".toogle-left").classList.remove("active");
  document.querySelector(".toogle-right").classList.add("active");
})