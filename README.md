# CSI3140: emergency_waitlist
The Hospital Triage application helps staff and patients view and understand current wait times in the emergency room. Users can log in as a staff (admin) or as a patient.

## Design
The overall designs for the game can be found at: [Design System](/docs/design_system.md)

## Database
The database entities, relationships and attributes can be found at: [Database](/db/db.md)

## Installation
You will need the following technologies installed.

- PHP
- Postgres

### PHP
To ensure your PHP is able to connect to the postgres database, ensure the following changes are made in your php.ini file.

1. Navigate to the php folder located in your C: drive
2. Open the php.ini file in a text editor
3. Uncomment the lines
```
extension=pgsql
extension=pdo_sql
```

### Postgres
To ensure your database can connect to the application, you will need to know your Postgres' username and password. If your `username` is not `postgres` and your `password` is not `password`, you will either have to change your postgres data to that, or change it in the _config file. 

See [here](#reconfigure-config-for-postgres) for instructions on how to change `_config.php`

#### Reconfigure Config for Postgres
>[!IMPORTANT]
>If your postgres configuration is not the default and you do not want to change your Postgres configuration, you will have to change the `_config.php` to match your setup to run the application.
>The default configuration written in the `_config.php` is:
```
hostname = 'localhost';
port = '5432';
database name = 'postgres';
username = 'postgres';
password = 'password';
```

##### Steps to Alter Config File
1. Open the file `_config.php` in the public directory
2. Change the Database Configuration values to your postgres setup and save the file. Ex.

```
$dbHost = 'YOUR_HOSTNAME';
$dbPort = 'YOUR_PORT_NUMBER';
$dbName = 'YOUR_DATABASE_NAME';
$dbUser = 'YOUR_USERNAME';
$dbPassword = 'YOUR_PASSWORD';
```

## How to Setup and Run Locally
1. Clone the repository and navigate into the folder. In a console, copy & paste
```bash
> git clone https://github.com/kkristene3/emergency_waitlist
> cd emergency_waitlist
```
2. Seed the database

    1. Navigate to the db folder and open `schema.sql`.
    2. Copy and paste the queries into a console in Postgres and run it
    3. Open the `seed.sql` file and repeat step 2.ii

3. Start up the PHP server.
```bash
(cd public && php -S localhost:4000)
```
4. Open a browser and visit http://localhost:4000

## How to Use Application
1. Once the web application is running in a browser, select the role you want to log in with and log in using a pre-existing staff or patient account.

    ![homepage](/docs/imgs/homepage.png)

    -   Existing staff accounts:
  
        | Username  | 3-letter Code
        | :---:     | ---
        | kxsaleris | ASK
        | jmpark    | BTS
        | aalert    | WLO
        | jypark    | JYP
        | mklee     | NCT
        
    -   Existing staff accounts:

        | Username  | 3-letter Code
        | :---:     | ---
        | jhsmith   | 123
  
  ### Admin Perspective
  - Staff can view the current patients in the hospital as well as their estimated wait time

    ![staff-page](/docs/imgs/staff-page.png)

  - Staff can perform two actions
    
    ![staff-actions](/docs/imgs/staff-actions.png)

    - Add a Patient
      
    ![add-patient](/docs/imgs/add-patient.png)

    - Remove a Patient
      
    ![remove-patient](/docs/imgs/remove-patient.png)

  ### User Perspective
  - Patients can view their account information

    ![patient-account-info](/docs/imgs/patient-account-info.png) 

  - Patients can view their current spot on the wait list and their estimated wait time

    ![patient-waiting-list](/docs/imgs/patient-waiting-list.png)

  - Patients can remove themselves from the wait list

    ![leave-queue](/docs/imgs/leave-queue.png)
