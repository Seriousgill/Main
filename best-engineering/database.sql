CREATE DATABASE IF NOT EXISTS best_engineering;
USE best_engineering;

CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    status ENUM('active','inactive') DEFAULT 'active'
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    short_description TEXT,
    full_description TEXT,
    specifications TEXT,
    image VARCHAR(255),
    featured ENUM('yes','no') DEFAULT 'no',
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    company_name VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(255),
    product VARCHAR(255),
    message TEXT,
    status ENUM('new','contacted') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE homepage_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255),
    hero_subtitle TEXT,
    about_text TEXT,
    why_choose_us TEXT,
    featured_product_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logo VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(255),
    address TEXT
);

CREATE TABLE seo_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(100) NOT NULL UNIQUE,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT
);

CREATE TABLE content_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    block_key VARCHAR(100) NOT NULL UNIQUE,
    content TEXT
);

INSERT INTO admin_users (username, password) VALUES
('admin', '$2y$12$yBzaZuT3a.dIYgaIwB1QPedGiHe9KQcqI2iZPbrl61uctehy3xvbW');

INSERT INTO categories (name, slug) VALUES
('Paper Machine Components', 'paper-machine-components'),
('Industrial Gears', 'industrial-gears'),
('Services', 'services');

INSERT INTO products (category_id, name, slug, short_description, full_description, specifications, featured, status) VALUES
(1,'Drying Cylinder','drying-cylinder','Heavy-duty drying cylinder for paper machinery.','Up to 2000 mm Diameter, 6000 mm deckle, dynamically balanced and hydraulic tested.','Up to 2000 mm Diameter\nUp to 6000 mm Deckle\nDynamically Balanced\nHydraulic Tested at 10 kg/cm²\nSurface Ground to Mirror Finish\nRepair & Reconditioning Services Available','no','active'),
(1,'CI Press Roll','ci-press-roll','Defect-free cast iron press rolls with precision finishing.','Built using cast steel end covers and metallurgical quality checks.','Up to 1500 mm Diameter\nUp to 6000 mm Deckle\nCast Steel End Covers\nFree from Metallurgical Defects','no','active'),
(2,'BC-901 Cast Nylon Gears','bc-901-cast-nylon-gears','Heat-stabilized nylon gears for high-speed machines.','Widely accepted for low friction and long component life.','Up to 6000 mm Diameter\nUp to 40 Module\nPrecision Hobbed Teeth\nDynamically Balanced\nHigh Wear Resistance\nLow Friction Coefficient','yes','active'),
(2,'MG Gears (Internal & External)','mg-gears','Internal and external MG gears in multiple materials.','Available in Cast Iron, Mild Steel, Fabrication and Cast Steel options.','Capacity up to 6000 mm Diameter & 40 Module','no','active'),
(1,'Tambour Roll Coupling','tambour-roll-coupling','Precision coupling for paper machinery reliability.','Engineered for high performance and durability in demanding operations.','Precision-engineered coupling components','no','active'),
(1,'Bearing Housing','bearing-housing','Plummer blocks and custom bearing housings.','Available in all types and specifications.','Any Type & Specification\nPlummer Blocks SN Series\nMaterial: CI & Cast Steel','no','active'),
(1,'Sole Plates','sole-plates','Custom CI sole plates for industrial assemblies.','CI grade 20 plates in custom shapes and sizes.','CI (Grade 20)\nCustom Shapes & Sizes','no','active'),
(2,'Washer Gear','washer-gear','Worm-wheel assemblies for process machinery.','Phosphor bronze and alloy steel washer gear sets.','Phosphor Bronze Worm Wheel\nAlloy Steel Worm\n77 Teeth (Dia 805 mm)\n70 Teeth (Dia 950 mm)','no','active'),
(2,'Girth Gear','girth-gear','Large-diameter gears for heavy-duty transmission.','Designed for robust power transmission in industrial plants.','Heavy-duty large diameter gear','no','active'),
(3,'Gear Box Repair','gear-box-repair','Precision repair and reconditioning services for gearboxes.','All types of industrial gear box alignment, testing and restoration.','Repair all types of industrial gear boxes','no','active');

INSERT INTO homepage_content (hero_title, hero_subtitle, about_text, why_choose_us, featured_product_id)
VALUES ('Precision Industrial Gears & Paper Machinery Solutions','Delivering High-Performance Engineering Components for Over 50 Years.','Best Engineering Works (Regd.) is a leading manufacturer of industrial gears and paper machine components. With over five decades of experience, we specialize in delivering precision-engineered solutions designed for durability, efficiency, and long operational life.','50+ Years of Manufacturing Excellence\nUp to 6000 mm Diameter Capability\nUp to 40 Module Gear Manufacturing\nHigh-Speed Machine Compatibility (750 MPM)\nDynamically Balanced Components\nReliable After-Sales Support',3);

INSERT INTO site_settings (logo, phone, email, address)
VALUES ('assets/images/logo.png','+91-98765-43210','info@bestengineeringworks.com','Best Engineering Works (Regd.), Industrial Area, Punjab, India');

INSERT INTO content_blocks (block_key, content) VALUES
('infrastructure','Heavy Duty Lathe Machines\nShaper Machines\nRadial Drill Machines\nPlanner Machines'),
('industries','Paper Industry\nSugar Industry\nCement Industry\nHeavy Engineering Sector');

INSERT INTO seo_settings (page_key, meta_title, meta_description, meta_keywords) VALUES
('home','Best Engineering Works | Precision Industrial Gears','Industrial gears and paper machinery components manufacturer with 50+ years experience.','industrial gears,paper dryers,cast nylon gears'),
('about','About Best Engineering Works','More than 50 years of industrial manufacturing excellence.','about engineering works,industrial manufacturer'),
('products','Industrial Products','Dynamic product portfolio of gears and paper machine components.','drying cylinder,press roll,mg gear'),
('product-details','Product Details','Technical product specifications and details.','product specs,industrial parts'),
('infrastructure','Infrastructure','Advanced machine shop infrastructure and manufacturing setup.','lathe,shaper,radial drill'),
('industries','Industries Served','Paper, sugar, cement and heavy engineering industries served.','paper industry,sugar industry,cement industry'),
('quality','Quality & Manufacturing','Strict quality checks and precision manufacturing workflow.','quality control,manufacturing process'),
('contact','Contact Us','Contact Best Engineering Works for project inquiries.','contact engineering company'),
('quote','Request a Quote','Submit your quote request for gears and paper machine components.','request quote,industrial gears');
