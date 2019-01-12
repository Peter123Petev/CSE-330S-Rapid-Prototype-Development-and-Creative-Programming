# Module 2
## Group Portion
**Efia Nuako & Peter Petev**

## Assignment Link
Box assignment:
http://ec2-18-223-149-165.us-east-2.compute.amazonaws.com/~peterpetev/boxlogin.php

## Rubric:
#### File Management
* The users files are under a file "etc/330class/330Box/boxusers" so that they are not visible until logging in and apache accesses them
    * The users.txt file is also in the above mentioned directory, not the public_html, so it can not be directed to using the url.
* Users have a view of their files when logged in, called "fileview"
    * Clicking on a file opens it
    * Clicking on the "Upload" part of the navbar takes you to a form where you can upload
    * As mentioned above, the user files are in a directory which is not under the public_html or the public user folder
    * Clicking on the "Delete Files" part of the navbar takes you to a list where clicking a file will send it to the "boxtrash.php" where it will get deleted from the system
    * Since the php reads the file directory and shows only the file names, the directory is hidden
    * There is a "Log Out" button which destroys the session and takes users back to the login page
## Best Practices
* Code is commented in all places we felt necessary
* The code was edited to follow FIEO policy, as you can see on the login page, the upload page, and the new user page
* All pages were made to pass the W3C validator
## Usability
* We hope you think it looks pretty and feels nice
## Creative Portion
* We did two things for the creative portion:
    1. **Users can Register:** We have a register button on both the login page and the page for when a username is not recognized. These buttons redirect you to the registration page, where a form can allow you to create a new user. This user is added to the users.txt and a file is created for them.
    2. **We learned to use Bootstrap to style the pages:** Any php file with user interface has bootstrap so that the look and feel of the site is modern. We styled cards, special buttons, forms, and a navbar using the bootstrap format.
## Additional details
* We have a few usernames already created: peter, test, userA, userB, userC, userD, userE
* The "userA" username has a pre-populated file folder so you can quickly test our site with that username