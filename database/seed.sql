-- database/seed.sql
--
-- Seed data for the MySQL database.

-- Insert a user.
INSERT INTO users (
    first_name,
    last_name,
    email,
    password
) VALUES (
    'John',
    'Doe',
    'john.doe@example.com',
    '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy' -- 'Password12345.'
);

-- Insert a few products.
INSERT INTO products (
    name,
    description,
    price,
    image_url
) VALUES (
    'Product 1',
    'Description 1',
    9.99,
    'https://via.placeholder.com/150'
), (
    'Product 2',
    'Description 2',
    19.99,
    'https://via.placeholder.com/150'
), (
    'Product 3',
    'Description 3',
    29.99,
    'https://via.placeholder.com/150'
), (
    'Product 4',
    'Description 4',
    39.99,
    'https://via.placeholder.com/150'
), (
    'Product 5',
    'Description 5',
    49.99,
    'https://via.placeholder.com/150'
), (
    'Product 6',
    'Description 6',
    59.99,
    'https://via.placeholder.com/150'
), (
    'Product 7',
    'Description 7',
    69.99,
    'https://via.placeholder.com/150'
), (
    'Product 8',
    'Description 8',
    79.99,
    'https://via.placeholder.com/150'
), (
    'Product 9',
    'Description 9',
    89.99,
    'https://via.placeholder.com/150'
), (
    'Product 10',
    'Description 10',
    99.99,
    'https://via.placeholder.com/150'
);

-- Insert a shopping cart.
INSERT INTO carts (
    user_id
)
SELECT id as user_id
FROM users
WHERE email = 'john.doe@example.com'
ON CONFLICT DO NOTHING;

-- -- Insert a few shopping cart items.
-- INSERT INTO cart_items (
    -- cart_id,
    -- product_id,
-- )
