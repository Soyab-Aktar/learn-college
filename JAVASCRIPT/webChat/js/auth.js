// Import Firebase modules
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, updateProfile, onAuthStateChanged } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
import { firebaseConfig } from './firebase-config.js';

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Function to switch to login tab
window.showLogin = function() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
    document.querySelectorAll('.tab-btn')[0].classList.add('active');
    document.querySelectorAll('.tab-btn')[1].classList.remove('active');
}

// Function to switch to register tab
window.showRegister = function() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
    document.querySelectorAll('.tab-btn')[1].classList.add('active');
    document.querySelectorAll('.tab-btn')[0].classList.remove('active');
}

// Handle user registration
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const username = document.getElementById('registerUsername').value.trim();
    const email = document.getElementById('registerEmail').value.trim();
    const password = document.getElementById('registerPassword').value;
    const errorMsg = document.getElementById('registerError');

    try {
        // Create user with email and password
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        
        // Update user profile with username
        await updateProfile(userCredential.user, {
            displayName: username
        });

        // Wait for profile update to complete
        await userCredential.user.reload();
        
        // Store username in localStorage
        localStorage.setItem('chatAppUsername', username);
        localStorage.setItem('chatAppUserId', userCredential.user.uid);
        localStorage.setItem('chatAppEmail', email);

        // Redirect to chat library page
        window.location.href = 'chat-library.html';

    } catch (error) {
        errorMsg.textContent = error.message;
        console.error('Registration error:', error);
    }
});

// Handle user login
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;
    const errorMsg = document.getElementById('loginError');

    try {
        // Sign in user
        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        
        // Get username from Firebase or use email prefix as fallback
        const username = userCredential.user.displayName || email.split('@')[0] || 'User';
        
        // Store user data
        localStorage.setItem('chatAppUsername', username);
        localStorage.setItem('chatAppUserId', userCredential.user.uid);
        localStorage.setItem('chatAppEmail', email);

        // Redirect to chat library
        window.location.href = 'chat-library.html';

    } catch (error) {
        errorMsg.textContent = error.message;
        console.error('Login error:', error);
    }
});

// Check if user is already logged in
onAuthStateChanged(auth, (user) => {
    if (user) {
        window.location.href = 'chat-library.html';
    }
});
