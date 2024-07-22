<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />



  <link rel="apple-touch-icon" href="/icons/android-launchericon-72-72.png">
  <link rel="icon" href="/icons//android-launchericon-72-72.png">
  <link rel="manifest" href="/icons/manifest.json">


  <title>HOME</title>

  <!-- boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />


  <!-- firebase -->
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>

  <script src="./js/cookieHelper.js"></script>

</head>

<body>
  <div class="container py-3">
    <div id="statusKoneksi"><span class="badge rounded-pill text-bg-danger">KAMU SEDANG OFFLINE</span></div>
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <img src="/assets/icons/android/android-launchericon-512-512.png" alt="" width="40px" />
          <span class="fs-4">MASDI BENGKEL</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <div class="d-flex me-3">
            <a id="btnMasuk" class="btn btn-primary me-2" href="/login.php">Masuk</a>
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
      <div id="barangContainer" class="row row-cols-1 row-cols-md-3 mb-3 text-center">

      </div>
    </main>


    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <img class="mb-2" src="/assets/icons/android/android-launchericon-512-512.png" alt="" width="24" height="19" />
          <small class="d-block mb-3 text-body-secondary">&masdi</small>
        </div>
      </div>
    </footer>
  </div>

  <!-- boostrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <script src="./js/main.js"></script>

  <script src="./js/pwa.js"></script>

  <!--  -->

</body>

</html>