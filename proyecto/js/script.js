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
  //añadimos funcionalidad a los elementos del Cart
  document.addEventListener("DOMContentLoaded", loadItem);
  function loadItem() {
    loadContent();
  }
  function loadContent() {
    //vector de elementos <i class='fa fa-trash'/> iconos papelera para remover cada item
    let btnRemove = document.querySelectorAll(".cart-remove");
    //console.log(btnRemove);
    //recorremos el vector
    btnRemove.forEach((btn) => {
      btn.addEventListener("click", removeItem);
    });
    // let qtyElements = document.querySelectorAll(".cart-quantity");
    // qtyElements.forEach((input) => {
    //   input.addEventListener("change", changeQty);
    // });

    // //tarjetas
    // let cartBtns = document.querySelectorAll(".add-cart");
    // qtyElements.forEach((btn) => {
    //   btn.addEventListener("click", addCart);
    // });
    updateTotal();
  }

  let itemList = [];

  function removeItem() {
    if (confirm("Are you sure to remove item")) {
      let title = this.parentElement.querySelector(".cart-item-title");
      itemList = itemList.filter((el) => el.title != title);
      this.parentElement.remove();
      loadContent();
    }
  }
  function updateTotal() {
    console.log("total Update");
  }
})();
