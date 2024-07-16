<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />

  <link rel="manifest" href="/manifest.json">

  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="application-name" content="Sparepart" />
  <meta name="apple-mobile-web-app-title" content="Sparepart" />
  <meta name="theme-color" content="#424242" />
  <meta name="msapplication-navbutton-color" content="#424242" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="msapplication-starturl" content="/" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <link rel="apple-touch-icon" href="/assets/icons/ios/72.png">
  <link rel="icon" href="/assets/icons/android/android-launchericon-72-72.png">
  <title>Beranda</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->

  <!-- firebase unutk notifikasi -->
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>


</head>

<body>
  <div class="container py-3">
    <div id="status"></div>
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <img src="/assets/icons/android/android-launchericon-512-512.png" alt="" width="40px" />
          <span class="fs-4">MASDI BENGKEL</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <div class="d-flex me-3">
            <a id="btnMasuk" class="btn btn-primary me-2" href="./login.php">Masuk</a>
            <a id="btnRiwayat" class="btn btn-success" href="/riwayat.html">Riwayat Saya</a>
            <button id="btnKeluar" class="btn btn-danger ms-2">Keluar</button>
          </div>
        </nav>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">
          KATALOG <span id="textStatus"></span>
        </h1>
        <p class="fs-5 text-body-secondary">
          Selamat datang di katalog bengekel masdi, disini kamu bisa memesan
          barang dari katalog bengkel masdi.
          <br />Selamat Menjelajah
        </p>
      </div>
    </header>

    <main>
      <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" id="barangContainer"></div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <img class="mb-2" src="/assets/icons/android/android-launchericon-512-512.png" alt="" width="24" height="19" />
          <small class="d-block mb-3 text-body-secondary">&copy; 2017–2024</small>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script src="./script/cookieHelper.js"></script>
  <script src="./pwa.js"></script>
  <script src="./script/get-barang.js"></script>

  <script>
    window.addEventListener('load', () => {

      const btnMasuk = $("#btnMasuk")
      const btnRiwayat = $("#btnRiwayat")
      const btnKeluar = $("#btnKeluar")
      if (!CookieHelper.isLogin()) {
        btnRiwayat.hide()
        btnKeluar.hide()
      } else {

        btnMasuk.hide()
      }
      btnKeluar.click(() => {
        CookieHelper.removeCookie('logIn')
        CookieHelper.removeCookie('isAdmin')
        window.location.href = './login.php'
      })


    })
  </script>

</body>

</html>