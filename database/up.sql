-- database/up.sql
--
-- Up migration for the PostgreSQL database.

-- Create a table for users.
create table users (
    id serial primary key,

    first_name text not null,
    last_name text not null,
    email text not null unique,
    password text not null,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp
);

-- Create a table for products.
create table products (
    id serial primary key,

    name text not null,
    description text not null,
    price decimal(10,2) not null,
    image_url text not null,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp
);

-- Create a table for shopping carts.
create table carts (
    id serial primary key,

    user_id int not null references users,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp,

    unique (user_id)
);

-- Create a table for shopping cart items.
create table cart_items (
    id serial primary key,

    cart_id int not null references carts,
    product_id int not null references products,

    quantity int not null,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp,

    unique(cart_id, product_id)
);

-- Create a table for orders.
create table orders (
    id serial primary key,

    user_id int not null references users,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp
);

-- Create a table for order items.
create table order_items (
    id serial primary key,

    order_id int not null references orders,
    product_id int not null references products,

    quantity int not null,

    created_at timestamp with time zone default current_timestamp,
    updated_at timestamp with time zone default current_timestamp,

    unique(order_id, product_id)
);
