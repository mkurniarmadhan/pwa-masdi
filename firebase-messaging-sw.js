importScripts("https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js");
importScripts(
  "https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"
);

firebase.initializeApp({
  apiKey: "AIzaSyAoA4W2yCvCu8rK0Yq_L-si4SMGyt2RguY",
  authDomain: "blogapp-5177e.firebaseapp.com",
  databaseURL: "https://blogapp-5177e.firebaseio.com",
  projectId: "blogapp-5177e",
  storageBucket: "blogapp-5177e.appspot.com",
  messagingSenderId: "597558601088",
  appId: "1:597558601088:web:cbbca52d39237799d74d65",
});

const messaging = firebase.messaging();

// messaging.setBackgroundMessageHandler((payload) => {
//   const title = "Background Message Title";
//   const options = {
//     body: payload.data.status,
//     icon: "/firebase-logo.png",
//   };
//   return self.registration.showNotification(title, options);
// });

messaging.onMessage((payload) => {
  console.log("Message received. ", payload);
  // Customize notification here
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: "/firebase-logo.png",
  };

  if (Notification.permission === "granted") {
    new Notification(notificationTitle, notificationOptions);
  }
});
