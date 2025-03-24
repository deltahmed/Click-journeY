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
    id_tr VARCHAR(255) NOT NULL,
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
('Survie Désertique', 'Gérez la chaleur extrême.', '2025-09-01', '2025-09-08', 7, 1399.99, 5, 2, 'beginner', 'survival-escape-game', 'Sahara', 'arid-desert', 4.2),
('Jungle de Bornéo', 'Plongez dans la jungle dense de Bornéo et apprenez à survivre dans un environnement tropical.', '2025-05-05', '2025-05-12', 7, 1500.00, 4, 2, 'advanced', 'wilderness-survival', 'Bornéo, Malaisie', 'lush-jungle', 4.7),
('Survie en Sibérie', 'Affrontez les conditions extrêmes de la taïga sibérienne et apprenez à survivre dans un environnement hostile.', '2025-06-20', '2025-06-30', 10, 1800.00, 5, 2, 'intermediate', 'survival-training', 'Sibérie, Russie', 'boreal-forest', 4.6),
('Défi du Volcan', 'Explorez les terrains volcaniques de Hawaï et apprenez à survivre dans un environnement instable.', '2025-07-10', '2025-07-15', 5, 1300.00, 4, 2, 'advanced', 'wilderness-survival', 'Hawaï, États-Unis', 'volcanic-terrain', 4.8),
('Aventure au Serengeti', 'Survivez dans la savane africaine et apprenez à cohabiter avec la faune sauvage.', '2025-08-01', '2025-08-10', 9, 1700.00, 6, 2, 'intermediate', 'survival-training', 'Serengeti, Tanzanie', 'open-savannah', 4.7),
('Survie en Finlande', 'Explorez les forêts boréales de Finlande et apprenez à survivre dans un environnement froid et dense.', '2025-09-05', '2025-09-12', 7, 1400.00, 4, 2, 'beginner', 'survival-escape-game', 'Finlande', 'boreal-forest', 4.4),
('Exploration du Grand Canyon', 'Explorez les canyons spectaculaires du Grand Canyon et apprenez à survivre en milieu aride.', '2025-10-01', '2025-10-07', 6, 1100.00, 5, 2, 'intermediate', 'wilderness-survival', 'Grand Canyon, États-Unis', 'rugged-mountains', 4.5),
('Jungle du Congo', 'Plongez dans la jungle dense du Congo et apprenez à survivre dans un environnement tropical hostile.', '2025-11-10', '2025-11-20', 10, 2000.00, 4, 2, 'advanced', 'wilderness-survival', 'Congo', 'dense-forest', 4.9),
('Aventure en Patagonie', 'Explorez les paysages sauvages de la Patagonie et apprenez à survivre dans un environnement montagneux et venteux.', '2025-12-01', '2025-12-08', 7, 1600.00, 5, 2, 'intermediate', 'wilderness-survival', 'Patagonie, Argentine', 'rugged-mountains', 4.7),
('Survie en Forêt Tropicale Australienne', 'Plongez dans la forêt tropicale australienne et apprenez à survivre dans un environnement humide et dense.', '2026-01-10', '2026-01-17', 7, 1550.00, 4, 2, 'advanced', 'wilderness-survival', 'Forêt Daintree, Australie', 'lush-jungle', 4.8),
('Expédition en Antarctique', 'Survivez dans les conditions extrêmes en Antarctique et apprenez à gérer le froid polaire.', '2026-02-15', '2026-02-22', 7, 2500.00, 4, 2, 'advanced', 'wilderness-survival', 'Antarctique', 'polar-regions', 4.9),
('Survie en Forêt Boréale Canadienne', 'Explorez la forêt boréale canadienne et apprenez à survivre dans un environnement froid et dense.', '2026-03-01', '2026-03-08', 7, 1400.00, 5, 2, 'intermediate', 'wilderness-survival', 'Forêt boréale, Canada', 'boreal-forest', 4.6),
('Aventure en Forêt Tropicale Amazonienne', 'Plongez dans la forêt amazonienne et apprenez à survivre dans un environnement tropical dense.', '2026-04-05', '2026-04-12', 7, 1500.00, 6, 2, 'advanced', 'wilderness-survival', 'Amazonie, Brésil', 'lush-jungle', 4.7);

