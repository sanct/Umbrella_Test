Umbrella test task: URL Shortener.
========

A Symfony project created on January 17, 2018, 9:05 pm.

#Project on Heroku: 
https://young-dawn-40609.herokuapp.com

#Versions: Symfony 3.4; PHP 7.1; Mysql 5.7

#Installation local
1. git clone https://github.com/sanct/Umbrella_Test.git
2. composer install
3. php bin/console doctrine:database:create
4. php bin/console doctrine:migrations:migrate
5. yarn install
6. yarn run encore production

#Working with API
1. Get list of original-short urls pairs.
     - Request Method: GET 
     - URL: api/urls
2. Create short url.
    - Request Method: POST
    - URL: api/urls
    - Params: 
        {
            original: 'value',
            short: 'value'
        }

#Used packages:

    - Backend: FOSRestBundle(tool for creating a REST API with Symfony).
    - Frontend: axios(Promise based HTTP client), SweetAler(makes popup messages).
