-- ============================================
-- SCRIPT RÁPIDO: CREAR FICHAS DE PRUEBA
-- Copia y pega este código en pgAdmin y ejecútalo
-- ============================================

-- Insertar fichas de prueba
INSERT INTO ficha (programa_prog_id, instructor_inst_id, fich_jornada, coordinacion_coord_id) 
VALUES 
(1, 1, 'Mañana', 1),
(2, 2, 'Tarde', 1),
(3, 1, 'Noche', 2);

-- Verificar que se crearon
SELECT f.fich_id, f.fich_jornada, 
       i.inst_nombres, i.inst_apellidos,
       p.prog_codigo
FROM ficha f
LEFT JOIN instructor i ON f.instructor_inst_id = i.inst_id
LEFT JOIN programa p ON f.programa_prog_id = p.prog_id;
