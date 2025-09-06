DROP TABLE IF EXISTS Item;

CREATE TABLE Item (
    item_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(64) NOT NULL,
    item_description VARCHAR(255),
    item_price DECIMAL(10,2) NOT NULL,
    item_image_url VARCHAR(255) NOT NULL
);