const SETTINGS = {
  appName: "pwa",
  remindAfterHours: 24, // Number of hours to wait before showing the prompt again
  serviceWorkerFile: "/service-worker.js", // Service worker file path and name
  serviceWorkerScope: "/", // Scope of the service worker
  diagnostics: false, // Set to true to enable diagnostic logs
};

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

// Helper functions for detecting user's operating system and browser
const userAgent = window.navigator.userAgent.toLowerCase();

const detectOS = () => {
  if (userAgent.includes("android")) return "Android";
  if (/iphone|ipad|ipod/.test(userAgent)) return "iOS";
  if (userAgent.includes("mac")) return "macOS";
  if (userAgent.includes("win")) return "Windows";
  if (userAgent.includes("cros")) return "ChromeOS";
  if (userAgent.includes("linux")) return "Linux";
  return "Unknown";
};

const detectBrowser = () => {
  if (userAgent.includes("chrome") && !userAgent.includes("edg"))
    return "Chrome";
  if (userAgent.includes("safari") && !userAgent.includes("chrome"))
    return "Safari";
  if (userAgent.includes("firefox")) return "Firefox";
  if (userAgent.includes("edg")) return "Edge";
  if (userAgent.includes("opera") || userAgent.includes("opr")) return "Opera";
  return "Unknown";
};

// Register service worker
if ("serviceWorker" in navigator && "PushManager" in window) {
  initializeFCM();
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("./sw.js")
      .then((registration) => {
        console.log(`service woreker registration  ${registration.scope} `);
      })
      .catch((err) => {
        console.log(`service worker filfe ${err}`);
      });

    navigator.serviceWorker.ready.then(function (registration) {
      console.log("A service worker is active:", registration.active);
    });

    navigator.serviceWorker.ready.then((registration) => {
      return registration.sync.register("sync-data");
    });
  });
}

const logMessage = (message, type = "info") => {
  if (SETTINGS.diagnostics) {
    if (type === "error") {
      console.error(message);
    } else {
      console.log(message);
    }
  }
};
const promptId = "installPWAPrompt";
const timeoutKey = `${SETTINGS.appName}-Prompt-Timeout`;
const foreverKey = `${SETTINGS.appName}-Prompt-Dismiss-Forever`;
const installedKey = `${SETTINGS.appName}-App-Installed`;
const notifKey = `${SETTINGS.appName}-Notif`;

let deferredPrompt;
// bikin promt unutk install pwa

const installPwa = () => {
  const now = Date.now();

  const setupTime = localStorage.getItem(timeoutKey);
  const dismissForever = localStorage.getItem(foreverKey);
  const appInstalled = localStorage.getItem(installedKey);

  if (
    dismissForever === "true" ||
    appInstalled === "true" ||
    (setupTime && now - setupTime < 24 * 60 * 60 * 1000)
  ) {
    return;
  }

  const PromtHTML = `

          <div class="modal fade" id="${promptId}" tabindex="-1" aria-labelledby="${promptId}Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">MASDI BENGKEL</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
                  <h5 class="pt-1" id="${promptId}Label">Install Madsi  app</h5>
       <div class="d-flex justify-content-center  w-100">
                        <button type="button" class="btn btn-primary w-100" id="installPWAButton">
                          <i class=" me-1 ms-1"></i>
                          Install
                        </button>
                        <button type="button" class="btn btn-secondary w-100" id="timeoutPWAButton">
                          <i class="ci-clock fs-base me-1 ms-n2"></i>
                          Remind later
                        </button>
                      </div>

                  </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-outline-secondary border-0 mb-1" id="dismissPWAButton">
                        <i class="ci-close fs-lg me-1 ms-n2"></i>
                        Dismiss forever
                      </button>
        </div>
      </div>
    </div>
  </div>
  `;

  document.body.insertAdjacentHTML("beforeend", PromtHTML);

  const promtEle = document.getElementById(promptId);

  const modalPWa = new bootstrap.Modal(promtEle, {
    backdrop: "static",
    keyboard: false,
  });

  modalPWa.show();

  console.log(`modal di tamilkan`);

  document.getElementById("timeoutPWAButton").addEventListener("click", () => {
    modalPWa.hide();
    localStorage.setItem(timeoutKey, Date.now());
  });
  document.getElementById("dismissPWAButton").addEventListener("click", () => {
    modalPWa.hide();
    localStorage.setItem(foreverKey, true);
  });

  promtEle.addEventListener("hidden.bs.modal", () => {
    modalPWa.dispose();
    promtEle.remove();
  });
};

