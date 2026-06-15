# CoA - Crisis Containment Service

A crisis management platform for handling natural disasters such as earthquakes,
floods, and fires. The application lets accredited authorities manage incidents,
shelters, and alerts through an admin panel, and offers a public interface where
citizens can view information without logging in.

This is a university project for the Web Technologies course.

## Features

- Authentication and session management for administrators
- CRUD for incidents (earthquakes, floods, fires) with filtering by year and status
- CRUD for shelters with geographic coordinates
- Creation and export of alerts in CAP format (XML)
- Interactive map (Leaflet) for viewing incidents and shelters, with routing
- Import and export of data in JSON and CSV
- Import of historical earthquake data from Kaggle datasets (offline scripts)
- Administrator account management
- Public information pages for citizens

## Technologies

- PHP (no framework) for the backend
- MySQL accessed through PDO
- Vanilla HTML, CSS, and JavaScript for the frontend
- Fetch API for asynchronous communication with the JSON endpoints
- Leaflet.js with Leaflet Routing Machine for maps and directions
- OpenStreetMap tiles (loaded client-side)
- ip-api for server-side geolocation
- Apache (XAMPP) as the runtime environment

## Architecture

The application follows the MVC pattern with a Front Controller. `index.php`
is the single entry point: it reads the `route` parameter and dispatches the
request to the right place.

- Controllers receive the request and call the models
- Models hold all the SQL and talk to the database through PDO
- Views render the HTML for the admin and public pages

Routes are grouped into three categories:

- API routes (return JSON): `api/events`, `api/shelters`, `api/alerts`,
  `api/users`, `api/import-export`, `api/login`, `api/logout`, `api/location`
- Admin routes (require authentication): `dashboard`, `events`, `shelters`,
  `alerts`, `users`, `import-export`, `event-details`, `cap-details`,
  `shelter-details`
- Public routes: `login`, `events-public`, `shelter-public`, `details-public`

## Project structure

```
index.php                 Front controller (entry point)
config/database.php       Database connection (PDO)
api/routes.php            Server-side geolocation endpoint
app/
  controllers/            EventController, ShelterController, AlertController,
                          UserController, ImportExportController, AuthController
  models/                 EventModel, ShelterModel, AlertModel, UserModel
  views/
    admin/                Admin pages and modals
    public/               Public pages
css/                      Stylesheets
js/                       Client-side scripts
.htaccess                 Directory protection
```

<img width="1898" height="1029" alt="image" src="https://github.com/user-attachments/assets/203cc096-63ff-420f-bfed-03579950e620" />
<img width="1888" height="1014" alt="image" src="https://github.com/user-attachments/assets/bf6dff60-bfdf-4623-8043-9b8557e0b5cb" />


<img width="1888" height="1042" alt="image" src="https://github.com/user-attachments/assets/1ca56138-68ef-43d8-a8b5-3fc777c94388" />
<img width="1919" height="1032" alt="image" src="https://github.com/user-attachments/assets/6eafc107-268a-4632-b044-cd8d6c9fe51d" />
<img width="1919" height="1030" alt="image" src="https://github.com/user-attachments/assets/27f0d71d-2452-4d95-9407-42e69020e91d" />
<img width="1912" height="1029" alt="image" src="https://github.com/user-attachments/assets/af299d8b-27c8-4192-a40d-fcf1c0891aaf" />


## Setup

1. Install XAMPP (or any Apache + PHP + MySQL stack).
2. Clone the repository into the web server root (for XAMPP, `htdocs`):
   ```
   git clone https://github.com/EatBreadMan/Proiect-web.git
   ```
3. Start Apache and MySQL.
4. Open phpMyAdmin, create a database, and import the SQL schema.
5. Edit `config/database.php` with your host, database name, user, and password.
6. Open the application in the browser, for example:
   ```
   http://localhost/Proiect-web/index.php?route=login
   ```

By default, an unauthenticated request is redirected to the login page. After
logging in, the administrator is taken to the events page.

## Notes

- The earthquake import scripts use Kaggle datasets and run offline; Kaggle is
  not a runtime dependency.
- OpenStreetMap tiles load directly in the browser, while the geolocation
  lookup (ip-api) runs on the server.
- Alerts are exported as valid CAP documents; the application does not send
  push notifications.

