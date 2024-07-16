const cart = JSON.parse(localStorage.getItem("cart")) || [];
const user = CookieHelper.getCookie("user_id");
const total = cart.reduce((sum, product) => sum + product.harga, 0);
const token = localStorage.getItem("pwa-Notif");

console.log(token);
$("#barang_id").val(cart[0].id_barang);
$("#user_id").val(user);
$("#total").val(total);

$("#form-checkout").on("submit", function (event) {
  event.preventDefault();
  const data = new FormData(this);

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
    url: `./api/fcm.php?token=${token}`,

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
