
<?php
include 'db.php';

$sql = "SELECT * FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yousuf's Coffee House</title>
    <link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700;800&display=swap" rel="stylesheet">


</head>
<body>

    <!-- Navbar -->
    <header>
        <nav class="navbar">
            <h2 class="logo">☕ Yousuf's Coffee</h2>

            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="signup.html">Sign Up</a></li>

            </ul>
        </nav>
    </header>

    <!-- Home Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Fresh Coffee, Fresh Mood!</h1>

            <p>
                Enjoy the taste of freshly brewed coffee.
                Start your day with happiness.
            </p>

            <a href="#menu" class="btn">Order Now</a>
        </div>
    </section>

    
<!-- ABOUT SECTION -->

<section class="about" id="about">

    <div class="about-container">

        <div class="about-image">
            <img
                src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=900"
                alt="Fresh coffee being prepared">
        </div>

        <div class="about-content">

            <span class="about-label">OUR STORY</span>

            <h2>More Than Just A Cup Of Coffee</h2>

            <p>
                Welcome to Yousuf's Coffee House, where every
                cup tells a story of passion, quality and love.
            </p>

            <p>
                We believe great coffee brings people together.
                That's why we focus on fresh ingredients,
                wonderful flavours and a warm atmosphere.
            </p>

            <div class="about-features">
                <div>
                    <h3>100%</h3>
                    <p>Fresh Coffee</p>
                </div>

                <div>
                    <h3>Premium</h3>
                    <p>Quality Beans</p>
                </div>
            </div>

            <a href="#menu" class="btn">Explore Our Menu</a>

        </div>

    </div>

</section>


    


<!-- MENU SECTION -->
<section class="menu" id="menu">

    <h2>Our Special Coffee</h2>

    <p class="menu-subtitle">
        Discover the perfect coffee for every mood.
    </p>

    <div class="coffee-container">

        <?php while($row = $result->fetch_assoc()) { ?>

            <div class="coffee-card">

                <img
                    src="<?php echo htmlspecialchars($row['image']); ?>"
                    alt="<?php echo htmlspecialchars($row['name']); ?>"
                >

                <h3>
                    <?php echo htmlspecialchars($row['name']); ?>
                </h3>

                <p>
                    <?php echo htmlspecialchars($row['description']); ?>
                </p>

                <p>
                    Rs. <?php echo htmlspecialchars($row['price']); ?>
                </p>

                <button onclick="addToCart(
                    '<?php echo htmlspecialchars(addslashes($row['name'])); ?>',
                    <?php echo (float)$row['price']; ?>
                )">
                    Add to Cart
                </button>

            </div>

        <?php } ?>

    </div>

    <h2 class="cart-heading">Your Shopping Cart</h2>

    <div id="cart">
        <p>Your cart is empty.</p>
    </div>

    <h3 id="total">Total: Rs. 0</h3>

    <div class="cart-actions">
        <button onclick="clearCart()">Clear Cart</button>
        <button onclick="checkout()">Checkout</button>
    </div>

</section>


    
<!-- CONTACT SECTION -->

<section class="contact" id="contact">

    <h2>Get In Touch</h2>

    <p class="contact-description">
        Have a question? We'd love to hear from you!
    </p>

    <div class="contact-container">

        <form id="contactForm">

            <div class="form-group">
                <label>Your Name</label>
                <input type="text" id="customerName"
                    placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label>Your Email</label>
                <input type="email" id="customerEmail"
                    placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" id="customerPhone"
                    placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label>Your Message</label>
                <textarea id="customerMessage"
                    placeholder="Write your message..."
                    rows="5" required></textarea>
            </div>

            <button type="submit" class="contact-btn">
                Send Message
            </button>

        </form>

    </div>

    <div class="contact-info">
        <p>Email: yousuf'scoffee@gmail.com</p>
        <p>Phone: +92 345 2252752</p>
        <p>Location: Karachi, Pakistan</p>
    </div>

</section>


   
<!-- PROFESSIONAL FOOTER -->

<footer class="main-footer">

    <div class="footer-container">

        <div class="footer-about">
            <h2>☕ Yousuf's Coffee</h2>
            <p>
                Brewing happiness, one cup at a time.
                Experience the taste of quality coffee.
            </p>
        </div>

        <div class="footer-links">
            <h3>Quick Links</h3>
            <a href="#home">Home</a>
            <a href="#about">About Us</a>
            <a href="#menu">Our Menu</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="footer-contact">
            <h3>Contact Information</h3>
            <p>Karachi, Pakistan</p>
            <p>yousuf'scoffee@gmail.com</p>
            <p>+92 300 0000000</p>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© 2026 Yousuf's Coffee House. All Rights Reserved.</p>
    </div>

</footer>

<script src="script.js"></script>
</body>
</html>

