
--  psql "<CONNECTION_STRING_RENDER>" -f db/seed_dummyjson_associations.sql
BEGIN;

--  Date de referință
INSERT INTO circumstances (name, description) VALUES
    ('Birthday',        'Birthday gifts'),
    ('Christmas',       'Christmas and winter holidays'),
    ('Valentine''s Day','Romantic gifts for Valentine''s Day'),
    ('Graduation',      'Celebrating an academic milestone'),
    ('Anniversary',     'Anniversary and couple celebrations'),
    ('Housewarming',    'Gifts for a new home')
ON CONFLICT (name) DO NOTHING;

INSERT INTO contexts (name, description) VALUES
    ('Family',       'For a family member'),
    ('Friend',       'For a friend'),
    ('Colleague',    'For a colleague'),
    ('Professional', 'Professional / business setting'),
    ('Romantic',     'For a partner')
ON CONFLICT (name) DO NOTHING;

INSERT INTO tags (name, slug) VALUES
    ('Tech',     'tech'),
    ('Beauty',   'beauty'),
    ('Fashion',  'fashion'),
    ('Home',     'home'),
    ('Luxury',   'luxury'),
    ('Sports',   'sports'),
    ('Everyday', 'everyday')
ON CONFLICT (name) DO NOTHING;


--BEAUTY: beauty, fragrances, skin-care 
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Beauty'
    WHERE c.name IN ('beauty','fragrances','skin-care')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Romantic','Family')
    WHERE c.name IN ('beauty','fragrances','skin-care')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Valentine''s Day','Birthday')
    WHERE c.name IN ('beauty','fragrances','skin-care')
ON CONFLICT DO NOTHING;

--laptops, smartphones, tablets, mobile-accessories
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Tech'
    WHERE c.name IN ('laptops','smartphones','tablets','mobile-accessories')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Professional','Colleague','Friend')
    WHERE c.name IN ('laptops','smartphones','tablets','mobile-accessories')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Birthday','Christmas','Graduation')
    WHERE c.name IN ('laptops','smartphones','tablets','mobile-accessories')
ON CONFLICT DO NOTHING;

-- watches, jewellery, sunglasses, bags 
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Luxury'
    WHERE c.name IN ('mens-watches','womens-watches','womens-jewellery','sunglasses','womens-bags')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Romantic','Professional')
    WHERE c.name IN ('mens-watches','womens-watches','womens-jewellery','sunglasses','womens-bags')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Anniversary','Valentine''s Day','Birthday')
    WHERE c.name IN ('mens-watches','womens-watches','womens-jewellery','sunglasses','womens-bags')
ON CONFLICT DO NOTHING;

-- shirts, shoes, dresses, tops 
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Fashion'
    WHERE c.name IN ('mens-shirts','mens-shoes','womens-dresses','womens-shoes','tops')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Friend','Romantic')
    WHERE c.name IN ('mens-shirts','mens-shoes','womens-dresses','womens-shoes','tops')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Birthday','Graduation')
    WHERE c.name IN ('mens-shirts','mens-shoes','womens-dresses','womens-shoes','tops')
ON CONFLICT DO NOTHING;

--  furniture, home-decoration, kitchen-accessories
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Home'
    WHERE c.name IN ('furniture','home-decoration','kitchen-accessories')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Family')
    WHERE c.name IN ('furniture','home-decoration','kitchen-accessories')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Housewarming','Christmas')
    WHERE c.name IN ('furniture','home-decoration','kitchen-accessories')
ON CONFLICT DO NOTHING;

-- sports-accessories, motorcycle, vehicle
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Sports'
    WHERE c.name IN ('sports-accessories','motorcycle','vehicle')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Friend','Family')
    WHERE c.name IN ('sports-accessories','motorcycle','vehicle')
ON CONFLICT DO NOTHING;

INSERT INTO gift_circumstances (gift_id, circumstance_id)
    SELECT g.id, s.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN circumstances s ON s.name IN ('Birthday','Graduation')
    WHERE c.name IN ('sports-accessories','motorcycle','vehicle')
ON CONFLICT DO NOTHING;

--groceries
INSERT INTO gift_tags (gift_id, tag_id)
    SELECT g.id, t.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN tags t ON t.name = 'Everyday'
    WHERE c.name IN ('groceries')
ON CONFLICT DO NOTHING;

INSERT INTO gift_contexts (gift_id, context_id)
    SELECT g.id, x.id FROM gifts g
    JOIN categories c ON g.category_id = c.id
    JOIN contexts x ON x.name IN ('Family')
    WHERE c.name IN ('groceries')
ON CONFLICT DO NOTHING;

-- Cadouri înrudite ('similar') — primele 3 din aceeași categorie

INSERT INTO gift_relations (gift_id, related_gift_id, relation_type)
    SELECT g.id, rel.id, 'similar'
    FROM gifts g
    CROSS JOIN LATERAL (
        SELECT r.id FROM gifts r
        WHERE r.category_id = g.category_id AND r.id <> g.id
        ORDER BY r.id
        LIMIT 3
    ) rel
ON CONFLICT (gift_id, related_gift_id) DO NOTHING;

COMMIT;
--   SELECT c.name, COUNT(*) FROM gifts g JOIN categories c ON g.category_id=c.id GROUP BY c.name;
--   SELECT COUNT(*) FROM gift_tags;  SELECT COUNT(*) FROM gift_circumstances;
--   SELECT COUNT(*) FROM gift_contexts;  SELECT COUNT(*) FROM gift_relations;
