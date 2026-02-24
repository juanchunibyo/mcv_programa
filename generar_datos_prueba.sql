-- ============================================
-- SCRIPT DE DATOS DE PRUEBA
-- Sistema de Gestión Académica SENA
-- Genera datos realistas para probar el sistema
-- ============================================

-- Limpiar datos existentes (excepto estructura)
TRUNCATE TABLE detalle_asignacion CASCADE;
TRUNCATE TABLE asignacion CASCADE;
TRUNCATE TABLE ficha CASCADE;
TRUNCATE TABLE competxprograma CASCADE;
TRUNCATE TABLE instructor CASCADE;
TRUNCATE TABLE coordinacion CASCADE;
TRUNCATE TABLE centro_formacion CASCADE;
TRUNCATE TABLE competencia CASCADE;
TRUNCATE TABLE programa CASCADE;
TRUNCATE TABLE titulo_programa CASCADE;
TRUNCATE TABLE ambiente CASCADE;
TRUNCATE TABLE sede CASCADE;

-- ============================================
-- 1. SEDES (3 sedes)
-- ============================================
INSERT INTO sede (sede_nombre) VALUES
('SENA – Centro Principal / Sede Cúcuta'),
('SENA CIES – Centro de la Industria'),
('SENA CEDRUM – Centro Rural y Minero');

-- ============================================
-- 2. AMBIENTES (12 ambientes)
-- ============================================
INSERT INTO ambiente (amb_nombre, sede_sede_id) VALUES
('Laboratorio de Sistemas 101', 1),
('Laboratorio de Redes 102', 1),
('Aula Multimedia 201', 1),
('Aula Teórica 202', 1),
('Taller de Mecánica Industrial', 2),
('Laboratorio de Electrónica', 2),
('Sala de Diseño Gráfico', 2),
('Aula de Idiomas', 2),
('Laboratorio Agroindustrial', 3),
('Taller de Soldadura', 3),
('Aula Rural 301', 3),
('Laboratorio de Química', 3);

-- ============================================
-- 3. TÍTULOS DE PROGRAMA (4 niveles)
-- ============================================
INSERT INTO titulo_programa (titpro_nombre) VALUES
('Tecnólogo'),
('Técnico'),
('Especialización Tecnológica'),
('Operario');

-- ============================================
-- 4. PROGRAMAS (10 programas con códigos aleatorios)
-- ============================================
INSERT INTO programa (prog_codigo, tit_programa_titpro_id, prog_tipo, sede_sede_id) VALUES
(228106, 1, 'Tecnólogo', 1),
(334521, 1, 'Tecnólogo', 1),
(445789, 2, 'Técnico', 1),
(556234, 2, 'Técnico', 2),
(667890, 1, 'Tecnólogo', 2),
(778123, 2, 'Técnico', 2),
(889456, 3, 'Especialización', 1),
(990567, 2, 'Técnico', 3),
(123789, 1, 'Tecnólogo', 3),
(234890, 4, 'Operario', 3);

-- ============================================
-- 5. COMPETENCIAS (15 competencias)
-- ============================================
INSERT INTO competencia (comp_nombre_corto, comp_horas, comp_nombre_unidad_competencia) VALUES
('BD-001', 120, 'Bases de Datos Relacionales'),
('PROG-001', 200, 'Programación Orientada a Objetos'),
('WEB-001', 150, 'Desarrollo Web Frontend'),
('REDES-001', 180, 'Fundamentos de Redes'),
('SEGURIDAD-001', 100, 'Seguridad Informática'),
('MECATRONICA-001', 160, 'Sistemas Mecatrónicos'),
('ELECTRONICA-001', 140, 'Electrónica Digital'),
('DISEÑO-001', 120, 'Diseño Gráfico Digital'),
('INGLES-001', 80, 'Inglés Técnico Nivel 1'),
('SOLDADURA-001', 200, 'Soldadura Industrial'),
('AGROINDUSTRIA-001', 150, 'Procesamiento de Alimentos'),
('QUIMICA-001', 100, 'Química Aplicada'),
('EMPRENDIMIENTO', 60, 'Emprendimiento y Gestión Empresarial'),
('ETICA', 40, 'Ética Profesional'),
('COMUNICACION', 50, 'Comunicación Asertiva');

