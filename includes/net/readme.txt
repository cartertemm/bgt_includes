net class, a network wrapper around bgt's networking capabilities
written by amir ramezani

introduction
this is a wrapper around bgt's network and network_event classes that simplifies working with UDP network in bgt
also it support's packet encryption and decryption

usage:
first, declare an instance of net class:
net n;
then, if you want to create server, use set_port function to give it a port and then use create_server to make it as a server
otherwise if you want to make it as a client, use create_client function (client does not require a port to listen)
also you can use set_decryption_key() to give it an encryption key, set_incoming_bandwidth(), and set_outgoing_bandwidth() to set the incoming and outgoing bandwidth respectively
then in your main loop, call this:
n.request();
then you can use get functions to retrieve anything that you want
you can use connect function to connect to someone, use send function to send a packet to a peer
functions:

void set_decryption_key(string dec)

parameters:
dec
the decryption key to set, if empty, encryption will be disabled

return value:
none

remarks:
you must set your key with this function if you want your packets to be encrypted

string get_message()

parameters:
none

remarks:
return's the message that was received from the server
please note that the net class automaticly encrypt/or decrypt the message for you, hense you don't need to do encryption and decryption

int get_channel()

parameters:
none

return value:
the channel, that the message was received from

remarks:
you can send messages through channels in bgt, this function return's the channel for you

int get_peer_id()

parameters:
none

return value:
the peer id that the packet was received from

remarks:
you can check with this function that who sent a packet, and possibly, you can skip him in processing of broadcasting the packet

int get_id()

parameters:
none

return value:
this function return's our peer-id on the server

remarks:
this is got dirring the connect function, and return's the client's peer id that is going to connect to server

void set_port(int p)

parameters:
p
the port that you want to set

return value:
none

remarks:
with this function, you can set the listening port

int get_port()

parameters:
none

return value:
the port that previously had been set

remarks:
this function return's the listening port which was previously set with set_port function

bool set_incomming_bandwidth(double i)

parameters:
i
incomming bandwidth

return value:
true if incoming bandwidth limit has successfully been set, false otherwise

remarks:
this is useful if you want to limit packets

double get_incoming_bandwidth()

parameters:
none

return value:
the incoming bandwidth

remarks:
this function return's the incoming bandwidth

bool set_outgoing_bandwidth(double o)

parameters:
o

return value:
true if outgoing bandwidth has successfully been set, false otherwise

remarks:
this function limit's the outgoing bandwidth, useful if you want to limit the packets that want' to be sent

double get_outgoing_bandwidth()

parameters:
none

return value:
the outgoing bandwidth

remarks:
this function return's the outgoing bandwidth that previously was set

bool is_none()

parameters:
none

return value:
return's true if nothing happened, false otherwise

remarks:
this function check's that nothing was received, or noone connected or disconnected
please note that you must call request() method in your main loop

bool is_connected()

parameters:
none

return value:
return's true if someone connected

remarks:
this function check's if a peer connected to server
please note that you must call request() method in your main loop

bool is_received()

parameters:
none

return value:
true if a packet has been received, false otherwise

remarks:
this function check's if a packet was received then you can process it
please note that you must call request() method in your main loop

bool is_disconnected()

parameters:
none

remarks:
this function check's if a peer disconnected
please note that you must call request() method in your main loop

void request()

parameters:
none

return value:
none

remarks:
you must call this in the main loop in order to get information about connections, disconnections, and packets

bool create_server(int max_channels, int max_clients)

parameters:
max_channels, maximum is 100
max_clients
the maximum clients that can connect to server, maximum is 4000

return value:
true if server has successfully been set up, false otherwise

remarks:
this function set's up the server, and listen's to the given port that was set in set_port method

bool create_client(int max_channels, int max_peers)

parameters:
max_channels
the maximum channels, maximum is 100
max_peers
maximum peers that can connect and send packets, maximum is 4000

return value:
true if network has been successfully set up in client mode, false otherwise

remarks:
this function set's the network in client mode
you must call this before trying to connect

uint[] get_peer_list()

parameters:
none

return value:
an array containing the list of peers

remarks:
look at bgt's refference manual, this function is that, this function returns the list of peer ids that are currently connected

double get_ping_time(uint p)

parameters:
p
the peer id that you want to ping

return value:
the time between pinging and the arrival of packet

remarks:
round trip time, known as ping, is useful in most senarios.
an example is, when you want to find out when the packet arrives to destination, you can use this function
ping is based on kilometers and can never be less than 20 milliseconds

string get_address(uint p)

parameters:
p
the peer id that you want to get it's hostname

return value:
a string containing the hostname

remarks:
this is useful for example, if you want to know where the client is from using the hostname or better to say, his assigned IP address

void connect(string h, uint p)

parameters:
h
the host to connect to
p
the port number

return value:
none

remarks:
with this function, you can connect to a server
please note that the server must listen's to the port

bool destroy()

parameters:
none

return value:
true if success, false otherwise

remarks:
nothing, just destroy's the network

bool disconnect(int pid, int how)

parameters:
pid
the peer id to disconnect
how
see remarks

return value:
true if the peer has successfully been disconnected, false otherwise

remarks: 
if how is set to 1, the network disconnect's the peer, without taking time to send packets
but a notification is garanteed to be given to the peer
if how is set to 2, the network immediately disconnect's the peer without giving any response
if how is set to 3, the network send's all the packets, then disconnect's the peer

bool send(int pid, string msg, int ch, bool reliable)

parameters:
pid
the peer id to send packet to
msg
the message that is going to be sent
ch
the channel number to send the packet from
reliable
true if you want to send the packet as a reliable one, false otherwise

return value:
true if the packet has successfully been sent, false otherwise

remarks:
this function send's a packet to a given peer, if pid is set to 0, the packet is broadcasted, meaning that it will be sent to anyone on the network
don't encrypt the message yourself if you previously set the encryption key, it will be encrypted automaticly

notes:
i'm not responsible for any usage of this script, use it totaly is at your own risk

contact:
email: amir.ramezani1370@gmail.com
skype: amir.ramezani1370
audiogames.net forum username: visualstudio