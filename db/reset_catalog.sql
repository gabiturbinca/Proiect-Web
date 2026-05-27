
--  psql "<CONNECTION_STRING_RENDER>" -f db/reset_catalog.sql
BEGIN;

-- recomandări
DELETE FROM rec_log;

-- Comenzi
DELETE FROM orders;

--Cadouri
DELETE FROM gifts;

-- Tabelele de referință 
DELETE FROM categories;
DELETE FROM tags;
DELETE FROM circumstances;
DELETE FROM contexts;

-- ALTER SEQUENCE gifts_id_seq        RESTART WITH 1;
-- ALTER SEQUENCE categories_id_seq   RESTART WITH 1;
-- ALTER SEQUENCE tags_id_seq         RESTART WITH 1;
-- ALTER SEQUENCE circumstances_id_seq RESTART WITH 1;
-- ALTER SEQUENCE contexts_id_seq     RESTART WITH 1;
-- ALTER SEQUENCE orders_id_seq       RESTART WITH 1;
-- ALTER SEQUENCE rec_log_id_seq      RESTART WITH 1;

COMMIT;
