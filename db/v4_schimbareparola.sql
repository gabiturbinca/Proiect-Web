ALTER TABLE users ADD COLUMN must_change_password BOOLEAN DEFAULT FALSE NOT NULL;
ALTER TABLE users ADD COLUMN password_changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL;

CREATE TYPE reset_status AS ENUM('pending', 'denied', 'accepted');
DROP TABLE password_reset_requests;
CREATE TABLE password_reset_requests (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    requested_at TIMESTAMP DEFAULT NOW(),
    status reset_status DEFAULT 'pending',
    admin_user_id INT REFERENCES users(id) NULL,
    processed_at TIMESTAMP NULL,
    message TEXT
);
