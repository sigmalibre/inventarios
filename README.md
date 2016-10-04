# inventarios
Sistema de gestión de inventarios para empresas.

___

### Instalación

1. Este paquete utiliza composer para el manejo de librerías. Puedes Instalar Composer desde su página oficial: https://getcomposer.org/download/. Una vez instalado, podemos descargar todas las librerías necesarias con el comando: `php composer.phar install`

2. Es posible que en la primer instalación tambien haga falta correr un segundo comando de composer para el *autoload* de los paquetes y clases necesarias: `php composer.phar dump-autoload -o`

3. Utilizamos el microframework [Slim](http://www.slimframework.com/) para desarrollar esta aplicación. Para el correcto funcionamiento de Slim, debemos configurar nuestro servidor web para redirigir todos los *request HTTP* a nuestro archivo *front-controller* ubicaco en `inventarios/public/index.php`. Ya que esta configuración es distinta según tu sistema operativo y servidor web, tendrás que investigar por tu cuenta, pero puedes comenzar en este [link](http://www.slimframework.com/docs/start/web-servers.html).

4. Actualmente utilizamos MySQL para el manejo de datos. Es necesario crear una base de datos llamada `inventarios`. Y un usuario con el nombre `invuser` y la contraseña `invpass`. Se puede hacer por ejemplo desde phpMyAdmin o desde la terminal con los siguientes comandos: `CREATE DATABASE inventarios;` `GRANT ALL ON inventarios.* TO 'invuser'@'%' IDENTIFIED BY 'invpass;'`

5. Luego debemos importar el archivo con la estructura de la base de datos ubicado en `app/DataSource/mysqldump_schema.sql`.
