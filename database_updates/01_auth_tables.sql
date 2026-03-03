-- ===============================================
-- 01_auth_tables.sql
-- MIGRACIÓN PARA AÑADIR SISTEMA DE USUARIOS Y ROLES
-- ===============================================

-- 1. Crear tabla de roles
CREATE TABLE IF NOT EXISTS rol (
    rol_id SERIAL PRIMARY KEY,
    rol_nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Insertar roles básicos
INSERT INTO rol (rol_nombre) VALUES 
('coordinador'),
('instructor'),
('centro de formacion')
ON CONFLICT (rol_nombre) DO NOTHING;

-- 2. Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuario (
    usu_id SERIAL PRIMARY KEY,
    usu_nombre VARCHAR(100) NOT NULL,
    usu_correo VARCHAR(100) NOT NULL UNIQUE,
    usu_password VARCHAR(255) NOT NULL, -- Guardará el hash encriptado
    rol_rol_id INT NOT NULL,
    inst_id INT NULL, -- Opcional, para vincular al usuario con su perfil de instructor si es que es instructor
    CONSTRAINT fk_usu_rol
        FOREIGN KEY (rol_rol_id)
        REFERENCES rol(rol_id),
    CONSTRAINT fk_usu_inst
        FOREIGN KEY (inst_id)
        REFERENCES instructor(inst_id)
);

-- 3. Insertar usuarios de prueba
-- La contraseña para ambos será 'admin123'
-- Nota: En PHP usaremos password_hash(), aquí ponemos el hash ya generado
-- Hash bcrypt de 'admin123': $2y$10$vPI7f2pYjPIfM0I3.N24fuy80YqW5aM9FTo/Yp5E3iVjHlkzGvNee

-- Coordinador de prueba
INSERT INTO usuario (usu_nombre, usu_correo, usu_password, rol_rol_id) 
VALUES (
    'Admin Coordinador', 
    'admin@sena.edu.co', 
    '$2y$10$vPI7f2pYjPIfM0I3.N24fuy80YqW5aM9FTo/Yp5E3iVjHlkzGvNee', 
    (SELECT rol_id FROM rol WHERE rol_nombre = 'coordinador')
) ON CONFLICT (usu_correo) DO NOTHING;

-- Instructor de prueba (vinculado al primer instructor)
INSERT INTO usuario (usu_nombre, usu_correo, usu_password, rol_rol_id, inst_id) 
VALUES (
    'Carlos Instructor', 
    'instructor@sena.edu.co', 
    '$2y$10$vPI7f2pYjPIfM0I3.N24fuy80YqW5aM9FTo/Yp5E3iVjHlkzGvNee', 
    (SELECT rol_id FROM rol WHERE rol_nombre = 'instructor'),
    1 -- ID del instructor de prueba
) ON CONFLICT (usu_correo) DO NOTHING;
