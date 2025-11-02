-- Drop old database (optional)
DROP DATABASE IF EXISTS arvina_clothing;
CREATE DATABASE arvina_clothing CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE arvina_clothing;

-- ==============================================================
-- 1️⃣ CATEGORY STRUCTURE
-- ==============================================================

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE subcategories (
    subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    subcategory_name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,
    thumbnail VARCHAR(255) NOT NULL,
    link VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    INDEX idx_category_id (category_id)
);

-- Example category data
INSERT INTO categories (category_name) VALUES
('Men'),
('Women');

-- Example subcategory data
INSERT INTO subcategories (subcategory_name, category_id, thumbnail, link) VALUES
('Shirts', (SELECT category_id FROM categories WHERE category_name = 'Men'), '../assest/men/shirts/(1).jpeg', './shirts.html'),
('Suits', (SELECT category_id FROM categories WHERE category_name = 'Men'), '../assest/men/suits/(1).jpg', './suits.html'),
('Pants', (SELECT category_id FROM categories WHERE category_name = 'Men'), '../assest/men/pants/(1).jpg', './pants.html'),
('Jackets', (SELECT category_id FROM categories WHERE category_name = 'Men'), '../assest/men/jackets/(1).jpg', './jackets.html'),
('Accessories', (SELECT category_id FROM categories WHERE category_name = 'Men'), '../assest/men/accessories/(1).jpg', './accessories.html'),
('Dresses', (SELECT category_id FROM categories WHERE category_name = 'Women'), '../assest/women/dresses/dress1.webp', './dresses.html'),
('Bottoms', (SELECT category_id FROM categories WHERE category_name = 'Women'), '../assest/women/bottoms/bottom1.webp', './bottoms.html');

-- ==============================================================
-- 2️⃣ PRODUCTS
-- ==============================================================

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category_id INT,
    subcategory_id INT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2),
    image_url VARCHAR(255),
    stock_quantity INT DEFAULT 0,
    available_colors TEXT,
    available_sizes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_subcategory (subcategory_id)
);

-- Example product data
INSERT INTO products (product_name, category_id, subcategory_id, description, price, discount_price, image_url, stock_quantity, available_colors, available_sizes)
VALUES
('DAEGU COTTON COLLAR T-SHIRT', 
    (SELECT category_id FROM categories WHERE category_name='Women'),
    (SELECT subcategory_id FROM subcategories WHERE subcategory_name='Dresses'),
    'Stylish cotton t-shirt with a buttoned collar for everyday comfort.', 
    11794.92, 8459.97, 'assest/women/dresses/dress1.webp', 
    50, JSON_ARRAY('Red','Blue','White','Black'), JSON_ARRAY('S','M','L','XL')),
('Lined Kinin Shirt', 
    (SELECT category_id FROM categories WHERE category_name='Men'),
    (SELECT subcategory_id FROM subcategories WHERE subcategory_name='Shirts'),
    'Classic lined shirt for formal occasions.',
    4500.00, 4050.00, 'images/shirt one front.jpeg',
    55, JSON_ARRAY('White','Light Blue','Pink'), JSON_ARRAY('S','M','L','XL'));

-- ==============================================================
-- 3️⃣ CUSTOMERS & ADMINS
-- ==============================================================

CREATE TABLE customer_users (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email)
);

CREATE TABLE admin_users (
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
);

-- ==============================================================
-- 4️⃣ ORDERS
-- ==============================================================

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_address TEXT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customer_users(customer_id)
        ON DELETE CASCADE,
    INDEX idx_status (order_status),
    INDEX idx_date (order_date)
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    selected_color VARCHAR(50),
    selected_size VARCHAR(20),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
);

-- ==============================================================
-- 5️⃣ CONTACT MESSAGES
-- ==============================================================

CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new','read','replied') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_date (created_at)
);






