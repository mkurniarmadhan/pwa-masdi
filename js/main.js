// vatiabel
let userId = CookieHelper.getCookie("user_id");

const btnMasuk = $("#btnMasuk");
const btnRiwayat = $("#btnRiwayat");
const btnKeluar = $("#btnKeluar");
const statusKoneksi = $("#statusKoneksi");
const pesanOffline = $("#pesanOffline");

let isAdmin = CookieHelper.isAdmin();

function updateOnlineStatus() {
  if (navigator.onLine) {
    statusKoneksi.hide();
    pesanOffline.hide();
  } else {
    pesanOffline.show();
    statusKoneksi.show();
  }
}

updateOnlineStatus();

window.addEventListener("online", updateOnlineStatus);
window.addEventListener("offline", updateOnlineStatus);

if (!CookieHelper.isLogin()) {
  btnRiwayat.hide();
  btnKeluar.hide();
} else {
  btnMasuk.hide();
}
btnKeluar.click(() => {
  CookieHelper.removeCookie("logIn");
  CookieHelper.removeCookie("isAdmin");
  CookieHelper.removeCookie("user_id");
  CookieHelper.removeCookie("infoPemesan");
  window.location.href = "./login.php";
});

$(document).ready(function () {
  //ketikan tombol lgoin di tekan.
  $("#form-login").on("submit", function (e) {
    e.preventDefault();

    const email = $("#email").val();
    const password = $("#password").val();

    login(email, password);
  });

  //ketikan daftar lgoin di tekan.
  $("#form-daftar").on("submit", function (event) {
    event.preventDefault();
    const nama = $("#nama").val();
    const alamat = $("#alamat").val();
    const email = $("#email").val();
    const password = $("#password").val();
    daftar(nama, alamat, email, password);
  });

  //ketika selesaiak pesanan di tekan
  $("#formPemesanan").on("submit", function (event) {
    event.preventDefault();

    var name = $("#nama_pemesan").val();
    var phone = $("#phone").val();
    var alamat = $("#alamat").val();

    simpanDataPemesan(name, phone, alamat);

    var keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
    var total = keranjang.reduce(
      (total, item) => item.jumlah * item.harga + total,
      0
    );

    $("#barang_id").val(keranjang[0].id);
    $("#user_id").val(userId);
    $("#total_bayar").val(total);
    const dataPesanan = new FormData(this);

    // Replace with actual user ID if available
    simpanDataPesanan(dataPesanan);
  });

  $("#form-tambah-barang").on("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "/api/api-barang.php",
      method: "POST",
      contentType: false,
      processData: false,
      data: formData,
      success: function (data) {
        window.location.reload();
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });
});

