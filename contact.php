<?php


session_start();

$success_message = '';
$error_message = '';
$form_data = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'php/db_connect.php';

    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $subject = sanitizeInput($_POST['subject']);
    $message = sanitizeInput($_POST['message']);

    $form_data = $_POST;


    $errors = array();

    if (strlen($name) < 3) {
        $errors[] = "Name must be at least 3 characters long";
    }

    if (!validateEmail($email)) {
        $errors[] = "Please enter a valid email address";
    }

    if (!empty($phone) && !validatePhone($phone)) {
        $errors[] = "Please enter a valid phone number";
    }

    if (strlen($subject) < 5) {
        $errors[] = "Subject must be at least 5 characters long";
    }

    if (strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters long";
    }

    if (empty($errors)) {
        $conn = getDBConnection();
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

        if ($stmt->execute()) {
            $success_message = "Thank you for contacting us! We will get back to you soon.";
            $form_data = array();
        } else {
            $error_message = "Error sending message. Please try again.";
        }

        $stmt->close();
        closeDBConnection($conn);
    } else {
        $error_message = implode("<br>", $errors);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="./css/contact.css">
    <script src="./java-script/cart.js"></script>
    <title>Contact Us - Arvina</title>
</head>

<body>
    <header>
        <nav>
            <div class="h2">A R V I N A</div>
            <ul>
                <li class="li"><a href="home.php" class="aNav">HOME</a></li>
                <li class="li"><a href="" class="aNav">OFFERS</a></li>
                <li class="li"><a href="" class="aNav">FAQ</a></li>
                <li class="li"><a href="./about.php" class="aNav">ABOUT US</a></li>
                <li class="li"><a href="contact.php" class="aNav active">CONTACT</a></li>
                <?php if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in']): ?>
                    <li class="li cart-link">
                        <a href="cart.php" class="aNav">
                            <i class="fa-solid fa-shopping-cart"></i> CART
                            <span id="cart-count" style="display:none; background-color: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; margin-left: 5px;">0</span>
                        </a>
                    </li>
                    <li class="li"><a href="logout.php" class="aNav"><i class="fa-solid fa-sign-out-alt"></i> LOGOUT</a></li>
                <?php else: ?>
                    <button onclick="window.location.href='login.php'">LOGIN</button>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div style="padding: 40px;"></div>
    <div class="contact-container">
        <h1 class="contact-title">Contact Us</h1>
        <p class="contact-subtitle">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

        <div class="contact-content">
            <div class="contact-info-section">
                <h2>Get in Touch</h2>

                <div class="info-box">
                    <div class="info-icon">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </div>
                    <div class="info-details">
                        <h3>Address</h3>
                        <p>67/2, Main Street<br>Colombo, Sri Lanka</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="info-details">
                        <h3>Phone</h3>
                        <p>+94 777 678 678<br>Monday - Friday, 9AM - 9PM</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="info-details">
                        <h3>Email</h3>
                        <p>oldmoneyclothing@gmail.com<br>We reply within 24 hours</p>
                    </div>
                </div>

                <div class="social-media">
                    <h3>Follow Us</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="contact-form-section">
                <h2>Send Us a Message</h2>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i> <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-error">
                        <i class="fa-solid fa-exclamation-circle"></i> <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" id="contactForm">
                    <div class="form-group">
                        <label for="name">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" required
                            value="<?php echo isset($form_data['name']) ? htmlspecialchars($form_data['name']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required
                            value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="+94 XXX XXX XXX"
                            value="<?php echo isset($form_data['phone']) ? htmlspecialchars($form_data['phone']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <input type="text" id="subject" name="subject" required
                            value="<?php echo isset($form_data['subject']) ? htmlspecialchars($form_data['subject']) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea id="message" name="message" rows="5" required><?php echo isset($form_data['message']) ? htmlspecialchars($form_data['message']) : ''; ?></textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>

    <footer class="foot">
        <div class="full-wrapper">
            <div class="about-wrapper">
                <div class="about">
                    <h4>More About Company</h4>
                </div>
                <div class="about-content">
                    <p>
                        Embrace timeless elegance with our Old Money Clothing collection—where sophistication meets
                        heritage. We blend classic fashion with modern craftsmanship to bring you premium-quality
                        apparel that exudes quiet luxury.
                    </p>
                </div>
            </div>
            <div class="social-wrapper">
                <h4>Contact Information</h4>
                <ul class="contact-list">
                    <li><i class="fa-solid fa-map-location"></i>67/2, Main street,Colombo</li>
                    <li><i class="fa-solid fa-id-badge"></i>+94777678678</li>
                    <li><i class="fa-solid fa-square-envelope"></i>oldmoneyclothing@gmail.com</li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>