INSERT INTO products 
(product_name, category_id, subcategory_id, description, price, discount_price, image_url, stock_quantity, available_colors, available_sizes)
VALUES
('Classic Dress Shirt', 1, 1, 'Elegant dress shirt perfect for formal occasions', 5450.00, 4900.00, '../../assest/men/shirts/(1).jpeg', 60, 'White,Blue,Gray', 'S,M,L,XL'),
('Casual Button-Down', 1, 1, 'Comfortable casual shirt for everyday wear', 4500.00, 4050.00, '../../assest/men/shirts/(2).jpeg', 70, 'Blue,Green,White', 'S,M,L,XL'),
('Premium Cotton Shirt', 1, 1, 'High-quality cotton shirt with modern design', 6700.00, 6030.00, '../../assest/men/shirts/(3).jpeg', 50, 'White,Black,Gray', 'S,M,L,XL'),
('Oxford Shirt', 1, 1, 'Classic Oxford weave for professional look', 5200.00, 4700.00, '../../assest/men/shirts/(4).jpeg', 40, 'Blue,White', 'S,M,L,XL'),
('Slim Fit Shirt', 1, 1, 'Contemporary slim fit design', 5800.00, 5200.00, '../../assest/men/shirts/(5).jpeg', 45, 'Gray,Black', 'S,M,L,XL'),
('Linen Blend Shirt', 1, 1, 'Breathable linen blend for warm weather', 6200.00, 5400.00, '../../assest/men/shirts/(6).jpeg', 55, 'Beige,White,Gray', 'M,L,XL'),
('Check Pattern Shirt', 1, 1, 'Stylish check pattern casual shirt', 4900.00, 4400.00, '../../assest/men/shirts/(7).jpeg', 65, 'Red,Blue,Green', 'S,M,L,XL'),
('Striped Formal Shirt', 1, 1, 'Professional striped shirt', 5600.00, 5000.00, '../../assest/men/shirts/(8).jpeg', 50, 'Blue,White', 'S,M,L,XL'),
('Denim Shirt', 1, 1, 'Classic denim shirt for casual occasions', 5300.00, 4600.00, '../../assest/men/shirts/(9).jpeg', 40, 'Blue,Dark Blue', 'M,L,XL'),
('White Dress Shirt', 1, 1, 'Timeless white dress shirt', 4800.00, 4300.00, '../../assest/men/shirts/(10).jpeg', 55, 'White', 'S,M,L,XL'),
('Printed Casual Shirt', 1, 1, 'Trendy printed design for weekends', 5100.00, 4600.00, '../../assest/men/shirts/(11).jpeg', 38, 'Navy,White', 'S,M,L,XL'),
('Smart Casual Shirt', 1, 1, 'Versatile shirt for any occasion', 5500.00, 4850.00, '../../assest/men/shirts/(12).jpeg', 42, 'Blue,Gray,White', 'S,M,L,XL');