-- Ajout des étapes pour chaque voyage
INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
-- Expédition Jungle Extrême
(1, 1, 'Entrée dans la jungle', 2, '3.4653,-62.2159', 'Amazonie - Entrée'),
(1, 2, 'Traversée de rivière', 2, '3.5673,-62.5421', 'Rivière Tapajós'),
(1, 3, 'Défi final', 3, '3.7891,-62.7890', 'Jungle Profonde'),

-- Évasion en Montagne
(2, 1, 'Ascension initiale', 2, '45.8390,6.9560', 'Base des Alpes'),
(2, 2, 'Traversée un glacier', 2, '45.8900,6.9500', 'Glacier des Alpes'),
(2, 3, 'Défi final : Sommet', 3, '45.9200,6.9700', 'Pic des Alpes'),

-- Survie Désertique
(3, 1, 'Entrée dans le désert', 1, '23.4180,13.5800', 'Bordure du Sahara'),
(3, 2, 'Traversée des dunes', 2, '23.5000,13.6000', 'Dunes du Sahara'),
(3, 3, 'Défi final : Oasis cachée', 2, '23.5500,13.6500', 'Oasis du Sahara'),

-- Jungle de Bornéo
(4, 1, 'Entrée dans la jungle', 2, '0.9619,114.5548', 'Bordure de la jungle'),
(4, 2, 'Traversée une rivière', 2, '3.5673,62.5421', 'Rivière de Bornéo'),
(4, 3, 'Défi final : Nuit en jungle profonde', 3, '3.7891,62.7890', 'Cœur de la jungle'),

-- Survie en Sibérie
(5, 1, 'Arrivée en taïga', 1, '61.5240,105.3188', 'Bordure de la taïga'),
(5, 2, 'Traversée une forêt gelée', 3, '61.5300,105.3200', 'Forêt boréale'),
(5, 3, 'Défi final : Nuit en autonomie', 2, '61.5400,105.3300', 'Zone isolée de la taïga'),

-- Défi du Volcan
(6, 1, 'Arrivée sur une île volcanique', 1, '19.4194,-155.2889', 'Base volcanique'),
(6, 2, 'Exploration des tunnels de lave', 2, '19.4200,-155.2900', 'Tunnels de lave'),
(6, 3, 'Défi final : Nuit près du cratère', 2, '19.4300,-155.3000', 'Cratère volcanique'),

-- Aventure au Serengeti
(7, 1, 'Arrivée dans la savane', 1, '-2.1530,34.6857', 'Camp de base du Serengeti'),
(7, 2, 'Traversée une plaine', 3, '-2.1600,34.6900', 'Plaine du Serengeti'),
(7, 3, 'Défi final : Nuit en brousse', 2, '-2.1700,34.7000', 'Zone isolée du Serengeti'),

-- Survie en Finlande
(8, 1, 'Entrée en forêt boréale', 1, '61.9241,25.7482', 'Bordure de la forêt'),
(8, 2, 'Traversée un lac gelé', 2, '61.9300,25.7500', 'Lac gelé de Finlande'),
(8, 3, 'Défi final : Nuit en forêt profonde', 2, '61.9400,25.7600', 'Cœur de la forêt boréale'),

-- Exploration du Grand Canyon
(9, 1, 'Arrivée au bord du canyon', 1, '36.1069,-112.1129', 'Point de vue Sud'),
(9, 2, 'Descente dans le canyon', 2, '36.1100,-112.1200', 'Sentier du canyon'),
(9, 3, 'Défi final : Nuit au fond du canyon', 2, '36.1200,-112.1300', 'Plateau du canyon'),

-- Jungle du Congo
(10, 1, 'Entrée dans la jungle', 2, '-0.2280,15.8277', 'Bordure de la jungle'),
(10, 2, 'Traversée une rivière', 2, '-0.2300,15.8300', 'Rivière du Congo'),
(10, 3, 'Défi final : Nuit en jungle profonde', 3, '-0.2400,15.8400', 'Cœur de la jungle'),

-- Aventure en Patagonie
(11, 1, 'Arrivée en Patagonie', 1, '-51.6235,-72.5273', 'Base de la Patagonie'),
(11, 2, 'Traversée sur un glacier', 2, '-50.4800,-73.0500', 'Glacier Perito Moreno'),
(11, 3, 'Défi final : Nuit en montagne', 2, '-50.5000,-73.1000', 'Montagnes de la Patagonie'),

