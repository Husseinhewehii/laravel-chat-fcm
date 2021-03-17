// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/7.9.3/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.9.3/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
var firebaseConfig = {
    apiKey: "AIzaSyA1nZ90Nn_WZQH8TlkO-tkb2ATENa0IpZQ",
    authDomain: "laravel-tutorials-e7be8.firebaseapp.com",
    projectId: "laravel-tutorials-e7be8",
    storageBucket: "laravel-tutorials-e7be8.appspot.com",
    messagingSenderId: "664488863437",
    appId: "1:664488863437:web:0a311b00ced43cf2aeeb84"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);



// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const { title, body } = payload.notification;
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body
    };

    self.registration.showNotification(title,
        notificationOptions);
});
