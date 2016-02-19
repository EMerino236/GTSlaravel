/*** ROL ***/
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('1','Administrador','Administrador');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('2','Jefe de UIB','Jefe de UIB');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('3','Ingeniero UIB','Ingeniero UIB');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('4','Secretaria UIB','Secretaria UIB');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('5','Ingeniero residente Tumimed','Ingeniero residente Tumimed');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('6','Técnico Tumimed','Técnico Tumimed');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('7','Jefe de servicio clínico','Jefe de servicio clínico');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('8','Secretaria servicio clínico','Secretaria servicio clínico');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('9','Jefes de departamento','Jefes de departamento');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('10','Director general','Director general');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('11','Coordinador','Coordinador');
INSERT INTO roles (idrol,nombre,descripcion) VALUES ('12','Inspector','Inspector');


/*** PRIORIDADES ***/
INSERT INTO prioridades (idprioridad,nombre) VALUES ('1','normal');
INSERT INTO prioridades (idprioridad,nombre) VALUES ('2','urgente');
INSERT INTO prioridades (idprioridad,nombre) VALUES ('3','critica');


INSERT INTO tipo_activos(idtipo_activo,nombre,descripcion) VALUES('1','Bien','Bien');
INSERT INTO tipo_activos(idtipo_activo,nombre,descripcion) VALUES('2','Tecnologia de Salud','Tecnologia de Salud');


INSERT INTO tipo_areas(idtipo_area,nombre,descripcion) VALUES ('1','Departamento','Departamento');
INSERT INTO tipo_areas(idtipo_area,nombre,descripcion) VALUES ('2','Unidad','Unidad');
INSERT INTO tipo_areas(idtipo_area,nombre,descripcion) VALUES ('3','Oficina ','Oficina ');
INSERT INTO tipo_areas(idtipo_area,nombre,descripcion) VALUES ('4','Dirección','Dirección');
INSERT INTO tipo_areas(idtipo_area,nombre,descripcion) VALUES ('5','Organo','Organo');


INSERT INTO tipo_doc_identidades(idtipo_documento,nombre) VALUES ('1','DNI');
INSERT INTO tipo_doc_identidades(idtipo_documento,nombre) VALUES ('2','Carnet de Extranjeria');
INSERT INTO tipo_doc_identidades(idtipo_documento,nombre) VALUES ('3','Pasaporte');


INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('1','Contratos','Contratos firmados que pueden incluir servicios y/o equipos');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('2','Manuales','Manuales de funcionamiento y de mantenimiento');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('3','Libros','Libros');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('4','Normas','Normas');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('5','Politicas institucionales','Politicas institucionales del hospital');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('6','Certificado de Funcionalidad','Certificado de Funcionalidad');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('7','Terminos de referencia','Término de Referencia');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('8','Reporte de Necesidad','Reporte de Necesidad');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('9','Acta de Conformidad','Acta de Conformidad');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('10','Politicas ETS','Politicas ETS');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('11','Inpugnaciones','Inpugnaciones');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('12','Documentos internos','Documentos internos');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('13','Correspondencia','Correspondencia');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('14','Reportes impresos','Reportes impresos');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('15','Ordenes de trabajo impresas','Ordenes de trabajo impresas');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('16','Normas y regulaciones en segutidas','Normas y regulaciones en segutidas');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('17','metrologia','metrologia');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('18','MOF','Manual de operaciones y funciones');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('19','ROF','Reglamento de operaciones y funciones institucional de UIB y SERVICOS CLINICOS');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('20','POA','Plan operativo anual');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('21','Plan de recuperación de tecnología en salud','Plan de recuperación de tecnología en salud');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('22','Plan y programación anual de mantenimiento preventivo','Plan y programación anual de mantenimiento preventivo');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('23','Plan anual de mantenimiento correctivo','Plan anual de mantenimiento correctivo');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('24','Plan anual de inspecciones','Plan anual de inspecciones');
INSERT INTO tipo_documentos(idtipo_documento,nombre,descripcion) VALUES ('25','Análisis de recursos económicos desperdiciados','Análisis de recursos económicos desperdiciados');


INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('1','Eléctrica');
INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('2','Mecánica');
INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('3','Electrónica');
INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('4','Operación');
INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('5','Re-reparación');
INSERT INTO tipo_fallas(idtipo_falla,nombre) VALUES ('6','Otros');


INSERT INTO tipo_servicios(idtipo_servicios,nombre,descripcion) VALUES ('1','Servicio clinico','Servicio clinico');
INSERT INTO tipo_servicios(idtipo_servicios,nombre,descripcion) VALUES ('2','Servicio hospitalario','Servicio hospitalario');


