# Lab 1 Requirements Fulfillment

## Project Topic

The team selected a Restaurant Ordering System. The project models the API server for a restaurant ordering service that can provide restaurant, menu, customer, order, and order detail data to web or mobile clients.

## Proposal Requirement

The proposal is complete as `Restaurant Ordering System Proposal.docx`. It describes the business, the chosen topic, the real-world objects being modeled, and how those objects relate to one another.

## Database Requirement

The database file is `database/restaurant_ordering_system_db.sql`.

The schema includes six tables:

- `restaurants`
- `categories`
- `customers`
- `menu_items`
- `orders`
- `order_details`

Each table has a primary key. The tables include three or more fields each. The SQL file includes sample data for all tables.

## Independent Entities

The independent entities are:

- `restaurants`
- `categories`
- `customers`

The project also treats `menu_items` as a core business entity connected to restaurants and categories.

## Dependent Entities

The dependent entities are:

- `orders`, which depends on `customers` and `restaurants`
- `order_details`, which depends on `orders` and `menu_items`

## Many-to-Many Relationship

The many-to-many relationship is between `orders` and `menu_items`.

One order can contain many menu items. One menu item can appear in many different orders. The project implements this through `order_details`, creating two one-to-many relationships:

- One `order` has many `order_details`.
- One `menu_item` has many `order_details`.

## Sample Data Requirement

The SQL file contains at least five rows in each table:

| Table | Rows |
|---|---:|
| `restaurants` | 5 |
| `categories` | 5 |
| `customers` | 6 |
| `menu_items` | 12 |
| `orders` | 6 |
| `order_details` | 15 |

Total sample rows: 49.

This meets the requirement that every table contain at least five rows and that the database contain at least 40 total rows.

## API Documentation Requirement

The API documentation is included as `docs/api-endpoint-documentation.md` and in the shared Google Drive file named `API Endpoint Documentation`.

The documentation covers these resources:

- Restaurants
- Categories
- Menu items
- Customers
- Orders

For each resource, the documentation describes URI patterns, HTTP methods, parameters, and sample JSON requests and responses.

## Remaining Note

The project package should include an ER diagram showing the relationships among the six tables. The relationship structure is already defined in the SQL file through primary keys and foreign keys.
