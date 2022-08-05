Laravel Sanctum Authentication
https://laravel.com/docs/9.x/sanctum


used primarily for single page applications.

Students -> Projects

Table -> students

    Columns -> [id, name, email, password, phone]

Table -> projects

    Columns -> [id, student_id, name, description, duration]

ENDPOINTS TO BE CREATED

1. STUDENT REGISTER 

2. STUDENT LOGIN

3. STUDENT PROFILE

4. LOGOUT

5. PROJECT CREATE

6. PROJECT LIST BY STUDENT ID

7. GET SINGLE PROJECT DETAIL

8. PROJECT DELETE

Create migrations
php artisan make:migration CreateStudentsTable
php artisan make:migration CreateProjectsTable

Migrate database
php artisan migrate

Create Models
php artisan make:model Student //note that name is singular
php artisan make:model Project //note that name is singular

Create controllers
add api folder to App\Http\Controllers
php artisan make:controller Api/StudentController
php artisan make:controller Api/ProjectController

Install Sanctum package
composer require laravel/sanctum

Publish Sanctum config -- configuration file for Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

php artisan migrate //it is necessary to rerun migration for sanctum personal access token table created in the last command.

//NOT NEEDED WITH LARA9 ->Update route service provider file -> App\Providers\RouteServiceProvider.php
//NOT NEEDED WITH LARA9 ->UNCOMMENT THIS LINE protected $namespace = 'App\\Http\\Controllers';

Update Model
use Laravel\Sanctum\HasApiTokens;
ADD THIS - HasApiTokens

Define Controller Methods

Student Controller
1. Register -- auth not needed
2. Login -- auth not needed
3. Profile -- auth needed
4. Logout -- auth needed

Project Controller -- all require auth
1. Project Create
2. Project List by Student Id
3. Get Single Project Detail
4. Project Delete

API Route Configuration
routes\api.php
import controllers to route file.
set up above routes as indicated.

Student Register API
as indicated in student controller.
php artisan migrate:refresh     //update the migration if needed.

test the register route in postman.
-- start the development server.
-- see settings in postman collection -- api-2.postman_collection.json
-- register works correctly.
-- check the unique student, form validation and password confirmation via postman.

Student Login API
-- validation of post request
-- check if student in db
-- create a token
-- send a response with the token.  chk db to see token.  note: abilities = "*" means the user has access to all information.

Student Profile API
-- once a token is used and passed into the header of a request the user has access to all information.
-- remember to change the token in the Authorization Header in postman to a valid taken from prior login.

Student Logout API
-- delete the Sanctum token that has been generated.
-- note: Intellisense indicates that there is an error in the Logout function of the Student Controller but it works as expected.

Create Project API
project controller
-- student id will come from the Sanctum token
-- refresh token in postman with login and paste in other requests.

List Project API
-- pass student id in request.

Single Project Detail API

Delete Project API











Faker Class github repo which has data definitions and usage information.
https://github.com/fzaninotto/Faker