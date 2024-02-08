# Test CRUD Exercise

1. For database, choose any SQL database you want and create database with single table for storing customers with following data:
   ID, FirstName, LastName, DateOfBirth, Username, Password
   Please provide SQL statement for creating such a table.

2. In PHP, create at least one class for handling customers business logic with following functions:
   a) Add customer with specified parameters
   Please make sure to include a minimum amount of validation for fields if you are not looking to implement also frontend with these checks in addition to whatever is needed for storing the new customer information in database.
   b) Edit/update a specific existing customer with new data
   Please make sure to include a minimum amount of validation for fields if you are not looking to implement also frontend with these checks in addtion to whatever is needed for storing new customer information in database.
   c) Retrieve a list of all customers and their data from database and return it in some usable way (e.g. json)
   d) Delete a specific existing customer and all of their data from database
   Any additions are welcome and are an optional bonus (e.g. proper handling of password, handling errors, proper responses, any additional functions like filtering the list by some parameter or search value).
   Another great bonus would be a simple unit test script, even in just plain php, using and evaluating the customer class function on some basic level.

3. If you chose to not create frontend for this task, please include at least basic documentation for customer class and it's functions as if someone unfamiliar with your code would like to use functionality provided by your class. If you choose to create frontend, feel free to do so in any way you want but it should include at least basic input validation and clear point(s) of interaction with backend.

## Installation

1. From root directory execute cmd: docker-compose build && docker-compose up -d

## How to Use

  Create new customers by adding them to 'Create New Customer' form.
  Modify/Remove customers can be done in 'Customer Collection' form.

  Validation (patterns can be changed in \Customer\Api\ValidationInterface):
   1. Username allows chars a-zA-Z0-9-
   2. Firstname and Lastname allows chars a-zA-Z
   3. Date allows chars 0-9-
   4. Password a-zA-Z0-9-

  Customer can change username in can new will be available.
  Password is hashed with cmd password_hash($password, PASSWORD_BCRYPT, ['cost' => 14])

  Search is working based on $_GET param same as sorting  

  Controller methods can be found in \Customer\Controller\
      Controllers are called from action.php

  Error handler is done in a bit fishy way :)
      Message is stored in log/system.log file

  Design:
      For CRUD requests used ajax
      Style - bootstrap

## WEB URL

1. Web application: http://localhost
2. PMA - http://localhost:8085