<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8" />

    <!-- <link rel="manifest" href="/manifest.json"> -->

    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="application-name" content="Sparepart" />
    <meta name="apple-mobile-web-app-title" content="Sparepart" />
    <meta name="theme-color" content="#424242" />
    <meta name="msapplication-navbutton-color" content="#424242" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="msapplication-starturl" content="/" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- 
    <link rel="apple-touch-icon" href="/assets/icons/ios/72.png">
    <link rel="icon" href="/assets/icons/android/android-launchericon-72-72.png"> -->
    <title>Beranda</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="./js/cookieHelper.js"></script>
    <script>
        if (!CookieHelper.isLogin()) {
            // Jika belum login, redirect ke halaman login
            window.location.href = 'login.php';
        }
    </script>
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

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Data Barang</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Tambah Barang</button>
                </li>

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                    <div class="row row-cols-1 row-cols-md-3 mb-3 text-center" id="barangContainer"></div>

                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                    <form id="form-tambah-barang" class="needs-validation" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nama_barang" class="form-label">Nama Barang
                                </label>
                                <input type="text" class="form-control" name="nama_barang" id="nama_barang" />
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="harga_barang" class="form-label">harga Barang</label>
                                <input type="number" class="form-control" id="harga_barang" name="harga_barang" />
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="formFileSm" class="form-label">Foto Barang</label>
                                <input class="form-control form-control-sm" id="foto" type="file" name="foto" accept="image/*" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary btn-lg" type="submit">
                                Tambah Barang
                            </button>
                        </div>
                    </form>
                </div>

            </div>
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

    <script src="./js/main.js"></script>


</body>

</html>