CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender ENUM('M', 'F', 'A') NOT NULL,
    birth_date DATE NOT NULL,
    phone_number VARCHAR(20),
    address TEXT,
    postal_code VARCHAR(10),
    city VARCHAR(100),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    comment TEXT
);

CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    departure_date DATE NOT NULL,
    return_date DATE NOT NULL,
    duration INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    travelers INT NOT NULL CHECK (travelers BETWEEN 1 AND 10),
    rooms INT NOT NULL CHECK (rooms BETWEEN 1 AND 5),
    level ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    activity ENUM('wilderness-survival', 'survival-training', 'survival-escape-game') NOT NULL,
    destination VARCHAR(255) NOT NULL,
    climate ENUM('arid-desert', 'lush-jungle', 'dense-forest', 'polar-regions', 'rugged-mountains') NOT NULL,
    rating DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    order_index INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    gps_position VARCHAR(50),
    location VARCHAR(255),
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);


CREATE TABLE options (
    id INT AUTO_INCREMENT PRIMARY KEY,
    stage_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    default_value VARCHAR(255),
    price DECIMAL(10,2),
    type VARCHAR(100),
    FOREIGN KEY (stage_id) REFERENCES stages(id) ON DELETE CASCADE
);

CREATE TABLE user_trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);

CREATE TABLE options_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT NOT NULL,
    options_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);


-- JEU DE TZST
INSERT INTO users (email, password, role, first_name, last_name, gender, birth_date, phone_number, address, postal_code, city, comment)
VALUES 
('alice@example.com', 'password123', 'user', 'Alice', 'Dupont', 'F', '1990-05-15', '0123456789', '123 rue de Paris, 75001', '75001', 'Paris', 'Voyageuse passionnée'),
('bob@example.com', 'password456', 'admin', 'Bob', 'Martin', 'M', '1985-08-22', '0987654321', '45 avenue des Champs, 75008', '75008', 'Paris', 'Administrateur principal'),
('carol@example.com', 'password789', 'user', 'Carol', 'Lemoine', 'F', '1992-12-03', '0147253698', '7 boulevard Saint-Germain, 75005', '75005', 'Paris', 'Amoureuse des aventures');


INSERT INTO trips (title, departure_date, return_date, duration, price, travelers, rooms, level, activity, destination, climate)
VALUES 
('Survival Adventure', '2025-06-01', '2025-06-10', 10, 1500.00, 5, 2, 'beginner', 'wilderness-survival', 'Alpes', 'rugged-mountains'),
('Jungle Survival Training', '2025-07-15', '2025-07-22', 7, 1200.00, 3, 1, 'intermediate', 'survival-training', 'Amazonia', 'lush-jungle'),
('Escape the Desert', '2025-08-01', '2025-08-05', 5, 900.00, 2, 1, 'advanced', 'survival-escape-game', 'Sahara', 'arid-desert');


INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES 
(1, 1, 'Arrivée et installation', 1, '45.8390, 6.9560', 'Refuge des Alpes'),
(1, 2, 'Apprentissage des techniques de survie', 2, '45.8500, 6.9700', 'Camp de survie'),
(1, 3, 'Randonnée en montagne', 3, '45.8900, 6.9500', 'Pic du Mont-Blanc'),
(2, 1, 'Introduction au survivalisme', 1, '3.1370, -60.6310', 'Base Amazonienne'),
(2, 2, 'Exercices pratiques en jungle', 3, '3.1500, -60.6200', 'Forêt dense'),
(3, 1, 'Début du défi', 1, '23.4180, 13.5800', 'Dunes du Sahara');


INSERT INTO options (stage_id, name, default_value, price, type)
VALUES 
(1, 'Tente de survie', 'Non', 50.00, 'Equipement'),
(1, 'Kit de premiers secours', 'Non', 25.00, 'Equipement'),
(2, 'Sac à dos', 'Oui', 40.00, 'Equipement'),
(2, 'Rations', 'Non', 15.00, 'Nourriture'),
(5, 'Carte', 'Non', 30.00, 'Equipement');


INSERT INTO user_trips (user_id, trip_id, amount)
VALUES 
(1, 1, 1500.00),
(2, 2, 1200.00),
(3, 3, 900.00);


INSERT INTO options_links (user_id, trip_id, options_id)
VALUES 
(1, 1, 1), 
(1, 1, 2),
(2, 2, 3),
(3, 3, 5);