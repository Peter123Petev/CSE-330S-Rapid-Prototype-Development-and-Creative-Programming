// Require the packages we will use:
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
	// This callback runs when a new connection is made to our HTTP server.
	
	fs.readFile("client.html", function(err, data){
		// This callback runs when the client.html file has been read from the filesystem.
		
		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);

//Variables to store information on server
var users = [];
var public_chats = [];
var private_chats = {};
var user_chat_map = {};
var chat_userids_map = {};
var id = 0;

var io = socketio.listen(app);
io.sockets.on("connection", function(socket){
	//assign ids on creation
	socket.on('create_id', function() {
		io.sockets.emit("assign_ids",{id:id});
		id++;
	});

	//check if user exists and add
	socket.on('add_user', function(data) {
		console.log("new user attempt: "+data["new_user"]);
		var found = false;
		for (var i=0; i<users.length; i++) {
			if (users[i] === data["new_user"]) {
				found = true;
			}
		}
		if(found){
			console.log("new user already exists: "+data["new_user"]);
			io.sockets.emit("new_user_success",{id:data['id'],new_user:data['new_user'],success:false});
		}else{
			console.log("new user created: "+data["new_user"]);
			users.push(data["new_user"]);
			io.sockets.emit("new_user_success",{id:data['id'],new_user:data['new_user'],success:true});
		}
	});

	//check if room exists, add public room
	socket.on('create_public', function(data) {
		var found = false;
		for (var key in chat_userids_map) {
			if (key === data["new_chat_name"]) {
				found = true;
			}
		}
		if(found){
			console.log("new chat already exists: "+data["new_chat_name"]);
			io.sockets.emit("new_chat_success",{id:data['id'],new_chat_name:data['new_chat_name'],success:false});
		}else{
			public_chats.push(data["new_chat_name"]);
			user_chat_map[data['user_name']] = data["new_chat_name"];
			chat_userids_map[data["new_chat_name"]] = [];
			chat_userids_map[data["new_chat_name"]].push(data['user_name']);
			console.log(JSON.stringify(chat_userids_map));
			console.log("new chat created: "+data["new_chat_name"]);
			io.sockets.emit("new_chat_success",{id:data['id'],new_chat_name:data['new_chat_name'],success:true});
		}
	});

	//check if room exists, add private
	socket.on('create_private', function(data) {
		var found = false;
		for (var key in chat_userids_map) {
			if (key === data["new_chat_name"]) {
				found = true;
			}
		}
		if(found){
			console.log("new chat already exists: "+data["new_chat_name"]);
			io.sockets.emit("new_chat_success",{id:data['id'],new_chat_name:data['new_chat_name'],success:false});
		}else{
			private_chats[data["new_chat_name"]] = data["new_chat_pass"];
			user_chat_map[data['user_name']] = data["new_chat_name"];
			chat_userids_map[data["new_chat_name"]] = [];
			chat_userids_map[data["new_chat_name"]].push(data['user_name']);
			console.log(JSON.stringify(chat_userids_map));
			console.log("new chat created: "+data["new_chat_name"] + " with password " + private_chats[data["new_chat_name"]]);
			io.sockets.emit("new_chat_success",{id:data['id'],new_chat_name:data['new_chat_name'],success:true});
		}
	});

	//join public room
	socket.on('join_public', function(data) {
		user_chat_map[data['user_name']] = data["new_chat_name"];
		chat_userids_map[data["new_chat_name"]].push(data['user_name']);
		if(Object.keys(chat_userids_map).includes(data["current_chat"])){
			for(var i = 0; i < chat_userids_map[data["current_chat"]].length; i++){
				if(data['user_name'] === chat_userids_map[data["current_chat"]][i]){
					chat_userids_map[data["current_chat"]].splice(i, 1);
				}
			}
		}
		io.sockets.emit("room_changed",{id:data['id'],new_chat_name:data['new_chat_name'],success:true});
	});

	//join private room if password is correct
	socket.on('join_private', function(data) {
		if(private_chats[data['new_chat_name']] === data['new_chat_pass']){
			user_chat_map[data['user_name']] = data["new_chat_name"];
			chat_userids_map[data["new_chat_name"]].push(data['user_name']);
			if(Object.keys(chat_userids_map).includes(data["current_chat"])){
				for(var i = 0; i < chat_userids_map[data["current_chat"]].length; i++){
					if(data['user_name'] === chat_userids_map[data["current_chat"]][i]){
						chat_userids_map[data["current_chat"]].splice(i, 1);
					}
				}
			}
			io.sockets.emit("room_changed",{id:data['id'],new_chat_name:data['new_chat_name'],success:true});
		}else{
			io.sockets.emit("room_changed",{id:data['id'],new_chat_name:data['new_chat_name'],success:false,msg:"Incorrect password"});
		}
	});

	//asks server to refresh all clients
	socket.on('update_request', function(data) {
		io.sockets.emit("update",{users:JSON.stringify(users),public_chats:JSON.stringify(public_chats),private_chats:JSON.stringify(Object.keys(private_chats)),user_chat_map:JSON.stringify(user_chat_map)});
	});

	//receiving message from clients
	socket.on('send_message', function(data) {
		if(data['msg'].charAt(0) === '!'){
			if(data['msg'].includes(' ')){
				//check for commands in message
				switch(data['msg'].split(' ')[0]){
					case '!kick': 
						console.log(data['user'] + " is trying to kick " + data['msg'].split(' ')[1] + " from the " + data['chat'] + " chat");
						if(chat_userids_map[data['chat']].length > 0){
							if(chat_userids_map[data['chat']][0] === data['user']){
								if(Object.keys(chat_userids_map).includes(data["chat"])){
									for(var i = 0; i < chat_userids_map[data["chat"]].length; i++){
										if(data['msg'].split(' ')[1] === chat_userids_map[data["chat"]][i]){
											chat_userids_map[data["chat"]].splice(i, 1);
											user_chat_map[data['msg'].split(' ')[1]] = null;
										}
									}
								}
								io.sockets.emit("kick",{user:data['user'],target:data['msg'].split(' ')[1],chat:data['chat']});
							}
						}
					break;
					case '!ban': 
						console.log(data['user'] + " is trying to ban " + data['msg'].split(' ')[1] + " from the " + data['chat'] + " chat");
						if(chat_userids_map[data['chat']].length > 0){
							if(chat_userids_map[data['chat']][0] === data['user']){
								if(Object.keys(chat_userids_map).includes(data["chat"])){
									for(var i = 0; i < chat_userids_map[data["chat"]].length; i++){
										if(data['msg'].split(' ')[1] === chat_userids_map[data["chat"]][i]){
											chat_userids_map[data["chat"]].splice(i, 1);
											user_chat_map[data['msg'].split(' ')[1]] = null;
										}
									}
								}
								io.sockets.emit("ban",{user:data['user'],target:data['msg'].split(' ')[1],chat:data['chat']});
							}
						}
					break;
					case '!message': 
						var parsed_msg_raw = data['msg'].substr(data['msg'].indexOf(" ") + 1);
						var parsed_msg = parsed_msg_raw.substr(parsed_msg_raw.indexOf(" ") + 1);
						console.log(data['user'] + " is trying to message " + data['msg'].split(' ')[1] + " from the " + data['chat'] + " chat: " + parsed_msg);
						io.sockets.emit("receive_private_message",{user:data['user'],target:data['msg'].split(' ')[1],chat:data['chat'],msg:parsed_msg});
					break;
					default: io.sockets.emit("receive_message",{user:data['user'],chat:data['chat'],msg:data['msg']}); break;
				}
			}else{
				io.sockets.emit("receive_message",{user:data['user'],chat:data['chat'],msg:data['msg']});
			}
		}else{
			io.sockets.emit("receive_message",{user:data['user'],chat:data['chat'],msg:data['msg']});
		}
	});

	//resends image to all clients
	socket.on('send_image', function(data) {
		io.sockets.emit("receive_image",{user:data['user'],chat:data['chat'],msg:data['msg']});
	});

	//resends link to all clients
	socket.on('send_link', function(data) {
		io.sockets.emit("receive_link",{user:data['user'],chat:data['chat'],msg:data['msg']});
	});
});