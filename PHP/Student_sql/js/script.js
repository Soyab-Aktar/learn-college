// Add smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollBehavView({ behavior: 'smooth' });
    });
});

// Form validation feedback
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('invalid', function() {
        this.style.borderColor = '#e74c3c';
    });
    
    input.addEventListener('input', function() {
        this.style.borderColor = '#B497D6';
    });
});
