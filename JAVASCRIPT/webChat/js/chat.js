// Import Firebase modules
import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js';
import { getAuth, onAuthStateChanged } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js';
import { getFirestore, collection, addDoc, query, onSnapshot, orderBy, serverTimestamp, doc, getDoc } from 'https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js';
import { firebaseConfig } from './firebase-config.js';

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);

// Get group ID and name from URL parameters
const urlParams = new URLSearchParams(window.location.search);
const groupId = urlParams.get('groupId');
const groupName = urlParams.get('groupName');

// Validate parameters
if (!groupId || !groupName) {
    alert('Invalid group. Redirecting...');
    window.location.href = 'chat-library.html';
}

// Display group name in header
if (groupName) {
    document.getElementById('groupName').textContent = decodeURIComponent(groupName);
}

// Go back to chat library
window.goBack = function() {
    window.location.href = 'chat-library.html';
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

// Check authentication
onAuthStateChanged(auth, async (user) => {
    if (!user) {
        window.location.href = 'index.html';
        return;
    }
    
    // Get username with proper fallback chain
    let username = localStorage.getItem('chatAppUsername');
    
    if (!username || username === 'null' || username === 'undefined') {
        username = await getUsernameFromFirestore(user.uid);
    }
    
    if (!username) {
        username = user.displayName || user.email?.split('@')[0] || 'User';
    }
    
    // Update localStorage
    localStorage.setItem('chatAppUsername', username);
    localStorage.setItem('chatAppUserId', user.uid);
    
    loadMessages();
});

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Send a new message
document.getElementById('messageForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const messageInput = document.getElementById('messageInput');
    const messageText = messageInput.value.trim();
    
    if (!messageText) return;

    const username = localStorage.getItem('chatAppUsername');
    const userId = localStorage.getItem('chatAppUserId');
    const submitBtn = e.target.querySelector('button[type="submit"]');

    submitBtn.disabled = true;

    try {
        await addDoc(collection(db, 'groups', groupId, 'messages'), {
            text: messageText,
            username: username,
            userId: userId,
            timestamp: serverTimestamp()
        });

        messageInput.value = '';
        
    } catch (error) {
        console.error('Error sending message:', error);
        alert('Failed to send message. Please try again.');
    } finally {
        submitBtn.disabled = false;
        messageInput.focus();
    }
});

// Load messages
function loadMessages() {
    const messagesContainer = document.getElementById('messagesContainer');
    const q = query(
        collection(db, 'groups', groupId, 'messages'), 
        orderBy('timestamp', 'asc')
    );

    onSnapshot(q, (snapshot) => {
        messagesContainer.innerHTML = '';

        if (snapshot.empty) {
            messagesContainer.innerHTML = '<p class="no-messages">No messages yet. Start the conversation!</p>';
            return;
        }

        const currentUserId = localStorage.getItem('chatAppUserId');

        snapshot.forEach((doc) => {
            const message = doc.data();
            const messageDiv = document.createElement('div');
            
            if (message.userId === currentUserId) {
                messageDiv.className = 'message message-own';
            } else {
                messageDiv.className = 'message message-other';
            }

            let timeString = '';
            if (message.timestamp) {
                const date = message.timestamp.toDate();
                timeString = date.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
            }

            messageDiv.innerHTML = `
                <div class="message-header">
                    <strong>${escapeHtml(message.username)}</strong>
                    ${timeString ? `<span class="message-time">${timeString}</span>` : ''}
                </div>
                <div class="message-text">${escapeHtml(message.text)}</div>
            `;

            messagesContainer.appendChild(messageDiv);
        });

        // Scroll to bottom smoothly
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: 'smooth'
        });
        
    }, (error) => {
        console.error('Error loading messages:', error);
        messagesContainer.innerHTML = '<p class="error-msg">Failed to load messages.</p>';
    });
}

// Handle Enter key to send message
document.getElementById('messageInput').addEventListener('keypress', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('messageForm').dispatchEvent(new Event('submit'));
    }
});
