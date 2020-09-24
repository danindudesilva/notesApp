# NotesApp for Thirdfort

## Dependencies
* laravel
* composer

## BEFORE USING THE APP

### 1. Download XAMPP or WAMPP Server

XAMPP:	https://www.apachefriends.org/download.html

WAMPP:	http://www.wampserver.com/en/#download-wrapper

### 2. Download Composer from below link

Composer: https://getcomposer.org/download/

### 3. Run the XAMPP (or WAMPP) server on your system, 

### 4. Create the Database

Open phpmyadmin, create a mysql database with the name 'notesdb', type 'utf8_general_ci', username 'homestead', and password 'secret'

### 5. Pull the Laravel project from Git, or download and extract the Git reposiory.

```node
git pull https://github.com/danindudesilva/notesApp.git
```

### 6. Rename .env.example file

Open the downloaded Git repository, On the Laravel project package you can see the .env.example file. Rename this .env.example file to. .env 

In this file you can see the database connection settings, check the following fields and verify whether they match wih the database configurations you made in step 4. If not, chane accordingly

```node
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=notesdb
DB_USERNAME=homestead
DB_PASSWORD=secret
````

### 7. Open a command prompt or terminal window and cd into the root directory of your project.

```node
cd notesApp
```

### 8. Install the dependencies. Run:

```node
composer install
```

### 9. Generate Application keys. Run:

```node
php artisan key:generate
```

### 10. Run the database migrations. Run:

```node
php artisan migrate
```

### 11. Start the PHP server. Run:

```node
php artisan serve
```

Once you have successfully done that,navigate to https://localhost:8000 to view the home page of the app.

Use Postman or any other REST client to access the below APIs to use the notesApp.

#### Assumption: In this scenario, notes are assumed to have only simple strings. When the user updates or deletes notes, archived notes can also be updated or deleted

# APIS

## CREATE A USER

### POST
### url: 
```node
http://notes.test/api/register
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "name":"danindu",
    "email":"danindu@notes.test",
    "password":"password",
    "password_confirmation":"password"
}
```

### SAMPLE RESPONSE:

```node
{
    "data": {
            "id": 1,
            "name": "danindu",
            "email": "danindu@notes.test"
    }
}
```
## SAVE A NEW NOTE

### POST
### url: 
```node
http://notes.test/api/notes
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "title":"My note",
    "description":"Note content",
    "user_id":1
}
```

### SAMPLE RESPONSE:

```node
{
    "data": {
        "title": "My note",
        "description": "Note content",
        "user_id": 1,
        "status": "unarchived",
        "created_at": "2020-09-23T13:16:18.000000Z",
        "id": 1
    }
}
```

## UPDATE A PREVIOUSLY SAVED NOTE

### PUT
### url: 
```node
http://notes.test/api/notes/{id}
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "title":"Updated title",
    "description":"This note has been updated",
    "user_id":1
}
```

### SAMPLE RESPONSE:

```node
{
    "data": {
        "id": 1,
        "title": "Updated title",
        "description": "This note has been updated",
        "user_id": 1,
        "status": "unarchived",
        "created_at": "2020-09-23T11:36:11.000000Z"
    }
}
```
In the above API, you will receive a null '404' response if the note is not found, or if the given user_id in the request body does note match the user_id of the note being updated. A more informative error message could be given once Authentication is implemented  

## DELETE A SAVED NOTE

### DELETE
### url: 
```node
http://notes.test/api/notes/{id}
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "user_id": 1
}
```

### SAMPLE RESPONSE:

```node
204, No content
```
In the above API, you will receive a null '404' response if the note is not found, or if the given user_id in the request body does note match the user_id of the note being deleted. A more informative error message could be given once Authentication is implemented

## ARCHIVE A NOTE

### PUT
### url: 
```node
http://notes.test/api/notes/{id}/archive
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "user_id": 1
}
```

### SAMPLE RESPONSE:

```node
{
    "data": {
        "id": 4,
        "title": "Note title",
        "description": "This is the note content",
        "user_id": 1,
        "status": "archived",
        "created_at": "2020-09-23T11:36:11.000000Z"
    }
}
```
In the above API, you will receive a null '404' response if the note is not found, or if the given user_id in the request body does note match the user_id of the note being archived. A more informative error message could be given once Authentication is implemented

## UNARCHIVE A PREVIOUSLY ARCHIVED NOTE

### PUT

### url: 
```node
http://notes.test/api/notes/{id}/unarchive
```

### request headers:

```node
Accept:application/json
```

### sample request body:

```node
{
    "user_id": 1
}
```

### SAMPLE RESPONSE:

```node
{
    "data": {
        "id": 4,
        "title": "Updated title",
        "description": "This note has been updated",
        "user_id": 1,
        "status": "unarchived",
        "created_at": "2020-09-23T11:36:11.000000Z"
    }
}
```

In the above API, you will receive a null '404' response if the note is not found, or if the given user_id in the request body does note match the user_id of the note being unarchived. A more informative error message could be given once Authentication is implemented

## LIST SAVED NOTES THAT AREN'T ARCHIVED

### GET
### url: 
```node
http://notes.test/api/notes/{user_id}/unarchived
```

### request headers:

```node
Accept:application/json
```

### SAMPLE RESPONSE:

```node
{
    "data": [
        {
            "id": 4,
            "title": "Updated title",
            "description": "This note has been updated",
            "user_id": 1,
            "status": "unarchived",
            "created_at": "2020-09-23T11:36:11.000000Z"
        },
        {
            "id": 7,
            "title": "new note",
            "description": "This is a new note",
            "user_id": 1,
            "status": "unarchived",
            "created_at": "2020-09-23T11:57:26.000000Z"
        },
        {
            "id": 9,
            "title": "My note",
            "description": "Note content",
            "user_id": 1,
            "status": "unarchived",
            "created_at": "2020-09-23T13:16:18.000000Z"
        }
    ]
}
```

## LIST SAVED NOTES THAT ARE ARCHIVED

### GET
### url: 
```node
http://notes.test/api/notes/{user_id}/archived
```

### request headers:

```node
Accept:application/json
```

### SAMPLE RESPONSE:

```node

