# API Endpoint Documentation - Restaurant Ordering System

## Major Resources

- Restaurants
- Categories
- Menu items
- Customers
- Orders

All responses are JSON. Path parameters are shown in braces, such as `{id}`.

## Restaurants

| Method | URI | Parameters | Purpose |
|---|---|---|---|
| GET | `/restaurants` | None | List all restaurants. |
| GET | `/restaurants/{id}` | `id`: restaurant id | Retrieve one restaurant. |
| POST | `/restaurants` | JSON body: `name`, `phone`, `street_address`, `city`, `state`, `zip_code` | Create a restaurant. |
| PUT | `/restaurants/{id}` | `id`, JSON body with updated fields | Update a restaurant. |
| DELETE | `/restaurants/{id}` | `id` | Delete a restaurant when allowed. |

Sample request:

```http
GET /restaurants/1
```

Sample response:

```json
{
  "restaurant_id": 1,
  "name": "Crimson Grill",
  "phone": "317-555-0180",
  "city": "Indianapolis",
  "state": "IN",
  "link": "/restaurants/1"
}
```

## Menu Items

| Method | URI | Parameters | Purpose |
|---|---|---|---|
| GET | `/menu-items` | Optional query: `restaurant_id`, `category_id` | List menu items. |
| GET | `/menu-items/{id}` | `id`: menu item id | Retrieve one menu item. |
| POST | `/menu-items` | JSON body: `restaurant_id`, `category_id`, `item_name`, `description`, `price`, `is_available` | Create a menu item. |
| PUT | `/menu-items/{id}` | `id`, JSON body with updated fields | Update a menu item. |
| DELETE | `/menu-items/{id}` | `id` | Delete or disable a menu item. |

Sample request:

```http
GET /menu-items?restaurant_id=1
```

Sample response:

```json
{
  "data": [
    {
      "item_id": 1,
      "item_name": "Classic Burger",
      "price": 9.99,
      "is_available": true,
      "link": "/menu-items/1"
    }
  ]
}
```

## Customers

| Method | URI | Parameters | Purpose |
|---|---|---|---|
| GET | `/customers` | None | List customers. |
| GET | `/customers/{id}` | `id`: customer id | Retrieve one customer. |
| POST | `/customers` | JSON body: `first_name`, `last_name`, `email`, `phone` | Create a customer. |
| PUT | `/customers/{id}` | `id`, JSON body with updated fields | Update customer contact information. |
| DELETE | `/customers/{id}` | `id` | Delete a customer when allowed. |

Sample request:

```http
POST /customers
```

Sample body:

```json
{
  "first_name": "Maya",
  "last_name": "Johnson",
  "email": "maya@example.com",
  "phone": "317-555-0122"
}
```

Sample response:

```json
{
  "customer_id": 6,
  "first_name": "Maya",
  "last_name": "Johnson",
  "email": "maya@example.com",
  "phone": "317-555-0122",
  "link": "/customers/6"
}
```

## Orders

| Method | URI | Parameters | Purpose |
|---|---|---|---|
| GET | `/orders` | Optional query: `customer_id`, `restaurant_id`, `status` | List orders. |
| GET | `/orders/{id}` | `id`: order id | Retrieve one order with line items. |
| POST | `/orders` | JSON body: `customer_id`, `restaurant_id`, `items` array | Create an order. |
| PUT | `/orders/{id}` | `id`, JSON body with updated `status` | Update order status. |
| DELETE | `/orders/{id}` | `id` | Cancel or remove an order when allowed. |

Sample request:

```http
POST /orders
```

Sample body:

```json
{
  "customer_id": 1,
  "restaurant_id": 1,
  "items": [
    { "item_id": 1, "quantity": 2 },
    { "item_id": 4, "quantity": 1 }
  ]
}
```

Sample response:

```json
{
  "order_id": 12,
  "customer_id": 1,
  "restaurant_id": 1,
  "status": "pending",
  "total": 24.57,
  "items": [
    { "item_id": 1, "quantity": 2 },
    { "item_id": 4, "quantity": 1 }
  ],
  "link": "/orders/12"
}
```

## Categories

| Method | URI | Parameters | Purpose |
|---|---|---|---|
| GET | `/categories` | None | List menu categories. |
| GET | `/categories/{id}` | `id`: category id | Retrieve one category. |
| POST | `/categories` | JSON body: `category_name`, `description`, `display_order` | Create a category. |
| PUT | `/categories/{id}` | `id`, JSON body with updated fields | Update a category. |
| DELETE | `/categories/{id}` | `id` | Delete a category when no menu items depend on it. |
