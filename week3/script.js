const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

// Toggle hamburger menu
hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    navLinks.classList.toggle("open");
});

// Auto-close on clicking a link
document.querySelectorAll("#nav-links a").forEach(link => {
    link.addEventListener("click", () => {
        hamburger.classList.remove("active");
        navLinks.classList.remove("open");
    });
});

// CONTACT FORM
const form = document.getElementById("contact-form");
const messageBox = document.getElementById("form-message");

form.addEventListener("submit", (event) => {
    event.preventDefault();

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();

    if (name === "" || email === "") {
        messageBox.textContent = "Please fill all fields.";
        messageBox.style.color = "red";
        return;
    }

    messageBox.textContent = "Message Sent Successfully! ✔";
    messageBox.style.color = "lightgreen";
    form.reset();
});
