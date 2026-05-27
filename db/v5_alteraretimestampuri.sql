
UPDATE users SET password_changed_at = NOW();

-- 1. users
ALTER TABLE users
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

ALTER TABLE users
    ALTER COLUMN password_changed_at TYPE TIMESTAMPTZ
    USING password_changed_at AT TIME ZONE 'Europe/Bucharest';

-- 2. categories
ALTER TABLE categories
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

-- 3. gifts
ALTER TABLE gifts
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

-- 4. reviews
ALTER TABLE reviews
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

-- 5. circumstances
ALTER TABLE circumstances
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

-- 6. rec_log ("timestamp" is a reserved word — quote it)
ALTER TABLE rec_log
    ALTER COLUMN "timestamp" TYPE TIMESTAMPTZ
    USING "timestamp" AT TIME ZONE 'Europe/Bucharest';

-- 7. orders
ALTER TABLE orders
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

ALTER TABLE orders
    ALTER COLUMN last_updated TYPE TIMESTAMPTZ
    USING last_updated AT TIME ZONE 'Europe/Bucharest';

-- 8. wishlists
ALTER TABLE wishlists
    ALTER COLUMN created_at TYPE TIMESTAMPTZ
    USING created_at AT TIME ZONE 'Europe/Bucharest';

-- 9. wishlist_items
ALTER TABLE wishlist_items
    ALTER COLUMN added_at TYPE TIMESTAMPTZ
    USING added_at AT TIME ZONE 'Europe/Bucharest';

-- 10. login_attempts
ALTER TABLE login_attempts
    ALTER COLUMN attempted_at TYPE TIMESTAMPTZ
    USING attempted_at AT TIME ZONE 'Europe/Bucharest';

-- 11. password_reset_requests
ALTER TABLE password_reset_requests
    ALTER COLUMN requested_at TYPE TIMESTAMPTZ
    USING requested_at AT TIME ZONE 'Europe/Bucharest';

ALTER TABLE password_reset_requests
    ALTER COLUMN processed_at TYPE TIMESTAMPTZ
    USING processed_at AT TIME ZONE 'Europe/Bucharest';


