

4. Ahora creo mi base de datos:
-CREATE DATABASE portafolioexamen;
Para comprobar si es cierto que tengo o no portafolioexamen:
-SHOW DATABASES;
Me meto dentro de portafolio:
-USE portafolioexamen;


4. Ahora creo mis tablas:
```
CREATE TABLE piezasportafolio(
  Identificador INT auto_increment PRIMARY KEY,
  titulo VARCHAR(255),
  descripcion TEXT,
  fecha VARCHAR(255),
  id_categoria INT
);
```
Para ver que es lo que ocurre:
- SHOW TABLES;

Que es piezas:
- DESCRIBE piezasportafolio;

```
CREATE TABLE categoriasportafolio(
  Identificador INT auto_increment PRIMARY KEY,
  nombre VARCHAR(255)
);
```
Para comprobar que tenemos las dos tablas:
-SHOW TABLES;
Para ver que tenemos la tabla de autores completamente extructurada:
- DESCRIBE categoriasportafolio;

5. Ahora alteramos las tablas (restricción de clave foranea):

```
ALTER TABLE piezasportafolio 
ADD CONSTRAINT categoriasportafolio_a_piezasportafolio 
FOREIGN KEY (id_categoria) 
REFERENCES categoriasportafolio(Identificador) 
ON DELETE RESTRICT 
ON UPDATE RESTRICT;
```
Ahora ya exixte una relación entre autores y piezas del portafolio.


6. Añado datos a las tablas:
```
INSERT INTO categoriasportafolio VALUES(
  NULL,
  '1'
  'lenguaje de marcas'
);

```
SELECT * FROM categoriasportafolio;

```
INSERT INTO piezasportafolio VALUES(
  NULL,
  'Titulo de la pieza 1',
  'Descripción de la pieza 1',
  '2025-11-10',
  1
);
```
SELECT * FROM piezas;

7. Alteramos la tabla para añadir imagen:
```
ALTER TABLE piezasportafolio
ADD COLUMN imagen VARCHAR(255);
```

Hacemos:
DESCRIBE piezasportafolio;
Y vemos como ya aparece imagen

8. Hago una vista cruzada:
```
SELECT 
categoriasportafolio.nombre,
piezasportafolio.titulo,
piezasportafolio.descripcion,
piezasportafolio.fecha,
piezasportafolio.imagen
 FROM piezasportafolio
LEFT JOIN categoriasportafolio
ON piezasportafolio.id_categoria = categoriasportafolio.Identificador;
```

Ahora creo la vista:
```
CREATE VIEW piezasportafolio_con_categoriasportafolio AS 
SELECT 
categoriasportafolio.nombre,
piezasportafolio.titulo,
piezasportafolio.descripcion,
piezasportafolio.fecha,
piezasportafolio.imagen
 FROM piezasportafolio
LEFT JOIN categoriasportafolio
ON piezasportafolio.id_categoria = categoriasportafolio.Identificador;
```

SELECT * FROM piezasportafolio_con_categoriasportafolio;

9. Ahora creo un usuario con permisos:

En consola:
```
CREATE USER 
'portafolio'@'localhost' 
IDENTIFIED  BY 'Portafolio123$';
```

Ahora le doy todos los permisos:
```
GRANT USAGE ON *.* TO 'portafolio'@'localhost';
```

Altero el usuario para que no tenga limites:
```
ALTER USER 'portafolio'@'localhost' 
REQUIRE NONE 
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0;
```

Le doy permiso al usuario portafolio para la base de datos portafolioexamen:
```
GRANT ALL PRIVILEGES ON `portafolioexamen`.* 
TO 'portafolio'@'localhost';
```

Y recargo los privilegios:
```
FLUSH PRIVILEGES;
```
En php myadmin:
En php myadmin da error hacerlo como en la consola, entonces , lo he hecho es irme a cuentas de usuario y he agragado un usuario manuealmente.
Usuario: portafolio2
Contraseña: Portafolio123$
y me ha dado este código:
```
CREATE USER 'portafolio2'@'%' IDENTIFIED VIA mysql_native_password USING '***';GRANT USAGE ON *.* TO 'portafolio2'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
```

10. Ahora demuestro que actualizo:
```
SELECT * FROM piezasportafolio;
```

Como la imagen es NULL:
```
UPDATE piezasportafolio SET imagen = 'serena.jpg' WHERE Identificador = 1;
```

Hago otra vez para comprobar que se ha actualizado:
```
SELECT * FROM piezasportafolio;
```


11. Ahora demuestro que elimino:
```
DELETE FROM piezasportafolio WHERE Identificador = 1;
```
Y ahora hago esto para comprobar que lo he eliminado:
```
SELECT * FROM piezasportafolio;
```










