# Module 5
## Individual Portion
Peter Petev - 457577
## AJAX Calendar (60 Points):
* **Link**: http://ec2-18-223-149-165.us-east-2.compute.amazonaws.com/~peterpetev/Module5/calendar.php
* **GRADING INFO**: A user for TA's with pre-loaded example events for Oct/Nov. It has it's own events, and two calendars are shared with it.
    * user: test
    * pass: test
**Also, if you click on an event, make sure to scroll down on the page. The event descriptions show up under the calendar!!!**
* **Creative:** In addition to the three suggested created portion ideas (see below), we also:
    * used bootstrap to style our website
    * added the functionality to have events span multiple days.

#### Calendar View (10 Points):
* The calendar is displayed as a table grid with days as the columns and weeks as the rows, one month at a time (5 points)
* The user can view different months as far in the past or future as desired using the previous, next, and current month buttons. (5 points)
#### User and Event Management (25 Points):
* Events can be added through logging in and filling out the "Create Events" form, modified using the "Edit" button in the event view under the calendar, and deleted using the "Delete" button in the event view under the calendar (5 points)
* Events have a title, date, and time (2 points)
* Users can log into the site using the navigation bar at the top, and they cannot view or manipulate events associated with other users (8 points)
* All actions are performed over AJAX, without ever needing to reload the page (10 points)
#### Best Practices (20 Points):
* Code is well formatted and easy to read, with proper commenting (2 points)
* Passwords are stored salted and hashed (2 points)
* All AJAX requests are performed via POST (3 points)
* We used htmlentities() to prevent all XSS attacks (3 points)
* We used $mysqli->real_escape_string() to prevent SQL Injection attacks (2 points)
* CSRF tokens are passed when editing or removing events, and every other form as well (3 points)
* Session cookie is HTTP-Only, this can be quickly seen at the top of login_ajax.php (3 points)
* Calendar.php page has no errors in the W3C validator (2 points)
#### Usability (5 Points):
* Site is intuitive to use and navigate (4 points)
* Site is visually appealing (1 point)
#### Creative Portion (15 Points)
* Users can tag an event with a particular category and enable/disable those tags in the calendar view. (5 points)
* Users can share their calendar with additional users. (5 points)
* Users can create group events that display on multiple users calendars (5 points)
* Make sure to save a description of your creative portion, and a link to your server in your README.md file.