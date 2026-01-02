-- ===============================
-- Languages tábla létrehozása
-- ===============================
-- use movies_db;

DROP TABLE IF EXISTS languages;

CREATE TABLE IF NOT EXISTS languages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_hungarian_ci;

-- ===============================
-- Nyelvek feltöltése
-- ===============================

INSERT IGNORE INTO languages (name) VALUES
('Magyar'),
('Angol'),
('Német'),
('Francia'),
('Olasz'),
('Spanyol'),
('Portugál'),
('Román'),
('Szlovák'),
('Szerb'),
('Horvát'),
('Lengyel'),
('Cseh'),
('Orosz'),
('Ukrán'),
('Bolgár'),
('Görög'),
('Török'),
('Finn'),
('Svéd'),
('Norvég'),
('Dán'),
('Holland'),
('Izlandi'),
('Kínai'),
('Japán'),
('Koreai'),
('Hindi'),
('Arab'),
('Perzsa'),
('Héber');

-- Movies tábla nyelv mező átalakítása
ALTER TABLE movies
    CHANGE COLUMN language language_id INT;

-- Index hozzáadása
ALTER TABLE movies
    ADD INDEX (language_id);

-- Külső kulcs létrehozása
ALTER TABLE movies
    ADD CONSTRAINT fk_movies_language
    FOREIGN KEY (language_id)
    REFERENCES languages(id)
    ON UPDATE CASCADE
    ON DELETE SET NULL;

-- ===============================
-- Felirat mező átalakítása BOOLEAN típusra
ALTER TABLE movies
ADD COLUMN subtitle TINYINT(1) NOT NULL DEFAULT 0;

