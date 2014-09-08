CREATE DATABASE `encuesta`;
USE `encuesta`;

/*Table structure for table `votante` */
DROP TABLE IF EXISTS `votante`;
CREATE TABLE `votante` (
  `ci` varchar(10) NOT NULL,
  `registro` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Data for the table `votante` */
insert  into `votante`(`ci`,`registro`,`nombre`) values ('2563221','215069521','JUAN PEREZ PEREZ'),('5822389',NULL,'GREGORIO VARGAS MIRANDA'),('5880069','205067141','GUSTAVO VARGAS MIRANDA');

/*Table structure for table `encuesta` */
DROP TABLE IF EXISTS `encuesta`;
CREATE TABLE `encuesta` (
  `id_enc` int(6) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_enc`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*Data for the table `encuesta` */
insert  into `encuesta`(`id_enc`,`titulo`,`estado`) values (1,'Encuesta para evaluar la feria académica',1);

/*Table structure for table `responde` */
DROP TABLE IF EXISTS `responde`;
CREATE TABLE `responde` (
  `id_enc` int(6) NOT NULL,
  `ci` varchar(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_enc`,`ci`),
  KEY `responde_votante` (`ci`),
  CONSTRAINT `responde_encuesta` FOREIGN KEY (`id_enc`) REFERENCES `encuesta` (`id_enc`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `responde_votante` FOREIGN KEY (`ci`) REFERENCES `votante` (`ci`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Data for the table `responde` */
insert  into `responde`(`id_enc`,`ci`,`fecha`) values (1,'5880069','2014-09-08 13:21:49');

/*Table structure for table `pregunta` */
DROP TABLE IF EXISTS `pregunta`;
CREATE TABLE `pregunta` (
  `id_pre` int(6) NOT NULL AUTO_INCREMENT,
  `pregunta` varchar(300) NOT NULL,
  `id_enc` int(6) NOT NULL,
  PRIMARY KEY (`id_pre`),
  KEY `pregunta_encuesta` (`id_enc`),
  CONSTRAINT `pregunta_encuesta` FOREIGN KEY (`id_enc`) REFERENCES `encuesta` (`id_enc`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*Data for the table `pregunta` */
insert  into `pregunta`(`id_pre`,`pregunta`,`id_enc`) values (1,'Que edad tiene?',1),(2,'Seleccione su Genero',1),(3,'Que le parecio la feria academica 2014?',1),(4,'Le pareció útiles los proyectos presentados en la feria',1),(5,'Cree usted que se puede mejorar la feria para el próximo año?',1);

/*Table structure for table `respuesta` */
DROP TABLE IF EXISTS `respuesta`;
CREATE TABLE `respuesta` (
  `id_res` int(6) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  PRIMARY KEY (`id_res`),
  UNIQUE KEY `UNICO` (`respuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Data for the table `respuesta` */
insert  into `respuesta`(`id_res`,`respuesta`) values (7,'bueno'),(11,'Entre 15 y 17 años'),(12,'Entre 18 y 20 años'),(13,'Entre 21 y 24 años'),(9,'excelente'),(16,'Femenino'),(5,'malo'),(15,'Masculino'),(14,'Mayor de 25 años'),(10,'Menor de 15 años'),(8,'muy bueno'),(2,'no'),(4,'pésimo'),(6,'regular'),(1,'si'),(3,'tal vez');

/*Table structure for table `guarda` */
DROP TABLE IF EXISTS `guarda`;
CREATE TABLE `guarda` (
  `num` int(6) NOT NULL,
  `id_pre` int(6) NOT NULL,
  `res` int(6) DEFAULT NULL,
  PRIMARY KEY (`num`,`id_pre`),
  KEY `guarda_pregunta` (`id_pre`),
  KEY `guarda_respuesta` (`res`),
  CONSTRAINT `guarda_respuesta` FOREIGN KEY (`res`) REFERENCES `respuesta` (`id_res`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guarda_pregunta` FOREIGN KEY (`id_pre`) REFERENCES `pregunta` (`id_pre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Data for the table `guarda` */
insert  into `guarda`(`num`,`id_pre`,`res`) values (1,5,1),(1,4,2),(1,3,7),(1,1,14),(1,2,15);

/*Table structure for table `oferta` */
DROP TABLE IF EXISTS `oferta`;
CREATE TABLE `oferta` (
  `id_pre` int(6) NOT NULL,
  `id_res` int(6) NOT NULL,
  PRIMARY KEY (`id_pre`,`id_res`),
  KEY `oferta_respuesta` (`id_res`),
  CONSTRAINT `oferta_pregunta` FOREIGN KEY (`id_pre`) REFERENCES `pregunta` (`id_pre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `oferta_respuesta` FOREIGN KEY (`id_res`) REFERENCES `respuesta` (`id_res`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*Data for the table `oferta` */
insert  into `oferta`(`id_pre`,`id_res`) values (4,1),(5,1),(4,2),(5,2),(4,3),(5,3),(3,4),(3,5),(3,6),(3,7),(3,8),(3,9),(1,10),(1,11),(1,12),(1,13),(1,14),(2,15),(2,16);