INSERT INTO tipo_reporte_instalaciones (nombre,descripcion) VALUES ('Entorno Concluido','Entorno Concluido');
INSERT INTO tipo_reporte_instalaciones (nombre,descripcion) VALUES ('Equipo Funcional','Equipo Funcional');


INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('1','Almacén/Repuestos','Solicita de almacén repuestos de equipos asociados a un número de código patrimonial','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('2','Almacén/Insumos','Solicita de almacén insumos de equipos asociados a un número de código patrimonial','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('3','Almacén/Accesorios','Solicita de almacén accesorios de equipos asociados a un tipo de equipo','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('4','Almacén/Equipos_P','Solicita de almacén equipos contemplados en el PAAC','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('5','Compra/Repuestos','Solicita por compra repuestos de equipos asociados a un número de código patrimonial','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('6','Compra/Insumos','Solicita por compra insumos de equipos asociados a un número de código patrimonial','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('7','Compra/Accesorios','Solicita por compra accesorios de equipos asociados a un tipo de equipo','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('8','Compra/Equipos_P','Solicita por compra equipos contemplados en el PAAC','60');
INSERT INTO tipo_solicitud_compras (idtipo_solicitud_compra,nombre,descripcion,tiempo_maximo) VALUES ('9','Compra/Equipos_NP','Solicita por compra equipos no comtemplados en el PAAC','60');



INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('1','Paper');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('2','Normas');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('3','Regulaciones');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('4','Protocolos');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('5','Manuales');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('6','Libros');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('7','Tesis');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('8','Estudios');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('9','Publicaciones');
INSERT INTO tipo_busqueda_infos (idtipo_busqueda_info,nombre) VALUES ('10','Otros');


INSERT INTO tablas (nombre_tabla) VALUES ('estado_general');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_activo');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_ot');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_sot');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_solicitud_compra');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_equipo_noint');
INSERT INTO tablas (nombre_tabla) VALUES ('estado_actividad_realizada');

INSERT INTO tipo_actas (nombre) VALUES ('Conformidad del Proveedor');

INSERT INTO estados (nombre,idtabla) VALUES ('Activo','1');
INSERT INTO estados (nombre,idtabla) VALUES ('Inactivo','1');
INSERT INTO estados (nombre,idtabla) VALUES ('Operativo Calibrado','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Operativo no calibrado','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Inoperativo por insumo','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Inoperativo por mantenimiento','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Inoperativo por repuesto','2');
INSERT INTO estados (nombre,idtabla) VALUES ('De baja','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Pendiente','3');
INSERT INTO estados (nombre,idtabla) VALUES ('Exceso de demanda por usuario','3');
INSERT INTO estados (nombre,idtabla) VALUES ('No ubicado en el servicio','3');
INSERT INTO estados (nombre,idtabla) VALUES ('Inoperativo por repuesto','3');
INSERT INTO estados (nombre,idtabla) VALUES ('Mantenimiento ejecutado','3');
INSERT INTO estados (nombre,idtabla) VALUES ('Pendiente','4');
INSERT INTO estados (nombre,idtabla) VALUES ('Aprobada','4');
INSERT INTO estados (nombre,idtabla) VALUES ('Falsa Alarma','4');
INSERT INTO estados (nombre,idtabla) VALUES ('Solución Menor','4');
INSERT INTO estados (nombre,idtabla) VALUES ('Solicitado','5');
INSERT INTO estados (nombre,idtabla) VALUES ('Atendido','5');
INSERT INTO estados (nombre,idtabla) VALUES ('Comprado','5');
INSERT INTO estados (nombre,idtabla) VALUES ('Recibido','5');
INSERT INTO estados (nombre,idtabla) VALUES ('Realizado','6');
INSERT INTO estados (nombre,idtabla) VALUES ('No Realizado','6');
INSERT INTO estados (nombre,idtabla) VALUES ('En Mantenimiento','2');
INSERT INTO estados (nombre,idtabla) VALUES ('Reprogramación','3');
INSERT INTO estados (nombre,idtabla) VALUES ('Mal Ingreso','4');

INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('1','Departamento de obstetricia y perinatologia','Departamento de obstetricia y perinatologia','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('2','Departamento de cuidados críticos','Departamento de cuidados críticos','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('3','Departamento de ginecologia','Departamento de ginecologia','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('4','Departamento de obstetrices','Departamento de obstetrices','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('5','Departamento de neonatología','Departamento de neonatología','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('6','UIB','Unidad de ingenieria biomedica','2','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('7','Departamento de Especialidades médicas','Departamento de Especialidades médicas','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('8','Departamento de patología','Departamento de patología','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('9','Departamento de anestecia, analfesia y reanimación','Departamento de anestecia, analfesia y reanimación','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('10','Departamento de servicios complementarios','Departamento de servicios complementarios','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('11','Departamento de enfermeria ','Departamento de enfermeria ','1','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('12','Oficina de economía','Oficina de economía','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('13','Oficina de logística','Oficina de logística','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('14','Oficina de recursos humanos','Oficina de recursos humanos','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('15','Oficina de servicios generales','Oficina de servicios generales','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('16','Oficina de estadística e informatica','Oficina de estadística e informatica','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('17','Oficina de comunicaciones','Oficina de comunicaciones','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('18','Oficina ejecutiva de apoyo a la investigacion y docencia especializada','Oficina ejecutiva de apoyo a la investigacion y docencia especializada','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('19','Oficina ejecutiva de planeamiento estrategico','Oficina ejecutiva de planeamiento estrategico','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('20','Oficina de asesoria juridica','Oficina de asesoria juridica','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('21','Oficina de epidemiologia y salud ambiental','Oficina de epidemiologia y salud ambiental','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('22','Oficina de gestion de la calidad','Oficina de gestion de la calidad','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('23','Oficina de cooperacion cientifica internacional','Oficina de cooperacion cientifica internacional','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('24','Oficina ejecutiva de administracion','Oficina ejecutiva de administracion','3','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('25','Direccion ejecutiva de investigación, docencia y atención en obstreticia y ginecología','Direccion ejecutiva de investigación, docencia y atención en obstreticia y ginecología','4','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('26','Direccion ejecutiva de investigación docencia y antención en neonatología','Direccion ejecutiva de investigación docencia y antención en neonatología','4','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('27','Dirección ejecutiva de apoyo de especialidades médicas y servicios complementarios','Dirección ejecutiva de apoyo de especialidades médicas y servicios complementarios','4','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('28','Dirección general','Dirección general','4','1');
INSERT INTO areas (idarea,nombre,descripcion,idtipo_area,idestado) VALUES ('29','Organo de control institucional','Organo de control institucional','5','1');

INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('1','1ER PISO','1ER PISO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('2','2DO PISO','2DO PISO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('3','ADOLESCENCIA','ADOLESCENCIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('4','AMBULANCIA 1','AMBULANCIA 1');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('5','AMBULANCIA 2','AMBULANCIA 2');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('6','AMBULANCIA 3','AMBULANCIA 3');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('7','AMBULANCIA 4','AMBULANCIA 4');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('8','ANESTESIOLOGIA','ANESTESIOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('9','ATENCION INMEDIATA','ATENCION INMEDIATA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('10','BANCO DE LECHE','BANCO DE LECHE');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('11','BANCO DE SANGRE','BANCO DE SANGRE');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('12','BIOQUIMICA','BIOQUIMICA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('13','CARDIOLOGIA','CARDIOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('14','CASA DE FUERZA','CASA DE FUERZA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('15','CENTRAL DE ESTERILIZACION','CENTRAL DE ESTERILIZACION');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('16','CENTRO OBSTETRICO','CENTRO OBSTETRICO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('17','CENTRO QUIRURGICO','CENTRO QUIRURGICO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('18','CLIMATERIO','CLIMATERIO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('19','CLINICA','CLINICA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('20','CONSULTA EXTERNA DE GINECO OBSTETRICIA','CONSULTA EXTERNA DE GINECO OBSTETRICIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('21','CONSULTORIO 01','CONSULTORIO 01');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('22','CONSULTORIO 02','CONSULTORIO 02');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('23','CONSULTORIO B2','CONSULTORIO B2');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('24','CONSULTORIO D2','CONSULTORIO D2');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('25','CONSULTORIO EXTERNO','CONSULTORIO EXTERNO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('26','CONSULTORIO MEDICO 1','CONSULTORIO MEDICO 1');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('27','CQ-SALA 8 (ASPIRACION Y TRANSF DE EMBRIONES)','CQ-SALA 8 (ASPIRACION Y TRANSF DE EMBRIONES)');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('28','EMERGENCIA','EMERGENCIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('29','ENDOCRINOLOGIA','ENDOCRINOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('30','ENFERMEDADES METABOLICAS','ENFERMEDADES METABOLICAS');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('31','ESTACION DE ENFERMERIA','ESTACION DE ENFERMERIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('32','ESTERILIZACION','ESTERILIZACION');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('33','FARMACIA','FARMACIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('34','FARMACIA CENTRAL','FARMACIA CENTRAL');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('35','GENETICA','GENETICA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('36','GINECOLOGIA','GINECOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('37','GINECOLOGIA PATOLOGICA','GINECOLOGIA PATOLOGICA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('38','HEMATOLOGIA','HEMATOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('39','HISTOPATOLOGIA','HISTOPATOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('40','INFERTILIDAD','INFERTILIDAD');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('41','INMUNOLOGIA','INMUNOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('42','INTERMEDIOS I','INTERMEDIOS I');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('43','INTERMEDIOS II','INTERMEDIOS II');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('44','INTERMEDIOS III','INTERMEDIOS III');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('45','INTERMEDIOS IV','INTERMEDIOS IV');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('46','JEFATURA LABORATORIO','JEFATURA LABORATORIO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('47','LAVANDERIA','LAVANDERIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('48','MADRES DELICADAS','MADRES DELICADAS');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('49','MICROBIOLOGIA','MICROBIOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('50','NUTRICION','NUTRICION');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('51','OBSTETRICIA','OBSTETRICIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('52','OBSTETRICIA','OBSTETRICIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('53','OBSTETRICIA A','OBSTETRICIA A');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('54','OBSTETRICIA B','OBSTETRICIA B');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('55','OBSTETRICIA C','OBSTETRICIA C');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('56','OBSTETRICIA C','OBSTETRICIA C');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('57','OBSTETRICIA D','OBSTETRICIA D');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('58','OBSTETRICIA E','OBSTETRICIA E');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('59','OBSTETRICIA Y PERINATOLOGIA','OBSTETRICIA Y PERINATOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('60','ODONTOESTOMATOLOGIA','ODONTOESTOMATOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('61','ODONTOLOGIA','ODONTOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('62','OFTALMOLOGIA','OFTALMOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('63','PASADIZO','PASADIZO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('64','PATOLOGIA CLINICA','PATOLOGIA CLINICA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('65','PEDIATRIA 4','PEDIATRIA 4');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('66','PREANESTESIA','PREANESTESIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('67','RADIOLOGIA','RADIOLOGIA');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('68','RECUPERACION','RECUPERACION');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('69','REHABILITACION','REHABILITACION');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('70','SALA 01','SALA 01');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('71','SALA 02','SALA 02');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('72','SALA 03','SALA 03');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('73','SALA 04','SALA 04');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('74','SALA 05','SALA 05');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('75','SALA 06','SALA 06');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('76','SALA 07','SALA 07');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('77','SALA 08','SALA 08');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('78','SALA 09','SALA 09');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('79','SALA MAQUINAS','SALA MAQUINAS');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('80','SALA MAQUINAS N° 01','SALA MAQUINAS N° 01');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('81','SALA MAQUINAS N° 02','SALA MAQUINAS N° 02');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('82','UCI MATERNO','UCI MATERNO');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('83','UCIN','UCIN');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('84','UNIDAD MEDICINA FETAL','UNIDAD MEDICINA FETAL');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('85','VACUNAS IEC','VACUNAS IEC');
INSERT INTO ubicacion_fisicas (idubicacion_fisica,nombre,descripcion) VALUES ('86','S/U','SIN UBICACION FISICA');

/*** USUARIO ***/
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('kvera','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Kelly Carol','Vera','Chacon','0000-00-00','F','','2','6','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('ncortez','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','cortez.noelia@gmail.com','','Alda Noelia','Cortez','Díaz','0000-00-00','F','','3','6','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('mlarrea','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Jesus Miguel','Larrea','Casanova','0000-00-00','M','','3','6','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('dgarrido','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Doris','Garrido','Rivadeneyra','0000-00-00','F','','7','28','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('sniño','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Segundo Valentin','Niño','Febres','0000-00-00','M','','7','5','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('gtorres','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Gladys Elsa','Torres','Marcos','0000-00-00','F','','7','11','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('mparedes','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','mparedes@iemp.gob.pe','','Miguel','Paredes','Aspilcueta','0000-00-00','M','','7','5','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('lsantisteban','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Luis Gerardo Silva','Santisteban','Perez','0000-00-00','M','','7','10','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jsilva','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','jsilva@iemp.gob.pe','','John','Silva','Zuñiga','0000-00-00','M','','7','5','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jalvarado','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Jaqueline Janeth','Alvarado','Zelada','0000-00-00','F','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jchinchayan','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','jchinchayan@iemp.gob.pe','','Juan Antonio','Chinchayan','Sanchez','0000-00-00','M','','7','5','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('asalvador','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','asalvador@iemp.gob.pe','','Alfredo','Salvador','Yamaguchi','0000-00-00','M','','7','8','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('elinamendoza','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','emendoza@iemp.gob.pe','','Elina','Mendoza','Ibañez','0000-00-00','F','','7','8','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('wgomez','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Walter','Gomez','Galiano','0000-00-00','M','','7','2','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jtasato','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Jose','Tasato','Kanashiro','0000-00-00','M','','7','2','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('nrodriguez','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','nrodriguez@iemp.gob.pe','','Norma','Rodriguez','Pozo','0000-00-00','F','','7','8','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jochoa','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Jesus Mario','Ochoa','Rua','0000-00-00','M','','7','8','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jrios','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','jrios@iemp.gob.pe','','Jorge Vicente','Rios','Echsle','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('bcanchari','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','bcanchari@iemp.gob.pe','','Basilia','Canchari','Canchari','0000-00-00','F','','7','7','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('rzumaeta','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','rzumaeta@iemp.gob.pe','','Rina Ruth','Zumaeta','Beramendi','0000-00-00','F','','7','9','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('lcarpio','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Luis Alberto','Carpio','Guzman','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('aortiz','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','aortiz@iemp.gob.pe','','Antonio','Ortiz','Flores','0000-00-00','M','','7','9','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('hizaguirre','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','hizaguirre@iemp.gob.pe','','Humberto Adler','Izaguirre','Lucano','0000-00-00','M','','7','2','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('ehuertas','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','ehuertas@iemp.gob.pe','','Erasmo','Huertas','Tacchino','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('acipriano','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Antonio','Cipriano','Bernui','0000-00-00','M','','7','10','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('bbelleza','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','bbelleza@iemp.gob.pe','','Bertha','Belleza','Cabrera','0000-00-00','F','','7','10','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('lalmeyda','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Luis','Almeyda','Castro','0000-00-00','M','','7','3','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('raragon','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Ronal Jacinto','Aragon','Osorio','0000-00-00','M','','7','3','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('lkobayashi','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','lkobayashi@iemp.gob.pe','','Luis Fernando','Kobayashi','Tsutsumi','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('dceledonio','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Dennys Jessy','Celedonio','Salvador','0000-00-00','F','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('sdiaz','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','odiaz@iemp.gob.pe','','Segundo Octavio','Diaz','Goicochea','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('hacuña','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','hacuna@iemp.gob.pe','','Hortencia','Acuña','Fernandez','0000-00-00','F','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('amejia','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','amejia@iemp.gob.pe','','Ana Maria','Mejia','Muñoz','0000-00-00','F','','7','10','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('llopez','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','llopez@iemp.gob.pe','','Luis Javier','Lopez','Vargas','0000-00-00','M','','7','10','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jabel','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Javier Brañez','Abel','Santos','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('rvalle','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','rvalle@iemp.gob.pe','','Rudy','Valle','Robles','0000-00-00','F','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('nbolarte','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','nbolarte@iemp.gob.pe','','Norma','Bolarte','Cerrate','0000-00-00','F','','7','5','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('aavalos','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','aavalos@iemp.gob.pe','','Ana Maria','Avalos','Lopez','0000-00-00','F','','7','28','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('wdelapeña','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','wdelapena@iemp.gob.pe','','Walter Jerry','De la Peña','Meniz','0000-00-00','M','','7','1','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('jgarcia','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','jgarcia@iemp.gob.pe','','Jaime','Garcia','Marin','0000-00-00','M','','7','28','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('tcallahui','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Teresa','Callahui','Ortiz','0000-00-00','F','','7','28','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('iaburto','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Isolina','Aburto','Soria','0000-00-00','F','','7','7','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('dcalle','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','David','Calle','Zurita','0000-00-00','M','','7','3','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('aherrera','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','','','Abdon','Herrera','Ramirez','0000-00-00','M','','7','3','1');
INSERT INTO users (username,password,email,remember_token,nombre,apellido_pat,apellido_mat,fecha_nacimiento,genero,numero_doc_identidad,idrol,idarea,idtipo_documento) VALUES ('gts_webmaster','$2y$10$YSwHz1VNwKl3z7iKVB8k4uxbYGIwNudoETrnZMo0pPG0F16d5SpC.','gts.desarrollo@gmail.com','','gts','webmaster','webmaster','42013','M','11223344','1','1','1');