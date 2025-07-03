# Product pricing service

This is a PHP 8.3-based backend service that fetches competitor pricing data from multiple sources, stores the lowest price per product, and exposes a secure REST API to retrieve pricing.

## Prerequisites
- Docker and Docker Compose
- PHP 8.3
- Composer
- PostgreSQL 13
- Make (for Makefile usage)

## Setup
1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd product-pricing-api
   ```

2. Use the Makefile to set up the project:
   ```bash
   make all
   ```
   This command builds Docker containers, starts them, installs dependencies, and runs database migrations.

## Usage
- Fetch prices manually:
  ```bash
   make fetch-prices
   ```

- Schedule periodic fetching using a cron job:
  ```bash
   * * * * * make fetch-prices
   ```

- Access the API:
  ```bash
   curl -H "X-API-Key: secure-key-123" http://localhost:8000/api/prices/123
   ```


  ```bash
   make test
   ```

## API Endpoints
- `GET /api/prices/{id}`
    - Headers: `X-API-Key: secure-key-123`
    - Response:
      ```json
      {
          "product_id": "123",
          "vendor": "ShopB",
          "price": 17.49,
          "fetched_at": "2025-06-17T14:00:00Z"
      }
      ```
      
## Running Tests
```bash
make test
```
Runs both unit and integration tests using PHPUnit with an in-memory SQLite database for integration tests.
