<!DOCTYPE html>
<html lang="en">
<head>
	<title>Calendar</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<!-- Navigation bar for logging in / out -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<div class="row">
				<div id="logarea">
					<input type="text" id="username" placeholder="Username" />
					<input type="password" id="password" placeholder="Password"/>
					<button id="loginbtn" class="btn btn-light">Log In</button>
					<button id="sign_up" class="btn btn-light">Sign Up</button>
				</div>
			</div>
		</div>
	</nav>

	<!-- Collapsable event creator - Allows events to be sent but they get rejected when received if user is not logged in -->
	<div id="eventcreation" style="display:none" class="col text-center">
		<a class="btn btn-light" data-toggle="collapse" href="#eventcreationact" role="button" aria-expanded="false" aria-controls="eventcreationact">
			Create Events
		</a>
		<a class="btn btn-light" data-toggle="collapse" href="#shareact" role="button" aria-expanded="false" aria-controls="shareact">
			Share
		</a>
	</div>
	<div class="collapse" id="eventcreationact">
		<div id = "viewcreateeventform" class="card card-body">
			<form id = "createeventform">
  				<div class="form-group">
    					<label for="cetitle">Title:</label>
    					<input type="text" class="form-control" id="cetitle" placeholder="Event Title">
				</div>
				<div class="form-group">
    					<label for="cedescription">Description:</label>
    					<input type="text" class="form-control" id="cedescription" placeholder="Event Description">
				</div>
				<div class="form-group">
    					<label for="cetag">Tag:</label>
    					<input type="text" class="form-control" id="cetag" placeholder="Event Tag">
				</div>
				<div class="form-group">
    					<label for="startdate">Start:</label>
    					<input type="date" class="form-control" id="startdate" value="2018-01-01"/>
					<input type="time" class="form-control" id="starttime" value="08:00"/>
				</div>
				<div class="form-group">
    					<label for="enddate">End:</label>
    					<input type="date" class="form-control" id="enddate" value="2018-01-01"/>
					<input type="time" class="form-control" id="endtime" value="08:00"/>
				</div>
				<script>
					document.getElementById("startdate").addEventListener("change", function(){
						if(document.getElementById("startdate").value > document.getElementById("enddate").value){
							document.getElementById("enddate").value = document.getElementById("startdate").value;
						}
					}, false);
					document.getElementById("enddate").addEventListener("change", function(){
						if(document.getElementById("startdate").value > document.getElementById("enddate").value){
							document.getElementById("startdate").value = document.getElementById("enddate").value;
						}
					}, false);
				</script>
				<div class="form-group">
    					<label for="otherusers">Add Others:</label>
    					<input type="text" class="form-control" id="otherusers" placeholder="user1,user2,user3,..."/>
				</div>
			</form>
			<input type="button" id="createevent" value="Create" class="btn btn-light"/>
		</div>
	</div>

	<!-- Button to pull up sharing ui -->
	<div class="collapse" id="shareact">
		<div id="sharearea" class="text-center"></div>
	</div>

	<!-- Calendar buttons and table view -->
	<div id="calendar">
		<h1 id="timeTitle"></h1>
		<div id="monthnav">
			<input id="prevmonth" type="button" value="Previous Month" class="btn btn-light">
			<input id="curmonth" type="button" value="Current Month" class="btn btn-light">
			<input id="nextmonth" type="button" value="Next Month" class="btn btn-light">
			<input id="tagentry" type="text" placeholder="Type a Tag, press Enter">
		</div>
		<table id="weeks" style="width:100%" class="table table-bordered"></table>
	</div>
	
	<!-- Area for viewing event details -->
	<div id="eventview" style="display:none">
		<hr>
		<h3 id="eventviewtitle">Event</h3>
		<p id="eventviewtimes">Time</p>
		<p id="eventviewdescription">Description</p>
		<div id="editingbuttons">
			<input id="eventviewedit" type="button" value="Edit" class="btn btn-light">
			<input id="eventviewdelete" type="button" value="Delete" class="btn btn-light">
		</div>
	</div>

	<!-- Collapsing Editor -->
	<div id="eventedit" style="display:none">
		<hr>
		<div id="viewediteventform" class="card card-body">
			<form id = "editeventform">
  				<div class="form-group">
    					<label for="eetitle">Title:</label>
    					<input type="text" class="form-control" id="eetitle" placeholder="Event Title">
				</div>
				<div class="form-group">
    					<label for="eedescription">Description:</label>
    					<input type="text" class="form-control" id="eedescription" placeholder="Event Description">
				</div>
				<div class="form-group">
    					<label for="eetag">Tag:</label>
    					<input type="text" class="form-control" id="eetag" placeholder="Event Tag">
				</div>
				<div class="form-group">
    					<label for="estartdate">Start:</label>
    					<input type="date" class="form-control" id="estartdate" value="2018-01-01"/>
					<input type="time" class="form-control" id="estarttime" value="08:00"/>
				</div>
				<div class="form-group">
    					<label for="eenddate">End:</label>
    					<input type="date" class="form-control" id="eenddate" value="2018-01-01"/>
					<input type="time" class="form-control" id="eendtime" value="08:00"/>
				</div>
				<script>
					document.getElementById("estartdate").addEventListener("change", function(){
						if(document.getElementById("estartdate").value > document.getElementById("eenddate").value){
							document.getElementById("eenddate").value = document.getElementById("estartdate").value;
						}
					}, false);
					document.getElementById("eenddate").addEventListener("change", function(){
						if(document.getElementById("estartdate").value > document.getElementById("eenddate").value){
							document.getElementById("estartdate").value = document.getElementById("eenddate").value;
						}
					}, false);
				</script>
			</form>
			<input type="button" id="editeventconfirm" value="Edit" class="btn btn-light"/>
			<input type="button" id="editeventcancel" value="Cancel" class="btn btn-light"/>
		</div>
	</div>

	<script>
		//global script variables
		var current_offset = 0;
		var logged_in = false;
		var logged_in_user = "";
		var logged_in_user_id = -1;
		var logged_in_token = "";
		
		//Constructs and updates calendar
		function makeCalendar(offset){
			current_offset = offset;
			var date = new Date(), y = date.getFullYear(), m = date.getMonth();
			var firstDay = new Date(y, m + offset, 1);
			var lastDay = new Date(y, m + offset + 1, 0);
			var firstDayDayOfWeekNumber = firstDay.getDay();
			var lastDayDateNumber = lastDay.getDate();
			document.getElementById("weeks").innerHTML = "<tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>";
			for(i = 0; i < 7; i++){
				const newWeek = document.createElement("tr");
				newWeek.setAttribute("id", "week"+i);
				document.getElementById("weeks").appendChild(newWeek);
				//console.log(i + " weeks created.");
			}
			for (i = 0; i < firstDayDayOfWeekNumber; i++){
				const newDay = document.createElement("td");
				var week_id = Math.floor(i/7)+1;
				document.getElementById("week" + week_id).appendChild(newDay);
				//console.log((i+1) + " blank days created.");
			}
			for (i = firstDayDayOfWeekNumber; i < lastDayDateNumber+firstDayDayOfWeekNumber; i++) {
				const newDay = document.createElement("td");
				newDay.appendChild(document.createTextNode(1+i-firstDayDayOfWeekNumber));
				newDay.setAttribute("id", "day"+(i));
				var week_id = Math.floor(i/7)+1;
				document.getElementById("week" + week_id).appendChild(newDay);
			}
			const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			document.getElementById("timeTitle").innerHTML = monthNames[firstDay.getMonth()]  + " " + (firstDay.getYear()+1900);

			//Validates user, adds their events
			if(logged_in){
				const data = { 'userid': logged_in_user_id, 'token': logged_in_token};
				fetch("getevents.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
				})
				//.then(resp => resp.text()).then(p => console.log(p))
				.then(response => response.json())
				.then(function(data){
					for(var i = 0; i < data.length; i++){
						var event_lower = new Date(data[i].yearstart, data[i].monthstart-1, data[i].daystart);
						var event_upper = new Date(data[i].yearend, data[i].monthend-1, data[i].dayend);

						(function () {
							var event_id = data[i].event_id;
							var startmonth = data[i].monthstart;
							var startyear = data[i].yearstart;
							var startday = data[i].daystart;
							var starthour = data[i].hourstart;
							var startminute = data[i].minutestart;
							var endmonth = data[i].monthend;
							var endyear = data[i].yearend;
							var endday = data[i].dayend;
							var endhour = data[i].hourend;
							var endminute = data[i].minuteend;
							var title = data[i].title;
							var tag = data[i].tag;
							var description = data[i].description;
							const breakl = document.createElement("br");
							addbuttons(true,lastDay.getDate(), firstDay.getYear(), firstDay.getMonth(), firstDay.getDay(), event_lower,event_upper,event_id,startmonth,startyear,startday,starthour,startminute,endmonth,endyear,endday,endhour,endminute,title,tag,description);
						}());
					}
				})
			}

			//Validates user, adds events from shared calendars
			if(logged_in){
				const data = { 'userid': logged_in_user_id, 'token': logged_in_token};
				fetch("getsharedevents.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
				})
				//.then(resp => resp.text()).then(p => console.log(p))
				.then(response => response.json())
				.then(function(data){
					for(var i = 0; i < data.length; i++){
						var event_lower = new Date(data[i].yearstart, data[i].monthstart-1, data[i].daystart);
						var event_upper = new Date(data[i].yearend, data[i].monthend-1, data[i].dayend);

						(function () {
							var event_id = data[i].event_id;
							var startmonth = data[i].monthstart;
							var startyear = data[i].yearstart;
							var startday = data[i].daystart;
							var starthour = data[i].hourstart;
							var startminute = data[i].minutestart;
							var endmonth = data[i].monthend;
							var endyear = data[i].yearend;
							var endday = data[i].dayend;
							var endhour = data[i].hourend;
							var endminute = data[i].minuteend;
							var title = data[i].title;
							var tag = data[i].tag;
							var description = data[i].description;
							const breakl = document.createElement("br");
							addbuttons(false,lastDay.getDate(), firstDay.getYear(), firstDay.getMonth(), firstDay.getDay(), event_lower,event_upper,event_id,startmonth,startyear,startday,starthour,startminute,endmonth,endyear,endday,endhour,endminute,title,tag,description);
						}());
					}
				})
			}
		}
	
		//Function to add all of the events to the correct place on the table
		function addbuttons(canedit, ld, py, pm, pd, event_lower,event_upper,event_id,startmonth,startyear,startday,starthour,startminute,endmonth,endyear,endday,endhour,endminute,title,tag,description) {
			var currentduration = 0;
			//console.log(ld);
			for(var cont = 1; cont < ld+1; cont++){
				var iteration_date = new Date(py+1900, pm, cont);
				//console.log(iteration_date);
				if(event_lower <= iteration_date && iteration_date <= event_upper && (document.getElementById("tagentry").value.length > 0 ? tag == document.getElementById("tagentry").value : true)){
					currentduration += 1;
					const clickabletitle = document.createElement("input");
					clickabletitle.setAttribute("id", "eventbutton" + event_id +","+currentduration);
					clickabletitle.setAttribute("type", "button");
					clickabletitle.className += "btn btn-secondary";
					clickabletitle.setAttribute("value", title);
					document.getElementById("day" + (cont + pd - 1)).appendChild(document.createElement("br"));
					document.getElementById("day" + (cont + pd - 1)).appendChild(clickabletitle);

					//Adds the listener to buttons so they display data in the event viewer
					document.getElementById("eventbutton" + event_id +","+currentduration).addEventListener("click", function(){
						document.getElementById("editingbuttons").style.display = canedit ? "block" : "none";
						document.getElementById("eventviewtitle").innerHTML = title;
						var am = true;
						var adjustedstarthour = starthour;
						if(adjustedstarthour > 12){
							am = false;
							adjustedstarthour -= 12;
						}
						var am2 = true;
						var adjustedendhour = endhour;
						if(adjustedendhour > 12){
							am2 = false;
							adjustedendhour -= 12;	
						}
						document.getElementById("eventviewtimes").innerHTML = "From " + adjustedstarthour + ":" + ('0' + startminute).split(-2) + " " + (am?"AM":"PM") + " on " + startmonth + "/" + startday + "/" + startyear + " to " + adjustedendhour + ":" + ('0' + endminute).split(-2) + " " + (am2?"AM":"PM") + " on " + endmonth + "/" + endday + "/" + endyear;
						document.getElementById("eventviewdescription").innerHTML = description;
						document.getElementById("eventview").style.display = "block";
						document.getElementById("viewediteventform").style.display = "block";
						var old_element = document.getElementById("eventviewdelete");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);

						//Button for deleting event
						document.getElementById("eventviewdelete").addEventListener("click", function(){
							const data = { 'event_id': event_id, 'token': logged_in_token};
							fetch("deleteevent.php", {
								method: 'POST',
								body: JSON.stringify(data),
								headers : { 
									'Content-Type': 'application/json',
									'Accept': 'application/json'
								}
							})
							.then(resp => resp.text()).then(p => console.log(p))
							.then(function(data){
								makeCalendar(current_offset);
								document.getElementById("eventview").style.display = "none";
								document.getElementById("viewediteventform").style.display = "block";
							})
						}, false);
						document.getElementById("eventedit").style.display = "none";
						var old_element = document.getElementById("eventviewedit");
						var new_element = old_element.cloneNode(true);
						old_element.parentNode.replaceChild(new_element, old_element);

						//button for editing event
						document.getElementById("eventviewedit").addEventListener("click", function(){
							document.getElementById("eventedit").style.display = "block";
							document.getElementById("eetitle").value = title;
							document.getElementById("eedescription").value = description;
							document.getElementById("eetag").value = tag;
							document.getElementById("estartdate").value = ('000' + startyear).slice(-4) + "-" + ('0' + startmonth).slice(-2) + "-" + ('0' + startday).slice(-2);
							document.getElementById("estarttime").value = ('0' + starthour).slice(-2) + ":" + ('0' + startminute).slice(-2);
							document.getElementById("eenddate").value = ('000' + endyear).slice(-4) + "-" + ('0' + endmonth).slice(-2) + "-" + ('0' + endday).slice(-2);
							document.getElementById("eendtime").value = ('0' + endhour).slice(-2) + ":" + ('0' + endminute).slice(-2);
							var old_element = document.getElementById("editeventconfirm");
							var new_element = old_element.cloneNode(true);
							old_element.parentNode.replaceChild(new_element, old_element);

							//Confirms event edit
							document.getElementById("editeventconfirm").addEventListener("click", function(){
								document.getElementById("eventview").style.display = "none";
								document.getElementById("viewediteventform").style.display = "none";
								createeditedevent();
								document.getElementById("eventedit").style.display = "none";
								//console.log(title + " Edited!");
								const data = { 'event_id': event_id, 'token': logged_in_token};
								fetch("deleteevent.php", {
									method: 'POST',
									body: JSON.stringify(data),
									headers : { 
										'Content-Type': 'application/json',
										'Accept': 'application/json'
									}
								})
								//.then(resp => resp.text()).then(p => console.log(p))
							}, false);
							document.getElementById("editeventcancel").addEventListener("click", function(){
								document.getElementById("eventedit").style.display = "none";
							}, false);
						}, false);
					}, false);
				}
			}
		}

		//Function to login
		function loginAjax(event) {
			console.log("login attempt");
			const username = document.getElementById("username").value; // Get the username from the form
			const password = document.getElementById("password").value; // Get the password from the form
			const data = { 'username': username, 'password': password };
			fetch("login_ajax.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			//.then(resp => resp.text()).then(p => console.log(p))
			.then(response => response.json())
			.then(function(data){
				//console.log(data);
				if(data.success){
					console.log("Successful Login");
					logged_in = true;
					logged_in_user = data.username;
					logged_in_user_id = data.id;
					logged_in_token = data.token;

					document.getElementById("logarea").innerHTML = "";
					document.getElementById("sharearea").innerHTML = "";
					document.getElementById("logarea").innerHTML += "Logged in as " + logged_in_user + "\n";
					const logoutbutton = document.createElement("input");
					logoutbutton.setAttribute("id", "logoutbutton");
					logoutbutton.setAttribute("type", "button");
					logoutbutton.className += "btn btn-light";
					logoutbutton.setAttribute("value", "Log Out");
					const sharebutton = document.createElement("input");
					sharebutton.setAttribute("id", "sharebutton");
					sharebutton.setAttribute("type", "button");
					sharebutton.setAttribute("value", "Share Calendar");
					sharebutton.className += "btn btn-light";
					const shareusername = document.createElement("input");
					shareusername.setAttribute("id", "shareusername");
					shareusername.setAttribute("type", "text");
					shareusername.setAttribute("placeholder", "Username to Share With");
					document.getElementById("logarea").appendChild(logoutbutton);
					document.getElementById("sharearea").appendChild(shareusername);
					document.getElementById("sharearea").appendChild(document.createTextNode("\n"));
					document.getElementById("sharearea").appendChild(sharebutton);
					document.getElementById("sharearea").appendChild(document.createTextNode("\n"));
					document.getElementById("logoutbutton").addEventListener("click", logout, false);
					document.getElementById("sharebutton").addEventListener("click", sharecalendar, false);
					document.getElementById("eventcreation").style.display = "block";
					document.getElementById("viewcreateeventform").style.display = "block";
				}else{
					console.log("Login Failed");
					alert("Login Failed: Invalid Credentials");
				}
			}).then(function(data){
				makeCalendar(0);
			})
		}
		
		//function to send login information
		function signup(){
			document.getElementById("logarea").removeChild(loginbtn);
			document.getElementById("logarea").removeChild(sign_up);
			const createbutton = document.createElement("input");
			createbutton.setAttribute("id", "createbutton");
			createbutton.setAttribute("type", "button");
			createbutton.setAttribute("value", "Create");
			createbutton.className += "btn btn-secondary";
			document.getElementById("logarea").appendChild(createbutton);
			document.getElementById("createbutton").addEventListener("click", createuser, false);
		}

		//function to create a user
		function createuser(){
			const username = document.getElementById("username").value; // Get the username from the form
			const password = document.getElementById("password").value; // Get the password from the form
			//if(username.length >= 1 && password >= 1){
				
			//}
			const data = { 'username': username, 'password': password };
				fetch("createuser.php", {
					method: 'POST',
					body: JSON.stringify(data),
					headers : { 
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				//.then(resp => resp.text()).then(p => console.log(p))
				.then(response => response.json())
				.then(function(data){
					if(data.success){
						console.log("Successfully created " + username + ".");
					}else{
						console.log("That username is unavailable.");
					}
				})
			
				logreset();
		}

		//function to create an event from the creation form
		function createevent(){
			const title = document.getElementById("cetitle").value;
			const description = document.getElementById("cedescription").value;
			const tag = document.getElementById("cetag").value;
			const others = document.getElementById("otherusers").value.split(",");
			const sdate = document.getElementById("startdate").value;
			const stime = document.getElementById("starttime").value;
			const edate = document.getElementById("enddate").value;
			const etime = document.getElementById("endtime").value;

			const data = {
				'userid': logged_in_user_id,
				'title': title,
				'description': description,
				'tag': tag,
				'others' : others,
				'startyear': sdate.split("-")[0],
				'startmonth': sdate.split("-")[1],
				'startday': sdate.split("-")[2],
				'endyear': edate.split("-")[0],
				'endmonth': edate.split("-")[1],
				'endday': edate.split("-")[2],
				'starthour': stime.split(":")[0],
				'startminute': stime.split(":")[1],
				'endhour': etime.split(":")[0],
				'endminute': etime.split(":")[1],
				'token': logged_in_token
			};
			
			console.log(data);
			
			fetch("createevent.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(resp => resp.text()).then(p => console.log(p))
			.then(function(data){
				makeCalendar(current_offset);
				alert("Your event has been created.");
			});
			document.getElementById("createeventform").reset();
		}

		//function to create event from edit form
		function createeditedevent(){
			const title = document.getElementById("eetitle").value;
			const description = document.getElementById("eedescription").value;
			const tag = document.getElementById("eetag").value;
			const sdate = document.getElementById("estartdate").value;
			const stime = document.getElementById("estarttime").value;
			const edate = document.getElementById("eenddate").value;
			const etime = document.getElementById("eendtime").value;

			const data = {
				'userid': logged_in_user_id,
				'title': title,
				'description': description,
				'tag': tag,
				'startyear': sdate.split("-")[0],
				'startmonth': sdate.split("-")[1],
				'startday': sdate.split("-")[2],
				'endyear': edate.split("-")[0],
				'endmonth': edate.split("-")[1],
				'endday': edate.split("-")[2],
				'starthour': stime.split(":")[0],
				'startminute': stime.split(":")[1],
				'endhour': etime.split(":")[0],
				'endminute': etime.split(":")[1],
				'token': logged_in_token
			};
			
			console.log(data);
			
			fetch("createevent.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(resp => resp.text()).then(p => console.log(p))
			.then(function(data){
				makeCalendar(current_offset);
			});
		}

		//function to share calendar with other users
		function sharecalendar(){
			const sharer_id = logged_in_user_id;
			const sharee_username = document.getElementById("shareusername").value;

			const data = {
				'sharerid': sharer_id,
				'shareeuser': sharee_username,
				'token': logged_in_token
			};
			
			console.log(data);
			
			fetch("sharecalendar.php", {
				method: 'POST',
				body: JSON.stringify(data),
				headers : { 
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
		//	.then(resp => resp.text()).then(p => console.log(p))
			.then(response => response.json())
			.then(function(data){
				alert("Shared your calendar with " + data.found);
			})
		}

		//function to reset everything once a user logs out
		function logreset(){
			document.getElementById("logarea").innerHTML = "";
			document.getElementById("sharearea").innerHTML = "";
			const usernameinput = document.createElement("input");
			usernameinput.setAttribute("id", "username");
			usernameinput.setAttribute("type", "text");
			usernameinput.setAttribute("placeholder", "Username");
			document.getElementById("logarea").appendChild(usernameinput);
			document.getElementById("logarea").appendChild(document.createTextNode("\n"));

			const passwordinput = document.createElement("input");
			passwordinput.setAttribute("id", "password");
			passwordinput.setAttribute("type", "password");
			passwordinput.setAttribute("placeholder", "Password");
			document.getElementById("logarea").appendChild(passwordinput);
			document.getElementById("logarea").appendChild(document.createTextNode("\n"));

			const loginbutton = document.createElement("input");
			loginbutton.setAttribute("id", "loginbtn");
			loginbutton.setAttribute("type", "button");
			loginbutton.setAttribute("value", "Log In");
			loginbutton.className += "btn btn-light";
			document.getElementById("logarea").appendChild(loginbutton);
			document.getElementById("loginbtn").addEventListener("click", loginAjax, false);
			document.getElementById("logarea").appendChild(document.createTextNode("\n"));

			const singupbutton = document.createElement("input");
			singupbutton.setAttribute("id", "sign_up");
			singupbutton.setAttribute("type", "button");
			singupbutton.setAttribute("value", "Sign Up");
			singupbutton.className += "btn btn-light";
			document.getElementById("logarea").appendChild(singupbutton);
			//document.getElementById("logarea").innerHTML += "\n";
			document.getElementById("sign_up").addEventListener("click", signup, false);

			document.getElementById("eventcreation").style.display = "none";
			document.getElementById("viewcreateeventform").style.display = "none";
			document.getElementById("eventview").style.display = "none";
			document.getElementById("viewediteventform").style.display = "none";
			makeCalendar(0);
		}

		//function to log a user out
		function logout(){
			logged_in = false;
			logged_in_user = "";
			logged_in_user_id = -1;
			logged_in_token = "";

			console.log("<?php
				$_SESSION['logged_in'] = false;
				echo "deleted.";
			?>");

			logreset();
		}
		
		//Adding all event listeners
		document.getElementById("prevmonth").addEventListener("click", function(){ makeCalendar(current_offset - 1); }, false);
		document.getElementById("nextmonth").addEventListener("click", function(){ makeCalendar(current_offset + 1); }, false);
		document.getElementById("curmonth").addEventListener("click", function(){ makeCalendar(0); }, false);
		document.getElementById("tagentry").addEventListener("change", function(){ makeCalendar(current_offset); }, false);
		document.getElementById("loginbtn").addEventListener("click", loginAjax, false);
		document.getElementById("sign_up").addEventListener("click", signup, false);
		document.getElementById("createevent").addEventListener("click", createevent, false);
		document.addEventListener("DOMContentLoaded", makeCalendar(0), false);
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>