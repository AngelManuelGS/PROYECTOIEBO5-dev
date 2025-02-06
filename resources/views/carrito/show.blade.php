@extends('adminlte::page')

@section('title', 'Mi Carrito')

@section('content_header')
<h1 class="text-center font-weight-bold mb-2" style="color: var(--color-primary);">
    <i class="fas fa-shopping-cart"></i> Mi Carrito
    </h1>
@stop

@section('content')
<div class="container">
    <div class="card shadow-sm border-2" style="border-color: var(--color-primary); border-radius: 8px;">
        <div class="card-header bg-primary text-white d-flex align-items-center" style="border-radius: 8px 8px 0 0;">
            <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Detalles del Carrito</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($carrito as $id => $item)
                            <tr>
                                <td class="fw-bold">{{ $item['nombre'] }}</td>
                                <td class="text-success fw-bold">${{ number_format($item['precio'], 2) }}</td>
                                <td>
                                    <form action="{{ route('carrito.actualizar', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <div class="d-flex justify-content-center align-items-center">
                                            <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                                   min="1" max="{{ $item['stock'] }}"
                                                   class="form-control form-control-sm text-center mx-2"
                                                   style="width: 60px; font-size: 1rem; font-weight: bold;">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="fas fa-sync-alt"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </td>
                                <td class="fw-bold text-success fs-5">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                                <td>
                                    <form action="{{ route('carrito.remover', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">🛒 El carrito está vacío.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if (!empty($carrito))
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total General:</td>
                                <td class="fw-bold text-success fs-4">${{ number_format($totalGeneral, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            @if (!empty($carrito))
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('productosVenta.index') }}" class="btn btn-blue btn-lg">
                        <i class="fas fa-arrow-left"></i> Seguir Comprando
                    </a>
                    </a>
                    <form action="{{ route('carrito.comprar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg fw-bold">
                            <i class="fas fa-check-circle"></i> Finalizar Compra
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        :root {
            --color-primary: #285C4D;
            --color-secondary: #B38E5D;
            --color-white: #ffffff;
        }

        /* 🔹 Estilización del menú lateral */
        .main-sidebar {
            background-color: var(--color-primary) !important; /* Fondo del menú */
        }

          /* 🟢 Personalización del Menú Lateral */

/* Estilo para el contenedor principal del menú lateral */
.main-sidebar {
    /* Establece el color de fondo del menú lateral usando una variable CSS */
    background-color: var(--color-primary) !important; /* Se usa !important para asegurarse de que este estilo tenga prioridad */
}

/* Estilo para los enlaces del menú lateral */
.nav-sidebar .nav-link {
    /* Establece el color del texto a blanco usando la variable CSS --color-white */
    color: var(--color-white);

    /* Establece el peso de la fuente del texto como negrita */
    font-weight: bold;
}

/* Estilo para los iconos del menú lateral */
.nav-sidebar .nav-icon {
    /* Establece el color de los iconos a blanco usando la variable CSS --color-white */
    color: var(--color-white);
}

/* Estilo para los enlaces del menú lateral cuando se pasa el ratón por encima (hover) */
.nav-sidebar .nav-link:hover {
    /* Cambia el fondo del enlace a un color secundario definido en --color-secondary */
    background-color: var(--color-secondary);

    /* Mantiene el texto blanco cuando el enlace está en estado hover */
    color: var(--color-white);
}

/* Estilo para los enlaces activos o de ítems de menú abiertos */
.nav-sidebar .nav-item.menu-open > .nav-link,
.nav-sidebar .nav-link.active {
    /* Cambia el fondo del enlace a un color secundario definido en --color-secondary */
    background-color: var(--color-secondary);

    /* Mantiene el texto blanco cuando el enlace está activo o cuando el ítem de menú está abierto */
    color: var(--color-white);
}


    .brand-text {
        font-weight: bold;
        font-size: 18px;
    }

        /* 🔹 Botón de cierre en móviles */
        .sidebar-mini.sidebar-collapse .main-sidebar {
            width: 70px !important;
        }
        h1.text-center {
            font-family: 'Arial', sans-serif; /* Fuente del encabezado */
            font-weight: bold; /* Peso de la fuente (negrita) */
            color: var(--color-primary); /* Color del texto (verde oscuro) */
            font-size: 2.5rem; /* Ajusta el tamaño según lo necesites */
            font-weight: bold;
        }
        .btn-blue {
    background-color: #007bff; /* Color azul */
    color: white; /* Color del texto blanco */
    border-color: #007bff; /* Color del borde (si tiene) */
}

    </style>
@stop


@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name="cantidad"]').forEach(input => {
        input.addEventListener('change', function () {
            let maxStock = parseInt(this.getAttribute('max'));
            if (parseInt(this.value) > maxStock) {
                alert('No puedes agregar más de ' + maxStock + ' unidades.');
                this.value = maxStock; // Ajusta automáticamente al máximo permitido
            }
        });
    });
});
</script>
@stop
