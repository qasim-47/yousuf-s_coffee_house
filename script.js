
let cart = [];

function addToCart(name, price) {

    let existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            name: name,
            price: price,
            quantity: 1
        });
    }

    displayCart();
}

function displayCart() {

    let cartDiv = document.getElementById("cart");
    let totalDiv = document.getElementById("total");

    if (!cartDiv || !totalDiv) return;

    cartDiv.innerHTML = "";

    let total = 0;

    if (cart.length === 0) {
        cartDiv.innerHTML = "<p>Your cart is empty.</p>";
        totalDiv.innerText = "Total: Rs. 0";
        return;
    }

    cart.forEach((item, index) => {

        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        cartDiv.innerHTML += `
            <div class="cart-item">
                <h3>${item.name}</h3>

                <p>Price: Rs. ${item.price}</p>

                <p>Quantity: ${item.quantity}</p>

                <p>Subtotal: Rs. ${itemTotal}</p>

                <button onclick="removeItem(${index})">
                    Remove
                </button>
            </div>
        `;

    });

    totalDiv.innerText = "Total: Rs. " + total;
}

function removeItem(index) {

    cart.splice(index, 1);

    displayCart();
}

function clearCart() {

    cart = [];

    displayCart();
}



function checkout() {

    console.log("Checkout button clicked!");

    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    sessionStorage.setItem(
        "coffeeCart",
        JSON.stringify(cart)
    );

    window.location.href = "checkout.php";
}
