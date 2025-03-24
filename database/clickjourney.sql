CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    un_id VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'vip') NOT NULL DEFAULT 'user',
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
    climate ENUM('arid-desert', 'lush-jungle', 'dense-forest', 'polar-regions', 'rugged-mountains', 'volcanic-terrain', 'open-savannah', 'boreal-forest') NOT NULL,
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
    payement_status ENUM('pending','declined', 'paid') NOT NULL DEFAULT 'pending',
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
('Aventure en Forêt Tropicale Amazonienne', 'Plongez dans la forêt amazonienne et apprenez à survivre dans un environnement tropical dense.', '2026-04-05', '2026-04-12', 7, 1500.00, 6, 2, 'advanced', 'wilderness-survival', 'Amazonie, Brésil', 'lush-jungle', 4.7),
('Aventure dans le Désert Tunisien', 'Explorez les dunes du désert tunisien et apprenez à survivre dans un environnement aride.', '2025-11-01', '2025-11-08', 7, 1200.00, 5, 2, 'beginner', 'survival-training', 'Désert Tunisien, Tunisie', 'arid-desert', 4.3),
('Aventure dans les Alpes Suisses', 'Explorez les montagnes suisses et apprenez à survivre dans un environnement alpin.', '2025-06-15', '2025-06-22', 7, 1800.00, 6, 2, 'intermediate', 'survival-training', 'Alpes Suisses, Suisse', 'rugged-mountains', 4.8),
('Expédition au Désert de Gobi', 'Découvrez les vastes étendues du désert de Gobi et apprenez à survivre dans un environnement aride.', '2025-09-10', '2025-09-17', 7, 1400.00, 5, 2, 'beginner', 'wilderness-survival', 'Désert de Gobi, Mongolie', 'arid-desert', 4.5);

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
(3, 3, 'Défi final : Oasis cachée', 2, '23.5500,13.6500', 'Oasis du Sahara');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
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
(6, 3, 'Défi final : Nuit près du cratère', 2, '19.4300,-155.3000', 'Cratère volcanique');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
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
(9, 3, 'Défi final : Nuit au fond du canyon', 2, '36.1200,-112.1300', 'Plateau du canyon');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES

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
(12, 3, 'Défi final : Nuit en forêt profonde', 2, '-16.9400,145.7900', 'Cœur de la forêt tropicale');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
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

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
(16, 1, 'Arrivée dans le désert', 1, '33.8815,9.5616', 'Douz - Porte du désert'),
(16, 2, 'Traversée des dunes', 3, '33.9200,9.5500', 'Dunes de l’Erg Oriental'),
(16, 3, 'Défi final : Nuit sous les étoiles', 3, '33.9500,9.5700', 'Campement isolé dans le désert');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
(17, 1, 'Randonnée alpine', 3, '46.8182,8.2275', 'Sentiers des Alpes Suisses'),
(17, 2, 'Campement en montagne', 4, '46.8500,8.3000', 'Campement au sommet');

INSERT INTO stages (trip_id, order_index, title, duration, gps_position, location)
VALUES
(18, 1, 'Exploration des dunes', 3, '42.5000,105.0000', 'Dunes de Khongoryn Els'),
(18, 2, 'Campement sous les étoiles', 4, '42.6000,105.1000', 'Campement isolé dans le désert');



-- Ajout des options pour chaque étape
INSERT INTO options (options_type, title, price, stage_id)
VALUES
-- Expédition Jungle Extrême
('transport', 'Marche en forêt', 0.00, 1),
('transport', 'Vélo', 10.00, 1),
('transport', 'Bateau motorisé', 50.00, 1),
('home', 'Tente basique', 0.00, 1),
('home', 'Cabane en bois', 30.00, 1),
('food', 'Rations de survie', 0.00, 1),
('food', 'Fruits locaux', 20.00, 1),
('food', 'Repas complet', 50.00, 1);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche en jungle', 0.00, 2),
('transport', 'Rafting', 40.00, 2),
('transport', 'Hélicoptère', 200.00, 2),
('home', 'Tente légère', 0.00, 2),
('home', 'Bungalow en bois', 50.00, 2),
('food', 'Noix et baies sauvages', 0.00, 2),
('food', 'Cuisine locale', 30.00, 2),
('food', 'Buffet gastronomique', 70.00, 2);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Trek dans la jungle', 0.00, 3),
('transport', 'Canoë', 60.00, 3),
('transport', 'Jet privé', 500.00, 3),
('home', 'Campement rustique', 0.00, 3),
('home', 'Lodge en bambou', 70.00, 3),
('home', 'Resort de luxe', 150.00, 3),
('food', 'Riz et légumineuses', 0.00, 3),
('food', 'Plat typique', 40.00, 3);


