<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />



  <link rel="apple-touch-icon" href="/icons/android-launchericon-72-72.png">
  <link rel="icon" href="/icons//android-launchericon-72-72.png">
  <link rel="manifest" href="/manifest.json">


  <title>HOME</title>

  <!-- boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />


  <!-- firebase -->
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>

  <script src="./js/cookieHelper.js"></script>



<body>
  <div id="response"></div>

  <div class="container py-3">

    <div id="statusKoneksi"></div>
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32" class="me-2" viewBox="0 0 118 94" role="img">
            <title>MASDI BENGKEL</title>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z" fill="currentColor"></path>
          </svg>
          <span class="fs-4">MASDI BENGKEL</span>
        </a>

        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto">
          <div class="d-flex me-3">
            <!-- <a class="btn btn-primary me-2" href="./login.php">Masuk</a> -->
            <a class="btn btn-success" href="#">KATALOG</a>
          </div>
        </nav>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">
          KATALOG BENGKEL
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
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">keranjang</span>
          </h4>
          <ul class="list-group mb-3" id="keranjangContainer"></ul>

          <div class="alert alert-warning" role="alert" id="pesanOffline">
            YAH SAAT INI KAMU OFFLINE </div>
        </div>
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Detail Pemesan</h4>
          <form id="formPemesanan" class="needs-validation">
            <div class="row g-3">
              <div class="col-12">
                <label for="nama_pemesan" class="form-label">Nama Pemesan
                </label>
                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" placeholder="" value="" required="" />
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-12">
                <label for="phone" class="form-label">No Hp </label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="" value="" required="" />
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>

              <div class="col-12">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea type="text" class="form-control" id="alamat" name="alamat" required=""></textarea>
              </div>
              <input type="hidden" name="user_id" id="user_id" />
              <input type="hidden" name="barang_id" id="barang_id" />
              <input type="hidden" name="total_bayar" id="total_bayar" />
            </div>

            <hr class="my-4" />

            <button id="enableNotifications" class="w-100 btn btn-primary btn-lg" type="submit">
              Selesaikan Pemesanan
            </button>


          </form>
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./js/main.js"></script>
</body>

</html>