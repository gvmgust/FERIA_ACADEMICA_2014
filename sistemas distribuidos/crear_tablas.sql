CREATE DATABASE `encuesta`;

USE `encuesta`;

/*Table structure for table `encuesta` */

DROP TABLE IF EXISTS `encuesta`;

CREATE TABLE `encuesta` (
  `id_enc` int(6) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `estado` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_enc`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `votante` */

DROP TABLE IF EXISTS `votante`;

CREATE TABLE `votante` (
  `ci` varchar(10) NOT NULL,
  `registro` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

/*Table structure for table `respuesta` */

DROP TABLE IF EXISTS `respuesta`;

CREATE TABLE `respuesta` (
  `id_res` int(6) NOT NULL,
  `respuesta` varchar(100) NOT NULL,
  PRIMARY KEY (`id_res`),
  UNIQUE KEY `UNICO` (`respuesta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `guarda` */

DROP TABLE IF EXISTS `guarda`;

CREATE TABLE `guarda` (
  `num` int(6) NOT NULL,
  `id_pre` int(6) NOT NULL,
  `res` int(6) DEFAULT NULL,
  PRIMARY KEY (`num`,`id_pre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