-- Évasion en Montagne
INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Randonnée', 0.00, 4),
('transport', 'Vélo de montagne', 30.00, 4),
('transport', 'Téléphérique', 80.00, 4),
('home', 'Tente alpine', 0.00, 4),
('home', 'Chalet rustique', 60.00, 4),
('home', 'Lodge 5 étoiles', 200.00, 4),
('food', 'Rations lyophilisées', 0.00, 4),
('food', 'Fromage et charcuterie', 40.00, 4);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Escalade', 0.00, 5),
('transport', 'Quad', 50.00, 5),
('transport', 'Hélicoptère', 250.00, 5),
('home', 'Tente avancée', 0.00, 5),
('home', 'Refuge en pierre', 80.00, 5),
('home', 'Chalet haut de gamme', 220.00, 5),
('food', 'Soupes et pain', 0.00, 5),
('food', 'Grillades', 50.00, 5),
('food', 'Dîner montagnard', 110.00, 5);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Ski de randonnée', 0.00, 6),
('transport', 'Motoneige', 100.00, 6),
('transport', 'Jet privé', 600.00, 6),
('home', 'Cabane isolée', 0.00, 6),
('home', 'Gîte panoramique', 90.00, 6),
('food', 'Céréales et fruits secs', 0.00, 6),
('food', 'Plat montagnard', 60.00, 6),
('food', 'Haute gastronomie', 130.00, 6);

-- Survie Désertique

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche dans le désert', 0.00, 7),
('transport', 'Dromadaire', 50.00, 7),
('transport', '4x4 tout-terrain', 150.00, 7),
('home', 'Bivouac sous les étoiles', 0.00, 7),
('home', 'Tente nomade', 40.00, 7),
('home', 'Lodge climatisé', 120.00, 7),
('food', 'Dattes et eau', 0.00, 7);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche de nuit', 0.00, 8),
('transport', 'Quad des sables', 70.00, 8),
('transport', 'Montgolfière', 200.00, 8),
('home', 'Couchage sur le sable', 0.00, 8),
('home', 'Campement berbère', 60.00, 8),
('home', 'Hôtel troglodyte', 150.00, 8),
('food', 'Pain et olives', 0.00, 8),
('food', 'Tagine traditionnel', 50.00, 8),
('food', 'Buffet royal', 100.00, 8);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée matinale', 0.00, 9),
('transport', 'Buggy', 90.00, 9),
('transport', 'Jet privé', 500.00, 9),
('home', 'Abri de fortune', 0.00, 9),
('home', 'Caravansérail', 80.00, 9),
('home', 'Palais saharien', 200.00, 9),
('food', 'Légumes secs et eau', 0.00, 9),
('food', 'Couscous berbère', 60.00, 9),
('food', 'Festin d’émir', 150.00, 9);

