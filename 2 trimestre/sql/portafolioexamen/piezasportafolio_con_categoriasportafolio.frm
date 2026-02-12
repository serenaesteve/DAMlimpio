TYPE=VIEW
query=select `portafolioexamen`.`categoriasportafolio`.`nombre` AS `nombre`,`portafolioexamen`.`piezasportafolio`.`titulo` AS `titulo`,`portafolioexamen`.`piezasportafolio`.`descripcion` AS `descripcion`,`portafolioexamen`.`piezasportafolio`.`fecha` AS `fecha`,`portafolioexamen`.`piezasportafolio`.`imagen` AS `imagen` from (`portafolioexamen`.`piezasportafolio` left join `portafolioexamen`.`categoriasportafolio` on(`portafolioexamen`.`piezasportafolio`.`id_categoria` = `portafolioexamen`.`categoriasportafolio`.`Identificador`))
md5=2bf5f203f05ee648ab3a00b3eb9294c1
updatable=0
algorithm=0
definer_user=root
definer_host=localhost
suid=1
with_check_option=0
timestamp=0001763050396476089
create-version=2
source=SELECT `categoriasportafolio`.`nombre` AS `nombre`, `piezasportafolio`.`titulo` AS `titulo`, `piezasportafolio`.`descripcion` AS `descripcion`, `piezasportafolio`.`fecha` AS `fecha`, `piezasportafolio`.`imagen` AS `imagen` FROM (`piezasportafolio` left join `categoriasportafolio` on(`piezasportafolio`.`id_categoria` = `categoriasportafolio`.`Identificador`))
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `portafolioexamen`.`categoriasportafolio`.`nombre` AS `nombre`,`portafolioexamen`.`piezasportafolio`.`titulo` AS `titulo`,`portafolioexamen`.`piezasportafolio`.`descripcion` AS `descripcion`,`portafolioexamen`.`piezasportafolio`.`fecha` AS `fecha`,`portafolioexamen`.`piezasportafolio`.`imagen` AS `imagen` from (`portafolioexamen`.`piezasportafolio` left join `portafolioexamen`.`categoriasportafolio` on(`portafolioexamen`.`piezasportafolio`.`id_categoria` = `portafolioexamen`.`categoriasportafolio`.`Identificador`))
mariadb-version=100432