-- Survie en Forêt Tropicale Australienne
(12, 1, 'Entrée dans la forêt', 1, '-16.9203,145.7710', 'Bordure de la forêt'),
(12, 2, 'Traversée une rivière', 2, '-16.9300,145.7800', 'Rivière Daintree'),
(12, 3, 'Défi final : Nuit en forêt profonde', 2, '-16.9400,145.7900', 'Cœur de la forêt tropicale'),

-- Expédition en Antarctique
(13, 1, 'Arrivée en Antarctique', 1, '-77.8460,166.6760', 'Base antarctique'),
(13, 2, 'Traversée sur une banquise', 2, '-77.8500,166.6800', 'Banquise en Antarctique'),
(13, 3, 'Défi final : Nuit polaire', 2, '-77.8600,166.6900', 'Zone isolée en Antarctique'),

-- Survie en Forêt Boréale Canadienne
(14, 1, 'Entrée en forêt boréale', 1, '53.7267,-127.6476', 'Bordure de la forêt'),
(14, 2, 'Traversée sur un lac gelé', 2, '53.7300,-127.6500', 'Lac gelé canadien'),
(14, 3, 'Défi final : Nuit en forêt profonde', 2, '53.7400,-127.6600', 'Cœur de la forêt boréale'),

-- Aventure en Forêt Tropicale Amazonienne
(15, 1, 'Entrée dans la forêt', 1, '-3.4653,-62.2159', 'Bordure de la forêt'),
(15, 2, 'Traversée une rivière', 2, '-3.5673,-62.5421', 'Rivière Amazonienne'),
(15, 3, 'Défi final : Nuit en forêt profonde', 2, '-3.7891,-62.7890', 'Cœur de la forêt amazonienne');

-- Ajout des options pour chaque étape
INSERT INTO options (options_type, title, price, stage_id)
VALUES
-- Expédition Jungle Extrême
('transport', 'Marche en forêt', 0.00, 1),
('transport', 'Vélo', 0.00, 1),
('transport', 'Bateau motorisé', 100.00, 2),
('transport', 'Hélicoptère', 300.00, 3),
('home', 'Tente basique', 0.00, 1),
('home', 'Cabane en bois', 50.00, 2),
('home', 'Lodge premium', 150.00, 3),
('food', 'Rations de survie', 0.00, 1),
('food', 'Fruits et légumes locaux', 30.00, 2),
('food', 'Menu complet avec viande', 60.00, 3),
('activity', 'Orientation en jungle', 0.00, 1),
('activity', 'Construction abris', 20.00, 2),
('activity', 'Survie extrême', 50.00, 3),

-- Évasion en Montagne
('transport', 'Marche en montagne', 0.00, 4),
('transport', 'Téléphérique', 80.00, 5),
('transport', 'Hélicoptère', 300.00, 6),
('home', 'Tente de montagne', 0.00, 4),
('home', 'Refuge en pierre', 60.00, 5),
('home', 'Chalet de luxe', 200.00, 6),
('food', 'Rations de survie', 0.00, 4),
('food', 'Fromage et charcuterie locale', 40.00, 5),
('food', 'Menu gastronomique', 80.00, 6),
('activity', 'Orientation en montagne', 0.00, 4),
('activity', 'Escalade', 50.00, 5),
('activity', 'Survie en haute altitude', 70.00, 6),

-- Survie Désertique
('transport', 'Marche dans le désert', 0.00, 7),
('transport', 'Quad', 120.00, 8),
('transport', 'Hélicoptère', 300.00, 9),
('home', 'Tente de désert', 0.00, 7),
('home', 'Abri en pierre', 40.00, 8),
('home', 'Lodge de luxe', 180.00, 9),
('food', 'Rations de survie', 0.00, 7),
('food', 'Dattes et noix locales', 20.00, 8),
('food', 'Menu berbère', 50.00, 9),
('activity', 'Orientation en désert', 0.00, 7),
('activity', 'Navigation à ancienne', 30.00, 8),
('activity', 'Survie en milieu aride', 60.00, 9),

