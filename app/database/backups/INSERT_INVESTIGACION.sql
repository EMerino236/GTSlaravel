/*TIPOS PADRE DE DOCUMENTOS DE INVESTIGACION*/

INSERT INTO tipo_documentosinf_padre (id, nombre) VALUES ('1','Estratégico');
INSERT INTO tipo_documentosinf_padre (id, nombre) VALUES ('2','Guías');
INSERT INTO tipo_documentosinf_padre (id, nombre) VALUES ('3','Diseño de servicios clínicos');
INSERT INTO tipo_documentosinf_padre (id, nombre) VALUES ('4','Procesos');

/*TIPOS DE DOCUMENTOS DE INVESTIGACION*/

INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('1','Plan anual/trianual de investigación y financiamiento (incluye diseño de servicios, diseño de procesos, procedimientos, investigaciones, proyectos, informes ETES, GPC, etc.)','1');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('2','Presupuesto de investigación formulado','1');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('3','Plan de formación de investigadores','1');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('4','Guía de mantenimiento preventivo por tipo de TS','2');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('5','Guías de verificación metrológica','2');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('6','Formatos y reportes para GTS','2');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('7','Guía de práctica clínica GPC elaborada y registrada','2');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('8','Lista de procedimientos clínicos por servicio','2');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('9','Diseño de  servicio clínico (nuevo, remodelación, ampliación)','3');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre, id_tipo_padre) VALUES ('10','Mapa de procesos y procedimientos','4');

/*SUBTIPOS DE DOCUMENTOS DE INVESTIGACION*/

/*Guía de mantenimiento preventivo por tipo de TS*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('1','Mantenimiento Preventivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('2','Mantenimiento Correctivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('3','Verificación Metrológica','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('4','Inspecciones','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('5','Requerimiento de Equipos','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('6','Solicitud de orden de trabajo','4');

/*Guía de práctica clínica GPC elaborada y registrada*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('7','Enfermedad 1','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('8','Enfermedad 2','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('9','Enfermedad 3','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('10','Enfermedad 4','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('11','Enfermedad 5','7');

/*Mapa de procesos y procedimientos*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('12','Mapa de procesos','10');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('13','Diagrama de flujos','10');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('14','Catálogo de Requerimientos','10');