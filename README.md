# Online Ordering System

## Overview

A PHP restaurant-ordering application. The repository includes customer and administration pages, order processing and history, product management, feedback handling, a QR generator, and a MySQL database export.

## Mission

Give customers a convenient way to browse restaurant offerings and submit orders, while helping staff manage products and order activity.

## Goals

- Display available restaurant items and their details.
- Support customer order submission and confirmation.
- Provide administration tools for product and availability management.
- Keep order history and feedback organized.
- Protect administrative actions and validate order data on the server.

## Technology

- PHP
- MySQL (`hotel_resto.sql`)
- HTML, CSS, and JavaScript

## Project structure

- `index.php` — customer-facing entry page
- `admin.php` — administration page
- `add_product.php`, `delete_product.php`, `toggle_status.php` — product management
- `process_order.php`, `confirm.php`, `order_history.php` — order workflow
- `login.php`, `logout.php` — access flow
- `hotel_resto.sql` — database export

## Local setup

1. Install XAMPP and start Apache and MySQL.
2. Create a database and import `hotel_resto.sql` using phpMyAdmin.
3. Configure `db.php` with local database settings. Do not commit real credentials.
4. Put the repository in `htdocs` and open it through localhost.

## Development priorities

Test order totals and state transitions, validate all submitted data on the server, and ensure only authorized staff can change product or order records.
