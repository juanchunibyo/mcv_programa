-- ============================================
-- SCRIPT DE CREACIÓN DE BASE DE DATOS
-- Sistema de Gestión Académica SENA
-- Base de datos: PostgreSQL
-- Estructura basada en el proyecto de referencia
-- ============================================

-- Eliminar tablas si existen (en orden inverso de dependencias)
DROP TABLE IF EXISTS detalle_asignacion CASCADE;
DROP TABLE IF EXISTS asignacion CASCADE;
DROP TABLE IF EXISTS ficha CASCADE;
DROP TABLE IF EXISTS competxprograma CASCADE;
DROP TABLE IF EXISTS instructor CASCADE;
DROP TABLE IF EXISTS coordinacion CASCADE;
DROP TABLE IF EXISTS centro_formacion CASCADE;
DROP TABLE IF EXISTS competencia CASCADE;
DROP TABLE IF EXISTS programa CASCADE;
DROP TABLE IF EXISTS titulo_programa CASCADE;
DROP TABLE IF EXISTS ambiente CASCADE;
DROP TABLE IF EXISTS sede CASCADE;

-- ===============================
-- TABLA SEDE
-- ===============================
CREATE TABLE sede (
    sede_id SERIAL PRIMARY KEY,
    sede_nombre VARCHAR(45) NOT NULL
);

-- ===============================
-- TABLA AMBIENTE
-- ===============================
CREATE TABLE ambiente (
    amb_id SERIAL PRIMARY KEY,
    amb_nombre VARCHAR(45) NOT NULL,
    sede_sede_id INT NOT NULL,
    CONSTRAINT fk_amb_sede
        FOREIGN KEY (sede_sede_id)
        REFERENCES sede(sede_id)
);

-- ===============================
-- TABLA TITULO_PROGRAMA
-- ===============================
CREATE TABLE titulo_programa (
    titpro_id SERIAL PRIMARY KEY,
    titpro_nombre VARCHAR(150) NOT NULL
);

-- ===============================
-- TABLA PROGRAMA
-- ===============================
CREATE TABLE programa (
    prog_id SERIAL PRIMARY KEY,
    prog_codigo INT NOT NULL,
    tit_programa_titpro_id INT NOT NULL,
    prog_tipo VARCHAR(30),
    sede_sede_id INT,
    CONSTRAINT fk_programa_titulo
        FOREIGN KEY (tit_programa_titpro_id)
        REFERENCES titulo_programa(titpro_id),
    CONSTRAINT fk_programa_sede
        FOREIGN KEY (sede_sede_id)
        REFERENCES sede(sede_id)
);

-- ===============================
-- TABLA COMPETENCIA
-- ===============================
CREATE TABLE competencia (
    comp_id SERIAL PRIMARY KEY,
    comp_nombre_corto VARCHAR(30) NOT NULL,
    comp_horas INT NOT NULL,
    comp_nombre_unidad_competencia VARCHAR(150)
);

-- ===============================
-- TABLA COMPETxPROGRAMA
-- ===============================
CREATE TABLE competxprograma (
    programa_prog_id INT NOT NULL,
    competencia_comp_id INT NOT NULL,
    PRIMARY KEY (programa_prog_id, competencia_comp_id),
    CONSTRAINT fk_cp_programa
        FOREIGN KEY (programa_prog_id)
        REFERENCES programa(prog_id),
    CONSTRAINT fk_cp_competencia
        FOREIGN KEY (competencia_comp_id)
        REFERENCES competencia(comp_id)
);

-- ===============================
-- TABLA CENTRO_FORMACION
-- ===============================
CREATE TABLE centro_formacion (
    cent_id SERIAL PRIMARY KEY,
    cent_nombre VARCHAR(100) NOT NULL
);

-- ===============================
-- TABLA COORDINACION
-- ===============================
CREATE TABLE coordinacion (
    coord_id SERIAL PRIMARY KEY,
    coord_nombre VARCHAR(45) NOT NULL,
    centro_formacion_cent_id INT NOT NULL,
    CONSTRAINT fk_coord_centro
        FOREIGN KEY (centro_formacion_cent_id)
        REFERENCES centro_formacion(cent_id)
);

-- ===============================
-- TABLA INSTRUCTOR
-- ===============================
CREATE TABLE instructor (
    inst_id SERIAL PRIMARY KEY,
    inst_nombres VARCHAR(45) NOT NULL,
    inst_apellidos VARCHAR(45) NOT NULL,
    inst_correo VARCHAR(45),
    inst_telefono BIGINT,
    centro_formacion_cent_id INT NOT NULL,
    CONSTRAINT fk_inst_centro
        FOREIGN KEY (centro_formacion_cent_id)
        REFERENCES centro_formacion(cent_id)
);

-- ===============================
-- TABLA FICHA
-- ===============================
CREATE TABLE ficha (
    fich_id SERIAL PRIMARY KEY,
    programa_prog_id INT NOT NULL,
    instructor_inst_id INT NOT NULL,
    fich_jornada VARCHAR(20),
    coordinacion_coord_id INT NOT NULL,
    CONSTRAINT fk_ficha_programa
        FOREIGN KEY (programa_prog_id)
        REFERENCES programa(prog_id),
    CONSTRAINT fk_ficha_instructor
        FOREIGN KEY (instructor_inst_id)
        REFERENCES instructor(inst_id),
    CONSTRAINT fk_ficha_coord
        FOREIGN KEY (coordinacion_coord_id)
        REFERENCES coordinacion(coord_id)
);

