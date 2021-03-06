-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.8-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

INSERT INTO `persona` (`perDocumento`, `perNombre`, `perApellido`, `perEstado`, `perUsuSesion`, `per_created_at`, `per_updated_at`) VALUES
	(8888888, 'has', 'gs', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(5555555, 'has', 'gs', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(123456789, 'Hprueba', 'Gprueba', 1, NULL, '2018-06-08 15:17:07', '2018-06-08 15:17:07'),
	(7944444, 'henry', 'garzon', 1, NULL, '2019-06-06 21:25:08', '2019-06-06 21:25:08'),
	(1234, 'Henry', 'garzon', 1, NULL, '2019-06-07 02:13:12', '2019-06-07 02:13:12'),
	(12345, 'Henry', 'garzon', 1, NULL, '2019-06-07 02:19:06', '2019-06-07 02:19:06'),
	(51879458, 'Ana', 'Sanchez', 1, NULL, '2019-06-07 17:41:59', '2019-06-07 17:41:59'),
	(987654, 'jose', 'maria', 1, NULL, '2019-06-07 19:38:40', '2019-06-07 19:38:40'),
	(666555, 'JUAN', 'PEREZ', 1, NULL, '2019-06-13 13:45:28', '2019-06-13 13:46:12');

INSERT INTO `rol` (`rolId`, `rolNombre`, `rolDescripcion`, `rolEstado`, `rolUsuSesion`, `rol_created_at`, `rol_updated_at`) VALUES
	(1, 'Administrador', 'Administrador', 1, NULL, '2019-06-07 10:18:36', '2019-06-07 10:18:36'),
	(2, 'Blibliotecario', 'Blibliotecario', 1, NULL, '2019-06-07 10:18:57', '2019-11-03 07:30:05'),
	(3, 'Miembro', 'Miembro', 1, NULL, '2019-06-07 10:19:16', '2019-11-03 07:30:19');

INSERT INTO `usuario_s` (`usuLogin`, `usuPassword`, `usuUsuSesion`, `usuEstado`, `usuRemember_token`, `usu_created_at`, `usu_updated_at`) VALUES
	('adminHAGS@si.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2018-05-29 11:48:38', '2018-06-08 15:18:53'),
	('ha@gs.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2018-06-06 15:02:04', '2018-06-06 15:02:04'),
	('hgprueba@si.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2018-06-08 15:17:07', '2018-06-08 15:17:07'),
	('halgarjr@gmail.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-06 21:25:08', '2019-06-06 21:25:08'),
	('halgarjr1@gmail.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-07 02:13:12', '2019-06-07 02:13:12'),
	('halgarjr3@gmail.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-07 02:19:06', '2019-06-07 02:19:06'),
	('notengo@no.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-07 17:41:59', '2019-06-07 17:41:59'),
	('jm@lk.com', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-07 19:38:40', '2019-06-07 19:38:40'),
	('huawei@juan.uei', 'd9840773233fa6b19fde8caf765402f5', NULL, 1, '', '2019-06-13 13:45:27', '2019-06-13 13:45:27');

INSERT INTO `usuario_s_roles` (`id_usuario_s`, `id_rol`, `usuRolEstado`, `usuRolFecha`, `usuRolObsFecha`, `usuRolUsuSesion`, `usuRolCreated_at`, `usuRolUpdated_at`) VALUES
	(1, 1, 1, '2019-10-27 18:52:00', NULL, NULL, '2019-08-23 18:52:00', '2019-10-27 18:30:00'),
	(1, 3, 1, '2018-03-07 10:22:00', NULL, NULL, '2018-01-20 17:26:00', '2017-03-12 18:22:00'),
	(2, 3, 1, '2019-10-21 15:52:00', NULL, NULL, '2018-08-27 17:52:00', '2019-09-27 18:24:00'),
	(3, 1, 1, '2017-10-27 18:22:00', NULL, NULL, '2016-08-27 18:50:00', '2019-10-15 18:30:00'),
	(3, 2, 1, '2019-10-29 18:52:00', NULL, NULL, '2019-10-29 18:52:00', '2019-10-29 18:52:00'),
	(3, 3, 1, '2017-07-07 20:22:00', NULL, NULL, '2016-11-20 13:15:00', '2018-03-20 22:22:00'),
	(4, 1, 1, '2019-10-29 18:51:41', NULL, NULL, '2019-10-29 18:51:41', '2019-10-29 18:51:41'),
	(4, 2, 1, '2019-09-25 18:52:00', NULL, NULL, '2019-08-20 12:52:00', '2019-02-27 22:30:00'),
	(4, 3, 1, '2014-05-07 16:12:00', NULL, NULL, '2018-09-20 18:20:00', '2015-09-21 17:22:00'),
	(5, 2, 1, '2019-01-27 18:52:08', NULL, NULL, '2014-08-27 19:52:00', '2019-10-22 18:01:09'),
	(5, 3, 1, '2014-12-07 16:27:00', NULL, NULL, '2017-03-20 10:02:00', '2019-08-08 11:22:00'),
	(6, 3, 1, '2018-06-30 21:52:50', NULL, NULL, '2018-07-05 12:44:12', '2017-11-07 16:30:00'),
	(7, 1, 1, '2019-11-27 01:52:00', NULL, NULL, '2019-06-27 18:52:40', '2018-10-13 18:30:21'),
	(7, 3, 1, '2016-09-07 14:22:00', NULL, NULL, '2019-05-20 14:12:00', '2017-03-15 08:22:00'),
	(8, 2, 1, '2016-12-29 18:51:00', NULL, NULL, '2017-03-29 09:52:00', '2015-12-27 16:35:00'),
	(8, 3, 1, '2015-10-07 12:22:00', NULL, NULL, '2018-10-20 20:21:00', '2016-01-19 05:22:00'),
	(9, 2, 1, '2018-04-20 17:58:00', NULL, NULL, '2019-10-07 18:32:00', '2014-11-27 17:30:00'),
	(9, 3, 1, '2019-11-02 16:10:25', NULL, NULL, '2019-10-29 18:52:17', '2019-11-02 16:10:25');

INSERT INTO `categorialibro` (`catLibId`, `catLibNombre`, `catLibEstado`, `catLibObservacion`) VALUES
	(1, 'General', 1, 'Libros que implican varias categorías o que no se les ha definido'),
	(2, 'Cultura General', 1, 'Cultura General');

INSERT INTO `categoria_elementos` (`catEleId`, `catEleNombre`, `catEleDescri`, `catEleEstado`, `catEleUsuSesion`, `catEle_created_at`, `catEle_updated_at`) VALUES
	(1, 'ajedrez', 'juegos', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(2, 'marcadores', 'Utencilios', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(3, 'sillas', 'mobiliario', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14');

INSERT INTO `categoria_libro_lecto` (`catLecId`, `catLecNombre`, `catLecDescri`, `catLecEstado`, `catLecUsuSesion`, `catLec_created_at`, `catLec_updated_at`) VALUES
	(1, 'Terror', 'Describe coas malas', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(2, 'Fantasia', 'Describe lo bueno', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(3, 'Gore', 'Describe mutilacion', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14');

INSERT INTO `estado_elementos` (`estEleId`, `estEleNombre`, `estEleObs`, `estEleEstado`, `estEleUsuSesion`, `estEle_created_at`, `estEle_updated_at`) VALUES
	(1, 'Dañado', 'pendiente arreglo', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(2, 'Aceptable', 'sin daños', 1, NULL, '2018-06-07 15:02:09', '2018-10-12 21:10:14'),
	(3, 'Nuevo', 'Nuevo', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14');

INSERT INTO `estado_libros` (`estLibId`, `estLibNombre`, `estLibObs`, `estLibEstado`, `estLibUsuSesion`, `estLib_created_at`, `estLib_updated_at`) VALUES
	(1, 'Dañado', 'pendiente arreglo', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14'),
	(2, 'Aceptable', 'sin daños', 1, NULL, '2018-06-07 15:02:09', '2018-10-12 21:10:14'),
	(3, 'Nuevo', 'Nuevo', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14');

INSERT INTO `libros` (`isbn`, `titulo`, `autor`, `precio`, `estado`, `categoriaLibro_catLibId`) VALUES
	(129, '24-TALLER DE FRUTAS Y HORTALIZAS', 'F.A.O', '39000', 1, 2),
	(258, 'ACTIVIDAD FISICA Y SALUD INTEGRAL', 'Medina Jimâenez, Eduardo', '55000', 1, 2),
	(387, 'AGUADA. Cuaderno de Pintura', 'OLMEDO SALVADOR', '42000', 1, 2),
	(516, 'ALTERACIONES DEL HABLA EN LA INFANCIA ASPECTOS CLINICOS', 'Gonzâalez, Jorge Nicolâas', '11900', 1, 2),
	(645, 'ANATOMIA CIENCIA EXPLICADA', 'Archila R., Leonardo, ed', '9514', 1, 1),
	(774, 'Antología de la narrativa mexicana del siglo XX, I', 'Domínguez Michael, Christopher', '144000', 1, 1),
	(903, 'APRENDIZAJE SERVICIO. EDUCAR PARA LA CIUDADANIA', 'PUIG ROVIRA, Josep', '70800', 1, 1),
	(1032, 'ARTE DE TOULOUSE-LAUTREC', 'Harris, Nathaniel', '300000', 1, 1),
	(1161, 'ATENCION A LOS DESPLAZADOS EXPERIENCIAS INSTITUCIONALES EN COLOMBIA', 'VARIOS, Autores', '24000', 1, 1),
	(1290, 'ATLAS DE PLANTAS VIVIENDAS', 'Schneider, Friederike ed', '100800', 1, 1),
	(1419, 'Auguste y Louis Lumière -Entre sombras y luces', 'Saad, Julián', '22500', 1, 1),
	(1548, 'BEBE', 'Levin, Ina Massler', '27300', 1, 1),
	(1677, 'BIOLOGIA LA UNIDAD Y DIVERSIDAD DE LA VIDA', 'Starr, Cecie', '116900', 1, 1),
	(1806, 'BREVE HISTORIA DEL ARTE AFRICANO', 'GILLO WERNER', '244800', 1, 1),
	(1935, 'CALDERON VIDA Y TEATRO', 'PEDRAZA JIMENEZ FELIPE B.', '45400', 1, 1),
	(2064, 'CANTATA DEL MAL, LA (E.N)', 'TOLEDO ZAMORA, Fernando', '39000', 1, 1),
	(2193, 'Casos prácticos de dirección financiera', 'Martín Fernández, Miguel; Martínez Solano, Pedro', '123100', 1, 1),
	(2322, 'CIENCIAS SOCIALES EN DISCUSION, LAS', 'BUNGE, MARIO', '33500', 1, 1),
	(2451, 'CLIMA, EL', 'HARRIS, CAROLINE', '34000', 1, 1),
	(2580, 'COMISIONES FILMICAS, LAS. UN NUEVO DISPOSITIVO PARA LA PROMOCION AUDIOVISUAL', 'Martínez Hermida, Marcelo', '93000', 1, 1),
	(2709, 'Compañia de sueños ilimitada', 'J.G. Ballard', '13200', 1, 1),
	(2838, 'CONCEPTOS FUNDAMENTALES EN LA HISTORIA DE LA MUSIC', 'SALAZAR ADOLFO', '144100', 1, 1),
	(2967, 'CONSULTOR DEL SABER', 'Elorza Martínez, Gustavo de, ed', '22900', 1, 1),
	(3096, 'Copos de espuma', 'Vargas Vila, J. M.', '22300', 1, 1),
	(3225, 'CRONICA DE AMERICA', 'García Jordán, Pilar', '61200', 1, 1),
	(3354, 'CUERPO (IR)', 'HANIF KUREISHI', '57900', 1, 1),
	(3483, 'CYBERGIRLS PORTAFOLIO', 'SHIROW HAR', '56000', 1, 1),
	(3612, 'DEL RACISMO A INTERCULTURALIDAD ', 'Garcia, Alfonso Y Saez, J', '101000', 1, 1),
	(3741, 'DESCUBRIMIENTO DEL UNIVERSO', 'Hacyan, Shahen, 1947-', '160000', 1, 1),
	(3870, 'DIBUJO Y DISENO EN INGENIERIA', 'Jensen, Cecil', '63700', 1, 1),
	(3999, 'DICCIONARIO DE CINE', 'Trueba, Fernando, 1955-', '120000', 1, 1),
	(4128, 'DICCIONARIO DE INTERPRETES Y DE LA INTERPRETACION MUSICAL', 'Paris, Alain, 1947-', '300000', 1, 1),
	(4257, 'DICCIONARIO DE PERIODISMO, PUBLICACIONES Y MEDIOS', ' Consuegra, Jorge ', NULL, 1, 1),
	(4386, 'DICCIONARIO DEL JAZZ', 'Carles, Philippe', '83900', 1, 1),
	(4515, 'DICCIONARIO HISTORICO DE LA ILUSTRACION', 'Ferrone, Vincenzo ed', '118105', 1, 1),
	(4644, 'DICCIONARIO RUSO-ESPANOL 000170.000 VOCES DE ENTRADA 00045', 'Martínez Calvo, Lorenzo', '80000', 1, 1),
	(4773, 'Dirección de empresas', 'Cabanelas Omil, José', '160500', 1, 1),
	(4902, 'DOMINE EXCEL 2007', 'Pérez', '42000', 1, 1),
	(5031, 'EDUCACION E IGUALDAD DE OPORTUNIDADES ENTRE SEXOS', 'Xosé R. Fernández Vazquez', '106000', 1, 1),
	(5160, 'El Mundo de la Célula, 6/ed.', 'BECKER', '215000', 1, 1),
	(5289, 'EN AMERICA', 'SONTAG, Susan', '45000', 1, 1),
	(5418, 'ENCICLOPEDIA DE LAS TECNICAS DE AEROGRAFIA', 'Leek, Michael', '69000', 1, 1),
	(5547, 'ENCICLOPEDIA PRACTICA DE LA PEDAGOGIA', 'Clifford, Margaret M', '80000', 1, 1),
	(5676, 'Enseñar a leer y escribir. Una aproximación histórica', 'Chartier, Anne-Marie', '43000', 1, 1),
	(5805, 'ESCRITOS FILOSOFICOS 2.', 'LAKATOS IMRE', '121800', 1, 1),
	(5934, 'ESTADISTICA Y MATEMATICAS APLICADAS. (EDICION DIRIGIDA A LOS ESTUDIOS DE FARMACIA)', 'SÁNCHEZ, M./FRUTOS, G./CUESTA, P. L.', '153800', 1, 1),
	(6063, 'ESTUCHE CARRASQUILLA', 'CARRASQUILLA, Tomás', '89000', 1, 1),
	(6192, 'Explora tus sentidos ', 'Helen Otway', '19500', 1, 1),
	(6321, 'FILOSOFIA DE LA LOGICA', 'QUINE W.', '72100', 1, 1),
	(6450, 'FISIOLOGIA APLICADA AL DEPORTE', 'Calderâon Montero, Francisco Javier', '52500', 1, 1),
	(6579, 'FREUD Y LA PSICOLOGIA DEL ARTE', 'DEL CONDE, TERESA', '28800', 1, 1),
	(6708, 'FUNDAMENTOS DE QUIMICA', 'ZUMDAHL, STE', '80000', 1, 1),
	(6837, 'GEOMETRIA DESCRIPTIVA SISTEMAS DE PROYECCION CILINDRICA', 'Sánchez Gallego, Juan Antonio', '16650', 1, 1),
	(6966, 'GOYA SU TIEMPO SU VIDA SU OBRA', 'Aribau, Ferrán', '88140', 1, 1),
	(7095, 'Grandes batallas de la historia - Batallas de Alej', 'Varios Autores', '21000', 1, 1),
	(7224, 'GUIA DE EQUIPOS BASICOS PARA EL PROCESAMIENTO AGROINDUSTRI', 'Romero, Arturo', '9350', 1, 1),
	(7353, 'HACIA UNA EDUCACION INFANTIL NO SEXISTA ', 'Browne', '76000', 1, 1),
	(7482, 'HISTOLOGIA VEGETAL', 'Garcia Breijo', '35000', 1, 1),
	(7611, 'HISTORIA DE LA VIDA PRIVADA II De la Europa feudal al Renacimiento', 'ARIES, Philippe / DUBY, Georges', '65000', 1, 1),
	(7740, 'HISTORIA ILUSTRADA DE COLOMBIA', 'OCAMPO LÓPEZ JAVIER', '25000', 1, 1),
	(7869, 'HORTALIZAS FRUTAS Y PLANTAS COMESTIBLES', 'Peel, Lucy', '24000', 1, 1),
	(7998, 'Indicadores de gestión y cuadro de mando', 'SALGUEIRO ANABITARTE A.', '32000', 1, 1),
	(8127, 'INTERACCION DEL COLOR', 'ALBERS JOSEF', '109100', 1, 1),
	(8256, 'INTRODUCCION A LA SOCIOLOGIA POLITICA', 'MICHELS, Roberto', '59800', 1, 1),
	(8385, 'ISO 009000 002000 CALIDAD Y EXCELENCIA', 'Senlle, Andrâes', '55740', 1, 1),
	(8514, 'JUGOS BATIDOS Y SORBETES', 'Gonzâalez, Jorge, fot', '90000', 1, 1),
	(8643, 'LAROUSSE DICCIONARIO ENCICLOPEDICO USUAL', NULL, '23000', 1, 1),
	(8772, 'LETRA', 'Blanchard, Gerard', '135200', 1, 1),
	(8901, 'LIDERAZGO Y LA COMUNICACION EFECTIVA PUNTO DE PARTIDA PARA', 'Cajiao de Pâerez, Gloria', '160000', 1, 1),
	(9030, 'LOS MITOS HEBREOS', 'GRAVES ROBERT', '78100', 1, 1),
	(9159, 'MANEJO POST-COSECHA Y MERCADEO DE TOMATE DE ARBOL CHYPHOMA', 'Gutiâerrez Vâasquez, Albeiro', '77675', 1, 1),
	(9288, 'MANUAL DE HORTICULTURA UNA GUIA PASO A PASO', 'Lesur Esquivel, Luis', '160000', 1, 1),
	(9417, 'MANUAL INTEGRADO DE DISENO Y CONSTRUCCION', 'Merrit, Frederick S., ed', '160000', 1, 1),
	(9546, 'MARKETING EMOCIONAL EL METODO DE HALLMARK PARA GANAR CLIEN', 'Robinette, Scott', '27870', 1, 1),
	(9675, 'MATEMATICAS PARA LOS ESTUDIANTES DE HUMANIDADES', 'Kline, Morris, 1908-', '160000', 1, 1),
	(9804, 'MEMORIA DEL FLAMENCO', 'GRANDE FELIX', '122300', 1, 1),
	(9933, 'MI PRIMER LAROUSSE DE LOS HEROES', 'EDICIONES LAROUSSE', '52400', 1, 1),
	(10062, 'MISTERIOS DE LOS OCEANOS', 'Dipper, Frances', '52200', 1, 1),
	(10191, 'MUJERES DE LA ANTIGUEDAD', 'VARIOS', '45400', 1, 1),
	(10320, 'NACIMIENTO DE LA HISTORIA, EL', 'CHATELET, Francois', '70000', 1, 1),
	(10449, 'NOVELA NATURALISTA HISPANOAMERICANA', 'Prendes, Manuel', '65950', 1, 1),
	(10578, 'NUTRICION DE PECES COMERCIALES EN ESTANQUES', 'Hepher, Balfour', '39000', 1, 1),
	(10707, 'OFICIO DE JURISTA, EL', 'DÍEZ PICAZO, Luis', '74000', 1, 1),
	(10836, 'OTROS ESTUDIOS SOBRE EL ESPAÑOL EN COLOMBIA', 'MONTES GIRALDO, José Joaquín', '30000', 1, 1),
	(10965, 'PASIÓN DE PAPEL- CTOS SOBRE EL MUNDO DEL LIBRO', 'AA.VV.', '67000', 1, 1),
	(11094, 'PERRO CALLEJERO(IR)', 'MARTIN AMIS', '64900', 1, 1),
	(11223, 'PLANTAS MEDICINALES EN VERSO ALIMENTESE Y SANESE', 'Gâomez Giraldo, Felipe, 1960-', '25000', 1, 1),
	(11352, 'Política y gestión pública', 'Bresser-Pereira, Luiz Carlos, et al.', '43000', 1, 1),
	(11481, 'PRIMAVERA DEL SER', 'MANTERO, Manuel', '26500', 1, 1),
	(11610, 'PROCESOS INDUSTRIALES EN FRUTAS Y HORTALIZAS', 'Osorio Dâiaz, Doris Liliana', '14073', 1, 1),
	(11739, 'PSICOTERAPIA Y SENTIDO DE VIDA', 'MARTINEZ ORTIZ,EFREN', '44000', 1, 1),
	(11868, 'QUIMICA GENERAL ORGANICA Y BIOLOGICA', 'Wolfe, Drew H', '51350', 1, 1),
	(11997, 'REDES NEURONALES', 'Anderson', '61000', 1, 1),
	(12126, 'REPENSAR LA RESURRECCION. (3ª ED) LA DIFERENCIA CRISTIANA EN LA CONTINUIDAD DE LAS RELIGIONES Y LA CULTURA', 'TORRES QUEIRUGA, Andrés', '82200', 1, 1),
	(12255, 'ROSTRO MAÑANA 2, TU.  BAILE Y SUEÑO', 'MARIAS, Javier', '45000', 1, 1),
	(12384, 'SEGUNDO SECRETO DE LA VIDA LAS NUEVAS MATEMATICAS DEL MUNDO', 'Stewart, Ian, 1945-', '160000', 1, 1),
	(12513, 'SIMBOLOS EN LA BIBLIA', 'ALVES, Herculano', '128900', 1, 1),
	(12642, 'SOCIOLOGIA URBANA DE MANUEL CASTELLS', 'SUSSER IDA (ed.)', '161200', 1, 1),
	(12771, 'TALMUD. TRATADO DE BERAJOT I', '0', '128000', 1, 1),
	(12900, 'TEOLOGIA DE LA LIBERACION Y REFUNDACION DE LA ESPERANZA', 'GIRARDI, Giulio', '44200', 1, 1),
	(13029, 'Textos políticos.', 'Burke, Edmund', '44000', 1, 1),
	(13158, 'TOXINAS AMBIENTALES Y SUS EFECTOS GENETICOS', 'Rodrâiguez Arnaiz, Rosario', '160000', 1, 1),
	(13287, 'TRIGONOMETRIA', 'Swokowski, Earl William, 1926-', '32200', 1, 1),
	(13416, 'UNIVERSALISMO CONSTRUCTIVO 2', 'TORRES GARCIA JOAQUIN', '209600', 1, 1),
	(13545, 'VIAJE AL CORAZON DE LA TORMENTA', 'EISNER WILL', '44000', 1, 1),
	(13674, 'Vitaminas y minerales esenciales para la salud ', 'Challem, Jack ', '37500', 1, 1),
	(13803, 'YO AMO A MI MAMI', 'JAIME BAYLY', '34900', 1, 1);

INSERT INTO `libros_lecto` (`libLecId`, `libLecCodigo`, `libLecTitulo`, `libLecAutor`, `libLecEstado`, `libLecUsuSesion`, `libLec_created_at`, `libLec_updated_at`, `categoria_libro_lecto_catLecId`, `estado_libros_estLibId`) VALUES
	(1, 'LBTE_01', 'MONSANTO', 'Luis Barton', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14', 2, 1),
	(2, 'LBGO_01', 'EL HOTEL DE LAS PARAFILIAS', 'ARCANGEL', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 3, 3),
	(3, 'LBFA_01', 'CORALINE', 'LUDING PEREZ', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 22:10:14', 1, 2),
	(4, 'LBTE_02', 'SENAFILIAS', 'Karen Garton', 1, NULL, '2018-08-06 15:02:04', '2018-08-09 21:10:14', 1, 1),
	(5, 'LBTE_03', 'PERRO FEO', 'Luis PERRO', 1, NULL, '2018-07-06 15:02:04', '2018-07-09 21:10:14', 3, 1),
	(6, 'LBTE_04', 'Perro come Perro', 'Miguel Churrias', 1, NULL, '2018-06-06 15:02:04', '2018-06-09 21:10:14', 2, 1),
	(7, 'LBFA_02', 'Sailor Moon', 'Chichiperalta ', 1, NULL, '2019-07-06 15:02:04', '2019-07-09 21:10:14', 3, 2),
	(8, 'LBGO_02', 'Dracula', 'Luis Arango', 1, NULL, '2019-09-06 15:02:04', '2019-09-09 21:10:14', 2, 3),
	(9, 'LBGO_03', 'BRUJAS MALDITAS', 'Lana Melana', 1, NULL, '2018-10-06 15:02:04', '2018-10-11 21:10:25', 2, 3),
	(10, 'LBGO_04', 'Lanaria', 'Melon Perez', 1, NULL, '2018-10-06 15:02:04', '2018-10-09 21:10:14', 3, 3);

INSERT INTO `elementos_lecto` (`eleLecId`, `eleLecCodigo`, `eleLecEstado`, `eleLecUsuSesion`, `eleLec_created_at`, `eleLec_updated_at`, `estado_elementos_estEleId`, `categoria_elementos_catEleId`) VALUES
	(1, 'AJE_01', 1, NULL, '2018-06-06 15:02:04', '2018-10-09 21:10:14', 2, 1),
	(2, 'MARC_01', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 3, 3),
	(3, 'SILLA_01', 1, NULL, '2019-06-06 15:02:04', '2019-10-09 22:10:14', 1, 2),
	(4, 'AJE_02', 1, NULL, '2018-08-06 15:02:04', '2018-08-09 21:10:14', 1, 1),
	(5, 'AJE_03', 1, NULL, '2018-07-06 15:02:04', '2018-07-09 21:10:14', 3, 1),
	(6, 'AJE_04', 1, NULL, '2018-06-06 15:02:04', '2018-06-09 21:10:14', 2, 1),
	(7, 'SILLA_02', 1, NULL, '2019-07-06 15:02:04', '2019-07-09 21:10:14', 3, 2),
	(8, 'MARC_02', 1, NULL, '2019-09-06 15:02:04', '2019-09-09 21:10:14', 2, 3),
	(9, 'MARC_03', 1, NULL, '2018-10-06 15:02:04', '2018-10-11 21:10:25', 2, 3),
	(10, 'MARC_04', 1, NULL, '2018-10-06 15:02:04', '2018-10-09 21:10:14', 3, 3);

INSERT INTO `contr_elementos` (`conEId`, `conEFechaSal`, `conEFechaEnt`, `conEFechaDev`, `conEPrestado`, `conEObsSalida`, `conEObsEntrada`, `conEUsuSesion`, `conE_created_at`, `conE_updated_at`, `conEEstado`, `elementos_lecto_eleLecId`, `persona_usuario_s_usuId`) VALUES
	(1, '2018-06-06 15:02:04', '2018-06-07 15:02:04', NULL, 0, 'Excelente Estado', NULL, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 1, 9, 2),
	(2, '2018-07-06 15:02:04', NULL, NULL, 1, 'Buen Estado', ' retorno buen estado', NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 1, 7, 3),
	(3, '2018-06-03 15:02:04', '2018-12-09 15:02:04', NULL, 0, 'Partes Perdidas', NULL, NULL, '2019-08-06 15:02:04', '2019-08-09 21:10:14', 1, 6, 4),
	(4, '2018-08-01 15:02:07', NULL, NULL, 1, 'Excelente Estado', 'retorno buen estado', NULL, '2019-08-06 15:02:04', '2019-12-09 21:10:14', 1, 5, 7),
	(5, '2018-06-06 15:02:04', NULL, NULL, 1, 'Buen Estado', 'retorno Roto', NULL, '2019-08-06 15:02:04', '2019-10-09 21:10:14', 1, 2, 1),
	(6, '2018-06-06 15:02:04', NULL, NULL, 1, 'Deteriorado', 'retorno igual', NULL, '2018-09-06 15:02:04', '2019-09-09 21:10:14', 1, 1, 9),
	(7, '2018-12-06 15:02:04', NULL, NULL, 1, 'Buen Estado', 'retorno Deteriorado', NULL, '2019-08-06 15:02:04', '2019-08-09 21:10:14', 1, 8, 5),
	(8, '2018-11-06 15:02:04', NULL, NULL, 1, 'Deteriorado', 'retorno peor estado', NULL, '2019-10-06 15:02:04', '2019-10-09 21:10:14', 1, 4, 4),
	(9, '2018-06-06 15:02:04', NULL, NULL, 1, 'Nuevo', 'retorno incompleto', NULL, '2019-12-06 15:02:04', '2019-12-09 21:10:14', 1, 3, 2),
	(10, '2018-06-06 15:02:04', NULL, NULL, 1, 'Mal Estado', 'retorno sin Partes', NULL, '2018-12-27 15:02:04', '2019-12-31 21:10:14', 1, 6, 4);

INSERT INTO `contr_prestamos_libros` (`conPId`, `conPFechaSal`, `conPFechaEnt`, `conPFechaDev`, `conPPrestado`, `conPObsSalida`, `conPObsEntrada`, `conPUsuSesion`, `conP_created_at`, `conP_updated_at`, `conPEstado`, `libros_lecto_libLecId`, `persona_usuario_s_usuId`) VALUES
	(1, '2018-06-06 15:02:04', '2018-06-07 15:02:04', NULL, 0, 'Excelente Estado', NULL, NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 1, 9, 2),
	(2, '2018-07-06 15:02:04', NULL, NULL, 1, 'Buen Estado', ' retorno buen estado', NULL, '2019-06-06 15:02:04', '2019-10-09 21:10:14', 1, 7, 3),
	(3, '2018-06-03 15:02:04', '2018-06-06 15:02:04', NULL, 0, 'Sin portada', NULL, NULL, '2019-08-06 15:02:04', '2019-08-09 21:10:14', 1, 6, 4),
	(4, '2018-08-01 15:02:07', NULL, NULL, 1, 'Excelente Estado', 'retorno buen estado', NULL, '2019-08-06 15:02:04', '2019-12-09 21:10:14', 1, 5, 7),
	(5, '2018-06-06 15:02:04', NULL, NULL, 1, 'Buen Estado', 'retorno sin Lomo', NULL, '2019-08-06 15:02:04', '2019-10-09 21:10:14', 1, 2, 1),
	(6, '2018-06-06 15:02:04', NULL, NULL, 1, 'Sin portada', 'retorno sin pasta', NULL, '2018-09-06 15:02:04', '2019-09-09 21:10:14', 1, 1, 9),
	(7, '2018-12-06 15:02:04', '2018-12-09 15:02:04', NULL, 0, 'Buen Estado', NULL, NULL, '2019-08-06 15:02:04', '2019-08-09 21:10:14', 1, 8, 5),
	(8, '2018-11-06 15:02:04', NULL, NULL, 1, ' Sin Lomo', 'retorno buen estado', NULL, '2019-10-06 15:02:04', '2019-10-09 21:10:14', 1, 4, 4),
	(9, '2018-06-06 15:02:04', NULL, NULL, 1, 'Sin Pag.17', 'retorno Sin Corazon', NULL, '2019-12-06 15:02:04', '2019-12-09 21:10:14', 1, 3, 2),
	(10, '2018-06-06 15:02:04', NULL, NULL, 1, 'Sin Lomo', 'retorno Buen Estado', NULL, '2018-12-27 15:02:04', '2019-12-31 21:10:14', 1, 6, 4);



/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
