![ADG200px](https://user-images.githubusercontent.com/106081002/203866692-f6651411-4842-40b2-8a30-d2a6c5bc99ff.png)



# README BACKEND v1
 
Para descargar y ejecutar el proyecto seguiremos los siguientes pasos:

  1.  Abrimos un terminal en la carpeta seleccionada y ejecutamos el comando `git clone git@github.com:ADGetafe/ADGetafe-back.git` 
  2.  Antes de ejecutar Symfony vamos a descargar las dependencias desde el comando `composer install` este comando nos lee el archivo `composer.json` y mapeara en el proyecto si existe la carpeta `vendor` y si esta recoge las dependencias registradas en el archivo json.
  3.  Una vez instaladas las dependencias vamos a ejecutar el servidor PHP-CGI que incorpora Symfony para que nos ejecute el proyecto con el comando `Symfony server:start -d`  El atributo -d nos levantará el servidor con un `daemon` que se ejecuta en segundo plano en nuestro sistema operativo y que nos permitirá seguir usando el terminal sin preocuparnos de que se esté ejecutando o no.
  4.  Podemos ver estado del servidor ejecutando `symfony server:status` y pararlo con `symfony server:stop`

El proyecto se ha desarrollado con las siguiente tecnologías:
  - PHP 8.1
  - Symfony 5.4.14 (LongTermSupport)
  - MariaDB 10.4
  - PHPMyAdmin 5.2
  - Apache 2.4

El proyecto se compone de: 
  - Tres entidades:
      - `User.php`
      - `Noticias.php`
      - `Revistas.PHP`
         
  - Siete Controladores:
      - Los Controladores (que parten del Modelo Vista Controlador) gestionan los datos con las entidades y estos son pintados en las vistas que, en Symfony se llaman Templates.
        Los controladores que hemos creado son los siguientes:
        - `ApiController.php`; nos envía o pinta los datos de la base de datos al front en forma de carrusel y tarjetas.
        - `Noticiascontroller.php`; crea el formulario `NoticiasType` que nos persistirá las noticias en la base de datos.
        - `Revistascontroller.php`; nos gestiona el CRUD de revistas que también conecta y estructura el formulario `RevistasType` y las persiste en la DDBB.
        - `RegistrationController.php`; es el que nos crea un formulario de registro de usuario y también nos persiste los datos en la base de datos.
        - `SecurityController.php`, nos crea un `FormUser` que gestiona el login y el logout y lo persiste en la base de datos
        - `SuperAdminController.php`, gestiona el CRUD de usuarios y noticias, e igual quedan registarados en MariaDB
   
  - Cinco formularios
      - `EditUserType.php`;
      - `NoticiasType.php`;
      - `RegistrationFormType`;
      - `RevistasType`;
      - `UserType`;
  - Un formulario security
      - `loginFormAutenticatorAuthenticator.php`;
  - Tres repositorios
      - `NoticiasRepository.php`;
      - `RevistasRepository.php`;
      - `Userrepository.php`;
  - Nueve templates con sus distintas vistas:
    Que recogen y pintan la información que solicita el controlador a la base de datos vía entidades, siguiendo la estructura de los `Form` pintándose en los templates *.html.twig
      -  `admin_sup`;
      -  `api`;
      -  `articulo`;
      -  `logout`;
      -  `noticias`;
      -  `registration`;
      -  `revistas`;
      -  `security`;
      -  `super_admin`;
    - Que recogen y pintan la información que solicita el controlador a la base de datos vía entidades, siguiendo la estructura de los `Form` pintándose en los templates `*.html.twig`
 
  - vistas de symfony mostradas en el front del back
      - Login
      
      ![image](https://user-images.githubusercontent.com/106081002/203867345-61ae8667-0405-4f13-8c79-133e1170b226.png)
      
      - CRUD de usuario
      
      ![image1](https://user-images.githubusercontent.com/106081002/203867380-741315bd-5702-4d0a-9e14-37e63193acf8.png)
      
      - Edición de noticias
      
      ![image2](https://user-images.githubusercontent.com/106081002/203867392-1fd87bba-0c1b-4e5b-b9fa-505657c68007.png)
      
      - CRUD de noticias

      ![image3](https://user-images.githubusercontent.com/106081002/203867400-070b8f61-5aa6-4270-82fe-b87e8e3de5d8.png)
