CREATE TABLE IF NOT EXISTS competitor_prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NULL,
    website_name VARCHAR(100) NOT NULL,
    competitor_product_name VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    competitor_url TEXT NULL,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
