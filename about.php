<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./about.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="./css/nav.css">
  <link rel="stylesheet" href="./css/footer.css">
  <link rel="stylesheet" href="./css/common.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="./css/cart.css">
  <script src="./java-script/cart.js"></script>
  <script src="./java-script/cart-page.js"></script>
  <title>About us</title>

</head>

<body>

  <header id="navi">
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.php" class="aNav active">HOME</a></li>
                <li class="li"><a href="#" class="aNav">OFFERS</a></li>
                <li class="li"><a href="#" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.php" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="contact.php" class="aNav">CONTACT</a></li>

                <!-- 🛒 CART LINK -->
                <li class="li cart-link">
                    <a href="cart.php" class="aNav">
                        <i class="fa-solid fa-shopping-cart"></i> CART
                        <span id="cart-count" style="<?php echo $cartCount > 0 ? 'display:inline-block;' : 'display:none;'; ?> background-color:red; color:white; border-radius:50%; padding:2px 6px; font-size:12px; margin-left:5px;">
                            <?php echo $cartCount; ?>
                        </span>
                    </a>
                </li>

                <!-- 👤 USER INFO -->
                <li class="li user-welcome">
                    <span style="color:#3498db;"><i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($customerName); ?></span>
                </li>

                <button onclick="window.location.href='logout.php'">
                    <i class="fa-solid fa-sign-out-alt"></i> LOGOUT
                </button>
            </ul>
        </nav>
    </header>
    <div style="padding: 40px;"></div>
  <div class="top">
    About Us
  </div>

  <div class="aboutcont">
    Welcome to Arvina – your ultimate destination for
    fashion-forward, affordable, and high-quality clothing.
    Born out of a love for style and a passion for self-expression,
    we bring you the
    latest trends in casual, formal, and ethnic wear for all seasons.

    At TrendNest, we believe fashion is for everyone. That’s why we handpick each item with care, ensuring it meets our standards of comfort, quality, and style. Whether you're dressing for a special occasion or everyday confidence, we’ve got you covered.

    Thank you for shopping with us – your support means the world.
  </div>
  <div class="vismisv">
    <div class="mission">
      <h2>Our Mission</h2>
      <p>
        Our mission at Arvina is to empower individuals through fashion by offering
        affordable, stylish, and quality clothing for everyone. We aim to make fashion inclusive,
        expressive, and sustainable.
      </p>
    </div>
    <div class="vision">
      <h2>Our Vision</h2>
      <p>
        At Arvina, our vision is to become a leading global fashion brand known for empowering individuality
        and self-expression. We envision a world where style knows no boundaries – where everyone, regardless of
        background or body type, can find clothing that makes them feel confident, comfortable, and seen.
      </p>
    </div>


  </div>

  <div class="why-us">
    <h2>Why Shop With Us?</h2>
    <ul>
      <li>✔ Handpicked, premium-quality clothing</li>
      <li>✔ Affordable pricing</li>
      <li>✔ Easy returns & customer support</li>
      <li>✔ Trendy and timeless collections</li>
      <li id="lin"></li>
    </ul>
  </div>

  <div class="team-section">
    <h2>Meet Our Team</h2>
    <div class="team-members">
      <div class="team-card">
        <img src="./pics/gimasa.jpeg" alt="Founder Photo">
        <h3>Gimasha </h3>
        <p>Founder & Creative Director</p>
      </div>
      <div class="team-card">
        <img src="./pics/sharfan.jpeg" alt="Designer Photo">
        <h3>Sharfan</h3>
        <p>Lead Fashion Designer</p>
      </div>
      <div class="team-card">
        <img src="./pics/tharusi.jpeg" alt="Marketing Head Photo">
        <h3>Tharushi</h3>
        <p>Head of Marketing</p>
      </div>
    </div>
  </div>

  <div class="brand-story">
    <h2>Our Story</h2>
    <p>
      Arvina began with a passion for style and a vision to make fashion more personal, inclusive, and affordable.
      What started as a small idea among a few friends quickly grew into a brand that connects with people who love
      expressing themselves through what they wear.
    </p>
    <p>
      Every piece we create reflects our belief that fashion should be fun, fearless, and for everyone. From our first
      collection to where we are now, we’ve stayed true to our values offering high-quality clothes that inspire confidence.
    </p>
    <p>
      Today, Arvina is more than just a clothing brand. It’s a community. And we’re just getting started.
    </p>
  </div>

  <div class="faq-section" id="faq">
    <h2>Frequently Asked Questions</h2>

    <div class="faq-item">
      <h3>1. What sizes do you offer?</h3>
      <p>We offer a wide range of sizes from XS to XXL. You can check our size guide on each product page.</p>
    </div>

    <div class="faq-item">
      <h3>2. How can I return a product?</h3>
      <p>Returns are easy! Just contact our support team within 7 days of delivery, and we’ll guide you through it.</p>
    </div>

    <div class="faq-item">
      <h3>3. Do you deliver nationwide?</h3>
      <p>Yes, we deliver to all areas within Sri Lanka. Delivery times may vary based on your location.</p>
    </div>

    <div class="faq-item">
      <h3>4. Are your clothes sustainable?</h3>
      <p>We're committed to sustainability. Many of our products are made with eco-friendly fabrics and ethical processes.</p>
    </div>

    <div class="faq-item">
      <h3>5. Can I track my order?</h3>
      <p>Yes! Once your order is shipped, you’ll receive a tracking link via email or SMS.</p>
    </div>
  </div>

  <div class="social-follow">
    <h2>Follow Us</h2>
    <p>Stay connected and updated with the latest trends, offers, and style tips.</p>
    <div class="social-icons">
      <a href="https://www.facebook.com/Arvina" target="_blank" class="facebook">Facebook</a>
      <a href="https://www.instagram.com/Arvina" target="_blank" class="instagram">Instagram</a>
      <a href="https://www.twitter.com/Arvina" target="_blank" class="twitter">Twitter</a>
      <a href="https://www.tiktok.com/@Arvina" target="_blank" class="tiktok">TikTok</a>
    </div>
  </div>









</body>
<script>
  document.getElementById("lin").innerHTML = "another line";
</script>

</html>