function login(email, password) {
  $.ajax({
    url: "/api/api-user.php",
    type: "POST",
    dataType: "json",
    data: {
      type: "login",
      email: email,
      password: password,
    },
    success: function (data) {
      if (data.status === "success") {
        CookieHelper.setCookie("logIn", 1, 7);
        CookieHelper.setCookie("user_id", data.user_id, 7);
        if (data.role === "admin") {
          CookieHelper.setCookie("isAdmin", 1, 7);
          window.location.href = "/admin.php";
        } else {
          CookieHelper.setCookie("isAdmin", 0, 7);
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
}

function daftar(nama, alamat, email, password) {
  $.ajax({
    url: "/api/api-user.php",
    type: "POST",
    dataType: "json",
    data: {
      type: "daftar",
      nama: nama,
      alamat: alamat,
      email: email,
      password: password,
    },
    success: function (data) {
      console.log(`berhasil daftar ${data}`);
      if (response.status) {
        window.location.href = "/login.php";
      }
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

// unutk index.php
ambilDataBarang();
let keranjang = [];

function ambilDataBarang() {
  $.ajax({
    url: "./api/api-barang.php", // Sesuaikan dengan URL API Anda
    type: "GET",
    success: function (data) {
      if (data.length > 0) {
        tampilKanBarang(data);
      } else {
        $("#product-container").append("<li>Tidak ada data barang.</li>");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error: " + error);
    },
  });
}

function tampilKanBarang(barang) {
  $.each(barang, function (index, barang) {
    console.log(barang);
    var card = `    
    <div class="col">
    <div class="card mb-4 rounded-3 shadow-sm"  data-tipe="${
      isAdmin ? "hapus" : "beli"
    }"
     data-id="${barang.id}" 
     data-nama="${barang.nama_barang}"
      data-harga="${barang.harga_barang}" 
      data-foto="${barang.foto}">
        <img src="../uploads/${
          barang.foto
        }" height="195px" class="card-img-top">
        <div class="card-body">

            <h1 class="card-title pricing-card-title">${barang.nama_barang}</h1>
            <h1 class="card-title pricing-card-title">Rp ${barang.harga.toLocaleString()}</h1>
 ${
   isAdmin
     ? `  <button type="button" class="w-100 btn btn-lg btn-outline-primary">Hapus Barang</button>
       `
     : `  <button type="button" class="w-100 btn btn-lg btn-outline-primary">"Beli Serakang"</button>
       `
 }
          
            </div>
    </div>
</div>`;

    $("#barangContainer").append(card);
  });

  $(".card").on("click", function () {
    const tipe = $(this).data("tipe");
    let barang = {
      id: $(this).data("id"),
      nama: $(this).data("nama"),
      harga: $(this).data("harga"),
      foto: $(this).data("foto"),
      jumlah: 1,
    };

    if (tipe === "beli") {
      return tambahKeranjang(barang);
    } else {
      return hapusBarang(barang.id);
    }
  });
}

function hapusBarang(id) {
  $.ajax({
    url: "./api/api-barang.php?id=" + id,
    method: "DELETE",
    success: function (data) {
      window.location.reload();
    },
  });
}

function tambahKeranjang(barang) {
  var keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

  let cek = false;
  keranjang.forEach(function (item) {
    if (item.id === barang.id) {
      item.jumlah += 1;
      cek = true;
    }
  });

  if (!cek) {
    keranjang.push(barang);
  }

  localStorage.setItem("keranjang", JSON.stringify(keranjang));

  window.location.href = "checkout.php";
}

// untuk checkout

tampilKeranjang();

// Load saved order information on page load
var infoPemesan = CookieHelper.getCookie("infoPemesan");
console.log(infoPemesan);

if (infoPemesan) {
  orderInfo = JSON.parse(infoPemesan);
  $("#nama_pemesan").val(orderInfo.nama);
  $("#phone").val(orderInfo.phone);
  $("#alamat").val(orderInfo.alamat);
}

// Function to save order information
function simpanDataPemesan(name, phone, alamat) {
  var dataPemesan = {
    nama: name,
    phone: phone,
    alamat: alamat,
  };
  CookieHelper.setCookie("infoPemesan", JSON.stringify(dataPemesan), 7); // Save for 7 days
}

function tampilKeranjang() {
  let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

  if (!keranjang.length > 0) {
    $("#formPemesanan button").addClass("disabled");
  }
  let total = 0;

  $("#keranjangContainer").empty();
  keranjang.forEach(function (item) {
    let list = `
        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">${item.nama}</h6>
                                <small class="text-body-secondary">${item.harga.toLocaleString()} x ${
      item.jumlah
    }</small>
                            </div>
                            <span class="text-body-secondary">Rp. ${(
                              item.harga * item.jumlah
                            ).toLocaleString()}</span>

                            <button class="btn btn-sm btn-danger hapus" data-id="${
                              item.id
                            }">x</button>
                        </li>
        `;

    $("#keranjangContainer").append(list);
    total += item.harga * item.jumlah;
  });

  $("#keranjangContainer").append(`
           <li class="list-group-item d-flex justify-content-between">
      <span>Total Bayar</span>
      <strong id="total">Rp. ${total.toLocaleString()}</strong>
    </li>
        `);

  $(".hapus").on("click", function () {
    const id = $(this).data("id");
    var keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];

    keranjang = keranjang.filter((i) => i.id !== id);
    localStorage.setItem("keranjang", JSON.stringify(keranjang));
    tampilKeranjang();
  });
}

// Function to save the complete order to local storage
function simpanDataPesanan(dataPesanan) {
  if (navigator.onLine) {
    $.ajax({
      url: "/api/api-pesanan.php",
      type: "POST",
      data: dataPesanan,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        window.location.href = "/riwayat.php";
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  } else {
    pesanOffline.show();
    const pesnanaBaru = {
      id: data.msg,
      user_id: userId,
      nama_pemesan: dataPesanan.get("nama_pemesan"),
      phone: dataPesanan.get("phone"),
      alamat: dataPesanan.get("alamat"),
      total_bayar: dataPesanan.get("total_bayar"),
    };
    localStorage.setItem("data-pesanan", JSON.stringify(pesnanaBaru));
  }
}
