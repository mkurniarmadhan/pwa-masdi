"use strict";

let swRegistration = null;

let deferredPrompt;
const installButton = document.getElementById("install_button");
const notificationButton = document.getElementById("chekout");
installButton.hidden = true;

// Initialize Firebase
const config = {
  apiKey: "AIzaSyAoA4W2yCvCu8rK0Yq_L-si4SMGyt2RguY",
  authDomain: "blogapp-5177e.firebaseapp.com",
  databaseURL: "https://blogapp-5177e.firebaseio.com",
  projectId: "blogapp-5177e",
  storageBucket: "blogapp-5177e.appspot.com",
  messagingSenderId: "597558601088",
  appId: "1:597558601088:web:cbbca52d39237799d74d65",
};

firebase.initializeApp(config);
const messaging = firebase.messaging();

window.addEventListener("beforeinstallprompt", (e) => {
  console.log("beforeinstallprompt fired");
  e.preventDefault();
  deferredPrompt = e;
  // Show the install button
  installButton.hidden = false;
  installButton.addEventListener("click", installApp);
});

initializeFCM();

function initializeApp() {
  if ("serviceWorker" in navigator && "PushManager" in window) {
    console.log("Service Worker and Push is supported");
    initializeFCM();
    //Register the service worker
    navigator.serviceWorker
      .register("./sw.js")
      .then((swReg) => {
        console.log("Service Worker is registered", swReg);
        swRegistration = swReg;
      })
      .catch((error) => {
        console.error("Service Worker Error", error);
      });
    navigator.serviceWorker.ready.then(function (registration) {
      console.log("A service worker is active:", registration.active);
    });
    navigator.serviceWorker.ready.then((registration) => {
      return registration.sync.register("sync-data");
    });
  } else {
    console.warn("Push messaging is not supported");
    notificationButton.textContent = "Push Not Supported";
  }
}

function initializeFCM() {
  messaging
    .requestPermission()
    .then(() => {
      console.log("Notification permission granted.");
      return messaging.getToken();
    })
    .then((token) => {
      console.log(token);
      $.ajax({
        url: "https://masdi.jogjatanpakamu.com/api.php/token",
        type: "POST",
        data: JSON.stringify({ token: token }),
        success: function (data) {
          console.log(data);
        },
      });
    })
    .catch((err) => {
      console.log("Unable to get permission to notify.", err);
    });
}

function installApp() {
  // Show the prompt
  deferredPrompt.prompt();
  // Wait for the user to respond to the prompt
  deferredPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome === "accepted") {
      console.log("PWA setup accepted");
      installButton.hidden = true;
    } else {
      console.log("PWA setup rejected");
    }
    installButton.disabled = false;
    deferredPrompt = null;
  });
}
