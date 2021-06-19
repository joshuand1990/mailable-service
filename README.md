# Transactional Email Microservice

### Requirements
This app is a simple email microservice built using Lumen and VueJs.
The app sends an email to the recipient's email through the following:

- JSON API's endpoint
- CLI
- Frontend

API speed should be improved by processing transactions asynchronously 
 
The app utilizes the two email service providers:
- MailJet 
- SendGrid

### NOTES: 
#### Please make sure docker has been installed and api keys have been generated for the email providers  
### Installation Instructions with Docker
````
docker run --rm -v $(pwd):/app composer install 
cp .env.example .env
make build
make deps
make migrate
make up
````
`make up` will start the required below services for the app to run:
- web service for the api and frontend
- mysql database
- redis store
- queue processor

####Edit the ````.env```` file with updated api keys for the email service providers and the from address details

### API
````
GET /api/mail
````
This service returns all the records in the `logmail` table. The main table that contains the history of sent emails. 
````
POST /api/mail
````
This service is used to send the transactional emails. It requires 4 fields:
- email : email used to send to the user *(required)*
- name : the name of the user *(required)*
- subject *(required)*
- body *(required)*

### CLI
````
php artisan mail:send {to : email recipient, for multiple separate by "," - supports adding names as well eg (john@doe.com:john,jane@doe.com:jane)} {subject : email subject} {content :  email content}
````
### Frontend
- Simple VueJS application using axios to pull all the information from the previously mentioned API's.
- The frontend uses TailwindCSS as its CSS framework.
- VueRouter is used to navigate between the pages of the app.
- By default, the frontend will show a list of the email transactions along with their statuses.
- The ability to initiate an email transaction has also been built.

### Mailer
- The class is its own implementation and doesn't use laravel components
- The implemented mailer class is used to connect to the different transports (here, SendGrid & MailJet)
- The whole implementation uses Dependency Injection using the laravel core container.
- To support the feature of the Auto Swapping (failback) mailer, an AutoSwapMailer class is used to decorate the Mailer Class.
- Using Laravel's queuing system the transactional emails are processed.
- *The system is designed to fallback to another transport on any failure, for a maximum of 6 tries in a round robin fashion, else it will be considered as "failed".*