-- ============================================
-- 6. CENTROS DE FORMACIÓN (3 centros)
-- ============================================
INSERT INTO centro_formacion (cent_nombre) VALUES
('Centro de Gestión Industrial'),
('Centro de Servicios Empresariales'),
('Centro de Desarrollo Agroindustrial');

-- ============================================
-- 7. COORDINACIONES (5 coordinaciones)
-- ============================================
INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) VALUES
('Coordinación Académica TI', 1),
('Coordinación Administrativa', 1),
('Coordinación Industrial', 2),
('Coordinación Servicios', 2),
('Coordinación Agroindustrial', 3);

-- ============================================
-- 8. INSTRUCTORES (15 instructores)
-- ============================================
INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) VALUES
('Carlos', 'Rodríguez', 'carlos.rodriguez@sena.edu.co', 3001234567, 1),
('María', 'García', 'maria.garcia@sena.edu.co', 3009876543, 1),
('Juan', 'Pérez', 'juan.perez@sena.edu.co', 3005551234, 1),
('Ana', 'Martínez', 'ana.martinez@sena.edu.co', 3007778899, 1),
('Luis', 'González', 'luis.gonzalez@sena.edu.co', 3002223344, 2),
('Sandra', 'López', 'sandra.lopez@sena.edu.co', 3004445566, 2),
('Pedro', 'Ramírez', 'pedro.ramirez@sena.edu.co', 3006667788, 2),
('Laura', 'Torres', 'laura.torres@sena.edu.co', 3008889900, 2),
('Diego', 'Vargas', 'diego.vargas@sena.edu.co', 3001112233, 3),
('Carmen', 'Ruiz', 'carmen.ruiz@sena.edu.co', 3003334455, 3),
('Roberto', 'Morales', 'roberto.morales@sena.edu.co', 3005556677, 3),
('Patricia', 'Castro', 'patricia.castro@sena.edu.co', 3007778800, 1),
('Fernando', 'Jiménez', 'fernando.jimenez@sena.edu.co', 3009990011, 2),
('Claudia', 'Herrera', 'claudia.herrera@sena.edu.co', 3002221133, 3),
('Miguel', 'Sánchez', 'miguel.sanchez@sena.edu.co', 3004443355, 1);

-- ============================================
-- 9. COMPETENCIAS POR PROGRAMA (relaciones)
-- ============================================
INSERT INTO competxprograma (programa_prog_id, competencia_comp_id) VALUES
-- Programa 1 (Tecnólogo TI)
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 13), (1, 14),
-- Programa 2 (Tecnólogo TI)
(2, 1), (2, 2), (2, 3), (2, 9), (2, 13), (2, 15),
-- Programa 3 (Técnico Redes)
(3, 4), (3, 5), (3, 9), (3, 14),
-- Programa 4 (Técnico Electrónica)
(4, 7), (4, 12), (4, 14),
-- Programa 5 (Tecnólogo Mecatrónica)
(5, 6), (5, 7), (5, 13), (5, 14),
-- Programa 6 (Técnico Diseño)
(6, 8), (6, 9), (6, 15),
-- Programa 7 (Especialización)
(7, 5), (7, 13),
-- Programa 8 (Técnico Soldadura)
(8, 10), (8, 14),
-- Programa 9 (Tecnólogo Agroindustria)
(9, 11), (9, 12), (9, 13), (9, 14),
-- Programa 10 (Operario)
(10, 11), (10, 15);

-- ============================================
-- 10. FICHAS (20 fichas)
-- ============================================
INSERT INTO ficha (programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) VALUES
(1, 1, 'Mañana', 1),
(1, 2, 'Tarde', 1),
(2, 3, 'Noche', 1),
(3, 4, 'Mañana', 1),
(3, 12, 'Tarde', 1),
(4, 5, 'Mañana', 3),
(5, 6, 'Tarde', 3),
(5, 7, 'Noche', 3),
(6, 8, 'Mañana', 4),
(6, 13, 'Tarde', 4),
(7, 15, 'Noche', 1),
(8, 9, 'Mañana', 5),
(8, 10, 'Tarde', 5),
(9, 11, 'Mañana', 5),
(9, 14, 'Tarde', 5),
(10, 14, 'Mañana', 5),
(1, 15, 'Tarde', 1),
(2, 1, 'Mañana', 1),
(4, 6, 'Noche', 3),
(5, 8, 'Mañana', 3);

