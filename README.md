## uframework by Pierre Pic & Aurélien Pillevesse

###PHP PROJECT

This project  was realized by :

 - **Aurelien Pillevesse**
 - **Pierre Pic**

####**Server start:**

	php -S localhost:8080 -t web/

####**DOCKER DATABASE:**

Create the docker :

	$ docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"

Run the docker new image, with this following command:

	$ docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"

When the docker image run, a prompt is displayed, in which you can use some command, for example create the table STATUS:
	
	source schemaMYSQL.sql

To connect ot the database you have to use the following command.

	$ mysql uframework -h127.0.0.1 -P<assigned port> -uuframework -p

You have to give the port forwarded by the image with the `docker ps` command. 
