(function () {
  "use strict";

  console.log("Starting Javascript Aplication");
  //Add to Cart///////////////////////////////////////////////
  //Manipulacion del DOM
  const btnCart = document.querySelector(".btn-cart");
  const cart = document.querySelector(".cart");
  const btnClose = document.querySelector("#cart-close");

  //Eventos
  btnCart.addEventListener("click", () => {
    cart.classList.add("cart-active");
  });
  btnClose.addEventListener("click", () => {
    cart.classList.remove("cart-active");
  });
  //cuando el dom esta totalmente cargado
  document.addEventListener("DOMContentLoaded", loadItem);
  function loadItem() {}
})();
