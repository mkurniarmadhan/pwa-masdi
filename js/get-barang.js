let keranjang = [];

function renderBarang(data) {
  var container = $("#barangContainer");
  $.each(data, function (index, barang) {
    var card = `
          <div class="col-md-4 mb-4">
            <div class="card mb-4 rounded-3 shadow-sm">
              <img src="../uploads/${barang.foto}" class="card-img-top" width="100%" height="225" alt="...">
              
                <div class="card-body">
                    <h2 class="card-title pricing-card-title">RP ${barang.harga}<small class="text-body-secondary fw-light">/pcs</small></h2>
                    <ul class="list-unstyled mt-3 mb-4">
<button onclick="addToCart('${barang.id}','${barang.nama_barang}', ${barang.harga})" class="w-100 btn btn-lg btn-outline-primary addCart" >PESAN</button>
                    </ul>
                
                </div>
            </div>
            </div>
        `;
    container.append(card);
  });
}

function addToCart(id_barang, nama_barang, harga) {
  const product = { id_barang, nama_barang, harga };
  keranjang.push(product);
  localStorage.setItem("cart", JSON.stringify(keranjang));

  if (CookieHelper.isLogin) {
    window.location.href = "checkout.html";
  } else {
    window.location.href = "login.php";
  }
}