-- Jungle de Bornéo

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche en forêt tropicale', 0.00, 10),
('transport', 'Pirogue', 40.00, 10),
('transport', 'Hydravion', 300.00, 10),
('home', 'Hamac sous abri', 0.00, 10),
('home', 'Cabane perchée', 50.00, 10),
('home', 'Ecolodge de luxe', 180.00, 10),
('food', 'Fruits et noix', 0.00, 10),
('food', 'Poisson grillé', 40.00, 10),
('food', 'Dîner gourmet', 120.00, 10);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Trek en montagne', 0.00, 11),
('transport', 'Tyrolienne', 60.00, 11),
('transport', 'Hélicoptère', 400.00, 11),
('home', 'Abri de bambou', 0.00, 11),
('home', 'Lodge en bois', 70.00, 11),
('home', 'Resort 5 étoiles', 250.00, 11),
('food', 'Légumes et racines', 0.00, 11),
('food', 'Viande sauvage', 60.00, 11),
('food', 'Buffet tropical', 150.00, 11);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Expédition guidée', 0.00, 12),
('transport', 'Bateau rapide', 80.00, 12),
('home', 'Campement minimaliste', 0.00, 12),
('home', 'Huttes traditionnelles', 90.00, 12),
('home', 'Villa tropicale', 300.00, 12),
('food', 'Riz et noix de coco', 0.00, 12),
('food', 'Curry local', 70.00, 12),
('food', 'Menu gastronomique', 180.00, 12);


-- Survie en Sibérie

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche dans la neige', 0.00, 13),
('transport', 'Chiens de traîneau', 80.00, 13),
('transport', 'Motoneige', 200.00, 13),
('home', 'Igloo improvisé', 0.00, 13),
('home', 'Cabane en rondins', 60.00, 13),
('home', 'Refuge chauffé', 150.00, 13),
('food', 'Baies et eau fondue', 0.00, 13),
('food', 'Soupe de poisson', 40.00, 13),
('food', 'Ragoût de renne', 100.00, 13);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Ski de randonnée', 0.00, 14),
('transport', 'Raquettes à neige', 50.00, 14),
('transport', 'Hélicoptère', 400.00, 14),
('home', 'Tente de survie', 0.00, 14),
('home', 'Chalet de trappeur', 80.00, 14),
('home', 'Hôtel de glace', 200.00, 14),
('food', 'Pain sec et thé chaud', 0.00, 14),
('food', 'Poisson fumé', 50.00, 14),
('food', 'Dîner nordique', 120.00, 14);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Piste glacée à pied', 0.00, 15),
('transport', 'Moto sur glace', 100.00, 15),
('transport', 'Jet privé', 600.00, 15),
('home', 'Sous un abri de fortune', 0.00, 15),
('home', 'Cabane rustique', 100.00, 15),
('home', 'Lodge de luxe', 250.00, 15),
('food', 'Lichen et baies', 0.00, 15),
('food', 'Viande séchée', 60.00, 15),
('food', 'Festin boréal', 150.00, 15);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

-- Défi du Volcan

('transport', 'Ascension à pied', 0.00, 16),
('transport', 'Escalade avec guide', 60.00, 16),
('transport', 'Hélicoptère', 350.00, 16),
('home', 'Bivouac rocheux', 0.00, 16),
('home', 'Cabane de volcanologue', 70.00, 16),
('home', 'Refuge panoramique', 180.00, 16),
('food', 'Fruits et eau', 0.00, 16),
('food', 'Soupe volcanique', 50.00, 16),
('food', 'Repas de chef', 120.00, 16);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée sur cratère', 0.00, 17),
('transport', 'VTT de montagne', 80.00, 17),
('transport', 'Parapente', 300.00, 17),
('home', 'Sous un surplomb rocheux', 0.00, 17),
('home', 'Tente sécurisée', 90.00, 17),
('home', 'Lodge en hauteur', 200.00, 17),
('food', 'Biscuits et thé', 0.00, 17),
('food', 'Plat local épicé', 60.00, 17),
('food', 'Dîner volcanique', 140.00, 17);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Descente en trek', 0.00, 18),
('transport', 'Tyrolienne géante', 100.00, 18),
('transport', 'Jet privé', 500.00, 18),
('home', 'Campement minimaliste', 0.00, 18),
('home', 'Hôtel en pierre de lave', 120.00, 18),
('home', 'Suite panoramique', 300.00, 18),
('food', 'Pain et eau', 0.00, 18),
('food', 'Grillade sur pierre chaude', 70.00, 18);

