// Import Firebase modules
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, onAuthStateChanged, signOut } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
import { getFirestore, collection, addDoc, query, onSnapshot, orderBy, serverTimestamp, doc, getDoc } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js';
import { firebaseConfig } from './firebase-config.js';

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

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

// Check authentication
onAuthStateChanged(auth, async (user) => {
    if (!user) {
        window.location.href = 'index.html';
        return;
    }
    
    // Get username with proper fallback chain
    let username = localStorage.getItem('chatAppUsername');
    
    // If no valid username in localStorage, fetch from Firestore
    if (!username || username === 'null' || username === 'undefined') {
        username = await getUsernameFromFirestore(user.uid);
    }
    
    // Fallback to displayName or email
    if (!username) {
        username = user.displayName || user.email?.split('@')[0] || 'User';
    }
    
    // Update localStorage
    localStorage.setItem('chatAppUsername', username);
    localStorage.setItem('chatAppUserId', user.uid);
    
    // Display username
    document.getElementById('displayUsername').textContent = username;
    
    loadChatGroups();
});

// Logout function
window.logout = async function() {
    if (confirm('Are you sure you want to logout?')) {
        try {
            await signOut(auth);
            localStorage.clear();
            window.location.href = 'index.html';
        } catch (error) {
            console.error('Logout error:', error);
            alert('Logout failed. Please try again.');
        }
    }
}

// Create new chat group
document.getElementById('createGroupForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const groupNameInput = document.getElementById('groupName');
    const groupName = groupNameInput.value.trim();
    const errorMsg = document.getElementById('createError');
    const username = localStorage.getItem('chatAppUsername') || 'User';
    const userId = localStorage.getItem('chatAppUserId');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    if (groupName.length < 3) {
        errorMsg.textContent = 'Group name must be at least 3 characters';
        return;
    }

    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating...';
    errorMsg.textContent = '';

    try {
        await addDoc(collection(db, 'groups'), {
            name: groupName,
            createdBy: username,
            createdById: userId,
            createdAt: serverTimestamp(),
            memberCount: 0
        });

        groupNameInput.value = '';
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create';
        
    } catch (error) {
        errorMsg.textContent = 'Failed to create group. Try again.';
        console.error('Error creating group:', error);
        submitBtn.disabled = false;
        submitBtn.textContent = 'Create';
    }
});

// Load chat groups
function loadChatGroups() {
    const groupsList = document.getElementById('groupsList');
    const q = query(collection(db, 'groups'), orderBy('createdAt', 'desc'));

    onSnapshot(q, (snapshot) => {
        groupsList.innerHTML = '';

        if (snapshot.empty) {
            groupsList.innerHTML = '<p class="no-groups">No groups yet. Create one!</p>';
            return;
        }

        snapshot.forEach((doc) => {
            const group = doc.data();
            const groupCard = document.createElement('div');
            groupCard.className = 'group-card';
            
            // Format creation date
            let dateStr = '';
            if (group.createdAt) {
                const date = group.createdAt.toDate();
                dateStr = date.toLocaleDateString('en-US', { 
                    month: 'short', 
                    day: 'numeric',
                    year: 'numeric'
                });
            }
            
            groupCard.innerHTML = `
                <h3>${escapeHtml(group.name)}</h3>
                <p class="group-meta">Created by ${escapeHtml(group.createdBy || 'Unknown')}</p>
                ${dateStr ? `<p class="group-meta">${dateStr}</p>` : ''}
            `;
            
            groupCard.addEventListener('click', () => {
                window.location.href = `chat-room.html?groupId=${doc.id}&groupName=${encodeURIComponent(group.name)}`;
            });

            groupsList.appendChild(groupCard);
        });
    }, (error) => {
        console.error('Error loading groups:', error);
        groupsList.innerHTML = '<p class="error-msg">Failed to load groups.</p>';
    });
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