INSERT INTO products 
(product_name, category_id, subcategory_id, description, price, discount_price, image_url, stock_quantity, available_colors, available_sizes)
VALUES
('Classic Black Suit', 1, 2, 'Elegant black suit for formal occasions', 35000.00, 30000.00, '../../assest/men/suits/(1).jpg', 25, 'Black,Gray', 'S,M,L,XL'),
('Navy Blue Suit', 1, 2, 'Professional navy blue business suit', 38000.00, 31000.00, '../../assest/men/suits/(2).jpg', 30, 'Navy,Blue', 'S,M,L,XL'),
('Charcoal Grey Suit', 1, 2, 'Sophisticated charcoal grey suit', 36500.00, 30000.00, '../../assest/men/suits/(3).jpg', 40, 'Gray,Black', 'S,M,L,XL'),
('Three-Piece Suit', 1, 2, 'Complete three-piece suit with vest', 42000.00, 34000.00, '../../assest/men/suits/(4).jpg', 20, 'Black,Navy', 'M,L,XL'),
('Slim Fit Suit', 1, 2, 'Contemporary slim fit design', 34000.00, 28000.00, '../../assest/men/suits/(5).jpg', 35, 'Gray,Black', 'S,M,L,XL'),
('Double-Breasted Suit', 1, 2, 'Timeless double-breasted style', 40000.00, 32500.00, '../../assest/men/suits/(6).jpg', 18, 'Black,Gray,Navy', 'M,L,XL'),
('Pinstripe Suit', 1, 2, 'Classic pinstripe pattern', 37500.00, 31000.00, '../../assest/men/suits/(7).jpg', 22, 'Blue,Gray', 'S,M,L,XL'),
('Linen Suit', 1, 2, 'Breathable linen suit for warm weather', 32000.00, 27000.00, '../../assest/men/suits/(8).jpg', 40, 'Beige,White', 'M,L,XL'),
('Tuxedo', 1, 2, 'Premium tuxedo for special occasions', 45000.00, 35000.00, '../../assest/men/suits/(9).jpg', 15, 'Black,White', 'M,L,XL'),
('Brown Tweed Suit', 1, 2, 'Traditional tweed suit', 39000.00, 32000.00, '../../assest/men/suits/(10).jpg', 25, 'Brown,Gray', 'M,L,XL'),
('Light Grey Suit', 1, 2, 'Fresh light grey suit', 33500.00, 28000.00, '../../assest/men/suits/(11).jpg', 28, 'Light Gray', 'S,M,L,XL'),
('Check Pattern Suit', 1, 2, 'Modern check pattern suit', 36000.00, 30000.00, '../../assest/men/suits/(12).jpg', 33, 'Gray,Black', 'S,M,L,XL'),
('Velvet Blazer Suit', 1, 2, 'Premium velvet blazer suit', 41000.00, 33000.00, '../../assest/men/suits/(13).jpg', 12, 'Maroon,Black', 'M,L,XL'),
('Beige Suit', 1, 2, 'Versatile beige suit', 31000.00, 26000.00, '../../assest/men/suits/(14).jpg', 35, 'Beige,Cream', 'S,M,L,XL'),
('Burgundy Suit', 1, 2, 'Bold burgundy statement suit', 38500.00, 31000.00, '../../assest/men/suits/(15).jpg', 20, 'Burgundy,Black', 'M,L,XL');


INSERT INTO products 
(product_name, category_id, subcategory_id, description, price, discount_price, image_url, stock_quantity)
VALUES
('Leather Belt', 1, 5, 'Classic leather belt for formal and casual wear', 3500.00, 3000.00, '../assest/men/accessories/(1).jpg', 20),
('Silk Tie', 1, 5, 'Premium silk tie', 2800.00, 2400.00, '../assest/men/accessories/(2).jpg', 30),
('Leather Wallet', 1, 5, 'Genuine leather bifold wallet', 4200.00, 3600.00, '../assest/men/accessories/(3).jpg', 25),
('Bow Tie', 1, 5, 'Elegant bow tie for special occasions', 2200.00, 1900.00, '../assest/men/accessories/(4).jpg', 40),
('Cufflinks Set', 1, 5, 'Stylish cufflinks set', 3800.00, 3300.00, '../assest/men/accessories/(5).jpg', 30),
('Pocket Square', 1, 5, 'Designer pocket square', 1500.00, 1300.00, '../assest/men/accessories/(6).jpg', 40),
('Suspenders', 1, 5, 'Adjustable suspenders', 2500.00, 2150.00, '../assest/men/accessories/(7).jpg', 30),
('Leather Gloves', 1, 5, 'Premium leather gloves', 4500.00, 3800.00, '../assest/men/accessories/(8).jpg', 25),
('Wool Scarf', 1, 5, 'Warm wool scarf', 3200.00, 2750.00, '../assest/men/accessories/(9).jpg', 30),
('Fedora Hat', 1, 5, 'Classic fedora hat', 5500.00, 4700.00, '../assest/men/accessories/(10).jpg', 20),
('Sunglasses', 1, 5, 'Designer sunglasses', 6800.00, 5800.00, '../assest/men/accessories/(11).jpg', 25),
('Watch', 1, 5, 'Premium wristwatch', 15000.00, 12500.00, '../assest/men/accessories/(12).jpg', 15),
('Messenger Bag', 1, 5, 'Leather messenger bag', 8500.00, 7300.00, '../assest/men/accessories/(13).jpg', 20);