-- Aventure au Serengeti

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Safari à pied', 0.00, 19),
('transport', '4x4 tout-terrain', 100.00, 19),
('transport', 'Montgolfière', 400.00, 19),
('home', 'Bivouac sous les étoiles', 0.00, 19),
('home', 'Tente safari', 80.00, 19),
('home', 'Lodge de luxe', 250.00, 19),
('food', 'Fruits sauvages et eau', 0.00, 19),
('food', 'Viande séchée', 60.00, 19),
('food', 'Repas traditionnel masaï', 140.00, 19);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche dans la savane', 0.00, 20),
('transport', 'Quad safari', 120.00, 20),
('transport', 'Hélicoptère', 500.00, 20),
('home', 'Couchage à la belle étoile', 0.00, 20),
('home', 'Cabane perchée', 90.00, 20),
('home', 'Villa avec vue', 300.00, 20),
('food', 'Noix et miel', 0.00, 20),
('food', 'Barbecue masaï', 80.00, 20);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour à dos d’âne', 0.00, 21),
('transport', 'Moto tout-terrain', 150.00, 21),
('transport', 'Jet privé', 600.00, 21),
('home', 'Hamac suspendu', 0.00, 21),
('home', 'Bungalow en bois', 110.00, 21),
('home', 'Suite safari VIP', 350.00, 21),
('food', 'Galettes et eau', 0.00, 21),
('food', 'Plat de gibier', 90.00, 21),
('food', 'Dîner étoilé', 200.00, 21);

-- Survie en Finlande
INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche en raquettes', 0.00, 22),
('transport', 'Ski nordique', 90.00, 22),
('transport', 'Motoneige', 250.00, 22),
('home', 'Abri sous neige', 0.00, 22),
('home', 'Chalet de trappeur', 100.00, 22),
('home', 'Igloo tout confort', 280.00, 22),
('food', 'Baies et eau fondue', 0.00, 22),
('food', 'Soupe de champignons', 50.00, 22),
('food', 'Festin finlandais', 150.00, 22);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée en forêt', 0.00, 23),
('transport', 'Traîneau à chiens', 120.00, 23),
('transport', 'Hélicoptère', 450.00, 23),
('home', 'Couchage en pleine nature', 0.00, 23),
('home', 'Cabane en bois', 130.00, 23),
('home', 'Auberge typique', 320.00, 23),
('food', 'Pain sec et eau', 0.00, 23),
('food', 'Saumon fumé', 80.00, 23),
('food', 'Buffet nordique', 180.00, 23);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Piste glacée à pied', 0.00, 24),
('transport', 'Ski alpin', 140.00, 24),
('transport', 'Jet privé', 650.00, 24),
('home', 'Sous un abri de fortune', 0.00, 24),
('home', 'Gîte de montagne', 150.00, 24),
('food', 'Racines et eau', 0.00, 24),
('food', 'Plat de rennes', 100.00, 24),
('food', 'Dîner gourmet', 220.00, 24);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

-- Exploration du Grand Canyon

('transport', 'Randonnée pédestre', 0.00, 25),
('transport', 'Cheval', 100.00, 25),
('transport', 'Hélicoptère', 350.00, 25),
('home', 'Bivouac sous les étoiles', 0.00, 25),
('home', 'Tente de camping', 90.00, 25),
('home', 'Lodge avec vue', 280.00, 25),
('food', 'Fruits secs et eau', 0.00, 25),
('food', 'Barbecue au feu de bois', 70.00, 25),
('food', 'Dîner gourmet', 180.00, 25);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Descente en canyoning', 0.00, 26),
('transport', 'Rafting', 120.00, 26),
('transport', 'Montgolfière', 400.00, 26),
('home', 'Couchage à la belle étoile', 0.00, 26),
('home', 'Tente suspendue', 110.00, 26),
('home', 'Suite troglodyte', 300.00, 26),
('food', 'Pain et eau', 0.00, 26),
('food', 'Viande séchée et légumes', 90.00, 26),
('food', 'Buffet gastronomique', 200.00, 26);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en randonnée', 0.00, 27),
('transport', 'Quad', 140.00, 27),
('home', 'Campement rudimentaire', 0.00, 27),
('home', 'Bungalow', 130.00, 27),
('home', 'Hôtel de luxe', 350.00, 27),
('food', 'Galette et eau', 0.00, 27),
('food', 'Plat traditionnel du désert', 110.00, 27),
('food', 'Dîner étoilé', 220.00, 27);

