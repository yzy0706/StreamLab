
-- followers table
CREATE TABLE followers (
    name VARCHAR(255),
    is_read BOOLEAN,
    created_at TIMESTAMP
);

-- subscribers table
CREATE TABLE subscribers (
    name VARCHAR(255),
    tier INT,
    is_read BOOLEAN,
    created_at TIMESTAMP
);

-- donations table
CREATE TABLE donations (
    amount FLOAT,
    currency VARCHAR(10),
    message TEXT,
    is_read BOOLEAN,
    created_at TIMESTAMP
);

-- merch_sales table
CREATE TABLE merch_sales (
    item_name VARCHAR(255),
    amount INT,
    price FLOAT,
    is_read BOOLEAN,
    created_at TIMESTAMP
);
    