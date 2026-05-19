-- Active: 1778671710392@@127.0.0.1@5432@proiect_web
ALTER TABLE users RENAME password TO password_hash;

CREATE TABLE gift_circumstances (
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    circumstance_id INT REFERENCES circumstances(id) ON DELETE CASCADE,
    PRIMARY KEY (gift_id, circumstance_id)
);

CREATE TABLE gift_contexts (
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    context_id INT REFERENCES contexts(id) ON DELETE CASCADE,
    PRIMARY KEY (gift_id, context_id)
);
-- GIFT_CIRCUMSTANCES
INSERT INTO gift_circumstances (gift_id, circumstance_id) VALUES
-- 1. Trandafiri Rosii (Romantic) → Valentines Day, Zi de Nastere
(1, 3), (1, 1),
-- 2. Lalele Colorate (Primavara) → Zi de Nastere, Absolvire
(2, 1), (2, 4),
-- 3. Dior Sauvage (Pentru El) → Zi de Nastere, Craciun, Valentines Day
(3, 1), (3, 2), (3, 3),
-- 4. Chanel No. 5 (Lux, Pentru Ea) → Zi de Nastere, Craciun, Valentines Day, Absolvire
(4, 1), (4, 2), (4, 3), (4, 4),
-- 5. God of War (Gaming) → Zi de Nastere, Craciun
(5, 1), (5, 2),
-- 6. Mario Kart (Gaming) → Zi de Nastere, Craciun
(6, 1), (6, 2),
-- 7. Philips Hue (Tech) → Zi de Nastere, Craciun
(7, 1), (7, 2),
-- 8. Pled Lana (Iarna) → Craciun
(8, 2),
-- 9. Spa Day (Lux) → Zi de Nastere, Craciun, Valentines Day, Absolvire
(9, 1), (9, 2), (9, 3), (9, 4),
-- 10. Masaj Cuplu (Romantic) → Valentines Day, Zi de Nastere
(10, 3), (10, 1),
-- 11. Zbor cu Balonul (Aventura) → Zi de Nastere, Absolvire
(11, 1), (11, 4),
-- 12. Curs Gatit (Unisex) → Zi de Nastere, Absolvire
(12, 1), (12, 4);


-- GIFT_CONTEXTS
INSERT INTO gift_contexts (gift_id, context_id) VALUES
-- 1. Trandafiri (Romantic) → Romantic, Familial
(1, 4), (1, 1),
-- 2. Lalele → Familial, Colegial
(2, 1), (2, 2),
-- 3. Dior Sauvage → Romantic, Familial, Profesional
(3, 4), (3, 1), (3, 3),
-- 4. Chanel No. 5 → Romantic, Familial
(4, 4), (4, 1),
-- 5. God of War → Familial, Colegial
(5, 1), (5, 2),
-- 6. Mario Kart → Familial, Colegial
(6, 1), (6, 2),
-- 7. Philips Hue → Familial, Colegial, Profesional
(7, 1), (7, 2), (7, 3),
-- 8. Pled Lana → Familial, Romantic
(8, 1), (8, 4),
-- 9. Spa Day → Familial, Romantic
(9, 1), (9, 4),
-- 10. Masaj Cuplu → Romantic
(10, 4),
-- 11. Zbor cu Balonul → Romantic, Familial
(11, 4), (11, 1),
-- 12. Curs Gatit → Romantic, Familial
(12, 4), (12, 1);


ALTER TABLE reviews ADD CONSTRAINT reviews_user_gift_unique UNIQUE (gift_id, user_id);

-- rating de la 1 la 5
ALTER TABLE reviews DROP CONSTRAINT IF EXISTS reviews_rating_check;
ALTER TABLE reviews ADD CONSTRAINT reviews_rating_check CHECK (rating >= 1 AND rating <= 5 );

ALTER TYPE order_status ADD VALUE 'shipped';
ALTER TYPE order_status ADD VALUE 'delivered';

CREATE OR REPLACE FUNCTION orders_update_timestamp()
RETURNS TRIGGER AS $$
BEGIN
    NEW.last_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER orders_set_updated
BEFORE UPDATE ON orders
FOR EACH ROW
EXECUTE FUNCTION orders_update_timestamp();