-- ===============================
-- TABLA ASIGNACION
-- ===============================
CREATE TABLE asignacion (
    asig_id SERIAL PRIMARY KEY,
    instructor_inst_id INT NOT NULL,
    asig_fecha_ini TIMESTAMP NOT NULL,
    asig_fecha_fin TIMESTAMP NOT NULL,
    ficha_fich_id INT NOT NULL,
    ambiente_amb_id INT NOT NULL,
    competencia_comp_id INT NOT NULL,
    CONSTRAINT fk_asig_inst
        FOREIGN KEY (instructor_inst_id)
        REFERENCES instructor(inst_id),
    CONSTRAINT fk_asig_ficha
        FOREIGN KEY (ficha_fich_id)
        REFERENCES ficha(fich_id),
    CONSTRAINT fk_asig_amb
        FOREIGN KEY (ambiente_amb_id)
        REFERENCES ambiente(amb_id),
    CONSTRAINT fk_asig_comp
        FOREIGN KEY (competencia_comp_id)
        REFERENCES competencia(comp_id)
);

-- ===============================
-- TABLA DETALLE_ASIGNACION
-- ===============================
CREATE TABLE detalle_asignacion (
    detasig_id SERIAL PRIMARY KEY,
    asignacion_asig_id INT NOT NULL,
    detasig_hora_ini TIMESTAMP NOT NULL,
    detasig_hora_fin TIMESTAMP NOT NULL,
    CONSTRAINT fk_det_asig
        FOREIGN KEY (asignacion_asig_id)
        REFERENCES asignacion(asig_id)
);

-- ============================================
-- DATOS DE EJEMPLO
-- ============================================

-- Insertar sedes
INSERT INTO sede (sede_nombre) VALUES
('SENA – Centro Principal / Sede Cúcuta'),
('SENA CIES – Centro de la Industria'),
('SENA CEDRUM – Centro Rural y Minero');

-- Insertar ambientes
INSERT INTO ambiente (amb_nombre, sede_sede_id) VALUES
('Laboratorio 101', 1),
('Aula 202', 1),
('Taller Mecánica', 2);

-- Insertar títulos de programa
INSERT INTO titulo_programa (titpro_nombre) VALUES
('Tecnólogo'),
('Técnico'),
('Especialización Tecnológica');

-- Insertar programas
INSERT INTO programa (prog_codigo, tit_programa_titpro_id, prog_tipo, sede_sede_id) VALUES
(228106, 1, 'Tecnólogo', 1),
(228120, 1, 'Tecnólogo', 1),
(228130, 2, 'Técnico', 2);

-- Insertar competencias
INSERT INTO competencia (comp_nombre_corto, comp_horas, comp_nombre_unidad_competencia) VALUES
('BD-001', 120, 'Bases de Datos Relacionales'),
('PROG-001', 200, 'Programación Orientada a Objetos'),
('WEB-001', 150, 'Desarrollo Web Frontend');

-- Insertar centros de formación
INSERT INTO centro_formacion (cent_nombre) VALUES
('Centro de Gestión Industrial'),
('Centro de Servicios Empresariales');

-- Insertar coordinaciones
INSERT INTO coordinacion (coord_nombre, centro_formacion_cent_id) VALUES
('Coordinación Académica TI', 1),
('Coordinación Administrativa', 2);

-- Insertar instructores
INSERT INTO instructor (inst_nombres, inst_apellidos, inst_correo, inst_telefono, centro_formacion_cent_id) VALUES
('Carlos', 'Rodríguez', 'carlos.rodriguez@sena.edu.co', 3001234567, 1),
('María', 'García', 'maria.garcia@sena.edu.co', 3009876543, 1),
('Juan', 'Pérez', 'juan.perez@sena.edu.co', 3005551234, 2);

-- ============================================
-- ÍNDICES PARA MEJORAR RENDIMIENTO
-- ============================================

CREATE INDEX idx_ambiente_sede ON ambiente(sede_sede_id);
CREATE INDEX idx_programa_titulo ON programa(tit_programa_titpro_id);
CREATE INDEX idx_programa_sede ON programa(sede_sede_id);
CREATE INDEX idx_instructor_centro ON instructor(centro_formacion_cent_id);
CREATE INDEX idx_coordinacion_centro ON coordinacion(centro_formacion_cent_id);
CREATE INDEX idx_ficha_programa ON ficha(programa_prog_id);
CREATE INDEX idx_ficha_instructor ON ficha(instructor_inst_id);
CREATE INDEX idx_ficha_coord ON ficha(coordinacion_coord_id);
CREATE INDEX idx_asignacion_instructor ON asignacion(instructor_inst_id);
CREATE INDEX idx_asignacion_ficha ON asignacion(ficha_fich_id);
CREATE INDEX idx_asignacion_ambiente ON asignacion(ambiente_amb_id);
CREATE INDEX idx_detalle_asignacion ON detalle_asignacion(asignacion_asig_id);

-- ============================================
-- FIN DEL SCRIPT
-- ============================================


-- ============================================
-- DATOS DE PRUEBA ADICIONALES PARA FICHAS
-- ============================================

-- Insertar fichas de prueba
INSERT INTO ficha (programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) VALUES
(1, 1, 'Mañana', 1),
(2, 2, 'Tarde', 1),
(3, 1, 'Noche', 2);

-- ============================================
-- FIN DE DATOS DE PRUEBA
-- ============================================
