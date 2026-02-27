CREATE DATABASE IF NOT EXISTS shri_balaji;
USE shri_balaji;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin_users (username, password)
VALUES ('admin', MD5('admin123'));

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    status TINYINT DEFAULT 1
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    specifications TEXT,
    image VARCHAR(255),
    price VARCHAR(100),
    status TINYINT DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS slider (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT,
    image VARCHAR(255),
    button_text VARCHAR(100),
    button_link VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    message TEXT NOT NULL,
    product_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

INSERT INTO categories (name, slug, image, status) VALUES
('Chaff Cutter', 'chaff-cutter', '', 1),
('Workshop Machinery', 'workshop-machinery', '', 1),
('Casting', 'casting', '', 1),
('Fabricated Components', 'fabricated-components', '', 1);

INSERT INTO products (category_id, title, slug, description, specifications, image, price, status) VALUES
(1, 'Sarpanch Taj Chaff Cutter', 'sarpanch-taj-chaff-cutter', 'Popular semi-automatic chaff cutter for medium farms with reliable output and durable blades.', 'Motor: 3-5 HP | Operation: Semi-automatic | Capacity: Up to 800 kg/hr*', '', 'On Request', 1),
(1, 'Sarpanch Wheel-2 Chaff Cutter', 'sarpanch-wheel-2-chaff-cutter', 'Efficient model for regular fodder cutting with consistent performance in daily farm operations.', 'Motor: 3-5 HP | Operation: Electric | Capacity: Approx. 500+ kg/hr*', '', 'On Request', 1),
(1, 'Sardar Bomb Side-Spring Model', 'sardar-bomb-side-spring-model', 'Heavy-duty variant for handling tougher fodder materials with shock protection style design.', 'Motor: 5 HP | Application: Coarse stalk fodder | Build: Heavy-duty', '', 'On Request', 1),
(1, 'Steel Gear Heavy Duty Chaff Cutter', 'steel-gear-heavy-duty-chaff-cutter', 'Gear-driven high-strength machine suitable for commercial and high-volume usage.', 'Drive: Steel gear | Use: Continuous operation | Build: Industrial', '', 'On Request', 1),
(2, 'Industrial Lathe Machine', 'industrial-lathe-machine', 'Heavy cast body lathe for turning, threading and workshop machining applications.', 'Duty: Industrial | Construction: Rigid cast body | Use: Precision turning', '', 'On Request', 1),
(2, 'Pillar Drilling Machine', 'pillar-drilling-machine', 'Workshop drilling machine for accurate drilling in steel and fabrication parts.', 'Type: Pillar/Radial variants | Spindle: Industrial grade', '', 'On Request', 1);

INSERT INTO slider (title, subtitle, image, button_text, button_link) VALUES
('Shri Balaji Foundry', 'Manufacturer & Exporter of Chaff Cutters, Workshop Machinery, Casting and Fabrication Products', '', 'View Chaff Cutters', 'products.php'),
('Workshop Machinery Division', 'Lathe, Drilling, Shaper, Plano Miller and Boring Machines for Industrial Requirements', '', 'Explore Machinery', 'workshop-machinery.php');