-- Jungle du Congo

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche dans la jungle', 0.00, 28),
('transport', 'Pirogue', 110.00, 28),
('transport', 'Hélicoptère', 400.00, 28),
('home', 'Hamac entre deux arbres', 0.00, 28),
('home', 'Cabane en bois', 100.00, 28),
('home', 'Lodge écologique', 280.00, 28),
('food', 'Fruits sauvages et eau', 0.00, 28),
('food', 'Poisson grillé', 70.00, 28),
('food', 'Repas de chef', 190.00, 28);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Traversée en radeau', 0.00, 29),
('transport', 'Tyrolienne', 130.00, 29),
('transport', 'Hydravion', 450.00, 29),
('home', 'Abri de fortune', 0.00, 29),
('home', 'Tente sur pilotis', 120.00, 29),
('home', 'Villa tropicale', 310.00, 29),
('food', 'Noix de coco et eau', 0.00, 29),
('food', 'Viande fumée', 90.00, 29),
('food', 'Buffet exotique', 210.00, 29);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en pirogue', 0.00, 30),
('transport', '4x4 tout-terrain', 150.00, 30),
('transport', 'Jet privé', 600.00, 30),
('home', 'Tente improvisée', 0.00, 30),
('home', 'Cabane avec moustiquaire', 140.00, 30),
('food', 'Légumes grillés et eau', 0.00, 30),
('food', 'Plat de gibier local', 110.00, 30);


-- Aventure en Patagonie

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée glaciaire', 0.00, 31),
('transport', 'Kayak', 120.00, 31),
('transport', 'Hélicoptère', 450.00, 31),
('home', 'Bivouac sous tente', 0.00, 31),
('home', 'Refuge de montagne', 110.00, 31),
('home', 'Chalet de luxe', 300.00, 31),
('food', 'Ration de survie', 0.00, 31),
('food', 'Grillades de mouton', 90.00, 31),
('food', 'Dîner gourmet andin', 200.00, 31);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Trek sur les sommets', 0.00, 32),
('transport', 'Escalade', 130.00, 32),
('transport', 'Survol en montgolfière', 480.00, 32),
('home', 'Campement sur glacier', 0.00, 32),
('home', 'Tente chauffée', 130.00, 32),
('home', 'Vue panoramique', 320.00, 32),
('food', 'Baies sauvages et eau', 0.00, 32),
('food', 'Poisson grillé', 100.00, 32);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour à cheval', 0.00, 33),
('transport', '4x4 tout-terrain', 160.00, 33),
('transport', 'Jet privé', 600.00, 33),
('home', 'Tente de fortune', 0.00, 33),
('home', 'Cabane en bois', 140.00, 33),
('home', 'Hôtel de montagne 5 étoiles', 350.00, 33),
('food', 'Pain et fromage local', 0.00, 33),
('food', 'Ragoût de bœuf argentin', 120.00, 33),
('food', 'Dîner raffiné', 250.00, 33);

-- Survie en Forêt Tropicale Australienne

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche dans la jungle', 0.00, 34),
('transport', 'Canoë sur la rivière', 110.00, 34),
('transport', 'Hélicoptère', 420.00, 34),
('home', 'Hamac entre les lianes', 0.00, 34),
('home', 'Cabane perchée', 120.00, 34),
('home', 'Lodge écologique', 290.00, 34),
('food', 'Baies et insectes', 0.00, 34),
('food', 'Poisson grillé', 80.00, 34),
('food', 'Festin exotique', 190.00, 34);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Exploration en spéléologie', 0.00, 35),
('transport', 'Tyrolienne à travers la canopée', 140.00, 35),
('transport', 'Hydravion', 460.00, 35),
('home', 'Abri de fortune', 0.00, 35),
('home', 'Tente sur pilotis', 130.00, 35),
('food', 'Noix de coco et eau', 0.00, 35),
('food', 'Viande fumée', 90.00, 35),
('food', 'Buffet sauvage', 210.00, 35);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en radeau', 0.00, 36),
('transport', 'Quad à travers la jungle', 170.00, 36),
('transport', 'Jet privé', 620.00, 36),
('home', 'Tente improvisée', 0.00, 36),
('home', 'Bungalow en bois', 140.00, 36),
('home', 'Hôtel tropical 5 étoiles', 380.00, 36),
('food', 'Légumes grillés et eau', 0.00, 36),
('food', 'Viande de brousse', 110.00, 36);