function initializeFCM() {
  messaging
    .requestPermission()
    .then(() => {
      console.log("Notification permission granted.");

      return messaging.getToken();
    })
    .then((token) => {
      $.ajax({
        url: "./api/api-notifikasi.php",
        type: "POST",
        dataType: "json",
        data: {
          type: "token",
          token: token,
        },
        success: function (data) {
          if (data.status === "success") {
            localStorage.setItem(notifKey, token); // Set the installedKey value to true
          }
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });

      // console.log(token);
    })
    .catch((err) => {
      console.log("Unable to get permission to notify.", err);
    });
}

window.addEventListener("appinstalled", () => {
  localStorage.setItem(installedKey, true); // Set the installedKey value to true
  deferredPrompt = null; // Clear the deferredPrompt so it can be garbage collected
  logMessage("PWA was installed"); // Log message
});

const setupPwa = () => {
  const os = detectOS();
  const browser = detectBrowser();
  // Check if the PWA is already installed
  const isInStandaloneMode = () =>
    ("standalone" in navigator && navigator.standalone) ||
    window.matchMedia("(display-mode: standalone)").matches;

  if ((os === "iOS" && browser === "Safari") || browser === "Chrome") {
    // Specific instructions for Safari on iOS
    // setTimeout(() => {
    //   if (!isInStandaloneMode()) {
    //     installPwa();
    //     logMessage("PWA installation prompt has been displayed.");
    //   }
    // }, 3500);
    window.addEventListener("beforeinstallprompt", (e) => {
      // Log message
      logMessage(`'beforeinstallprompt' event was fired.`);
      // Prevent the mini-infobar from appearing on mobile
      e.preventDefault();
      // Stash the event so it can be triggered later
      deferredPrompt = e;
      // Show the installation prompt to the user
      setTimeout(() => {
        installPwa();
      }, 3500);
    });
    // Handle "Install" button click event
    document.body.addEventListener("click", (e) => {
      const target = e.target;
      // Check if the clicked element is an "Install" button
      if (target.id === "installPWAButton") {
        const promptElement = document.getElementById(promptId);
        /* eslint-disable no-undef */
        const promptInstance = bootstrap.Modal.getInstance(promptElement);
        /* eslint-enable no-undef */

        if (promptInstance) {
          promptInstance.hide(); // Hide the prompt
        }

        deferredPrompt.prompt(); // Show the installation prompt
        deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === "accepted") {
            logMessage("User accepted the A2HS prompt. PWA was installed");
            localStorage.setItem(installedKey, true); // Set the installedKey value to true
          } else {
            logMessage("User dismissed the A2HS prompt");
            localStorage.setItem(timeoutKey, Date.now()); // Set the new timeout value
          }
          deferredPrompt = null; // We've used the prompt and can't use it again, throw it away
        });
      }
    });
  } else if (
    os !== "iOS" &&
    (browser === "Chrome" || browser === "Edge" || browser === "Opera")
  ) {
    // Setup for Chrome, Edge, and Opera on non-iOS devices
    if (!isInStandaloneMode()) {
      window.addEventListener("beforeinstallprompt", (e) => {
        // Log message
        logMessage(`'beforeinstallprompt' event was fired.`);
        // Prevent the mini-infobar from appearing on mobile
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt = e;
        // Show the installation prompt to the user
        setTimeout(() => {
          installPwa();
        }, 3500);
      });

      // Handle "Install" button click event
      document.body.addEventListener("click", (e) => {
        const target = e.target;
        // Check if the clicked element is an "Install" button
        if (target.id === "installPWAButton") {
          console.log("xx");
          const promptElement = document.getElementById(promptId);
          /* eslint-disable no-undef */
          const promptInstance = bootstrap.Modal.getInstance(promptElement);
          /* eslint-enable no-undef */

          if (promptInstance) {
            promptInstance.hide(); // Hide the prompt
          }

          deferredPrompt.prompt(); // Show the installation prompt
          deferredPrompt.userChoice.then((choiceResult) => {
            if (choiceResult.outcome === "accepted") {
              logMessage("User accepted the A2HS prompt. PWA was installed");
              localStorage.setItem(installedKey, true); // Set the installedKey value to true
            } else {
              logMessage("User dismissed the A2HS prompt");
              localStorage.setItem(timeoutKey, Date.now()); // Set the new timeout value
            }
            deferredPrompt = null; // We've used the prompt and can't use it again, throw it away
          });
        }
      });
    }
  } else {
    console.log("oke");
  }
};

setupPwa();
