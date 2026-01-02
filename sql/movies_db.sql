-- ===============================
-- Filmek adatbázis teljes létrehozása
-- ===============================

-- 1️⃣ Adatbázis létrehozása, ha nem létezik
CREATE DATABASE IF NOT EXISTS movies_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_hungarian_ci;

USE movies_db;

-- 2️⃣ Régi táblák törlése, ha újra akarjuk generálni
DROP TABLE IF EXISTS ratings;
DROP TABLE IF EXISTS movie_actors;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS actors;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS directors;
DROP TABLE IF EXISTS studios;

-- ===============================
-- 3️⃣ TÁBLÁK LÉTREHOZÁSA
-- ===============================

CREATE TABLE studios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE directors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE actors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    studio_id INT,
    director_id INT,
    category_id INT,
    rating_age VARCHAR(10),
    language VARCHAR(50),
    subtitles BOOLEAN,
    description TEXT,
    poster_url VARCHAR(255),
    trailer_url VARCHAR(255),
    avg_rating FLOAT DEFAULT 0,
    FOREIGN KEY (studio_id) REFERENCES studios(id) ON DELETE SET NULL,
    FOREIGN KEY (director_id) REFERENCES directors(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE movie_actors (
    movie_id INT,
    actor_id INT,
    PRIMARY KEY (movie_id, actor_id),
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    FOREIGN KEY (actor_id) REFERENCES actors(id) ON DELETE CASCADE
);

CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    user_name VARCHAR(100),
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);



-- ===============================
-- 4️⃣ ALAPADATOK FELTÖLTÉSE
-- ===============================

-- STUDIOS
INSERT INTO studios (name) VALUES
('Marvel Studios'),
('Walt Disney Pictures'),
('Warner Bros.'),
('Universal Pictures'),
('Paramount Pictures'),
('Pixar Animation Studios'),
('20th Century Studios'),
('Columbia Pictures'),
('Lionsgate Films'),
('DreamWorks Pictures');

-- DIRECTORS
INSERT INTO directors (name) VALUES
('Christopher Nolan'),
('Greta Gerwig'),
('Steven Spielberg'),
('James Cameron'),
('Taika Waititi'),
('Quentin Tarantino'),
('Ridley Scott'),
('Patty Jenkins'),
('Ryan Coogler'),
('Peter Jackson'),
('Denis Villeneuve'),
('Jon Favreau'),
('Wes Anderson'),
('Guy Ritchie'),
('George Miller');

-- CATEGORIES
INSERT INTO categories (name) VALUES
('Action'),
('Adventure'),
('Comedy'),
('Drama'),
('Sci-Fi'),
('Fantasy'),
('Animation'),
('Thriller');

-- ACTORS
INSERT INTO actors (name) VALUES
('Robert Downey Jr.'),
('Scarlett Johansson'),
('Chris Evans'),
('Tom Holland'),
('Emma Stone'),
('Ryan Gosling'),
('Margot Robbie'),
('Leonardo DiCaprio'),
('Anne Hathaway'),
('Zendaya'),
('Christian Bale'),
('Hugh Jackman'),
('Natalie Portman'),
('Matt Damon'),
('Benedict Cumberbatch'),
('Gal Gadot'),
('Keanu Reeves'),
('Emily Blunt'),
('Timothée Chalamet'),
('Florence Pugh');