-- Expédition en Antarctique

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche sur la banquise', 0.00, 37),
('transport', 'Traîneau à chiens', 150.00, 37),
('transport', 'Hélicoptère', 500.00, 37),
('home', 'Igloo de fortune', 0.00, 37),
('home', 'Base de recherche', 140.00, 37),
('home', 'Campement de luxe chauffé', 350.00, 37),
('food', 'Ration militaire', 0.00, 37),
('food', 'Poisson des glaces', 100.00, 37),
('food', 'Dîner polaire gourmet', 250.00, 37);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Exploration en motoneige', 0.00, 38),
('transport', 'Ski de fond', 120.00, 38),
('transport', 'Sous-marin sous la glace', 550.00, 38),
('home', 'Abri dans la neige', 0.00, 38),
('home', 'Refuge en bois', 150.00, 38),
('home', 'Station polaire privée', 400.00, 38),
('food', 'Soupe chaude et pain', 0.00, 38),
('food', 'Viande séchée et légumes', 110.00, 38),
('food', 'Buffet polaire', 270.00, 38);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en brise-glace', 0.00, 39),
('transport', 'Hélicoptère d’évacuation', 180.00, 39),
('transport', 'Jet privé', 650.00, 39),
('home', 'Caverne glacée', 0.00, 39),
('home', 'Cabane isolée', 160.00, 39),
('home', 'Hôtel igloo de luxe', 420.00, 39),
('food', 'Galettes de survie', 0.00, 39),
('food', 'Ragoût de gibier', 130.00, 39);

-- Survie en Forêt Boréale Canadienne

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée en raquettes', 0.00, 40),
('transport', 'Canoë sur la rivière gelée', 130.00, 40),
('transport', 'Hélicoptère', 480.00, 40),
('home', 'Abri sous les branches', 0.00, 40),
('home', 'Cabane rustique', 130.00, 40),
('home', 'Chalet en bois rond', 300.00, 40),
('food', 'Noix et baies sauvages', 0.00, 40),
('food', 'Truite grillée', 90.00, 40),
('food', 'Banquet de gibier', 220.00, 40);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Exploration en traîneau à chiens', 0.00, 41),
('transport', 'VTT sur sentiers enneigés', 150.00, 41),
('transport', 'Montgolfière panoramique', 500.00, 41),
('home', 'Igloo de fortune', 0.00, 41),
('home', 'Tente chauffée', 140.00, 41),
('home', 'Lodge 5 étoiles', 350.00, 41),
('food', 'Écorce de bouleau et eau', 0.00, 41),
('food', 'Viande fumée', 100.00, 41),
('food', 'Dîner forestier gourmet', 240.00, 41);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en raquettes', 0.00, 42),
('transport', 'Motoneige', 180.00, 42),
('transport', 'Avion privé', 600.00, 42),
('home', 'Abri sous les rochers', 0.00, 42),
('home', 'Cabane en rondins', 150.00, 42),
('home', 'Hôtel en pleine nature', 400.00, 42),
('food', 'Fruits secs et eau', 0.00, 42),
('food', 'Soupe de gibier', 120.00, 42),
('food', 'Dîner gastronomique canadien', 270.00, 42);


