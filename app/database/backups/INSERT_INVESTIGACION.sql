/*TIPOS DE DOCUMENTOS DE INVESTIGACION*/
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('1','Plan anual/trianual de investigación y financiamiento (incluye diseño de servicios, diseño de procesos, procedimientos, investigaciones, proyectos, informes ETES, GPC, etc.)');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('2','Presupuesto de investigación formulado');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('3','Plan de formación de investigadores');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('4','Guía de mantenimiento preventivo por tipo de TS');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('5','Guías de verificación metrológica');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('6','Formatos y reportes para GTS');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('7','Guía de práctica clínica GPC elaborada y registrada');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('8','Lista de procedimientos clínicos por servicio');
INSERT INTO tipo_documentosinf (idtipo_documentosinf, nombre) VALUES ('9','Diseño de  servicio clínico (nuevo, remodelación, ampliación)');

/*SUBTIPOS DE DOCUMENTOS DE INVESTIGACION*/

/*Guía de mantenimiento preventivo por tipo de TS*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('1','Mantenimiento Preventivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('2','Mantenimiento Correctivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('3','Verificacion Metrologica','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('4','Inspecciones','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('5','Requerimiento de Equipos','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('6','Solicitud de orden de trabajo','4');

/*Guía de práctica clínica GPC elaborada y registrada*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('7','Enfermedad 1','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('8','Enfermedad 2','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('9','Enfermedad 3','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('10','Enfermedad 4','7');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('11','Enfermedad 5','7');