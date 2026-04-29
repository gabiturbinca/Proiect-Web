-- Active: 1777305896303@@127.0.0.1@5432@proiect_web
CREATE IF NOT EXISTS TYPE user_role AS ENUM('admin', 'user');
CREATE IF NOT EXISTS TYPE relation_type AS ENUM('similar', 'goes_well_with', 'includes');

CREATE IF NOT EXISTS TYPE action_type AS ENUM('recommendation', 'chosen', 'purchased');

CREATE IF NOT EXISTS TYPE order_status AS ENUM('pending', 'completed', 'cancelled', 'placed');

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role user_role NOT NULL DEFAULT 'user',
    preferences_json JSONB DEFAULT '{}',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    sort_order INT DEFAULT 0 NOT NULL
);
CREATE TABLE brands (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE gifts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price NUMERIC(10, 2) NOT NULL CHECK (price >= 0),
    category_id INT REFERENCES categories(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    specifications JSONB DEFAULT '{}',
    brand_id INT REFERENCES brands(id) ON DELETE SET NULL,
    image_url VARCHAR(255),
    chosen_count INT DEFAULT 0 NOT NULL,
    score NUMERIC(3, 2) DEFAULT 0.00 NOT NULL CHECK (score >= 0 AND score <= 5)
);


CREATE TABLE tags (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    slug VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE gift_tags (
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    tag_id INT REFERENCES tags(id) ON DELETE CASCADE,
    PRIMARY KEY (gift_id, tag_id)
);

CREATE TABLE gift_relations (
    id SERIAL PRIMARY KEY,
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    related_gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    relation_type relation_type NOT NULL,
    UNIQUE (gift_id, related_gift_id)
);

CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    rating NUMERIC(3, 2) NOT NULL CHECK (rating >= 0 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE circumstances (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE contexts (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT
);


CREATE TABLE rec_log (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE SET NULL,
    gift_id INT REFERENCES gifts(id) ON DELETE SET NULL,
    context_id INT REFERENCES contexts(id) ON DELETE SET NULL,
    circumstance_id INT REFERENCES circumstances(id) ON DELETE SET NULL,
    min_budget NUMERIC(10, 2) CHECK (min_budget >= 0),
    max_budget NUMERIC(10, 2) CHECK (max_budget >= 0),
    action action_type NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE RESTRICT,
    gift_id INT REFERENCES gifts(id) ON DELETE RESTRICT,
    quantity INT NOT NULL CHECK (quantity > 0),
    total_price NUMERIC(10, 2) NOT NULL CHECK (total_price >= 0),
    status order_status NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    address VARCHAR(255) NOT NULL,
    is_anonymous BOOLEAN DEFAULT FALSE NOT NULL,
    description TEXT,
    recipient_name VARCHAR(255) 
);

CREATE TABLE wishlists (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE wishlist_items (
    id SERIAL PRIMARY KEY,
    wishlist_id INT REFERENCES wishlists(id) ON DELETE CASCADE,
    gift_id INT REFERENCES gifts(id) ON DELETE CASCADE,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    UNIQUE (wishlist_id, gift_id)
);

ALTER TABLE categories ADD COLUMN IF NOT EXISTS image_url VARCHAR(255);