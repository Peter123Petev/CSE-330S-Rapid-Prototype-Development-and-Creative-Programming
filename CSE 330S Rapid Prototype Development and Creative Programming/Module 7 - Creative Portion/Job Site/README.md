# Module 6
## Group Portion
Peter Petev - 457577, Max Rocco 455086
## TA Grading Info:
There is no gui for messaging/kicking/banning because we wanted the chat to be command based. As a result, this is how you do the various functions required in this module:
* Commands to message someone:
    * !message <user> <msg>
* Commands only "Creator" can run:
    * !kick <user>
    * !ban <user>
## Multi-room Chat Server (50 Points):
#### Administration of user created chat rooms (25 Points):
* Users can create chat rooms with an arbitrary room name(5 points)
    * Click The "Create Public" or "Create Private" buttons after choosing a username. 
* Users can join an arbitrary chat room (5 points)
    * The chats are listed to the left, users can click on one to attempt to join
* The chat room displays all users currently in the room (5 points)
    * Live-updated user list on the left under chat rooms
* A private room can be created that is password protected (5 points)
    * Click "Create Private" after choosing a name and then enter a password
* Creators of chat rooms can temporarily kick others out of the room (3 points)
    * Creators (we made it so that the oldest member in the room is the creator) can use the "!kick <username>" command to kick a user.
* Creators of chat rooms can permanently ban users from joining that particular room (2 points)
    * Creators (we made it so that the oldest member in the room is the creator) can use the "!ban <username>" command to kick a user.
#### Messaging (5 Points):
* A user's message shows their username and is sent to everyone in the room (1 point)
* Users can send private messages to another user in the same room (4 points)
    * Members of a chat can use the "!message <username> <message>" command to send a mesage to only one user in a chat.
#### Best Practices (5 Points):
* Code is well formatted and easy to read, with proper commenting (2 points)
* Code passes HTML validation (2 points)
* node_modules folder is ignored by version control (1 points)
#### Usability (5 Points):
* Communicating with others and joining rooms is easy and intuitive (4 points)
* Site is visually appealing (1 point)
* Creative Portion (10 Points)
    * Used bootstrap to style (5 points)
    * Users can send urls of images to display them in the chat (5 points)
    * Users can send urls and make the webpages display in the chat (5 points)