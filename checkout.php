
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Coffee Shop Checkout</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <section class="contact">

        <h2>Complete Your Order ☕</h2>

        <div class="contact-container">

            <form id="checkoutForm"
                  action="place_order.php"
                  method="POST">

                <div class="form-group">

                    <label>Your Name</label>

                    <input
                        type="text"
                        name="customer_name"
                        placeholder="Enter your name"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Your Email</label>

                    <input
                        type="email"
                        name="customer_email"
                        placeholder="Enter your email"
                        required
                    >

                </div>

                <div class="form-group">

                    <label>Phone Number</label>

                    <input
                        type="tel"
                        name="customer_phone"
                        placeholder="Enter your phone number"
                        required
                    >

                </div>

                <input
                    type="hidden"
                    name="cart_data"
                    id="cartData"
                >

                <button type="submit" class="contact-btn">
                    Place Order
                </button>

            </form>

        </div>

    </section>

    <script>

        const savedCart =
            sessionStorage.getItem("coffeeCart");

        if (savedCart) {

            document.getElementById("cartData").value =
                savedCart;

        } else {

            alert("Your cart is empty!");

            window.location.href = "index.php#menu";

        }

    </script>

</body>
</html>
