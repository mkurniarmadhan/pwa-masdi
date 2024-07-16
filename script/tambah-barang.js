$("#form-barang").on("submit", function (event) {
  event.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    url: "./api/api-barang.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      console.log(data);
      // window.location.reload();
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
});
