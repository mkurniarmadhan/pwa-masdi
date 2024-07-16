$("#form-login").on("submit", function (event) {
  event.preventDefault();
  const email = $("#email").val();
  const password = $("#password").val();

  $.ajax({
    url: "./api/api-user.php",
    type: "POST",
    dataType: "json",
    data: {
      type: "login",
      email: email,
      password: password,
    },
    success: function (data) {
      if (data.status === "success") {
        CookieHelper.setCookie("logIn", "true", 7);
        CookieHelper.setCookie("user_id", data.user_id, 7);

        if (data.role === "admin") {
          CookieHelper.setCookie("isAdmin", "true", 7);
          window.location.href = "/admin.php";
        } else {
          CookieHelper.setCookie("isAdmin", "false", 7);
          window.location.href = "/index.php";
        }
      } else {
        alert(data.message);
      }
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
});

$("#form-daftar").on("submit", function (event) {
  event.preventDefault();
  const nama = $("#nama").val();
  const alamat = $("#alamat").val();
  const email = $("#email").val();
  const password = $("#password").val();
  $.ajax({
    url: "./api/api-user.php",
    type: "POST",
    dataType: "json",
    data: {
      type: "daftar",
      nama: nama,
      alamat: alamat,
      email: email,
      password: password,
    },
    success: function (response) {
      window.location.href = "../login.php";
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
});
