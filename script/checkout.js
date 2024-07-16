const cart = JSON.parse(localStorage.getItem("cart")) || [];
const user = CookieHelper.getCookie("user_id");
const total = cart.reduce((sum, product) => sum + product.harga, 0);

$("#barang_id").val(cart[0].id_barang);
$("#user_id").val(user);
$("#total").val(total);

$("#form-checkout").on("submit", function (event) {
  event.preventDefault();
  const data = new FormData(this);
  const token = localStorage.getItem("pwa-Notif");
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
  $.ajax({
    type: "POST",
    url: "https://fcm.googleapis.com/fcm/send",
    headers: {
      Authorization:
        "key=" +
        "AAAAiyFEpYA:APA91bGf75IoZA9zfmixAziXF6tKl2jfspN3l_d6HZ4GMGSGR0Wb9tm09dUuxTiRJqV2J5hM-VnaUBCnBp3fblSHrdlxic_03XQESrrJlDAoRkKJ9DuvGnA9UYc29Y7n4ujtvwOVPHCO",
    },
    contentType: "application/json",
    dataType: "json",
    data: JSON.stringify({
      to: token,
      notification: {
        title: "Pesanan diterima",
        body: "Pesanan Kamu berhasil di buat",
      },
    }),
    success: function (response) {
      if (response.success) {
        localStorage.setItem("cart", JSON.stringify([]));
        window.location.href = "../riwayat.html";
      }

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
