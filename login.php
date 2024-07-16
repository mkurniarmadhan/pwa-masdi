<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
  <meta name="generator" content="Hugo 0.122.0" />
  <title>LOGIN</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- Custom styles for this template -->
  <link href="./login.css" rel="stylesheet" />

  <script src="./script//cookieHelper.js"></script>

  <script>
    if (CookieHelper.isLogin()) {
      // Jika belum login, redirect ke halaman login
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

  <script src="./script/login.js"></script>
</body>

</html>