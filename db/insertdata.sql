-- USERS
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@giw.ro', '$2y$10$YlGZuieDMACFWxOJHGdMGefvNLbJPgMasWVg0enH5E.8GQbR6VnMC', 'admin'),
('test',  'test@giw.ro',  '$2y$10$YlGZuieDMACFWxOJHGdMGefvNLbJPgMasWVg0enH5E.8GQbR6VnMC', 'user');

-- CATEGORIES
INSERT INTO categories (name, description, sort_order) VALUES
('Flori',              'Buchete si aranjamente florale',    1),
('Parfumuri',          'Parfumuri pentru ea si el',         2),
('Jocuri Electronice', 'Jocuri video',                      3),
('Articole Casnice',   'Obiecte utile pentru casa',         4),
('Abonamente Spa',     'Relaxare si ingrijire',             5),
('Experiente',         'Activitati si aventuri',            6);

-- BRANDS
INSERT INTO brands (name) VALUES
('FloraExpress'), ('Dior'), ('Chanel'), ('Sony'), ('Nintendo'),
('IKEA'), ('Philips'), ('Therme'), ('Evolve Experience');

-- GIFTS (12 — 2 per categorie)
INSERT INTO gifts (name, description, price, category_id, brand_id, specifications) VALUES
('Buchet Trandafiri Rosii',  'Buchet de 25 trandafiri rosii',           149.99, 1, 1, '{"flower_type": "trandafiri", "color": "rosu", "quantity": 25}'),
('Buchet Lalele Colorate',   'Buchet de 30 lalele asortate',            119.99, 1, 1, '{"flower_type": "lalele", "color": "mixt", "quantity": 30}'),
('Dior Sauvage EDP',         'Parfum masculin 100ml',                   549.99, 2, 2, '{"gender": "masculin", "concentration": "EDP", "volume_ml": 100}'),
('Chanel No. 5 EDP',         'Parfum feminin iconic 100ml',             699.99, 2, 3, '{"gender": "feminin", "concentration": "EDP", "volume_ml": 100}'),
('God of War Ragnarok',      'Aventura epica PS5',                      279.99, 3, 4, '{"platform": "PS5", "genre": "Action-RPG", "pegi": 18}'),
('Mario Kart 8 Deluxe',      'Joc de curse multiplayer Switch',         249.99, 3, 5, '{"platform": "Nintendo Switch", "genre": "Racing", "pegi": 3}'),
('Lampa Smart Philips Hue',  'Bec inteligent RGB',                      199.99, 4, 7, '{"type": "iluminat", "smart": true}'),
('Pled Lana Merinos',        'Pled premium 150x200cm',                  349.99, 4, 6, '{"type": "textile", "material": "lana merinos"}'),
('Spa Day Premium',          'Zi completa: piscina, sauna, masaj',      599.99, 5, 8, '{"type": "program", "duration": "1 zi"}'),
('Masaj Cuplu 90min',        'Masaj relaxant pentru 2 persoane',         449.99, 5, 8, '{"type": "masaj", "duration_min": 90, "persons": 2}'),
('Zbor cu Balonul',          'Zbor 1 ora deasupra Transilvaniei',       699.99, 6, 9, '{"type": "aventura", "duration_min": 60}'),
('Curs de Gatit Italian',    'Curs 3 ore: paste si tiramisu',           349.99, 6, 9, '{"type": "culinar", "duration_min": 180}');

-- TAGS
INSERT INTO tags (name, slug) VALUES
('Primavara', 'primavara'), ('Vara', 'vara'), ('Toamna', 'toamna'), ('Iarna', 'iarna'),
('Romantic', 'romantic'), ('Lux', 'lux'), ('Budget-Friendly', 'budget-friendly'),
('Pentru Ea', 'pentru-ea'), ('Pentru El', 'pentru-el'), ('Unisex', 'unisex'),
('Relaxare', 'relaxare'), ('Aventura', 'aventura'), ('Gaming', 'gaming'),
('Tech', 'tech'), ('Bestseller', 'bestseller');

-- GIFT_TAGS
INSERT INTO gift_tags (gift_id, tag_id) VALUES
(1, 5), (1, 8),           -- Trandafiri: Romantic, Pentru Ea
(2, 1), (2, 7),           -- Lalele: Primavara, Budget-Friendly
(3, 9), (3, 15),          -- Sauvage: Pentru El, Bestseller
(4, 8), (4, 6),           -- Chanel: Pentru Ea, Lux
(5, 9), (5, 13),          -- GoW: Pentru El, Gaming
(6, 10), (6, 13),         -- Mario Kart: Unisex, Gaming
(7, 14), (7, 10),         -- Philips: Tech, Unisex
(8, 4), (8, 5),           -- Pled: Iarna, Romantic
(9, 11), (9, 6),          -- Spa Day: Relaxare, Lux
(10, 11), (10, 5),        -- Masaj: Relaxare, Romantic
(11, 12), (11, 6),        -- Balon: Aventura, Lux
(12, 10), (12, 7);        -- Gatit: Unisex, Budget-Friendly

-- CIRCUMSTANCES
INSERT INTO circumstances (name) VALUES
('Zi de Nastere'), ('Craciun'), ('Valentines Day'), ('Absolvire');

-- CONTEXTS
INSERT INTO contexts (name, description) VALUES
('Familial',    'Cadou pentru familie'),
('Colegial',    'Cadou pentru colegi'),
('Profesional', 'Cadou formal'),
('Romantic',    'Cadou pentru partener');

-- REVIEWS
INSERT INTO reviews (gift_id, user_id, rating, comment) VALUES
(1,  2, 4.50, 'Buchet frumos, foarte proaspat.'),
(3,  2, 5.00, 'Parfum excelent, rezistenta buna.'),
(5,  2, 4.75, 'Joc fantastic, recomand!'),
(9,  2, 4.50, 'Zi perfecta de relaxare.'),
(11, 2, 5.00, 'Experienta unica!');

-- GIFT_RELATIONS
INSERT INTO gift_relations (gift_id, related_gift_id, relation_type) VALUES
(1, 2, 'similar'),
(3, 4, 'similar'),
(5, 6, 'similar'),
(9, 10, 'goes_well_with');