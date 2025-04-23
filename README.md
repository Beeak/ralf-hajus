# Ralf Hajusrakendused

## Lingid

#######

## Table of Contents

-   [Installation](#installation)
-   [API Routes](#api-routes)
    -   [Authentication API](#authentication-api)
    -   [Aircraft API](#aircraft-api)
-   [Web Routes](#web-routes)
    -   [Authentication](#authentication)
    -   [User Profile](#user-profile)
    -   [Weather](#weather)
    -   [Map Markers](#map-markers)
    -   [Blog System](#blog-system)
    -   [Shop System](#shop-system)
    -   [Aircraft Web Interface](#aircraft-web-interface)

## Installation

```bash
# Clone the repository
git clone [repository-url]

# Navigate to the project directory
cd ralf-hajus

# Install dependencies
composer install
npm install

# Copy environment file and configure your database
cp .env.example .env
php artisan key:generate

# Run migrations and seed the database
php artisan migrate --seed

# Compile assets
npm run dev

# Start the server
php artisan serve
```

## API Routes

The API uses token-based authentication with Laravel Sanctum and includes rate limiting to prevent abuse.

### Authentication API

| Method | URI           | Action                  | Middleware                 |
| ------ | ------------- | ----------------------- | -------------------------- |
| POST   | /api/login    | AuthController@login    | throttle:4,1               |
| POST   | /api/register | AuthController@register | throttle:4,1               |
| POST   | /api/logout   | AuthController@logout   | auth:sanctum, throttle:4,1 |
| GET    | /api/user     | AuthController@user     | auth:sanctum, throttle:4,1 |

#### Authentication Examples

```bash
# Register a new user
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{"name":"User","email":"user@example.com","password":"password","password_confirmation":"password"}'

# Login to get bearer token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Use the token to access protected routes
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer {your_token}"

# Logout
curl -X POST http://localhost:8000/api/logout \
  -H "Authorization: Bearer {your_token}"
```

### Aircraft API

All aircraft endpoints require authentication except where noted.

| Method | URI                | Action                     | Middleware                 |
| ------ | ------------------ | -------------------------- | -------------------------- |
| GET    | /api/aircraft      | AircraftController@index   | auth:sanctum, throttle:4,1 |
| POST   | /api/aircraft      | AircraftController@store   | auth:sanctum, throttle:4,1 |
| GET    | /api/aircraft/{id} | AircraftController@show    | auth:sanctum, throttle:4,1 |
| PUT    | /api/aircraft/{id} | AircraftController@update  | auth:sanctum, throttle:4,1 |
| DELETE | /api/aircraft/{id} | AircraftController@destroy | auth:sanctum, throttle:4,1 |

#### Aircraft API Examples

```bash
# Get all aircraft (requires authentication)
curl -X GET http://localhost:8000/api/aircraft \
  -H "Authorization: Bearer {your_token}"

# Get a specific aircraft
curl -X GET http://localhost:8000/api/aircraft/1 \
  -H "Authorization: Bearer {your_token}"

# Create a new aircraft
curl -X POST http://localhost:8000/api/aircraft \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{"title":"Boeing 747","description":"Passenger aircraft","type":"Civilian","aircraft_type":"Jet"}'

# Create a new aircraft with an image
curl -X POST http://localhost:8000/api/aircraft \
  -H "Authorization: Bearer {your_token}" \
  -H "Accept: application/json" \
  -F "title=Boeing 787" \
  -F "description=Dreamliner aircraft" \
  -F "type=Civilian" \
  -F "aircraft_type=Jet" \
  -F "image=@/path/to/your/image.jpg"

# Update an aircraft
curl -X PUT http://localhost:8000/api/aircraft/1 \
  -H "Authorization: Bearer {your_token}" \
  -H "Content-Type: application/json" \
  -d '{"title":"Updated Boeing 747"}'

# Update an aircraft with a new image
curl -X PUT http://localhost:8000/api/aircraft/1 \
  -H "Authorization: Bearer {your_token}" \
  -H "Accept: application/json" \
  -F "title=Updated Boeing 787" \
  -F "image=@/path/to/your/new_image.jpg"

# Delete an aircraft
curl -X DELETE http://localhost:8000/api/aircraft/1 \
  -H "Authorization: Bearer {your_token}"
```

**Note**: The Aircraft API implements server-side caching to improve performance. GET requests are cached for 10 minutes, and the cache is automatically invalidated when data is modified through POST, PUT, or DELETE requests.

**Image Upload**: The Aircraft API supports image uploads in JPEG, PNG, JPG, and GIF formats with a maximum file size of 2MB. Images are stored in the public storage directory and are accessible via the `image_url` attribute in the aircraft data.

## Web Routes

### Authentication

Standard Laravel Breeze authentication routes are available for web interface authentication.

### User Profile

| Method | URI      | Action                    | Middleware |
| ------ | -------- | ------------------------- | ---------- |
| GET    | /profile | ProfileController@edit    | auth       |
| PATCH  | /profile | ProfileController@update  | auth       |
| DELETE | /profile | ProfileController@destroy | auth       |

### Weather

| Method | URI      | Action                  | Middleware |
| ------ | -------- | ----------------------- | ---------- |
| GET    | /weather | WeatherController@index | none       |

### Map Markers

Full CRUD functionality for map markers:

| Method | URI                | Action                   | Middleware |
| ------ | ------------------ | ------------------------ | ---------- |
| GET    | /markers           | MarkerController@index   | none       |
| GET    | /markers/create    | MarkerController@create  | none       |
| POST   | /markers           | MarkerController@store   | none       |
| GET    | /markers/{id}      | MarkerController@show    | none       |
| GET    | /markers/{id}/edit | MarkerController@edit    | none       |
| PUT    | /markers/{id}      | MarkerController@update  | none       |
| DELETE | /markers/{id}      | MarkerController@destroy | none       |

### Blog System

| Method | URI                             | Action                    | Middleware |
| ------ | ------------------------------- | ------------------------- | ---------- |
| GET    | /blog                           | BlogController@index      | none       |
| GET    | /blog/{id}                      | BlogController@show       | none       |
| GET    | /blog/create                    | BlogController@create     | auth       |
| POST   | /blog                           | BlogController@store      | auth       |
| GET    | /blog/{id}/edit                 | BlogController@edit       | auth       |
| PUT    | /blog/{id}                      | BlogController@update     | auth       |
| DELETE | /blog/{id}                      | BlogController@destroy    | auth       |
| POST   | /blog/{blog}/comments           | CommentController@store   | auth       |
| GET    | /blog/{blog}/comments/{id}/edit | CommentController@edit    | auth       |
| PUT    | /blog/{blog}/comments/{id}      | CommentController@update  | auth       |
| DELETE | /blog/{blog}/comments/{id}      | CommentController@destroy | auth       |

### Shop System

| Method | URI               | Action                                  | Middleware |
| ------ | ----------------- | --------------------------------------- | ---------- |
| GET    | /shop             | ShopController@index                    | none       |
| GET    | /shop/create      | ShopController@create                   | none       |
| POST   | /shop             | ShopController@store                    | none       |
| GET    | /shop/{id}        | ShopController@show                     | none       |
| GET    | /shop/{id}/edit   | ShopController@edit                     | none       |
| PUT    | /shop/{id}        | ShopController@update                   | none       |
| DELETE | /shop/{id}        | ShopController@destroy                  | none       |
| GET    | /cart             | CartController@index                    | none       |
| POST   | /cart/add         | CartController@add                      | none       |
| POST   | /cart/update      | CartController@update                   | none       |
| POST   | /cart/remove      | CartController@remove                   | none       |
| POST   | /cart/clear       | CartController@clear                    | none       |
| POST   | /checkout/create  | PaymentController@createCheckoutSession | none       |
| GET    | /checkout/success | PaymentController@success               | none       |
| GET    | /checkout/cancel  | PaymentController@cancel                | none       |

### Aircraft Web Interface

| Method | URI                 | Action                     | Middleware |
| ------ | ------------------- | -------------------------- | ---------- |
| GET    | /aircraft           | AircraftController@index   | none       |
| GET    | /aircraft/create    | AircraftController@create  | none       |
| POST   | /aircraft           | AircraftController@store   | none       |
| GET    | /aircraft/{id}      | AircraftController@show    | none       |
| GET    | /aircraft/{id}/edit | AircraftController@edit    | none       |
| PUT    | /aircraft/{id}      | AircraftController@update  | none       |
| DELETE | /aircraft/{id}      | AircraftController@destroy | none       |

## Technologies Used

-   Laravel Framework
-   Laravel Sanctum for API Authentication
-   SQLite Database
-   Blade Templating Engine
-   Tailwind CSS

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
