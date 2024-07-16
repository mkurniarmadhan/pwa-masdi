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
    to: "cdN0utlSZc09z-sZwPGWff:APA91bEyiEcCTwTBWabe-tEgLZwsRNwn3uRYVVlM--VcfrNVGJMKW30Tzzv7ye5aAJVxdXbMOaQV038GjmCKGDvfCGJy7h8Us1DMPhjMeOT4VKUGz8xV7JqN25NKN7G3rRJpdY41Ik1T",
    notification: { title: "Test", body: "Test" },
  }),
  success: function (response) {
    console.log(response);
  },
  error: function (xhr, status, error) {
    console.log(xhr.error);
  },
});
