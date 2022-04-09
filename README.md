## Install App

Instalar docker.

Si estan en linux deben instalar docker-compose.

Se debe copiar el archivo docker-compose.yml.example y le damos el nombre de docker-compose.yml (en este archivo podemos cambiar el puerto al mysql y a la app, por el que nos convenga mas).

Entramos a la carpeta del proyecto, y ejecutamos los siguientes comandos:

"docker-compose up -d" -> este comando empezará a construir las maquinas de docker.

"docker-compose exec php bash" -> accedemos a la maquina de php

#dentro de la maquina debemos de correr los siguientes comandos, 
#Nota: esta imagen tiene unos comandos personalizados.

"php composer.phar install"
"php artisan key:generate"
"migrate"

Listo, tendremos nuestra app funcionando.