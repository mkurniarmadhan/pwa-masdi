const cart = JSON.parse(localStorage.getItem("cart")) || [];
const user = CookieHelper.getCookie("user_id");
const total = cart.reduce((sum, product) => sum + product.harga, 0);
const token = localStorage.getItem("pwa-Notif");

console.log(token);
$("#barang_id").val(cart[0].id_barang);
$("#user_id").val(user);
$("#total").val(total);

const { nama_pemesan, phone, alamat } =
  JSON.parse(localStorage.getItem("dataPesanan")) || [];

$("#nama_pemesan").val(nama_pemesan) ?? "";
$("#phone").val(phone) ?? "";
$("#alamat").val(alamat) ?? "";

// function cekKoneksi() {
//   if (navigator.onLine) {
//     let dataPesanan = JSON.parse(localStorage.getItem("dataPesanan"));
//     kirimDataPesanan(dataPesanan);
//   } else {
//     const { nama_pemesan, phone, alamat } = JSON.parse(
//       localStorage.getItem("dataPesanan")
//     );

//     $("#nama_pemesan").val(nama_pemesan);
//     $("#phone").val(phone);
//     $("#alamat").val(alamat);
//     console.log("Currently offline. Login data will be sent when online.");
//   }
// }

// cekKoneksi();

// // Listen for online and offline events
// window.addEventListener("online", cekKoneksi);
// window.addEventListener("offline", cekKoneksi);

$("#form-checkout").on("submit", function (event) {
  event.preventDefault();
  const data = new FormData(this);

  var dataPesanan = {
    barang_id: $("#barang_id").val(),
    user_id: $("#user_id").val(),
    total: $("#total").val(),

    nama_pemesan: $("#nama_pemesan").val(),
    phone: $("#phone").val(),
    alamat: $("#alamat").val(),
  };

  localStorage.setItem("dataPesanan", JSON.stringify(dataPesanan));

  $.ajax({
    url: "./api/api-pesanan.php",
    type: "POST",
    data: data,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data.status === "success") {
        sendNotif(token);
      }
      console.log(data);
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
});

function sendNotif(token) {
  console.log(token);
  $.ajax({
    type: "GET",
    url: `./api/fcm.php?token=f26EjPknHWiZlacA6LBMSl:APA91bEA1j1bf8qUFexJtpVpnrO-0c_si_sb6wkCRYzml2eMPyqsOmJ_u2glLrKcc8SevXWoQxQq8cSAWAW2otytIpLKK8pX1z0YGMxw67Wru2M9pKK5PHZLjNFSy0ofTtjrVFhX87de`,

    success: function (response) {
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.log(xhr.error);
    },
  });
}

function renderCart(cart) {
  const cartContainer = document.getElementById("cart-container");
  cartContainer.innerHTML = "";
  cart.forEach((produk, index) => {
    const cartItem = `
            <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0">${produk.nama_barang}</h6>

                        </div>
                        <span class="text-body-secondary">${produk.harga}</span>
                        <button class="btn btn-danger" onclick="removeFromCart(${index})">x</button>
             
                    </li>
    `;
    cartContainer.innerHTML += cartItem;
  });

  const total = cart.reduce((sum, product) => sum + product.harga, 0);
  const totalItem = `
        <li class="list-group-item d-flex justify-content-between">
                        <span>Total Bayar</span>
                        <strong>${total}</strong>
                    </li>
`;

  cartContainer.innerHTML += totalItem;
}

function removeFromCart(index) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  renderCart(cart);
}
