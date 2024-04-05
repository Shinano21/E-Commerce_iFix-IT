document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const cartItems = document.getElementById("cart-items");
  const totalDisplay = document.getElementById("total");
  let totalPrice = 0;

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const price = parseFloat(this.getAttribute("data-price"));
      totalPrice += price;
      updateCart(price);
    });
  });

  function updateCart(price) {
    const li = document.createElement("li");
    li.textContent = `₱${price}`;
    cartItems.appendChild(li);
    totalDisplay.textContent = `Total: ₱${totalPrice}`;
  }

  const checkoutButton = document.getElementById("checkout");
  checkoutButton.addEventListener("click", function () {
    alert(`Total: ₱${totalPrice}. Your order has been placed.`);
    resetCart();
  });

  function resetCart() {
    cartItems.innerHTML = "";
    totalPrice = 0;
    totalDisplay.textContent = `Total: ₱${totalPrice}`;
  }
});