-- ============================================
-- 11. ASIGNACIONES (30 asignaciones para marzo 2026)
-- ============================================
INSERT INTO asignacion (instructor_inst_id, asig_fecha_ini, asig_fecha_fin, ficha_fich_id, ambiente_amb_id, competencia_comp_id) VALUES
-- Semana 1 (3-7 marzo)
(1, '2026-03-03 00:00:00', '2026-03-07 23:59:59', 1, 1, 1),
(2, '2026-03-03 00:00:00', '2026-03-07 23:59:59', 2, 2, 2),
(3, '2026-03-03 00:00:00', '2026-03-07 23:59:59', 3, 3, 3),
(4, '2026-03-03 00:00:00', '2026-03-07 23:59:59', 4, 4, 4),
(5, '2026-03-03 00:00:00', '2026-03-07 23:59:59', 6, 5, 7),
-- Semana 2 (10-14 marzo)
(6, '2026-03-10 00:00:00', '2026-03-14 23:59:59', 7, 6, 6),
(7, '2026-03-10 00:00:00', '2026-03-14 23:59:59', 8, 7, 7),
(8, '2026-03-10 00:00:00', '2026-03-14 23:59:59', 9, 8, 8),
(9, '2026-03-10 00:00:00', '2026-03-14 23:59:59', 12, 9, 10),
(10, '2026-03-10 00:00:00', '2026-03-14 23:59:59', 13, 10, 10),
-- Semana 3 (17-21 marzo)
(11, '2026-03-17 00:00:00', '2026-03-21 23:59:59', 14, 11, 11),
(12, '2026-03-17 00:00:00', '2026-03-21 23:59:59', 5, 1, 9),
(13, '2026-03-17 00:00:00', '2026-03-21 23:59:59', 10, 7, 8),
(14, '2026-03-17 00:00:00', '2026-03-21 23:59:59', 15, 12, 12),
(15, '2026-03-17 00:00:00', '2026-03-21 23:59:59', 11, 3, 5),
-- Semana 4 (24-28 marzo)
(1, '2026-03-24 00:00:00', '2026-03-28 23:59:59', 17, 2, 2),
(2, '2026-03-24 00:00:00', '2026-03-28 23:59:59', 18, 4, 1),
(3, '2026-03-24 00:00:00', '2026-03-28 23:59:59', 3, 1, 3),
(4, '2026-03-24 00:00:00', '2026-03-28 23:59:59', 4, 2, 4),
(5, '2026-03-24 00:00:00', '2026-03-28 23:59:59', 19, 5, 7),
-- Adicionales distribuidas
(6, '2026-03-05 00:00:00', '2026-03-12 23:59:59', 20, 6, 6),
(7, '2026-03-12 00:00:00', '2026-03-19 23:59:59', 8, 8, 7),
(8, '2026-03-19 00:00:00', '2026-03-26 23:59:59', 9, 7, 8),
(9, '2026-03-06 00:00:00', '2026-03-13 23:59:59', 12, 10, 10),
(10, '2026-03-13 00:00:00', '2026-03-20 23:59:59', 13, 9, 10),
(11, '2026-03-20 00:00:00', '2026-03-27 23:59:59', 14, 11, 11),
(12, '2026-03-04 00:00:00', '2026-03-11 23:59:59', 5, 3, 9),
(13, '2026-03-11 00:00:00', '2026-03-18 23:59:59', 10, 8, 8),
(14, '2026-03-18 00:00:00', '2026-03-25 23:59:59', 15, 12, 12),
(15, '2026-03-25 00:00:00', '2026-03-31 23:59:59', 11, 4, 5);

