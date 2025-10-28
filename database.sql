
CREATE DATABASE IF NOT EXISTS arvina_clothing;
USE arvina_clothing;

CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    subcategory VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    discount_price DECIMAL(10, 2),
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    available_colors TEXT,
    
    available_sizes TEXT,
   
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_subcategory (subcategory)
);

CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_status ENUM(
        'pending',
        'processing',
        'shipped',
        'delivered',
        'cancelled'
    ) DEFAULT 'pending',
    payment_method VARCHAR(50),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (customer_email),
    INDEX idx_status (order_status),
    INDEX idx_date (order_date)
);

CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    selected_color VARCHAR(50),
    selected_size VARCHAR(20),
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
);
INSERT INTO products (
        product_name,
        category,
        subcategory,
        description,
        price,
        discount_price,
        image_url,
        stock_quantity,
        available_colors,
        available_sizes
    )
VALUES (
        'DAEGU COTTON COLLAR T-SHIRT',
        'Women',
        'Dresses',
        'A stylish cotton t-shirt with a buttoned collar for everyday comfort.',
        11794.92,
        8459.97,
        'assest/women/dresses/dress1.webp',
        50,
        '["Red", "Blue", "White", "Black"]',
        '["S", "M", "L", "XL"]'
    ),
    (
        'SEOUL FLORAL SUMMER DRESS',
        'Women',
        'Dresses',
        'Lightweight floral dress perfect for sunny days and vacations.',
        9499.50,
        7499.50,
        'assest/women/dresses/dress2.webp',
        40,
        '["Floral Pink", "Floral Blue", "Floral White"]',
        '["S", "M", "L", "XL"]'
    ),
    (
        'BUSAN LINEN WRAP DRESS',
        'Women',
        'Dresses',
        'A breezy linen wrap dress that blends comfort with elegance.',
        10999.00,
        8499.00,
        'assest/women/dresses/dress3.jpg',
        35,
        '["Beige", "White", "Light Blue"]',
        '["S", "M", "L", "XL", "XXL"]'
    ),
    (
        'JEJU PRINTED MAXI',
        'Women',
        'Dresses',
        'Printed maxi dress inspired by the coastal beauty of Jeju Island.',
        13250.00,
        9500.00,
        'assest/women/dresses/dress4.avif',
        30,
        '["Navy Blue", "Coral", "Turquoise"]',
        '["S", "M", "L", "XL"]'
    ),
    (
        'INCHEON CHECKED MIDI',
        'Women',
        'Dresses',
        'Midi dress with a checked pattern — classic and professional.',
        7950.00,
        5951.00,
        'assest/women/dresses/dress6.jpg',
        45,
        '["Black & White", "Navy & White", "Red & Black"]',
        '["S", "M", "L", "XL"]'
    ),
    (
        'TeaBek Sweat Shirt',
        'Men',
        'Shirts',
        'Comfortable sweat shirt for casual wear',
        5450.00,
        4900.00,
        'images/shirt five front.jpeg',
        60,
        '["Grey", "Black", "Navy"]',
        '["M", "L", "XL", "XXL"]'
    ),
    (
        'Lined Kinin Shirt',
        'Men',
        'Shirts',
        'Classic lined shirt for formal occasions',
        4500.00,
        4050.00,
        'images/shirt one front.jpeg',
        55,
        '["White", "Light Blue", "Pink"]',
        '["S", "M", "L", "XL"]'
    ),
    (
        'Jakipak Shirt',
        'Men',
        'Shirts',
        'Premium quality shirt with modern design',
        6700.00,
        6030.00,
        'images/shirt four front.jpeg',
        40,
        '["Black", "White", "Charcoal"]',
        '["M", "L", "XL"]'
    ),
    (
        'Pincy Skirt',
        'Women',
        'Bottoms',
        'Elegant skirt for formal and casual wear',
        9700.00,
        8730.00,
        'images/women 13 front.jpg',
        25,
        '["Black", "Navy", "Burgundy"]',
        '["S", "M", "L", "XL"]'
    );

CREATE TABLE IF NOT EXISTS admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO admin_users (username, password, email)
VALUES (
        'admin',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'admin@arvina.com'
    ) ON DUPLICATE KEY UPDATE username=username;

CREATE TABLE IF NOT EXISTS customer_users (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username),
    INDEX idx_email (email)
);

INSERT INTO customer_users (username, password, email, full_name, phone)
VALUES (
        'user1',
        'user123',
        'user1@demo.com',
        'Demo User',
        '+94777123456'
    ) ON DUPLICATE KEY UPDATE username=username;


CREATE TABLE IF NOT EXISTS contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_date (created_at)
);