-- Aventure en Forêt Tropicale Amazonienne

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Randonnée dans la jungle', 0.00, 43),
('transport', 'Canoë sur l’Amazone', 140.00, 43),
('transport', 'Hélicoptère au-dessus de la canopée', 500.00, 43),
('home', 'Hamac entre deux arbres', 0.00, 43),
('home', 'Cabane sur pilotis', 130.00, 43),
('home', 'Lodge de luxe dans la jungle', 320.00, 43),
('food', 'Fruits et noix sauvages', 0.00, 43),
('food', 'Poisson grillé à la feuille de bananier', 110.00, 43),
('food', 'Buffet exotique de la forêt', 250.00, 43);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Marche sur les sentiers indigènes', 0.00, 44),
('transport', 'Tyrolienne au-dessus de la forêt', 160.00, 44),
('transport', 'Montgolfière sur la jungle', 520.00, 44),
('home', 'Abri en branches', 0.00, 44),
('home', 'Tente imperméable', 140.00, 44),
('home', 'Villa écologique en pleine nature', 350.00, 44),
('food', 'Racines et eau de pluie', 0.00, 44),
('food', 'Viande de chasse locale', 120.00, 44),
('food', 'Dîner gastronomique amazonien', 260.00, 44);

INSERT INTO options (options_type, title, price, stage_id)
VALUES

('transport', 'Retour en pirogue', 0.00, 45),
('transport', 'Bateau rapide sur l’Amazone', 180.00, 45),
('transport', 'Jet privé', 600.00, 45),
('home', 'Refuge sous une falaise', 0.00, 45),
('home', 'Cabane sur un arbre géant', 150.00, 45),
('home', 'Éco-hôtel avec vue sur la rivière', 400.00, 45),
('food', 'Baies et insectes', 0.00, 45),
('food', 'Soupe de jungle et manioc', 130.00, 45),
('food', 'Festin traditionnel des tribus locales', 280.00, 45);


INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche dans le désert', 0.00, 46),
('transport', 'Dromadaire', 50.00, 46),
('transport', '4x4 tout-terrain', 150.00, 46),
('home', 'Bivouac sous les étoiles', 0.00, 46),
('home', 'Tente nomade', 40.00, 46),
('food', 'Manger du Zgougou', 0.00, 46),
('food', 'Mloukhia extreme', 20.00, 46),
('food', 'Défis Harissa', 20.00, 46);


INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche de nuit', 0.00, 47),
('transport', 'Quad des sables', 70.00, 47),
('transport', 'Montgolfière', 200.00, 47),
('home', 'Couchage sur le sable', 0.00, 47),
('home', 'Campement berbère', 60.00, 47),
('food', 'Zgougou et chapati', 0.00, 47),
('food', 'Tagine tunisien (quiche)', 50.00, 47),
('food', 'Buffet royal', 100.00, 47);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Randonnée matinale', 0.00, 48),
('transport', 'Buggy', 90.00, 48),
('transport', 'Jet privé', 500.00, 48),
('home', 'Abri de fortune', 0.00, 48),
('home', 'Caravane', 80.00, 48),
('food', 'Bsissa royale', 0.00, 48),
('food', 'Couscous poisson', 60.00, 48);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche dans le désert', 0.00, 49),
('transport', 'Dromadaire', 50.00, 49),
('transport', '4x4 tout-terrain', 150.00, 49),
('home', 'Bivouac sous les étoiles', 0.00, 49),
('food', 'Dattes et eau', 0.00, 49),
('food', 'Ragoût de chèvre', 30.00, 49);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Randonnée en forêt', 0.00, 50),
('transport', 'VTT', 20.00, 50),
('home', 'Tente de camping', 0.00, 50),
('food', 'Baies et eau', 0.00, 50),
('food', 'Soupe de champignons', 20.00, 50);

INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Marche sur les plages', 0.00, 51),
('transport', 'Kayak', 30.00, 51),
('home', 'Tente sur la plage', 0.00, 51),
('home', 'Cabane en bois', 50.00, 51),
('food', 'Fruits tropicaux', 0.00, 51),
('food', 'Poisson grillé', 40.00, 51);


INSERT INTO options (options_type, title, price, stage_id)
VALUES
('transport', 'Randonnée alpine', 0.00, 52),
('transport', 'Vélo de montagne', 30.00, 52),
('home', 'Tente alpine', 0.00, 52),
('home', 'Chalet rustique', 60.00, 52),
('food', 'Rations lyophilisées', 0.00, 52),
('food', 'Fromage et charcuterie', 40.00, 52);