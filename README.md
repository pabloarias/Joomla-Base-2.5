Joomla-Base
===========

El pack Joomla-Base está compuesto por el gestor de contenidos Joomla, su traducción al español, diversas extensiones y contenidos que ayudan a ahorrar tiempo a la hora de desplegar nuevos sitios web.

Paquetes utilizados:
- Joomla 2.5.11
- Idioma español 2.5.10
- Akeeba Backup 3.7.6 y traducción al español.
- JCE 2.3.2.4 y traducción al español 2.2.7.2
- Xmap 2.3.3
- Framework Gantry 4.1.9 (incluye template y RokNavMenu 2.0.2)
- aiContactSafe 2.0.19
- Google Maps plugin 2.18
- JLSecure My Site 1.0.1
- Title Manger 2.0

Contenidos incluidos:
- Página de error
- Nota legal
- Política de privacidad

Notas:
- Para acceder a la administración de Joomla: www.ejemplo.com/administrator?secure_key=secure_value. Configuración de seguridad proporcionada por el plugin JLSecure.
- El usuario y la contraseña son "admin". Recomendable cambiarlos.
- El archivo con la base de datos es joomlabase.sql. Es necesario borrar este archivo antes de poner el proyecto en producción.

Intalación o despliegue:
Para desplegar el proyecto es necesario descargar todos los archivos, importar la base de datos en MySQL y adaptar el fichero configuration.php.

Archivos a eliminar antes del despliegue:
- README.md
- joomla-base.sql
- .gitignore