{
    "data": [
        {
            "id": 1,
            "title": "note1",
            "description": "First note",
            "user_id": 1,
            "status": "archived",
            "created_at": "2020-09-23T11:16:23.000000Z"
        },
        {
            "id": 2,
            "title": "note2",
            "description": "Second note",
            "user_id": 1,
            "status": "archived",
            "created_at": "2020-09-23T11:17:11.000000Z"
        },
        {
            "id": 6,
            "title": "archived note note",
            "description": "This is another note",
            "user_id": 1,
            "status": "archived",
            "created_at": "2020-09-23T11:37:03.000000Z"
        }
    ]
}

```

## LIST ALL SAVED NOTES OF ALL USERS

### GET
### url: 
```node
http://notes.test/api/notes/
```

### request headers:

```node
Accept:application/json
```

### SAMPLE RESPONSE

```node
{
    "data": [
        {
            "id": 6,
            "title": "archived note note",
            "description": "This is another note",
            "user_id": 1,
            "status": "archived",
            "created_at": "2020-09-23T11:37:03.000000Z"
        },
        {
            "id": 7,
            "title": "new note",
            "description": "This is a new note",
            "user_id": 1,
            "status": "unarchived",
            "created_at": "2020-09-23T11:57:26.000000Z"
        },
        {
            "id": 9,
            "title": "My note",
            "description": "Note content",
            "user_id": 1,
            "status": "unarchived",
            "created_at": "2020-09-23T13:16:18.000000Z"
        },
        {
            "id": 11,
            "title": "de silva",
            "description": "email@email.com",
            "user_id": 3,
            "status": "unarchived",
            "created_at": "2020-09-24T08:46:55.000000Z"
        },
        {
            "id": 12,
            "title": "note",
            "description": "email@email.com",
            "user_id": 4,
            "status": "unarchived",
            "created_at": "2020-09-24T08:47:07.000000Z"
        }
    ]
}
```

The above API is given for testing purposes so that all notes and their properties can be viewed without accessing the db externally
 
## TECHNOLOGIES CHOSEN AND REASONS WHY

* Laravel

Easy to develop and implement
Effective ORM and database layer
Active and growing community that can provide quick support and answers


* MySQL

high performance 
secure and reliable

## POSSIBLE IMPROVEMENTS

* Authentication

an authentication layer can be added to authenticate the users before they access notes. Currently the user is identified by passing the user_id field in the request body. Oauth2 can be used for this

* Using a seperate db to store the archived notes 

currently the app does not have a separate database for archived notes. We can add another database to store archived notes after a certain period of time

* Support for large content in notes

Currently note content is stored in a database field as is, but for larger content, there needs to be proper storage options
db can be used to store the status for easier and faster accessing.

