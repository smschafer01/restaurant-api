CREATE DATABASE IF NOT EXISTS restaurant_ordering_system DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE restaurant_ordering_system;

CREATE TABLE restaurants (
  restaurant_id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  street_address VARCHAR(150) NOT NULL,
  city VARCHAR(80) NOT NULL,
  state CHAR(2) NOT NULL,
  zip_code VARCHAR(10) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (restaurant_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE categories (
  category_id INT NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(75) NOT NULL,
  description VARCHAR(255),
  display_order INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (category_id),
  UNIQUE KEY category_name (category_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE customers (
  customer_id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(60) NOT NULL,
  last_name VARCHAR(60) NOT NULL,
  email VARCHAR(120) NOT NULL,
  phone VARCHAR(20),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (customer_id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE menu_items (
  item_id INT NOT NULL AUTO_INCREMENT,
  restaurant_id INT NOT NULL,
  category_id INT NOT NULL,
  item_name VARCHAR(100) NOT NULL,
  description VARCHAR(255),
  price DECIMAL(8,2) NOT NULL,
  is_available TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (item_id),
  KEY idx_menu_items_restaurant_id (restaurant_id),
  KEY idx_menu_items_category_id (category_id),
  CONSTRAINT fk_menu_items_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants (restaurant_id) ON UPDATE CASCADE,
  CONSTRAINT fk_menu_items_category FOREIGN KEY (category_id) REFERENCES categories (category_id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE orders (
  order_id INT NOT NULL AUTO_INCREMENT,
  customer_id INT NOT NULL,
  restaurant_id INT NOT NULL,
  order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('pending','preparing','ready','completed','canceled') NOT NULL DEFAULT 'pending',
  subtotal DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  tax DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  total DECIMAL(8,2) NOT NULL DEFAULT 0.00,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (order_id),
  KEY idx_orders_customer_id (customer_id),
  KEY idx_orders_restaurant_id (restaurant_id),
  KEY idx_orders_status (status),
  CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers (customer_id) ON UPDATE CASCADE,
  CONSTRAINT fk_orders_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants (restaurant_id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE order_details (
  order_detail_id INT NOT NULL AUTO_INCREMENT,
  order_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL,
  item_price DECIMAL(8,2) NOT NULL,
  line_total DECIMAL(8,2) NOT NULL,
  PRIMARY KEY (order_detail_id),
  KEY idx_order_details_order_id (order_id),
  KEY idx_order_details_item_id (item_id),
  CONSTRAINT fk_order_details_order FOREIGN KEY (order_id) REFERENCES orders (order_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_order_details_item FOREIGN KEY (item_id) REFERENCES menu_items (item_id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO restaurants (restaurant_id, name, phone, street_address, city, state, zip_code) VALUES
(1, 'Crimson Grill', '317-555-0180', '1201 University Blvd', 'Indianapolis', 'IN', '46202'),
(2, 'Union Cafe', '317-555-0199', '210 College Ave', 'Bloomington', 'IN', '47405'),
(3, 'Downtown Pizza', '317-555-0144', '88 Market St', 'Indianapolis', 'IN', '46204'),
(4, 'Hoosier Tacos', '317-555-0167', '412 Main St', 'Greenwood', 'IN', '46142'),
(5, 'Canal Bistro Express', '317-555-0118', '730 Canal Walk', 'Indianapolis', 'IN', '46202');

INSERT INTO categories (category_id, category_name, description, display_order) VALUES
(1, 'Appetizers', 'Small plates and starters', 1),
(2, 'Entrees', 'Main meals and featured dishes', 2),
(3, 'Drinks', 'Cold and hot beverages', 3),
(4, 'Desserts', 'Sweet menu items', 4),
(5, 'Sides', 'Side items and add-ons', 5);

INSERT INTO customers (customer_id, first_name, last_name, email, phone) VALUES
(1, 'Maya', 'Johnson', 'maya@example.com', '317-555-0122'),
(2, 'Ethan', 'Brooks', 'ethan.brooks@example.com', '317-555-0148'),
(3, 'Sofia', 'Ramirez', 'sofia.ramirez@example.com', '317-555-0131'),
(4, 'Liam', 'Patel', 'liam.patel@example.com', '317-555-0155'),
(5, 'Ava', 'Miller', 'ava.miller@example.com', '317-555-0177'),
(6, 'Noah', 'Wilson', 'noah.wilson@example.com', '317-555-0188');

INSERT INTO menu_items (item_id, restaurant_id, category_id, item_name, description, price, is_available) VALUES
(1, 1, 2, 'Classic Burger', 'Burger with lettuce, tomato, and house sauce.', 9.99, 1),
(2, 1, 5, 'Crispy Fries', 'Golden fries with sea salt.', 3.50, 1),
(3, 1, 3, 'Lemonade', 'Fresh lemonade served cold.', 2.99, 1),
(4, 2, 2, 'Garden Salad', 'Mixed greens with cucumber, tomato, and vinaigrette.', 7.50, 1),
(5, 2, 3, 'Iced Coffee', 'Chilled coffee served over ice.', 3.25, 1),
(6, 3, 2, 'Pepperoni Pizza', 'Personal pizza with pepperoni and mozzarella.', 11.99, 1),
(7, 3, 1, 'Garlic Knots', 'Baked knots brushed with garlic butter.', 4.99, 1),
(8, 4, 2, 'Chicken Tacos', 'Three chicken tacos with salsa and cilantro.', 10.50, 1),
(9, 4, 5, 'Chips and Salsa', 'Tortilla chips with house salsa.', 3.99, 1),
(10, 5, 2, 'BBQ Chicken Sandwich', 'Grilled chicken with house BBQ sauce.', 11.50, 1),
(11, 5, 4, 'Chocolate Brownie', 'Warm brownie with chocolate drizzle.', 4.50, 1),
(12, 5, 3, 'Sparkling Water', 'Bottled sparkling water.', 2.25, 1);

INSERT INTO orders (order_id, customer_id, restaurant_id, order_date, status, subtotal, tax, total) VALUES
(1, 1, 1, '2026-06-01 11:15:00', 'pending', 26.47, 1.85, 28.32),
(2, 2, 2, '2026-06-01 12:05:00', 'preparing', 10.75, 0.75, 11.50),
(3, 3, 3, '2026-06-02 18:30:00', 'completed', 16.98, 1.19, 18.17),
(4, 4, 4, '2026-06-03 13:10:00', 'ready', 14.49, 1.01, 15.50),
(5, 5, 5, '2026-06-04 19:45:00', 'canceled', 18.25, 1.28, 19.53),
(6, 6, 1, '2026-06-05 10:20:00', 'completed', 16.48, 1.15, 17.63);

INSERT INTO order_details (order_detail_id, order_id, item_id, quantity, item_price, line_total) VALUES
(1, 1, 1, 2, 9.99, 19.98),
(2, 1, 2, 1, 3.50, 3.50),
(3, 1, 3, 1, 2.99, 2.99),
(4, 2, 4, 1, 7.50, 7.50),
(5, 2, 5, 1, 3.25, 3.25),
(6, 3, 6, 1, 11.99, 11.99),
(7, 3, 7, 1, 4.99, 4.99),
(8, 4, 8, 1, 10.50, 10.50),
(9, 4, 9, 1, 3.99, 3.99),
(10, 5, 10, 1, 11.50, 11.50),
(11, 5, 11, 1, 4.50, 4.50),
(12, 5, 12, 1, 2.25, 2.25),
(13, 6, 1, 1, 9.99, 9.99),
(14, 6, 2, 1, 3.50, 3.50),
(15, 6, 3, 1, 2.99, 2.99);
