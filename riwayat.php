<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />

  <link rel="apple-touch-icon" href="/icons/android-launchericon-72-72.png">
  <link rel="icon" href="/icons//android-launchericon-72-72.png">
  <link rel="manifest" href="/manifest.json">


  <title>HOME</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="icon" href="https://getbootstrap.com/docs/5.0/assets/img/favicons/favicon.ico" />
  <link rel="manifest" href="./css/manifest.json" />

  <!-- firebase unutk notifikasi -->
  <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.6.1/firebase-messaging.js"></script>

  <link rel="stylesheet" href="./css/style.css" />
  <!-- Custom styles for this template -->
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
            <a id="btnMasuk" class="btn btn-primary me-2" href="/login.php">Masuk</a>
            <a id="btnRiwayat" class="btn btn-success" href="/riwayat.php">Riwayat Saya</a>
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
      <div class="row g-5">
        <div class="card">
          <div class="table-responsive small">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                  <th scope="col">Nama Pemesan</th>
                  <th scope="col">Nama Barang</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody id="data-riwayat"></tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <img class="mb-2" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="24" height="19" />
          <small class="d-block mb-3 text-body-secondary">&copy; 2017–2024</small>
        </div>
      </div>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- <script src="./js/app.js"></script> -->
  <script src="./js/cookieHelper.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/main.js"></script>
  <script>
    $.ajax({
      url: `./api/api-pesanan.php?user_id=${userId}`,
      type: "GET",
      dataType: "json",
      success: function(data) {
        if (data.length > 0) {
          console.log(data);
          renderRiwayat(data);
        } else {
          $("#product-container").append("<li>Tidak ada data barang.</li>");
        }
      },
      error: function(xhr, status, error) {
        console.error("Error: " + error);
      },
    });

    function renderRiwayat(data) {
      const cartContainer = $("#data-riwayat");
      $.each(data, function(index, pesanan) {
        const cartItem = `
              <tr>
                        <td>${pesanan.nama_pemesan}</td>
                        <td>${pesanan.total}</td>
                        <td>Silahkan tranfer ke Rekening BNI (123456)</td>

                      </tr>
              `;
        cartContainer.append(cartItem);
      });
    }
  </script>
</body>

</html>