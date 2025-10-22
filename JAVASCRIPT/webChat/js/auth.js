// Import Firebase modules
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword, updateProfile, onAuthStateChanged } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
import { getFirestore, doc, setDoc, getDoc } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js';
import { firebaseConfig } from './firebase-config.js';

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

// Flag to prevent redirect during registration
let isRegistering = false;

// Function to switch to login tab
window.showLogin = function() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('registerForm').style.display = 'none';
    document.querySelectorAll('.tab-btn')[0].classList.add('active');
    document.querySelectorAll('.tab-btn')[1].classList.remove('active');
    clearErrors();
}

// Function to switch to register tab
window.showRegister = function() {
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('registerForm').style.display = 'block';
    document.querySelectorAll('.tab-btn')[1].classList.add('active');
    document.querySelectorAll('.tab-btn')[0].classList.remove('active');
    clearErrors();
}

// Clear error messages
function clearErrors() {
    document.getElementById('loginError').textContent = '';
    document.getElementById('registerError').textContent = '';
}

// Store user data in Firestore
async function storeUserData(uid, username, email) {
    try {
        await setDoc(doc(db, 'users', uid), {
            username: username,
            email: email,
            createdAt: new Date().toISOString()
        });
    } catch (error) {
        console.error('Error storing user data:', error);
        throw error;
    }
}

// Get username from Firestore
async function getUsernameFromFirestore(uid) {
    try {
        const userDoc = await getDoc(doc(db, 'users', uid));
        if (userDoc.exists()) {
            return userDoc.data().username;
        }
    } catch (error) {
        console.error('Error fetching username:', error);
    }
    return null;
}

// Handle user registration
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const username = document.getElementById('registerUsername').value.trim();
    const email = document.getElementById('registerEmail').value.trim();
    const password = document.getElementById('registerPassword').value;
    const errorMsg = document.getElementById('registerError');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    // Validation
    if (username.length < 3) {
        errorMsg.textContent = 'Username must be at least 3 characters';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating account...';
    errorMsg.textContent = '';
    
    // Set registration flag to prevent redirect
    isRegistering = true;

    try {
        // Create user with email and password
        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;
        
        // IMPORTANT: Store in Firestore FIRST (this is the source of truth)
        await storeUserData(user.uid, username, email);
        
        // Update Firebase Auth profile (secondary)
        await updateProfile(user, {
            displayName: username
        });

        // Force reload to get updated profile
        await user.reload();
        
        // Store username in localStorage
        localStorage.setItem('chatAppUsername', username);
        localStorage.setItem('chatAppUserId', user.uid);
        localStorage.setItem('chatAppEmail', email);

        // Clear registration flag
        isRegistering = false;

        // Redirect to chat library page
        window.location.href = 'chat-library.html';

    } catch (error) {
        isRegistering = false;
        submitBtn.disabled = false;
        submitBtn.textContent = 'Register';
        
        // User-friendly error messages
        if (error.code === 'auth/email-already-in-use') {
            errorMsg.textContent = 'Email already registered. Please login.';
        } else if (error.code === 'auth/weak-password') {
            errorMsg.textContent = 'Password is too weak. Use at least 6 characters.';
        } else if (error.code === 'auth/invalid-email') {
            errorMsg.textContent = 'Invalid email address.';
        } else {
            errorMsg.textContent = 'Registration failed. Please try again.';
        }
        console.error('Registration error:', error);
    }
});

// Handle user login
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value.trim();
    const password = document.getElementById('loginPassword').value;
    const errorMsg = document.getElementById('loginError');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    submitBtn.disabled = true;
    submitBtn.textContent = 'Logging in...';
    errorMsg.textContent = '';

    try {
        // Sign in user
        const userCredential = await signInWithEmailAndPassword(auth, email, password);
        const user = userCredential.user;
        
        // Get username from Firestore (source of truth)
        let username = await getUsernameFromFirestore(user.uid);
        
        // Fallback to displayName or email
        if (!username) {
            username = user.displayName || user.email?.split('@')[0] || 'User';
        }
        
        // Store user data
        localStorage.setItem('chatAppUsername', username);
        localStorage.setItem('chatAppUserId', user.uid);
        localStorage.setItem('chatAppEmail', email);

        // Redirect to chat library
        window.location.href = 'chat-library.html';

    } catch (error) {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Login';
        
        // User-friendly error messages
        if (error.code === 'auth/user-not-found' || error.code === 'auth/wrong-password' || error.code === 'auth/invalid-credential') {
            errorMsg.textContent = 'Invalid email or password.';
        } else if (error.code === 'auth/invalid-email') {
            errorMsg.textContent = 'Invalid email address.';
        } else if (error.code === 'auth/too-many-requests') {
            errorMsg.textContent = 'Too many failed attempts. Try again later.';
        } else {
            errorMsg.textContent = 'Login failed. Please try again.';
        }
        console.error('Login error:', error);
    }
});

// Check if user is already logged in
// IMPORTANT: Block redirect during registration to prevent race condition
onAuthStateChanged(auth, async (user) => {
    // Don't redirect if we're in the middle of registration
    if (isRegistering) {
        return;
    }
    
    if (user) {
        // Ensure username is stored
        let username = localStorage.getItem('chatAppUsername');
        
        if (!username || username === 'null' || username === 'undefined') {
            // Try to get from Firestore first
            username = await getUsernameFromFirestore(user.uid);
            
            // Fallback chain
            if (!username) {
                username = user.displayName || user.email?.split('@')[0] || 'User';
            }
            
            localStorage.setItem('chatAppUsername', username);
            localStorage.setItem('chatAppUserId', user.uid);
        }
        
        window.location.href = 'chat-library.html';
    }
});
