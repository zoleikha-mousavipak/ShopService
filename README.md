# Symfony Product Service HTTP API

This repository contains a Symfony-based HTTP API for managing user purchases of products. The API allows users to retrieve their purchased products, create new purchases, and delete existing purchases. The authentication method used in this API is JWT (JSON Web Token).

## Getting Started

- Starter Commands:

    - docker-compose up -d
    - composer update

- App commands for data import:

    - php bin/console app:import-products
    - php bin/console app:import-purchases
    - php bin/console app:import-users


## Endpoints

**Create a Token**

- Endpoint: POST /api/login_check

- This endpoint allows to authenticate and obtain a JWT token, with the user credentials.

- Example Request Body:
{
  "username": "mac94@moen.com",
  "password": "secret"
}

- Output: 
{
  "token": "your_generated_jwt_token"
}

**Retrieve Purchased Products**

- Endpoint: GET /api/user/products

- This endpoint retrieves the list of products purchased by the authenticated user.

**Create a Purchase**

- Endpoint: POST /api/user/products

- This endpoint allows the user to create a new purchase by providing the product_id in the request payload.

- Example Request Body:
{
  "product_id": 123
}

**Delete a Purchase**

- Endpoint: DELETE /api/user/products/{sku}

- This endpoint deletes a purchase identified by its SKU.


## Unit Test

To demonstrate how the various API endpoints behave, a PHPUnit test has been provided. Run the test with:

- ./vendor/bin/phpunit