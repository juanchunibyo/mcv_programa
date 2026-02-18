-- ============================================
-- SCRIPT PARA INSERTAR DATOS DE PRUEBA
-- Ejecuta este script en pgAdmin para tener datos de prueba
-- ============================================

-- Insertar fichas de prueba
INSERT INTO ficha (programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) VALUES
(1, 1, 'Mañana', 1),
(2, 2, 'Tarde', 1),
(3, 1, 'Noche', 2);

-- Verificar que se insertaron
SELECT * FROM ficha;

-- ============================================
-- NOTA: Si ya tienes datos en las tablas relacionadas
-- (programa, instructor, coordinacion), las fichas se crearán correctamente.
-- Si no tienes datos, primero ejecuta el database_schema.sql completo
-- que ya incluye datos de ejemplo.
-- ============================================
