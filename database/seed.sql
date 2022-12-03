-- database/seed.sql
--
-- Seed data for the PostgreSQL database.

with
    new_admin_user as (
        insert into users (
            first_name,
            last_name,
            email,
            password,
            is_admin
        ) values (
            'Admin',
            'Admin',
            'admin@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy',
            true
        )
        on conflict (email)
            do update
            set first_name = excluded.first_name,
                last_name = excluded.last_name,
                email = excluded.email,
                password = excluded.password,
                is_admin = excluded.is_admin
        returning id, first_name, last_name, email
    ),
    new_regular_users as (
        insert into users (
            first_name,
            last_name,
            email,
            password
        ) values (
            'Salome',
            'Promise',
            'salome.promise@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Sunday',
            'Vi',
            'sunday.vi@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Maegan',
            'Rue',
            'maegan.rue@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Oli',
            'Portia',
            'oli.portia@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Sheree',
            'Richard',
            'sheree.richard@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Lockie',
            'Cory',
            'lockie.cory@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Denton',
            'Briana',
            'denton.briana@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Alisya',
            'Kenrick',
            'alisya.kenrick@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Chrysanta',
            'Christal',
            'chrysanta.christal@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        ), (
            'Mike',
            'Catherine',
            'mike.catherine@example.com',
            -- Password12345.
            '$2y$10$zQD29V12ugZT.M6XQxrkIuPwKQh7pOqZY/NC8dTd1aQwZCF5eWeqy'
        )
        on conflict (email)
            do update
            set first_name = excluded.first_name,
                last_name = excluded.last_name,
                email = excluded.email,
                password = excluded.password
        returning id, first_name, last_name, email
    ),
    new_products as (
        insert into products (
            name,
            description,
            price,
            image_url
        ) values (
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
        )
        returning id, name, description, price, image_url
    ),
    new_carts as (
        insert into carts (
            user_id
        )
        select id as user_id
        from new_regular_users
        on conflict (user_id)
            where ordered_at is null
            do update
            set user_id = excluded.user_id
        returning id, user_id
    )

select
    (select count(id) from new_admin_user) as admin_users_count,
    (select count(id) from new_regular_users) as regular_users_count,
    (select count(id) from new_products) as products_count,
    (select count(id) from new_carts) as carts_count;