-- MOVIES
INSERT INTO movies (title, studio_id, director_id, category_id, rating_age, language, subtitles, description, poster_url, trailer_url, avg_rating) VALUES
('Iron Man', 1, 1, 1, '12+', 'English', TRUE, 'A genius builds a powered armor to fight evil.', 'images/ironman.jpg', 'https://www.youtube.com/watch?v=8ugaeA-nMTc', 4.6),
('Barbie', 2, 2, 3, '6+', 'English', TRUE, 'Barbie explores the real world in a colorful adventure.', 'images/barbie.jpg', 'https://www.youtube.com/watch?v=pBk4NYhWNMM', 4.8),
('Inception', 3, 1, 5, '16+', 'English', TRUE, 'A thief steals secrets through dream manipulation.', 'images/inception.jpg', 'https://www.youtube.com/watch?v=YoHD9XEInc0', 4.9),
('Jurassic Park', 4, 3, 2, '12+', 'English', FALSE, 'Dinosaurs return to life in a thrilling adventure.', 'images/jurassicpark.jpg', 'https://www.youtube.com/watch?v=lc0UehYemQA', 4.7),
('Avatar', 5, 4, 5, '12+', 'English', TRUE, 'A marine becomes part of an alien tribe on Pandora.', 'images/avatar.jpg', 'https://www.youtube.com/watch?v=5PSNL1qE6VY', 4.9),
('Thor: Ragnarok', 1, 5, 1, '12+', 'English', TRUE, 'Thor faces the end of Asgard with humor and action.', 'images/thor_ragnarok.jpg', 'https://www.youtube.com/watch?v=ue80QwXMRHg', 4.5),
('Dune', 7, 11, 5, '12+', 'English', TRUE, 'A young man becomes the messiah of a desert planet.', 'images/dune.jpg', 'https://www.youtube.com/watch?v=n9xhJrPXop4', 4.8),
('The Dark Knight', 3, 1, 8, '16+', 'English', TRUE, 'Batman faces his greatest enemy, the Joker.', 'images/dark_knight.jpg', 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 5.0),
('Wonder Woman', 3, 8, 2, '12+', 'English', TRUE, 'An Amazon princess joins humanity to fight war.', 'images/wonder_woman.jpg', 'https://www.youtube.com/watch?v=1Q8fG0TtVAY', 4.4),
('Interstellar', 3, 1, 5, '12+', 'English', TRUE, 'Astronauts travel through a wormhole to save Earth.', 'images/interstellar.jpg', 'https://www.youtube.com/watch?v=zSWdZVtXT7E', 4.9),
('La La Land', 8, 13, 4, '6+', 'English', TRUE, 'A musician and an actress fall in love in LA.', 'images/lalaland.jpg', 'https://www.youtube.com/watch?v=0pdqf4P9MB8', 4.3),
('Mad Max: Fury Road', 9, 15, 1, '16+', 'English', FALSE, 'Survivors battle for freedom in a desert wasteland.', 'images/madmax.jpg', 'https://www.youtube.com/watch?v=hEJnMQG9ev8', 4.7),
('Guardians of the Galaxy', 1, 12, 2, '12+', 'English', TRUE, 'A band of misfits saves the galaxy from destruction.', 'images/gotg.jpg', 'https://www.youtube.com/watch?v=d96cjJhvlMA', 4.6),
('The Martian', 5, 7, 5, '12+', 'English', TRUE, 'An astronaut survives alone on Mars.', 'images/martian.jpg', 'https://www.youtube.com/watch?v=ej3ioOneTy8', 4.7),
('Encanto', 6, 2, 7, '6+', 'Spanish', TRUE, 'A magical family in Colombia faces a fading miracle.', 'images/encanto.jpg', 'https://www.youtube.com/watch?v=CaimKeDcudo', 4.5);

-- MOVIE_ACTORS
INSERT INTO movie_actors (movie_id, actor_id) VALUES
(1, 1), (1, 2), (1, 3),
(2, 7), (2, 5),
(3, 8), (3, 9),
(4, 8), (4, 18),
(5, 4), (5, 13),
(6, 7), (6, 16),
(7, 19), (7, 20),
(8, 11), (8, 15),
(9, 16), (9, 13),
(10, 11), (10, 14),
(11, 5), (11, 6),
(12, 17), (12, 18),
(13, 3), (13, 10),
(14, 14), (14, 9),
(15, 5), (15, 20);

-- RATINGS
INSERT INTO ratings (movie_id, user_name, rating, comment) VALUES
(1, 'Anna', 5, 'An excellent start to the MCU.'),
(1, 'Peter', 4, 'Great effects, a bit predictable.'),
(2, 'Julia', 5, 'Loved the visuals and message.'),
(3, 'Mark', 5, 'Mind-blowing concept.'),
(4, 'Laura', 4, 'Classic adventure film.'),
(5, 'Tom', 5, 'Beautiful and emotional.'),
(6, 'Chris', 4, 'Funny and action-packed.'),
(7, 'Nora', 5, 'Epic and atmospheric.'),
(8, 'Daniel', 5, 'One of the best movies ever.'),
(9, 'Anna', 4, 'Inspiring and powerful.'),
(10, 'Mia', 5, 'Visually stunning and emotional.'),
(11, 'Oliver', 4, 'Sweet and heartfelt.'),
(12, 'Kevin', 5, 'Pure chaos, pure brilliance.'),
(13, 'Sophie', 4, 'Great humor and soundtrack.'),
(14, 'Jack', 5, 'Realistic and thrilling.'),
(15, 'Ella', 4, 'Charming and magical.');
