// Import Firebase modules
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, onAuthStateChanged, signOut } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
import { getFirestore, collection, addDoc, query, onSnapshot, orderBy, serverTimestamp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js';
import { firebaseConfig } from './firebase-config.js';

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

// Check authentication
onAuthStateChanged(auth, (user) => {
    if (!user) {
        window.location.href = 'index.html';
    } else {
        // Get username with fallback chain
        let username = localStorage.getItem('chatAppUsername');
        
        if (!username || username === 'null' || username === 'Anonymous') {
            username = user.displayName;
        }
        
        if (!username || username === 'null') {
            username = user.email ? user.email.split('@')[0] : 'User';
        }
        
        // Update localStorage
        localStorage.setItem('chatAppUsername', username);
        
        // Display username
        document.getElementById('displayUsername').textContent = username;
        
        loadChatGroups();
    }
});

// Logout function
window.logout = async function() {
    try {
        await signOut(auth);
        localStorage.clear();
        window.location.href = 'index.html';
    } catch (error) {
        console.error('Logout error:', error);
    }
}

// Create new chat group
document.getElementById('createGroupForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const groupName = document.getElementById('groupName').value.trim();
    const errorMsg = document.getElementById('createError');
    const username = localStorage.getItem('chatAppUsername') || 'User';

    try {
        await addDoc(collection(db, 'groups'), {
            name: groupName,
            createdBy: username,
            createdAt: serverTimestamp()
        });

        document.getElementById('groupName').value = '';
        errorMsg.textContent = '';
        
    } catch (error) {
        errorMsg.textContent = 'Failed to create group. Try again.';
        console.error('Error creating group:', error);
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
            groupCard.innerHTML = `
                <h3>${group.name}</h3>
                <p class="group-meta">Created by ${group.createdBy || 'Unknown'}</p>
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
