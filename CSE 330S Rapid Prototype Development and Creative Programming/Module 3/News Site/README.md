# Module 3
## Group Portion
**Peter Petev - 457577 , Max Rocco - 455086**
## Assignment Link:
http://ec2-18-223-149-165.us-east-2.compute.amazonaws.com/~peterpetev/Module3/start.php
## Creative Portion:
* **Bootstrap**: We used bootstrap to create cards, collapsables, navbars, search bars, forms, drop-down menus, and buttons. We tried to use as much styling as possible available fromm bootstrap to add to the site. Our styling and special effects took a long time.
* **Like System**: Users can like and unlike stories, and the stories on the home page are sorted by highest likes (trending).
* **Profile pages**: Users can click on other usernames to see all of a their stories, comments, and liked stories. Very cool.
* **Search Functionality**: The search bar at the end of the navigation bar can search through all stories, comments, and users to find what you might be looking for.
## Login Details:
* Register an account with "register"
* Login after registering
* Try posting stories and comments, viewing other stories, and liking other stories!
* See all your activity on your "account" page, and edit whatever you want
* Log out by clicking "log out"
## Checking-Off Rubric:
#### News Site (60 Points):
* User Management (20 Points):
    * A session is created when a user logs in (3 points)
        * The user logs in on the "login.php" page and then the "enter.php" page validates the user's credentials. If valid, we create a session when the user logs in, and store both the user name and the user id of the user in the session variables.
    * New users can register (3 points)
        * A "register" link on the navigation bar links to "register.php" where users can register with a unique user name and a password. The form sends details to the "makeuser.php" page, where a unique username will be created with a hashed and salted password.
    * Passwords are hashed, salted, and checked securely (3 points)
        * Passwords put into the sql database by the "makeuser.php" page are hashed and salted, and to check passwords the "enter.php" page checks passwords using password_verify() function .
    * Users can log out (3 points)
        * Logged-in users see a "logout" link on the navbar, which they can click to be redirected to "logout.php". Once redirected, their session is deleted using the session_destroy() function. They are then redirected again to "start.php".
    * A user can edit and delete his/her own stories and comments but cannot edit or delete the stories or comments of another user (8 points)
        * The only way to access comment and story editing from the website itself is to go to your "account" link on the navigation bar once you are logged in. This links to the "accounts.php" page, where you are able to edit stories and comments. Links on this page go to "editstory.php" and "editcomment.php", which verify that the session user id is the same one that wrote the story or comment. This means only a logged-in user with a session can change their own stories and comments.
* Story and Comment Management (20 Points):
    * Relational database is configured with correct data types and foreign keys (4 points)
        * We committed a 'single' text file containing the output of the SHOW CREATE TABLE command for all tables in your database, called "tables.sql". This one file contains the output for all of your tables.
    * Stories can be posted (3 points)
        * The "post" button appears on the home page and account page for logged-in users. Filling out this form allows logged-in users to post under their own username.
    * A link can be associated with each story, and is stored in a separate database field from the story (3 points)
        * The stories database has seperate fields for story_id, author_id, title, body, and link.
    * Comments can be posted in association with a story (4 points)
        * Comments are created in the comments database, with fields to keep track of the comment_id, the author_id of the author of the comment, and the comment itself.
    * Stories can be edited and deleted (3 points)
        * A logged-in user can go to their account page and edit thier story with the "edit" button underneath it. The "editstory.php" verifies the user is the author of the story.
    * Comments can be edited and deleted (3 points)
        * A logged-in user can go to their account page and edit thier comment with the "edit" button underneath it. The "editcomment.php" verifies the user is the author of the comment.
* Best Practices (15 Points):
    * Code is well formatted and easy to read, with proper commenting (3 points)
        * Up to the Grader.
    * Safe from SQL Injection attacks (2 points)
        * $mysqli->real_escape_string() is used to prevent sql attacks
    * Site follows the FIEO philosophy (3 points)
        * htmlentities() and casting to data types are the methods we used to follow this philosophy
    * All pages pass the W3C HTML and CSS validators (2 points)
        * Yes.
    * CSRF tokens are passed when creating, editing, and deleting comments and stories (5 points)
        * We made the CSRF token in the "start.php" page after creating the session, and the CSRF token is passed through a hidden field and validated on every form for stories/comments.
* Usability (5 Points):
    * Site is intuitive to use and navigate (4 points)
        * Up to the Grader.
    * Site is visually appealing (1 point)
        * Up to the Grader.
#### Creative Portion (15 Points) (see below)
* Make sure you have a README.md file in your group repo with the following:
    * Names and Student IDs of all the group members
        * Peter Petev - 457577 , Max Rocco - 455086
    * A link to your homepage of the site
        * http://ec2-18-223-149-165.us-east-2.compute.amazonaws.com/~peterpetev/Module3/start.php
    * A brief description of what you did for your creative portion
        * **Bootstrap**: We used bootstrap to create cards, collapsables, navbars, search bars, forms, drop-down menus, and buttons. We tried to use as much styling as possible available fromm bootstrap to add to the site. Our styling and special effects took a long time.
        * **Like System**: Users can like and unlike stories, and the stories on the home page are sorted by highest likes (trending).
        * **Profile pages**: Users can click on other usernames to see all of a their stories, comments, and liked stories. Very cool.
        * **Search Functionality**: The search bar at the end of the navigation bar can search through all stories, comments, and users to find what you might be looking for.
    * Any additional login details needed for the TA
        * Register an account with "register"
        * Login after registering
        * Try posting stories and comments, viewing other stories, and liking other stories!
        * See all your activity on your "account" page, and edit whatever you want
        * Log out by clicking "log out"