<?php
/**
 * Vista: Ejemplos de Componentes SENA
 * Esta página muestra todos los componentes disponibles en el sistema
 */

$rol = 'coordinador';
$title = 'Componentes del Sistema';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ejemplos'],
];

include __DIR__ . '/layout/header.php';
?>

<div class="page-header">
    <h1 class="page-title">Componentes del Sistema</h1>
    <span class="sena-badge">
        <i data-lucide="palette" style="width: 14px; height: 14px;"></i>
        Guía de Diseño
    </span>
</div>

<!-- Alertas -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Alertas</h2>
    
    <div class="alert alert-success">
        <i data-lucide="check-circle-2"></i>
        Operación completada exitosamente
    </div>
    
    <div class="alert alert-error">
        <i data-lucide="alert-circle"></i>
        Ha ocurrido un error en la operación
    </div>
</section>

<div class="sena-divider"></div>

<!-- Botones -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Botones</h2>
    
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <button class="btn btn-primary">
            <i data-lucide="plus"></i>
            Botón Primario
        </button>
        
        <button class="btn btn-secondary">
            <i data-lucide="edit"></i>
            Botón Secundario
        </button>
        
        <button class="btn btn-danger">
            <i data-lucide="trash-2"></i>
            Botón Peligro
        </button>
        
        <button class="btn btn-primary btn-sm">
            <i data-lucide="save"></i>
            Botón Pequeño
        </button>
    </div>
</section>

<div class="sena-divider"></div>

<!-- Badges -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Badges</h2>
    
    <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <span class="sena-badge">SENA Oficial</span>
        <span class="badge badge-success">Activo</span>
        <span class="badge badge-info">Información</span>
        <span class="badge badge-warning">Advertencia</span>
    </div>
</section>

<div class="sena-divider"></div>

<!-- Tabla -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Tabla de Datos</h2>
    
    <div class="table-container">
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="table-id">001</span></td>
                        <td>Ejemplo 1</td>
                        <td><span class="badge badge-success">Activo</span></td>
                        <td>
                            <div class="table-actions">
                                <button class="action-btn view-btn" title="Ver">
                                    <i data-lucide="eye"></i>
                                </button>
                                <button class="action-btn edit-btn" title="Editar">
                                    <i data-lucide="pencil-line"></i>
                                </button>
                                <button class="action-btn delete-btn" title="Eliminar">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="table-id">002</span></td>
                        <td>Ejemplo 2</td>
                        <td><span class="badge badge-info">Pendiente</span></td>
                        <td>
                            <div class="table-actions">
                                <button class="action-btn view-btn" title="Ver">
                                    <i data-lucide="eye"></i>
                                </button>
                                <button class="action-btn edit-btn" title="Editar">
                                    <i data-lucide="pencil-line"></i>
                                </button>
                                <button class="action-btn delete-btn" title="Eliminar">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="sena-divider"></div>

<!-- Formulario -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Formulario</h2>
    
    <div class="form-container">
        <div class="form-card">
            <form>
                <div class="form-group">
                    <label for="ejemplo1" class="form-label">
                        Campo de Texto <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="ejemplo1"
                        class="form-input"
                        placeholder="Ingresa un valor"
                    >
                    <div class="form-hint">Este es un texto de ayuda</div>
                </div>

                <div class="form-group">
                    <label for="ejemplo2" class="form-label">
                        Campo con Error <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="ejemplo2"
                        class="form-input input-error"
                        placeholder="Campo con error"
                    >
                    <div class="form-error visible">
                        <i data-lucide="alert-circle"></i>
                        <span>Este campo es requerido</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i>
                        Guardar
                    </button>
                    <button type="button" class="btn btn-secondary">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="sena-divider"></div>

<!-- Tarjeta de Detalle -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Tarjeta de Detalle</h2>
    
    <div class="detail-card">
        <div class="sena-card-header">
            <i data-lucide="info" style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; margin-right: 8px;"></i>
            Información del Registro
        </div>
        <div class="detail-card-body">
            <div class="detail-row">
                <div class="detail-label">Campo 1</div>
                <div class="detail-value">Valor de ejemplo</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Campo 2</div>
                <div class="detail-value">Otro valor</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Estado</div>
                <div class="detail-value">
                    <span class="badge badge-success">Activo</span>
                </div>
            </div>
        </div>
        <div class="detail-card-footer">
            <button class="btn btn-secondary">
                <i data-lucide="arrow-left"></i>
                Volver
            </button>
            <button class="btn btn-primary">
                <i data-lucide="pencil-line"></i>
                Editar
            </button>
        </div>
    </div>
</section>

<div class="sena-divider"></div>

<!-- Colores -->
<section style="margin-bottom: 40px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 16px; color: #111827;">Paleta de Colores SENA</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div style="padding: 24px; background: #39A900; border-radius: 8px; color: white; text-align: center;">
            <div style="font-weight: 700; margin-bottom: 4px;">Verde Principal</div>
            <div style="font-size: 13px; opacity: 0.9;">#39A900</div>
        </div>
        
        <div style="padding: 24px; background: #007832; border-radius: 8px; color: white; text-align: center;">
            <div style="font-weight: 700; margin-bottom: 4px;">Verde Secundario</div>
            <div style="font-size: 13px; opacity: 0.9;">#007832</div>
        </div>
        
        <div style="padding: 24px; background: #e6f7e0; border-radius: 8px; color: #007832; text-align: center; border: 2px solid #39A900;">
            <div style="font-weight: 700; margin-bottom: 4px;">Verde Claro</div>
            <div style="font-size: 13px;">#e6f7e0</div>
        </div>
        
        <div style="padding: 24px; background: white; border-radius: 8px; color: #111827; text-align: center; border: 2px solid #d4edcc;">
            <div style="font-weight: 700; margin-bottom: 4px;">Blanco</div>
            <div style="font-size: 13px;">#FFFFFF</div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/layout/footer.php'; ?>