-- Jungle de Bornéo
('transport', 'Marche en forêt', 0.00, 10),
('transport', 'Bateau motorisé', 100.00, 11),
('transport', 'Hélicoptère', 300.00, 12),
('home', 'Tente basique', 0.00, 10),
('home', 'Cabane sur pilotis', 70.00, 11),
('home', 'Lodge de luxe', 200.00, 12),
('food', 'Rations de survie', 0.00, 10),
('food', 'Fruits exotiques', 25.00, 11),
('food', 'Menu asiatique', 70.00, 12),
('activity', 'Orientation en jungle', 0.00, 10),
('activity', 'Pêche traditionnelle', 30.00, 11),
('activity', 'Survie extrême', 60.00, 12),

-- Survie en Sibérie
('transport', 'Marche en forêt', 0.00, 13),
('transport', 'Traîneau à chiens', 120.00, 14),
('transport', 'Hélicoptère', 300.00, 15),
('home', 'Tente basique', 0.00, 13),
('home', 'Cabane en rondins', 60.00, 14),
('home', 'Lodge de luxe', 180.00, 15),
('food', 'Rations de survie', 0.00, 13),
('food', 'Poisson fumé local', 40.00, 14),
('food', 'Menu russe traditionnel', 70.00, 15),
('activity', 'Orientation en forêt', 0.00, 13),
('activity', 'Chasse et pêche', 30.00, 14),
('activity', 'Survie extrême', 60.00, 15),

-- Défi du Volcan
('transport', 'Marche en forêt', 0.00, 16),
('transport', 'Véhicule tout-terrain', 80.00, 17),
('transport', 'Hélicoptère', 300.00, 18),
('home', 'Tente basique', 0.00, 16),
('home', 'Cabane en bois', 50.00, 17),
('home', 'Lodge de luxe', 200.00, 18),
('food', 'Rations de survie', 0.00, 16),
('food', 'Fruits tropicaux', 30.00, 17),
('food', 'Menu hawaïen', 80.00, 18),
('activity', 'Orientation en terrain volcanique', 0.00, 16),
('activity', 'Exploration des tunnels de lave', 40.00, 17),
('activity', 'Survie extrême', 70.00, 18),

-- Aventure au Serengeti
('transport', 'Marche en savane', 0.00, 19),
('transport', 'Véhicule tout-terrain', 80.00, 20),
('transport', 'Hélicoptère', 300.00, 21),
('home', 'Tente basique', 0.00, 19),
('home', 'Campement mobile', 70.00, 20),
('home', 'Lodge de luxe', 200.00, 21),
('food', 'Rations de survie', 0.00, 19),
('food', 'Barbecue africain', 50.00, 20),
('food', 'Menu gastronomique', 90.00, 21),
('activity', 'Orientation en savane', 0.00, 19),
('activity', 'Safari photo', 40.00, 20),
('activity', 'Survie extrême', 70.00, 21),

-- Survie en Finlande
('transport', 'Marche en forêt', 0.00, 22),
('transport', 'Traîneau à chiens', 120.00, 23),
('transport', 'Hélicoptère', 300.00, 24),
('home', 'Tente basique', 0.00, 22),
('home', 'Cabane en bois', 60.00, 23),
('home', 'Lodge de luxe', 180.00, 24),
('food', 'Rations de survie', 0.00, 22),
('food', 'Soupe de poisson', 30.00, 23),
('food', 'Menu finlandais traditionnel', 70.00, 24),
('activity', 'Orientation en forêt', 0.00, 22),
('activity', 'Chasse et pêche', 30.00, 23),
('activity', 'Survie extrême', 60.00, 24),

-- Exploration du Grand Canyon
('transport', 'Marche en canyon', 0.00, 25),
('transport', 'Véhicule tout-terrain', 80.00, 26),
('transport', 'Hélicoptère', 300.00, 27),
('home', 'Tente basique', 0.00, 25),
('home', 'Cabane en bois', 50.00, 26),
('home', 'Lodge de luxe', 200.00, 27),
('food', 'Rations de survie', 0.00, 25),
('food', 'Barbecue américain', 40.00, 26),
('food', 'Menu gastronomique', 80.00, 27),
('activity', 'Orientation en canyon', 0.00, 25),
('activity', 'Descente en rappel', 50.00, 26),
('activity', 'Survie extrême', 70.00, 27),

