// js/script.js - Basic JavaScript for mobile menu (optional for now)

document.addEventListener('DOMContentLoaded', function() {
    console.log('MedCore loaded successfully!');
    
    // Mobile menu toggle (we'll implement this later)
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
        });
    }
});
