@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1 class="text-center font-weight-bold" style="color: var(--color-primary);">Perfil de Usuario</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Tarjeta para actualizar información del perfil -->
            <div class="card shadow-sm border-2 mb-4" style="border-color: var(--color-primary); border-radius: 8px;">
                <div class="card-header bg-primary text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Información</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        @if ($user->cliente)
                            <!-- Teléfono -->
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono', $user->cliente->telefono) }}">
                            </div>

                            <!-- Dirección -->
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion" value="{{ old('direccion', $user->cliente->direccion) }}">
                            </div>

                            <!-- Plantel Educativo -->
                            <div class="mb-3">
                                <label for="plante_educativo" class="form-label">Plantel Educativo</label>
                                <input type="text" class="form-control" name="plante_educativo" value="{{ old('plante_educativo', $user->cliente->plante_educativo) }}">
                            </div>

                            <!-- Región -->
                            <div class="mb-3">
                                <label for="region" class="form-label">Región</label>
                                <input type="text" class="form-control" name="region" value="{{ old('region', $user->cliente->region) }}">
                            </div>
                        @endif

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                    </form>
                </div>
            </div>

            <!-- Tarjeta para actualizar la contraseña -->
            <div class="card shadow-sm border-2 mb-4" style="border-color: var(--color-secondary); border-radius: 8px;">
                <div class="card-header bg-warning text-white text-center" style="border-radius: 8px 8px 0 0;">
                    <h5 class="mb-0">Actualizar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" name="current_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>

           <!-- Tarjeta para eliminar cuenta -->
<div class="card shadow-sm border-2" style="border-color: var(--color-danger); border-radius: 8px;">
    <div class="card-header bg-danger text-white text-center" style="border-radius: 8px 8px 0 0;">
        <h5 class="mb-0">Eliminar Cuenta</h5>
    </div>
    <div class="card-body text-center">
        <p>Una vez que elimine su cuenta, todos sus datos y recursos serán eliminados permanentemente. Antes de proceder, descargue cualquier información que desee conservar.</p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger w-100" id="deleteAccountBtn">Eliminar Cuenta</button>
        </form>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Definición de los colores principales como variables CSS */
        :root {
            --color-primary: #285C4D; /* Color principal (verde oscuro) */
            --color-secondary: #B38E5D; /* Color secundario (marrón) */
            --color-danger: #dc3545; /* Color para los botones de peligro (rojo) */
            --color-white: #ffffff; /* Color blanco */
        }

        /* Clase para aplicar el color de fondo principal (verde oscuro) */
        .bg-primary { background-color: var(--color-primary) !important; }

        /* Clase para aplicar el color de fondo secundario (marrón) */
        .bg-warning { background-color: var(--color-secondary) !important; }

        /* Clase para aplicar el color de fondo de peligro (rojo) */
        .bg-danger { background-color: var(--color-danger) !important; }

        /* Estilos para botones de éxito y peligro */
        .btn-success, .btn-danger {
            color: var(--color-white); /* Color del texto del botón (blanco) */
            border: none; /* Sin borde en los botones */
        }

        /* Efecto al pasar el cursor sobre los botones, reduciendo la opacidad */
        .btn-success:hover, .btn-danger:hover { opacity: 0.8; }

        /* Estilo del encabezado h1: fuente, peso y color */
        h1 {
            font-family: 'Arial', sans-serif; /* Fuente del encabezado */
            font-weight: bold; /* Peso de la fuente (negrita) */
            color: var(--color-primary); /* Color del texto (verde oscuro) */
            font-size: 2.5rem; /* Ajusta el tamaño según lo necesites */
            font-weight: bold;
        }
    </style>

@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    let inputs = this.querySelectorAll('input[required]');
                    for (let input of inputs) {
                        if (input.value.trim() === '') {
                            e.preventDefault();
                            alert('Por favor, complete todos los campos obligatorios.');
                            return;
                        }
                    }
                });
            });
        });
    </script>
@stop