-- Jungle du Congo
('transport', 'Marche en forêt', 0.00, 28),
('transport', 'Bateau motorisé', 100.00, 29),
('transport', 'Hélicoptère', 300.00, 30),
('home', 'Tente basique', 0.00, 28),
('home', 'Cabane sur pilotis', 70.00, 29),
('home', 'Lodge de luxe', 200.00, 30),
('food', 'Rations de survie', 0.00, 28),
('food', 'Fruits tropicaux', 30.00, 29),
('food', 'Menu africain traditionnel', 70.00, 30),
('activity', 'Orientation en jungle', 0.00, 28),
('activity', 'Pêche traditionnelle', 30.00, 29),
('activity', 'Survie extrême', 60.00, 30),

-- Aventure en Patagonie
('transport', 'Marche en montagne', 0.00, 31),
('transport', 'Véhicule tout-terrain', 80.00, 32),
('transport', 'Hélicoptère', 300.00, 33),
('home', 'Tente basique', 0.00, 31),
('home', 'Cabane en bois', 50.00, 32),
('home', 'Lodge de luxe', 200.00, 33),
('food', 'Rations de survie', 0.00, 31),
('food', 'Poisson fumé local', 40.00, 32),
('food', 'Menu gastronomique', 80.00, 33),
('activity', 'Orientation en montagne', 0.00, 31),
('activity', 'Escalade', 50.00, 32),
('activity', 'Survie extrême', 70.00, 33),

-- Survie en Forêt Tropicale Australienne
('transport', 'Marche en forêt', 0.00, 34),
('transport', 'Bateau motorisé', 100.00, 35),
('transport', 'Hélicoptère', 300.00, 36),
('home', 'Tente basique', 0.00, 34),
('home', 'Cabane sur pilotis', 70.00, 35),
('home', 'Lodge de luxe', 200.00, 36),
('food', 'Rations de survie', 0.00, 34),
('food', 'Fruits exotiques', 30.00, 35),
('food', 'Menu australien', 70.00, 36),
('activity', 'Orientation en jungle', 0.00, 34),
('activity', 'Pêche traditionnelle', 30.00, 35),
('activity', 'Survie extrême', 60.00, 36),

-- Expédition en Antarctique
('transport', 'Marche sur glace', 0.00, 37),
('transport', 'Traîneau à chiens', 120.00, 38),
('transport', 'Hélicoptère', 300.00, 39),
('home', 'Tente basique', 0.00, 37),
('home', 'Igloo', 60.00, 38),
('home', 'Base scientifique', 200.00, 39),
('food', 'Rations de survie', 0.00, 37),
('food', 'Poisson séché', 40.00, 38),
('food', 'Menu polaire', 80.00, 39),
('activity', 'Orientation en Antarctique', 0.00, 37),
('activity', 'Exploration des glaciers', 50.00, 38),
('activity', 'Survie extrême', 70.00, 39),

-- Survie en Forêt Boréale Canadienne
('transport', 'Marche en forêt', 0.00, 40),
('transport', 'Traîneau à chiens', 120.00, 41),
('transport', 'Hélicoptère', 300.00, 42),
('home', 'Tente basique', 0.00, 40),
('home', 'Cabane en rondins', 60.00, 41),
('home', 'Lodge de luxe', 180.00, 42),
('food', 'Rations de survie', 0.00, 40),
('food', 'Poisson fumé local', 40.00, 41),
('food', 'Menu canadien traditionnel', 70.00, 42),
('activity', 'Orientation en forêt', 0.00, 40),
('activity', 'Chasse et pêche', 30.00, 41),
('activity', 'Survie extrême', 60.00, 42),

-- Aventure en Forêt Tropicale Amazonienne
('transport', 'Marche en forêt', 0.00, 43),
('transport', 'Bateau motorisé', 100.00, 44),
('transport', 'Hélicoptère', 300.00, 45),
('home', 'Tente basique', 0.00, 43),
('home', 'Cabane sur pilotis', 70.00, 44),
('home', 'Lodge de luxe', 200.00, 45),
('food', 'Rations de survie', 0.00, 43),
('food', 'Fruits tropicaux', 30.00, 44),
('food', 'Menu amazonien', 70.00, 45),
('activity', 'Orientation en jungle', 0.00, 43),
('activity', 'Pêche traditionnelle', 30.00, 44),
('activity', 'Survie extrême', 60.00, 45);
