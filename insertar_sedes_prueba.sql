-- Script para insertar sedes de prueba
-- Ejecuta este script en tu base de datos PostgreSQL

-- Primero, verificar si hay sedes
SELECT * FROM sede;

-- Si no hay sedes, insertar algunas de prueba
INSERT INTO sede (sede_nombre) VALUES
('SENA – Centro Principal / Sede Cúcuta'),
('SENA CIES – Centro de la Industria'),
('SENA CEDRUM – Centro Rural y Minero')
ON CONFLICT DO NOTHING;

-- Verificar que se insertaron
SELECT * FROM sede;
