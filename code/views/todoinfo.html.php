
<h2>Todo Details</h2>

<h3>Scope:</h3>

<p>
    <strong>PHP</strong>: the app is built within a Docker container with PHP, MySQL and Ngnix technologies. For getting started I used a bare bones environment (see <a target="_blank" href="https://github.com/adamdenverco/docker_php_mysql_starter">docker_php_mysql_starter</a>) and continued examping for this project.
</p>

<p>
    <strong>Frontend</strong>: the current frontend of this app uses very lite CSS and no JS as I focused on fleshing out the backend.
</p>

<p>
    <strong>MySQL</strong>: the app writes to a database using PDO and the SQL will load up when the docker is launched. The app should be using a OOP Singleton for the database connection. When run locally, a phpMyAdmin link will appear in the top menu for easy access.
</p>

<p>
    <strong>CRUD</strong>: The app can create, read, update and delete the todo items. I created a base CRUD object that other models can use to extend from. In this way the "todo" model can pass an array of variables to the parent CRUD model and it will create all the necessary SQL and PDO commands to interact with the database in one place. Potentially, you could expand this application without writing any SQL queries.
</p>

<h3>Using the application</h3>

<p>
    <strong>Locally</strong>: This project is available for download at my Github here: <a target="_blank" href="https://github.com/adamdenverco/docker_php_mysql_todo">docker_php_mysql_todo</a>.
</p>
<ul>
    <li>Open the project folder in your terminal.</li>
    <li>In the terminal run the command "docker-compose up -d"</li>
    <li>To view the project go to http://localhost/ in a browser.</li>
    <li>To edit the mysql go to http://localhost:8080/ for phpMyAdmin</li>
    <li>Log into phpMyAdmin with username "phpuser" and password "phppass"</li>
    <li>To stop the project run the terminal command "docker-composer stop"</li>
</ul>
<p>
    Note: in a local environment 
</p>

<p>
    <strong>Locally</strong>: This project is available for download at my Github here: <a target="_blank" href="https://github.com/adamdenverco/docker_php_mysql_todo">docker_php_mysql_todo</a>.
</p>

<h3>Other Features</h3>

<p>
    <strong>User Data</strong>: a user login was outside of the initial scope, but looking at the other proejcts (user poll and calendar events), I went ahead and added lite user tracking with IP addresses logging in the database to a particular user id. This is done automatically when the user access the page and a user id is assigned as constant. Then all todo items entered by that user are assigned to that user id.
</p>

<p>
    <strong>Mark "Complete"</strong>: As is common in todo apps, I went ahead and added the feature to mark and unmark items as "complete".
</p>

<p>
    <strong>Expandability</strong>: Building the app on an MVC with a CRUD object that other models extend from was also added so other projects/pages can be added easily later.
</p>

<p>
    <strong>Logging</strong>: right now database interactions are monitored by try/catch exceptions that log errors to a monthly text file using the Logging model class.
</p>

<p>
    <strong>Clean Code</strong>: I tried to apply Clean Code principles in writing the code. This includes readable/descriptive function names and trying to keep functions shorter in length and breaking up longer or repeated code into other functions within the same class. Granted Clean Code principles recommend less comments, but as others will be looking at this code to understand the logic, I went ahead and tried to comment as much as possible.
</p>

<p>
    <strong>Autoloading Classes</strong>: Also to speed up future development, all classes use PHP's auto loading feature.
</p>

<p>
    <strong>Future Development</strong>: As this is a rough pass of an application, further development would be spent streamlining the code, buidling further testing and error reporting and converting the frontend to AJAX powered functionality. Also, adding in a user login and ability to add multiple lists would be beneficial as well.
</p>


<hr/>

