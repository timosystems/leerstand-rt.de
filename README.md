# Leerstandsmelder-RT
 
This platform was created to collect and publish vacant houses and apartments. The aim is to exert pressure on the city and owners to rent out living space and to enact regulations such as bans on misappropriation and vacancies. 

The idea is that the platform is published for a city and then publicized there in the press by a political group or an alliance of different parties. The public is then to be alerted to vacancies by mail. The operators of the vacancy notifier can then enter the addresses mentioned via a password-protected backend. Addresses are automatically translated to GPS locations and displayed on an interactive map in the frontend of the site. 

This project was initially coded and used by the group "FCKEigenheim" (https://fckeigenheim.de), a local housing action organization in the german city "Reutlingen".

## Setup

To setup this project, you must:

1. copy the ".env" file in the root project directory to ".env.local" and fill out the three env-variables:
    ```
    DATABASE_URL=mysql://<username>:<password>@<host>:<port>/<dbname>
    APP_ENV=PROD
    APP_SECRET=<randomstring>
    ```
2. install all the vendor packages by running this command inside of the projects root directory in the shell of your webserver (php needed)
    ```
    composer install --no-dev --optimize-autoloader
    ```
3. setup the database by running this command inside of the projects root directory in the shell of your webserver (php needed)
    ```
    bin/console make:migration
    bin/console doctrine:migration:migrate -n
    ```
4. change the initial admin credentials by editing the file **src/DataFixtures/UserFixtures.php**
    ```
    $user = new User();
    $user->setEmail('change@me.com');                                   // <-- EDIT THIS LINE
    $user->setPassword(password_hash('changeme', PASSWORD_DEFAULT));    // <-- EDIT THIS LINE
    $manager->persist($user);
    $manager->flush();
    ```
    and run inside of the projects root directory in the shell of your webserver (php needed)
    ```
    bin/console doctrine:fixtures:load
    ```
4. setup your webserver so that the project root directory is /public
5. Visit your website, it should now display an empty map.