const CookieHelper = {
  setCookie: function (name, value, days) {
    let expires = "";
    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = `${name}=${value || ""}${expires}; path=/; SameSite=pwa`;
  },

  getCookie: function (name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == " ") c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  },

  removeCookie: function (name) {
    document.cookie = name + "=; Max-Age=-99999999;";
  },

  checkCookie: function (name) {
    const cookie = this.getCookie(name);
    return cookie !== null;
  },

  isLogin: function () {
    return this.checkCookie("logIn");
  },

  isAdmin: function () {
    const cookie = this.getCookie("isAdmin");
    return cookie;
  },
};
