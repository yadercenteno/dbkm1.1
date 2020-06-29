DBKM Backend
====================

Backend para aplicaciones web con KumbiaPHP con la elegancia de Bootstrap de Twitter.  Con el DBKM podrás gestionar de manera rápida y segura los usuarios, perfiles, recursos, menús, y mucho más!.

Esta versión está basada en el DBKM original de argordmel que se puede encontrar aquí https://github.com/argordmel/dbkm, pero con una versión actualizada del Core de KumbiaPHP versión 1.1.2, versión de Bootstrap v3.1.1, jQuery v1.11.0, jquery-jeditable, PHPExcel v1.7.7 (para uno de los ejemplos) y que ya incluye 2 ejemplos prácticos para poder explorar las ventajas de KumbiaPHP, los cuales son:
1. CRUD de un Catalogo de cuentas sencillo (Código y Nombre de cuents) con ejemplo de informe visual, versión exportable a Excel y opción de importar datos desde Excel usando una plantilla provista por el mismo DBKM.
2. Listado de presupuesto de 1 sola página (todo se hace desde 1 sola vista) donde se puede agregar, eliminar y editar esos datos por AJAX.  Para editar, se hace uso de la librería jquery-jeditable, la cual permite hacer cambios solo dando click con el ratón sobre el campo que se quiere editar "in-line" (ahí mismo).

![image](https://i.ibb.co/bm9K2FC/dbkm1-1.png)


Instalación
-------------------
Para instalar el DBKM simplemente lo descargas, creas una base de datos MySQL llamada "dbkm" e importas el archivo backup-1.sql ubicado en la carpeta "app/temp/backup", editas el databases.ini y databases.org.ini con los parámetros de conexión.

Esta versión del DBKM ha sido probada sobre PHP 7.2 y 7.3 usando Apache como web server y MySQL como gestor de Base de Datos.


Usuarios incluidos
-------------------

Para efectos de conocer como funciona el BDKM, se han creado 2 usuarios con privilegios diferentes:

Administrador (con todas los privilegios posibles)

Usuario: admin

Clave: 123456

-------------------

Usuario con un perfil "normal"

Usuario: prueba

Clave: prueba123

Para los ejemplos creados, este usuario puede ver/imprimir/exportar a Excel el presupuesto (sin editar, ni elminar) y SI puede agregar/editar las cuentas (sin poder eliminarlas).



Perfiles
-------------------
La gestión de perfiles permite administrar los direfentes roles de los usuarios que acceden al sistema.

Recursos
-------------------
Los recursos son las acciones o métodos que se pueden ejecutar en los controladores

Privilegios
-------------------
Los privilegios son los recursos que puede acceder cada perfil creado, brindando una mayor seguridad y escalabilidad al sistema

Menús
-------------------
La administración de menús permite gestionar los diferentes menús para que los usuarios accedan a los recursos.  Por ahora cada menú puede tener un submenú

Empresa
-------------------
Permite la administración de los datos básicos de la empresa

Sucursales
-------------------
Si esta opción está habilitada, permite gestionar las sucursales de la empresa y asignarla a un usuario específico

Accesos
-------------------
Permite la visualización de las entradas y salidas de los usuarios del sistema

Backups
-------------------
Permite crear copias de seguridad y restaurar el sistema en un punto específico

Auditorías
-------------------
Las acciones que realizan los usuarios en el sistema se registran para tener un control sobre los eventos generados.

Visor de sucesos
-------------------
Si está activo, permite la visualización de los logs de las consultas generadas en la base de datos, para tener un control sobre la base de datos

Mantenimiento
-------------------
Permite optimizar, vaciar el cache, desfragmentar y reparar (si es posible) las tablas de la base de datos

Archivos de configuración
-------------------
Permite editar los diferentes archivos de configuración del sistema ubicados en la carpeta "config" de la aplicación

