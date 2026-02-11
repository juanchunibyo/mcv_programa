# 🎨 Diseño Sistema Académico SENA

## Identidad Visual

Este sistema utiliza la identidad visual oficial del SENA con los siguientes colores:

### Paleta de Colores

- **Verde Principal**: `#39A900` - Color institucional SENA
- **Verde Secundario**: `#007832` - Color complementario
- **Fondos**: Blanco con gradientes verdes suaves
- **Acentos**: Gradientes lineales entre verde principal y secundario

## Características del Diseño

### 1. Sidebar (Menú Lateral)
- Header con gradiente verde institucional
- Logo SENA con fondo blanco y sombra
- Enlaces con hover verde suave
- Indicador visual para página activa (borde izquierdo verde)
- Fondo con gradiente sutil verde-blanco

### 2. Contenido Principal
- Fondo con gradiente diagonal verde muy suave
- Títulos con gradiente de texto verde
- Tarjetas con bordes verdes suaves
- Sombras con tinte verde para coherencia visual

### 3. Componentes

#### Botones
- **Primario**: Gradiente verde con sombra verde
- **Secundario**: Blanco con borde gris
- **Peligro**: Blanco con hover rojo

#### Tablas
- Header con gradiente verde institucional
- Hover en filas con fondo verde muy claro
- Bordes verdes suaves

#### Formularios
- Inputs con focus verde
- Labels con peso visual adecuado
- Validación con colores semánticos

### 4. Páginas Especiales

#### Login (`views/login.php`)
- Fondo con gradiente verde completo
- Patrón de puntos animado
- Tarjeta blanca flotante con sombra profunda
- Header verde con logo SENA
- Formulario limpio y accesible

#### Dashboard (`index.php`)
- Banner de bienvenida con gradiente verde
- Tarjetas de estadísticas con iconos coloridos
- Accesos rápidos con hover interactivo
- Grid responsivo

## Archivos Modificados

1. **`assets/css/styles.css`**
   - Actualización completa de colores SENA
   - Gradientes en componentes clave
   - Mejoras de accesibilidad
   - Estilos de impresión

2. **`views/layout/header.php`**
   - Sidebar con identidad SENA
   - Navegación mejorada
   - Logo institucional

3. **`views/layout/footer.php`**
   - Scripts de inicialización
   - Funcionalidad móvil

4. **`views/login.php`** (NUEVO)
   - Página de login con diseño SENA
   - Gradientes verdes en fondo
   - Animaciones sutiles

5. **`index.php`** (NUEVO)
   - Dashboard principal
   - Estadísticas visuales
   - Accesos rápidos

## Responsive Design

El diseño es completamente responsive:

- **Desktop**: Sidebar fijo, contenido amplio
- **Tablet**: Sidebar colapsable, ajustes de grid
- **Mobile**: Sidebar overlay, botones full-width

## Accesibilidad

- Contraste WCAG AA cumplido
- Focus visible en todos los elementos interactivos
- Etiquetas semánticas
- Navegación por teclado
- Textos alternativos

## Uso

### Estructura de una Vista

```php
<?php
$title = 'Título de la Página';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/'],
    ['label' => 'Sección'],
];
include __DIR__ . '/../layout/header.php';
?>

<!-- Tu contenido aquí -->

<?php include __DIR__ . '/../layout/footer.php'; ?>
```

### Componentes Disponibles

- `.btn-primary` - Botón principal verde
- `.btn-secondary` - Botón secundario
- `.btn-danger` - Botón de peligro
- `.table-container` - Contenedor de tabla
- `.form-card` - Tarjeta de formulario
- `.detail-card` - Tarjeta de detalles
- `.alert-success` / `.alert-error` - Alertas
- `.sena-badge` - Badge institucional
- `.sena-divider` - Divisor verde

## Iconos

Se utiliza **Lucide Icons** para todos los iconos del sistema:
- Carga desde CDN
- Inicialización automática
- Consistencia visual

## Navegación

El menú lateral incluye acceso a:
- Inicio
- Sedes
- Ambientes
- Programas
- Fichas
- Instructores
- Asignaciones
- Detalles de Asignación
- Competencias
- Competencias por Programa
- Títulos

---

**Desarrollado con la identidad visual del SENA** 🟢
