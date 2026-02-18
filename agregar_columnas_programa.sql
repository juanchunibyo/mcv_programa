-- Script para agregar columnas faltantes a la tabla programa
-- Ejecuta este script en tu base de datos PostgreSQL

ALTER TABLE programa 
ADD COLUMN IF NOT EXISTS prog_denominacion VARCHAR(200),
ADD COLUMN IF NOT EXISTS prog_duracion VARCHAR(50);

-- Verificar que se agregaron correctamente
SELECT column_name, data_type, character_maximum_length 
FROM information_schema.columns 
WHERE table_name = 'programa';
