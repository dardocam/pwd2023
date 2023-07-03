(function () {
  "use strict";

  console.log("Starting Javascript Aplication");
  //Add to Cart///////////////////////////////////////////////
  //Manipulacion del DOM
  let itemList = [];

  const btnCart = document.querySelector(".btn-cart");
  const cart = document.querySelector(".cart");
  const btnClose = document.querySelector("#cart-close");
  const btnBuy = document.querySelector(".btn-buy");

  //Eventos
  btnCart.addEventListener("click", () => {
    cart.classList.add("cart-active");
  });
  btnClose.addEventListener("click", () => {
    cart.classList.remove("cart-active");
  });
  btnBuy.addEventListener("click", () => {
    console.log(itemList);
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
    //recorremos el vector
    btnRemove.forEach((btn) => {
      btn.addEventListener("click", removeItem);
    });
    let qtyElements = document.querySelectorAll(".cart-quantity");
    qtyElements.forEach((input) => {
      input.addEventListener("change", changeQty);
    });

    //tarjetas
    let cartBtns = document.querySelectorAll(".tarjeta-add-cart");
    cartBtns.forEach((btn) => {
      btn.addEventListener("click", addCart);
    });
    updateTotal();
  }

  function removeItem() {
    if (confirm("Are you sure to remove item")) {
      let title =
        this.parentElement.querySelector(".cart-item-title").innerHTML;
      itemList = itemList.filter((el) => el.title !== title);
      this.parentElement.remove();
      loadContent();
    }
  }
  function updateTotal() {
    let carItems = document.querySelectorAll(".cart-box");
    let totalValue = document.querySelector(".total-price");

    let total = 0;
    carItems.forEach((product) => {
      let priceElement = product.querySelector(".cart-price");
      let price = parseFloat(priceElement.innerHTML.replace("$", ""));
      let qty = product.querySelector(".cart-quantity").value;
      total += price * qty;
      product.querySelector(".cart-amt").innerText = "$ " + price * qty;
    });
    totalValue.innerHTML = "$ " + total.toFixed(2);
    updateTotalMenu();
  }
  function updateTotalMenu() {
    const cartCount = document.querySelector(".cart-count");
    let count = itemList.length;
    cartCount.innerHTML = count;
    if (count == 0) {
      cartCount.style.visibility = "hidden";
    } else {
      cartCount.style.visibility = "visible";
    }
  }
  function changeQty() {
    if (isNaN(this.value) || this.value < 1) {
      this.value = 1;
    }
    loadContent();
  }
  function addCart() {
    let item = this.parentElement;
    let title = item.querySelector(".tarjeta-item-title").innerHTML;
    let price = item.querySelector(".tarjeta-item-price").innerHTML;
    let imgSrc = item.querySelector(".tarjeta-imagen").src;
    price = parseFloat(price.slice(1));
    let newItem = { title, price, imgSrc };
    if (itemList.find((el) => el.title === newItem.title)) {
      alert("The item already added in cart");
      return;
    } else {
      itemList.push(newItem);
    }
    let newItemElement = createCartItem(newItem);
    let element = document.createElement("div");
    element.innerHTML = newItemElement;
    let cartContent = document.querySelector(".cart-content");
    cartContent.append(element);
    loadContent();
  }
  function createCartItem(item) {
    return `
            <div class="cart-box">
              <img class="cart-img" src="${item.imgSrc}" alt="" srcset="" />
              <div class="cart-detail-box">
                <div class="cart-item-title">${item.title}</div>
                <div class="cart-price-box">
                  <div class="cart-price">$ ${item.price}</div>
                  <div class="cart-amt">$125</div>
                </div>
                <input type="number" name="" value="1" class="cart-quantity" />
              </div>
              <i class="fa fa-trash cart-remove"></i>
            </div>
    `;
  }
})();
