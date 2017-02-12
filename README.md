## uframework by Pierre Pic & Aurélien Pillevesse

### PHP PROJECT

This project  was realized by :

 - **Aurelien Pillevesse**
 - **Pierre Pic**

#### **Server start:**

	php -S localhost:8080 -t web/

#### **DOCKER DATABASE:**

Create the docker :

	$ docker run -d \
    --volume /var/lib/mysql \
    --name data_mysql \
    --entrypoint /bin/echo \
    busybox \
    "mysql data-only container"

Run the docker new image, with this following command:

	$ docker run -d -p 3306 \
    --name mysql \
    --volumes-from data_mysql \
    -e MYSQL_USER=uframework \
    -e MYSQL_PASS=p4ssw0rd \
    -e ON_CREATE_DB=uframework \
    tutum/mysql

When the docker image run, a prompt is displayed, in which you can use some command, for example create the table STATUS:

	source schemaMYSQL.sql

To connect ot the database you have to use the following command.
(You have to give the port forwarded by the image with the `docker ps` command.)
In the example below, the port is 32768 but take care to write the port is written by the `docker ps` command.

    $ mysql uframework -h127.0.0.1 -P32768 -uuframework -pp4ssw0rd < app/config/schemaMYSQL.sql

If it's not the port 32768, you have to change it at line 16 of the app/app.php file.

### BILAN

Les points qui ont été réalisés : 
	- Les status
	- Les utilisateurs
	- La connexion
	- La déconnexion
	- L'affichage avec des options de tris
	- La gestion des erreurs lors de l'inscription/connexion
	- La gestion d'erreur si on mets l'url d'un status qui n'existe pas
