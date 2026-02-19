Enunciado de la actividad (Sistemas Informáticos)

Curso: 1º DAM
Evaluación: 2ª evaluación
Módulo: Sistemas Informáticos

Contexto

Vas a preparar un equipo (real o virtual) para una fotógrafa que quiere guardar y compartir sus fotos de forma segura entre varios dispositivos. Para ello, se pide configurar un sistema operativo y varios servicios básicos aplicando lo trabajado en la segunda evaluación: usuarios, permisos, red, servicios y copias de seguridad.

Objetivos de la actividad
-Configurar un sistema (Windows o Linux) para que:
-Haya usuarios con permisos correctos.
-Exista una estructura de carpetas organizada para el trabajo.
-Se pueda acceder a una carpeta compartida por red.
-Se realicen copias de seguridad básicas.
-Se documenten los pasos.

Tareas obligatorias

1. Sistema y red
-Instalar (o usar ya instalado) un sistema operativo: Ubuntu o Windows.
-Mostrar la configuración de red del equipo (IP, máscara, puerta de enlace y DNS).
-Cambiar el nombre del equipo a: FOTO-DAM-01.

2. Usuarios y grupos
Crear los siguientes usuarios:
-thais (usuario principal)
-editor (solo edición)
-invitado (solo lectura)

-Crear un grupo llamado fotografia e incluir a thais y editor.
-Configurar contraseñas y documentar la política mínima (longitud, etc.).

3. Estructura de carpetas

Crear esta estructura:
-Proyectos/
-Proyectos/Familia/
-Proyectos/Naturaleza/
-Proyectos/Entregas/

4. Asignar permisos:
-thais: lectura/escritura en todo.
-editor: lectura/escritura en Familia y Naturaleza, pero no borrar Entregas.
-invitado: solo lectura en Entregas.




Respuesta:


En esta actividad he configurado un sistema operativo Windows para preparar un equipo de trabajo para una fotógrafa. Mi objetivo ha sido organizar las fotos y permitir que varios usuarios puedan acceder a los archivos de forma segura.

Para ello, he creado usuarios, carpetas y permisos, he configurado la red y he realizado una copia de seguridad básica, aplicando los conocimientos aprendidos en clase.

1. SISTEMA Y RED

He utilizado un sistema operativo Windows ya instalado en el equipo.
Para comprobar la configuración de red he abierto el Símbolo del sistema (cmd) y he ejecutado el comando:
``
ipconfig /all
``

Con este comando se ven los siguientes datos:
-Dirección IP
-Máscara de subred
-Puerta de enlace
-Servidores DNS

A continuación, he cambiado el nombre del equipo:
Nombre asignado: FOTO-DAM-01

Ruta utilizada:
Configuración → Sistema → Acerca de → Cambiar el nombre de este equipo
Después he reiniciado el pc para aplicar los cambios.

2. USUARIOS Y GRUPOS

He creado los siguientes usuarios desde Configuración → Cuentas → Otros usuarios:
-thais → usuario principal
-editor → usuario con permisos de edición
-invitado → usuario con permisos de solo lectura

Todos los usuarios son usuarios estándar.

**Grupo fotografia**
He creado un grupo llamado fotografia usando la herramienta lusrmgr.msc.
Usuarios incluidos en el grupo:
-thais
-editor

**Política de contraseñas**
Las contraseñas configuradas cumplen las siguientes normas mínimas:
-Longitud mínima de 8 caracteres
-Uso de letras y números
-No se permiten contraseñas vacías

3. ESTRUCTURA DE CARPETAS

He creado la siguiente estructura de carpetas en el disco:

C:\Proyectos
│
├── Familia
├── Naturaleza
└── Entregas


Esta estructura permite organizar el trabajo fotográfico de forma clara.

4. PERMISOS DE USUARIOS

**Usuario thais**
-Lectura y escritura en todas las carpetas
-Control total sobre el contenido

**Usuario editor**
-Carpeta Familia: lectura y escritura
-Carpeta Naturaleza: lectura y escritura
-Carpeta Entregas: solo lectura (no puede borrar archivos)

**Usuario invitado**
-Carpeta Entregas: solo lectura
-Sin acceso al resto de carpetas

Los permisos se han configurado desde:
Propiedades → Seguridad de cada carpeta.

5. COPIAS DE SEGURIDAD

He configurado una copia de seguridad básica utilizando el Historial de archivos de Windows.

Ruta:
Configuración → Actualización y seguridad → Copia de seguridad

He seleccionado la carpeta Proyectos para que se realicen copias automáticas.

6. PROBLEMAS ENCONTRADOS Y SOLUCIONES

El usuario editor podía borrar archivos de la carpeta Entregas.
→ Lo he solucionado quitando el permiso de modificación.

En algunos sistemas no aparece lusrmgr.msc.
→ Lo he comprobado que el sistema utilizado es Windows Pro.

7. CONCLUSIÓN

El sistema Windows ha sido configurado correctamente para permitir:
-Uso seguro de los archivos
-Control de accesos mediante usuarios y permisos
-Organización del trabajo
-Copias de seguridad básicas


Con esta práctica he conseguido configurar correctamente el sistema Windows según lo solicitado. He asignado los permisos adecuados a cada usuario y he organizado las carpetas de forma correcta.

Además, he realizado una copia de seguridad para proteger los archivos importantes. Esta actividad me ha ayudado a entender mejor la gestión de usuarios, permisos y seguridad en un sistema operativo.
