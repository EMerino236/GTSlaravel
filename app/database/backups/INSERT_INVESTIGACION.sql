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

/*Guía de practica por tipo de TS*/

INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('1','Reporte ETES','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('2','Reporte RCN corto plazo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('3','Reporte RCN nuevo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('4','Reporte RCN reemplazo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('5','Reporte de necesidad para planes de mediano y largo plazo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('6','Reporte para PAAC','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('7','Asignación de costos para PAAC','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('8','Presupuesto PAAC','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('9','PAAC','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('10','Especificaciones técnicas de TS','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('11','Precios referenciales de TS','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('12','Expediente técnico y económico de TS','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('13','Observaciones levantadas y pendientes','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('14','Relación de miembros de comité de evaluación','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('15','Impugnacinoes levantadas y pendientes','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('16','Penalizaciones a proveedores','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('17','Reporte: Análisis de recursos desperdiciados','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('18','Reporte de búsquedas de información','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('19','Reporte de instalación TS: Entorno concluido','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('20','Reporte de instalación TS: Equipo funcional','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('21','Certificado de conformidad de equipo funcional','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('22','Reporte de retiro de servicio','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('23','Requerimiento de TS para compra','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('24','Requerimiento de TS para almacén','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('25','Reporte de incumplimiento de proveedor','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('26','Acta de conformidad de servicio','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('27','OT de baja de equipo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('28','OT de mantenimiento preventivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('29','OT de mantenimiento correctivo','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('30','OT de verificación metrológica','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('31','Reporte mensual de estado','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('32','Reporte de verificación metrológica','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('33','Reporte trimestral de evaluación de resultados','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('34','Reporte de identificación y evaluación de riesgos','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('35','Registro de eventos adversos','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('36','Matriz IPER','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('37','Reporte de resultados de verificación metrológica y calibración de TS','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('38','Reporte que certifica la problemática e identificación del financiamiento','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('39','Informe económico de proyecto','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('40','Registro de perfiles profesionales','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('41','Reporte de supervisión de ejecución de capacitación','4');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('42','Solicitud de materiales y herramientas para capacitación','4');

/*Mapa de procesos y procedimientos*/
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('43','Mapa de procesos','10');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('44','Diagrama de flujos','10');
INSERT INTO subtipo_documentosinf (id, nombre, id_tipo) VALUES ('45','Catálogo de Requerimientos','10');

/*Categorias de proyectos*/
INSERT INTO proyecto_categorias (id, nombre) VALUES ('1','Inversión - Instalación del servicio');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('2','Inversión - Recuperación del servicio');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('3','Inversión - Ampliacion de la capacidad del servicio');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('4','Inversión - Mejoramiento del servicio');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('5','Investigación - Biomedica');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('6','Investigación - Clinica');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('7','Investigación - Sociomedica / Epidemiologia');
INSERT INTO proyecto_categorias (id, nombre) VALUES ('8','Investigación - Tecnológica');

/*Estados de requerimientos clinicos*/
INSERT INTO requerimientos_clinicos_estados (id, nombre) VALUES ('1','Aprobado');
INSERT INTO requerimientos_clinicos_estados (id, nombre) VALUES ('2','Rechazado');
INSERT INTO requerimientos_clinicos_estados (id, nombre) VALUES ('3','Pendiente');