-- ============================================
-- 12. DETALLES DE ASIGNACIÓN (horarios específicos)
-- ============================================
-- Lunes a Viernes, diferentes horarios
INSERT INTO detalle_asignacion (asignacion_asig_id, detasig_hora_ini, detasig_hora_fin) VALUES
-- Asignación 1: Lunes, Miércoles, Viernes 8:00-10:00
(1, '2026-03-03 08:00:00', '2026-03-03 10:00:00'),
(1, '2026-03-05 08:00:00', '2026-03-05 10:00:00'),
(1, '2026-03-07 08:00:00', '2026-03-07 10:00:00'),
-- Asignación 2: Martes, Jueves 14:00-16:00
(2, '2026-03-04 14:00:00', '2026-03-04 16:00:00'),
(2, '2026-03-06 14:00:00', '2026-03-06 16:00:00'),
-- Asignación 3: Lunes a Viernes 18:00-20:00
(3, '2026-03-03 18:00:00', '2026-03-03 20:00:00'),
(3, '2026-03-04 18:00:00', '2026-03-04 20:00:00'),
(3, '2026-03-05 18:00:00', '2026-03-05 20:00:00'),
(3, '2026-03-06 18:00:00', '2026-03-06 20:00:00'),
(3, '2026-03-07 18:00:00', '2026-03-07 20:00:00'),
-- Asignación 4: Lunes, Miércoles 10:00-12:00
(4, '2026-03-03 10:00:00', '2026-03-03 12:00:00'),
(4, '2026-03-05 10:00:00', '2026-03-05 12:00:00'),
-- Asignación 5: Martes, Jueves 08:00-10:00
(5, '2026-03-04 08:00:00', '2026-03-04 10:00:00'),
(5, '2026-03-06 08:00:00', '2026-03-06 10:00:00'),
-- Asignación 6: Lunes a Viernes 14:00-16:00
(6, '2026-03-10 14:00:00', '2026-03-10 16:00:00'),
(6, '2026-03-11 14:00:00', '2026-03-11 16:00:00'),
(6, '2026-03-12 14:00:00', '2026-03-12 16:00:00'),
(6, '2026-03-13 14:00:00', '2026-03-13 16:00:00'),
(6, '2026-03-14 14:00:00', '2026-03-14 16:00:00'),
-- Asignación 7: Martes, Jueves 16:00-18:00
(7, '2026-03-11 16:00:00', '2026-03-11 18:00:00'),
(7, '2026-03-13 16:00:00', '2026-03-13 18:00:00'),
-- Asignación 8: Lunes, Miércoles, Viernes 08:00-10:00
(8, '2026-03-10 08:00:00', '2026-03-10 10:00:00'),
(8, '2026-03-12 08:00:00', '2026-03-12 10:00:00'),
(8, '2026-03-14 08:00:00', '2026-03-14 10:00:00'),
-- Asignación 9: Lunes a Viernes 06:00-08:00
(9, '2026-03-10 06:00:00', '2026-03-10 08:00:00'),
(9, '2026-03-11 06:00:00', '2026-03-11 08:00:00'),
(9, '2026-03-12 06:00:00', '2026-03-12 08:00:00'),
(9, '2026-03-13 06:00:00', '2026-03-13 08:00:00'),
(9, '2026-03-14 06:00:00', '2026-03-14 08:00:00'),
-- Asignación 10: Martes, Jueves 10:00-12:00
(10, '2026-03-11 10:00:00', '2026-03-11 12:00:00'),
(10, '2026-03-13 10:00:00', '2026-03-13 12:00:00'),
-- Más horarios para las demás asignaciones
(11, '2026-03-17 08:00:00', '2026-03-17 10:00:00'),
(11, '2026-03-19 08:00:00', '2026-03-19 10:00:00'),
(11, '2026-03-21 08:00:00', '2026-03-21 10:00:00'),
(12, '2026-03-17 14:00:00', '2026-03-17 16:00:00'),
(12, '2026-03-19 14:00:00', '2026-03-19 16:00:00'),
(13, '2026-03-18 16:00:00', '2026-03-18 18:00:00'),
(13, '2026-03-20 16:00:00', '2026-03-20 18:00:00'),
(14, '2026-03-17 10:00:00', '2026-03-17 12:00:00'),
(14, '2026-03-19 10:00:00', '2026-03-19 12:00:00'),
(15, '2026-03-18 18:00:00', '2026-03-18 20:00:00'),
(15, '2026-03-20 18:00:00', '2026-03-20 20:00:00');

-- ============================================
-- VERIFICACIÓN DE DATOS
-- ============================================
SELECT 'Datos insertados correctamente:' as mensaje;
SELECT COUNT(*) as total_sedes FROM sede;
SELECT COUNT(*) as total_ambientes FROM ambiente;
SELECT COUNT(*) as total_programas FROM programa;
SELECT COUNT(*) as total_competencias FROM competencia;
SELECT COUNT(*) as total_instructores FROM instructor;
SELECT COUNT(*) as total_fichas FROM ficha;
SELECT COUNT(*) as total_asignaciones FROM asignacion;
SELECT COUNT(*) as total_detalles FROM detalle_asignacion;

-- ============================================
-- FIN DEL SCRIPT
-- ============================================
