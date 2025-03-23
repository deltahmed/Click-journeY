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
    description TEXT,
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
    options_type ENUM('transport', 'home', 'food', 'activity', 'other') NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stage_id INT NOT NULL,
    FOREIGN KEY (stage_id) REFERENCES stages(id) ON DELETE CASCADE
);

CREATE TABLE user_trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    trip_id INT NOT NULL,
    user_numbers INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payement_status ENUM('declined', 'paid') NOT NULL DEFAULT 'declined',
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);

CREATE TABLE options_user_trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_trip_id INT NOT NULL,
    option_id INT NOT NULL,
    FOREIGN KEY (user_trip_id) REFERENCES user_trips(id) ON DELETE CASCADE,
    FOREIGN KEY (option_id) REFERENCES options(id) ON DELETE CASCADE
);

-- Ajout d'utilisateurs
INSERT INTO users (email, password, role, first_name, last_name, gender, birth_date, phone_number, address, postal_code, city)
VALUES
('admin@survival.com', 'adminpass', 'admin', 'John', 'Doe', 'M', '1980-05-15', '0601020304', '123 Rue des Aventuriers', '75001', 'Paris'),
('user1@survival.com', 'userpass1', 'user', 'Alice', 'Smith', 'F', '1992-07-20', '0605060708', '456 Jungle Road', '69002', 'Lyon'),
('user2@survival.com', 'userpass2', 'user', 'Bob', 'Johnson', 'M', '1985-09-30', '0611223344', '789 Forêt Mystique', '33000', 'Bordeaux');

-- Ajout de voyages
INSERT INTO trips (title, description, departure_date, return_date, duration, price, travelers, rooms, level, activity, destination, climate, rating)
VALUES
('Expédition Jungle Extrême', 'Survivre en pleine jungle avec peu de ressources.', '2025-06-10', '2025-06-17', 7, 1299.99, 6, 2, 'advanced', 'wilderness-survival', 'Amazonie', 'lush-jungle', 4.8),
('Évasion en Montagne', 'Apprenez à survivre dans des conditions extrêmes.', '2025-07-05', '2025-07-12', 7, 1499.99, 8, 3, 'intermediate', 'survival-training', 'Alpes', 'rugged-mountains', 4.5),
('Survie Désertique', 'Gérez la chaleur extrême et le manque d\'eau.', '2025-09-01', '2025-09-08', 7, 1399.99, 5, 2, 'beginner', 'survival-escape-game', 'Sahara', 'arid-desert', 4.2);

-- Ajout d'étapes pour le premier voyage (Expédition Jungle Extrême)
INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
(1, 1, 'Entrée dans la jungle', 2, '3.4653,-62.2159', 'Amazonie - Entrée'),
(1, 2, 'Traversée de rivière', 2, '3.5673,-62.5421', 'Rivière Tapajós'),
(1, 3, 'Défi final', 3, '3.7891,-62.7890', 'Jungle Profonde');

-- Ajout des options pour les étapes
INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche en forêt', 0.00, 1),
('transport', 'Bateau motorisé', 100.00, 2),
('transport', 'Hélicoptère', 300.00, 3),
('home', 'Tente basique', 0.00, 1),
('home', 'Cabane en bois', 50.00, 2),
('home', 'Lodge premium', 150.00, 3),
('food', 'Rations de survie', 10.00, 1),
('food', 'Fruits et légumes locaux', 30.00, 2),
('food', 'Menu complet avec viande', 60.00, 3),
('activity', 'Orientation en jungle', 0.00, 1),
('activity', 'Construction d\'abris', 20.00, 2),
('activity', 'Survie extrême', 50.00, 3);

-- Ajout d'achats de voyages par les utilisateurs
INSERT INTO user_trips (user_id, trip_id, user_numbers, amount)
VALUES
(2, 1, 2, 1299.99), -- Alice achète le voyage en jungle
(3, 2, 2, 1499.99); -- Bob achète le voyage en montagne

-- Ajout d'options sélectionnées par les utilisateurs pour leur voyage
INSERT INTO options_user_trips (user_trip_id, user_numbers, option_id)
VALUES
(1, 2, 1), -- Alice choisit "Marche en forêt"
(1, 2, 2), -- Alice choisit "Bateau motorisé"
(1, 2, 3), -- Alice choisit "Hélicoptère"
(1, 2, 4), -- Alice choisit "Tente basique"
(1, 2, 5), -- Alice choisit "Cabane en bois"
(1, 2, 6), -- Alice choisit "Lodge premium"
(1, 2, 7), -- Alice choisit "Rations de survie"
(1, 2, 8), -- Alice choisit "Fruits et légumes locaux"
(1, 2, 9), -- Alice choisit "Menu complet avec viande"
(1, 2, 10), -- Alice choisit "Orientation en jungle"
(1, 2, 11), -- Alice choisit "Construction d'abris"
(1, 2, 12); -- Alice choisit "Survie extrême"
