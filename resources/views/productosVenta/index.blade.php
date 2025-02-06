@extends('adminlte::page')

@section('title', 'Catálogo de Libros')

@section('content')
<div class="container">
    <h1 class="text-center" style="color: var(--color-primary); font-weight: bold;">
        📚 Catálogo de Libros
    </h1>

    <!-- 🔍 Buscador y Filtros -->
    <div class="mb-4 row">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar por nombre..." onkeyup="filterProducts()">
        </div>
        <div class="col-md-6">
            <select id="categoryFilter" class="form-control" onchange="filterProducts()">
                <option value="">Todas las categorías</option>
                @foreach ($productos->groupBy('categoria.nombre') as $categoria => $productosCategoria)
                    <option value="{{ strtolower($categoria) }}">{{ $categoria }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @foreach ($productos->groupBy('categoria.nombre') as $categoria => $productosCategoria)
        <div class="mb-4 categoria-container" data-categoria="{{ strtolower($categoria) }}">
            <h2 style="color: var(--color-secondary); font-weight: bold;">{{ $categoria }}</h2>

            <div class="horizontal-scroll">
                @foreach ($productosCategoria as $producto)
                    <div class="card producto-card" data-nombre="{{ strtolower($producto->producto) }}" data-categoria="{{ strtolower($categoria) }}">
                        <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : 'https://via.placeholder.com/150' }}"
                            class="card-img-top"
                            alt="{{ $producto->producto }}">

                        <div class="card-body">
                            <!-- ✅ Nombre del libro ahora completamente centrado -->
                            <h4 class="card-title nombre-libro">{{ $producto->producto }}</h4>

                            <p class="card-text text-center"><strong>Precio:</strong> <span class="precio-destacado">${{ number_format($producto->precio_venta, 2) }}</span></p>
                            <p class="card-text text-center"><strong>Stock:</strong> {{ $producto->stock }}</p>

                            <p class="card-text text-center categoria-text">
                                <strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </p>

                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary w-100">🛒 Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection

@section('css')
<style>
    :root {
        --color-primary: #285C4D; /* Verde oscuro */
        --color-secondary: #B38E5D; /* Marrón elegante */
        --color-white: #ffffff;
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

    /* 🔵 Estilo de Productos */
    .horizontal-scroll {
        display: flex;
        overflow-x: auto;
        gap: 15px;
        padding-bottom: 10px;
    }

    .horizontal-scroll::-webkit-scrollbar {
        height: 8px;
    }

    .horizontal-scroll::-webkit-scrollbar-thumb {
        background-color: var(--color-primary);
        border-radius: 10px;
    }

    .producto-card {
        flex: 0 0 250px;
        border: 1px solid var(--color-primary);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .producto-card:hover {
        transform: scale(1.05);
    }

    .producto-card img {
        height: 180px;
        object-fit: cover;
    }

    .producto-card .card-body {
        text-align: center;
    }

    /* ✅ Estilos mejorados */
    .nombre-libro {
        font-size: 1.6rem;
        color: var(--color-primary);
        font-weight: bold;
        text-align: center;
        display: block;
    }

    .categoria-text {
        font-size: 1rem;
        font-weight: bold;
        color: var(--color-secondary);
    }

    .precio-destacado {
        font-size: 20px;
        font-weight: bold;
        color: #28a745;
    }

</style>
@endsection

@section('js')
<script>
    function filterProducts() {
        let searchInput = document.getElementById('searchInput').value.toLowerCase();
        let selectedCategory = document.getElementById('categoryFilter').value;
        let categorias = document.querySelectorAll('.categoria-container');

        categorias.forEach(categoria => {
            let productos = categoria.querySelectorAll('.producto-card');
            let matches = 0;

            productos.forEach(producto => {
                let nombre = producto.getAttribute('data-nombre');
                let categoriaProducto = producto.getAttribute('data-categoria');

                let matchNombre = nombre.includes(searchInput);
                let matchCategoria = selectedCategory === "" || categoriaProducto === selectedCategory;

                if (matchNombre && matchCategoria) {
                    producto.style.display = "block";
                    matches++;
                } else {
                    producto.style.display = "none";
                }
            });

            if (matches === 0) {
                categoria.classList.add('hidden');
            } else {
                categoria.classList.remove('hidden');
            }
        });
    }
</script>
@endsection
