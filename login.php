<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />



  <link rel="apple-touch-icon" href="/icons/android-launchericon-72-72.png">
  <link rel="icon" href="/icons//android-launchericon-72-72.png">
  <link rel="manifest" href="/manifest.json">


  <title>HOME</title>

  <!-- boostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <link rel="stylesheet" href="./css/login.css">
  <!-- firebase -->
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>


  <script src="./js/cookieHelper.js"></script>

  <script>
    if (CookieHelper.isLogin()) {
      // Jika sudah login, redirect ke halaman login
      window.location.href = "index.php";
    }
  </script>
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
  <main class="form-signin w-100 m-auto">
    <form id="form-login">
      <h1 class="h3 mb-3 fw-normal">MASUK</h1>

      <div class="form-floating">
        <input type="email" class="form-control" name="email" id="email" />
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="password" />
        <label for="floatingPassword">Password</label>
      </div>

      <p>belum punya akun ? <a href="/daftar.html">daftar</a></p>
      <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
      <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script src="./js/main.js"></script>
</body>

</html>