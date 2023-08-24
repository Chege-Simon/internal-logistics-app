<h1>Internal Logistics Application</h1>
Prerequisites
php
composer
npm and node.js
mysql

If using xampp
place the project in the xampp folder
Set Up
git clone "https://github.com" //clone project from github
cd into project directory
copy the env.example and paste as env.
Change (if needed):
app_name,
app_url,
app_debug (set to False for Production Env)
DATABASE CONNECTIONS
Session LifeTime
composer install
php artisan migrate
php artisan key:generate
php artisan db:seed

npm install
npm run build or npm run dev

php artisan serve
API
get api token :
POST: localhost:8000/api/auth/login
post data must include: email, password //must be admin email
#result will contain access token that will expire in 30 minutes
##use access token as bearer token to access the data endpoints

Data End points
#dates are mandatory
GET: localhost:8000/api/trip_logs/2023-01-13/2023-09-02 //triplogs/{from date}/{to date}
GET: localhost:8000/api/trips/2023-01-13/2023-09-02 //trips/{from date}/{to date}
GET: localhost:8000/api/bags/2023-01-13/2023-09-02 //bags/{from date}/{to date}
GET: localhost:8000/api/items/2023-01-13/2023-09-02 //items/{from date}/{to date}
GET: localhost:8000/api/users/2023-01-13/2023-09-02 //users/{from date}/{to date}
