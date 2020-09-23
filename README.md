# NotesApp for Thirdfort

## Dependencies
* laravel
* homestead

# BEFORE USING THE APP

## Installing Laravel Homestead

Laravel Homestead is an official, pre-packaged Vagrant box that provides you a wonderful development environment without requiring you to install PHP, a web server, and any other server software on your local machine. No more worrying about messing up your operating system! Vagrant boxes are completely disposable. If something goes wrong, you can destroy and re-create the box in minutes!
Before launching your Homestead environment, you must install: 
* Composer: https://getcomposer.org/download/
* VirtualBox 6.x: https://www.virtualbox.org/wiki/Downloads
* Vagrant: https://www.vagrantup.com/downloads.html


## Installing The Homestead Vagrant Box

Once VirtualBox / VMware and Vagrant have been installed, you should add the laravel/homestead box to your Vagrant installation using the following command in your terminal
```node
vagrant box add laravel/homestead
```

## Installing Homestead

You may install Homestead by cloning the repository onto your host machine. Consider cloning the repository into a Homestead folder within your "home" directory, as the Homestead box will serve as the host to all of your Laravel projects:


```node
git clone https://github.com/laravel/homestead.git ~/Homestead
```

You should check out a tagged version of Homestead since the master branch may not always be stable. You can find the latest stable version on the GitHub Release Page. Alternatively, you may checkout the release branch which always contains the latest stable release:

```node
cd ~/Homestead

git checkout release
```
Once you have cloned the Homestead repository, run the bash init.sh command from the Homestead directory to create the Homestead.yaml configuration file. The Homestead.yaml file will be placed in the Homestead directory:


```node
// Mac / Linux...
bash init.sh

// Windows...
init.bat
```
## Configuring Homestead

* Setting Your Provider

The provider key in your Homestead.yaml file indicates which Vagrant provider should be used

```node
provider: virtualbox
```
* Configuring Shared Folders

The folders property of the Homestead.yaml file lists all of the folders you wish to share with your Homestead environment. As files within these folders are changed, they will be kept in sync between your local machine and the Homestead environment. You may configure as many shared folders as necessary:

```node
folders:
    - map: ~/Laravel-Projects
      to: /home/vagrant/code
	  
sites:
    - map: notes.test
      to: /home/vagrant/code/notesApp/public
	  
databases:
    - notesdb
	
```
Please note that you will need to clone the Git repository notesApp to: ~/Laravel-Projects (The folder path given in 'folders' in the Homestead.yaml file)

* Hostname Resolution

Using automatic hostnames works best for "per project" installations of Homestead. If you host multiple sites on a single Homestead instance, you may add the "domains" for your web sites to the hosts file on your machine. The hosts file will redirect requests for your Homestead sites into your Homestead machine. On Windows, it is located at C:\Windows\System32\drivers\etc\hosts. The lines you add to this file will look like the following:

```node
192.168.10.10  notes.test
```

Make sure the IP address listed is the one set in your Homestead.yaml file. Once you have added the domain to your hosts file and launched the Vagrant box you will be able to access the site via your web browser:

```node
http://notes.test
```

## Setting up the project

After cloning the git repository, you will nee to copy the contents of the .env.example file to a new file named .env in the notesApp folder

## Launching The Vagrant Box

Once you have edited the Homestead.yaml to your liking, run the 'vagrant up' command on a terminal window from your Homestead directory. Vagrant will boot the virtual machine and automatically configure your shared folders and Nginx sites.

After the vagrant machine is booted, ssh into your varant box. Run the following command in the terminal to ssh into the vagrant box.

```node
vagrant ssh
```

Once you have successfully logged into your vagrant box, you can navigate to ~/code/notesApp/ directory and run the following command to download and install the dependencies required for the app

```node
composer install
```

Once the dependencies have been installed, run the following artisan command to generate the Application key

```node
php artisan key:generate
```

One last step! Run the database migrtions using the following artisan command.

```node
php artisan migrate
```

Now you are ready to use the app. Navigate to http://notes.test using your favourite browser to view the app home page. If you have successfully configured the App, you will see the home page with the title 'Notes'

Use Postman or any other REST client to access the below APIs to use the notesApp.

#### Assumption: In this scenario, notes are assumed to have only simple strings.

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

### request body:

```node
{
    "name":"danindu",
    "email":"danindu@notes.test",
    "password":"password",
	"password_confirmation":"password"
}
```

### RESPONSE:

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

### request body:

```node
{
    "title":"note1",
    "description":"First note",
    "user_id":1
}
```

### RESPONSE:

```node
{
    "data": {
        "title": "My note",
        "description": "Note content",
        "user_id": 1,
        "status": "unarchived",
        "created_at": "2020-09-23T13:16:18.000000Z",
        "id": 9
    }
}
```

## UPDATE A PREVIOUSLY SAVED NOTE

### PUT
### url: 
```node
http://notes.test/api/notes/{id}
```

### request body:

```node
{
    "title":"Updated title",
    "description":"This note has been updated"
}
```

### RESPONSE:

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
## DELETE A SAVED NOTE

### DELETE
### url: 
```node
http://notes.test/api/notes/{id}
```

### request body:

```node
null
```

### RESPONSE:

```node
204, No content
```

## ARCHIVE A NOTE

### PUT
### url: 
```node
http://notes.test/api/notes/{id}/archive
```

### request body:

```node
null
```

### RESPONSE:

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
## UNARCHIVE A PREVIOUSLY ARCHIVED NOTE

### PUT
### url: 
```node
http://notes.test/api/notes/{id}/unarchive
```

### request body:

```node
null
```

### RESPONSE:

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

## LIST SAVED NOTES THAT AREN'T ARCHIVED

### GET
### url: 
```node
http://notes.test/api/notes/unarchived
```

### RESPONSE:

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
http://notes.test/api/notes/archived
```

### RESPONSE:

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

