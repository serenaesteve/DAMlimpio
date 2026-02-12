El lenguaje de descripción de datos (DDL) es una herramienta fundamental para la definición y gestión de estructuras de bases de datos relacionales. Este conjunto de comandos permite crear, modificar y eliminar objetos como tablas, índices y vistas, así como establecer restricciones y políticas de acceso a los mismos.

El primer paso en el uso del DDL es la creación de una tabla, que es la estructura básica de cualquier base de datos relacional. Este proceso implica definir el nombre de la tabla, sus columnas (con su tipo de dato y restricciones), y las relaciones entre ellas. Por ejemplo, para crear una tabla llamada "Clientes" con campos como identificación, nombre y dirección, se utilizaría un comando similar a:

CREATE TABLE Clientes (
    ID INT PRIMARY KEY,
    Nombre VARCHAR(100),
    Direccion VARCHAR(255)
);
