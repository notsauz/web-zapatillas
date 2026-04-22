@extends("layouts.app")

@section("styles")
    <link rel="stylesheet" href="{{ asset("css/profile.edit.css") }}">
@endsection

@section("content")
    <div class="row justify-content-center">
        <!-- Profile Edit Content -->
        <div class="col-md-10">
            <div class="card profile-card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        Mi Perfil
                    </h4>
                    <a href="{{ route("profile.favorites") }}" class="btn btn-light btn-sm">
                        <i class="fas fa-heart"></i> Mis Favoritos
                    </a>
                </div>

                <!-- Profile Edit Form -->
                <div class="card-body">
                    @if(session("success"))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session("success") }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session("error"))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session("error") }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session("info"))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session("info") }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session("warning"))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session("warning") }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane"
                                type="button" role="tab" aria-selected="true">
                                Información Personal
                            </button>
                        </li>
                        <!-- Cambiar Contraseña -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password-pane"
                                type="button" role="tab" aria-selected="false">
                                Cambiar Contraseña
                            </button>
                        </li>
                        <!-- Verificación de Email -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="verification-tab" data-bs-toggle="tab"
                                data-bs-target="#verification-pane" type="button" role="tab" aria-selected="false">
                                Verificación de Email
                            </button>
                        </li>
                        <!-- Eliminar Cuenta -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="delete-tab" data-bs-toggle="tab" data-bs-target="#delete-pane"
                                type="button" role="tab" aria-selected="false">
                                Eliminar Cuenta
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        <!-- 1. INFORMACIÓN PERSONAL -->
                        <div class="tab-pane fade show active" id="info-pane" role="tabpanel">
                            <form action="{{ route("profile.update") }}" method="POST">
                                @csrf
                                @method("PUT")

                                <!-- Nombre Completo -->
                                <div class="mb-3">
                                    <label for="name" class="form-label"><strong>Nombre Completo</strong></label>
                                    <input type="text" class="form-control @error("name") is-invalid @enderror" id="name"
                                        name="name" value="{{ old("name", $usuario->name) }}" required>
                                    @error("name")
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email editable o solo lectura según verificación -->
                                @if($usuario->email_verified_at)
                                    <!-- Email verificado: mostrar solo como información -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <strong>Correo Electrónico</strong>
                                            <span class="badge bg-success ms-2">Verificado</span>
                                        </label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $usuario->email }}" readonly disabled>
                                        <small class="form-text text-muted d-block mt-2">
                                            Tu correo está verificado y protegido. No puede ser modificado.
                                        </small>
                                    </div>
                                @else
                                    <!-- Email sin verificar: mostrar editable -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <strong>Correo Electrónico</strong>
                                            <span class="badge bg-warning ms-2">Sin Verificar</span>
                                        </label>
                                        <input type="email" class="form-control @error("email") is-invalid @enderror" id="email"
                                            name="email" value="{{ old("email", $usuario->email) }}" required>
                                        @error("email")
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <small class="form-text text-muted d-block mt-2">
                                            Verifica tu correo en la pestaña "Verificación de Email" para proteger tu cuenta.
                                        </small>
                                    </div>
                                @endif

                                <!-- Nota sobre cambios -->
                                <div class="alert alert-info mt-4" role="alert">
                                    <strong>Nota:</strong> Los cambios se guardarán inmediatamente.
                                </div>

                                <!-- Botones de Acción -->
                                <div class="btn-group-custom">
                                    <button type="submit" class="btn btn-primary">
                                        Guardar Cambios
                                    </button>
                                    <a href="{{ route("catalogo") }}" class="btn btn-secondary">
                                        Volver
                                    </a>
                                </div>
                            </form>
                        </div>

                        <!-- 2. CAMBIAR CONTRASEÑA -->
                        <div class="tab-pane fade" id="password-pane" role="tabpanel">
                            <form action="{{ route("profile.password") }}" method="POST">
                                @csrf

                                <!-- Contraseña Actual -->
                                <div class="mb-3">
                                    <label for="current_password" class="form-label"><strong>Contraseña
                                            Actual</strong></label>
                                    <input type="password"
                                        class="form-control @error("current_password") is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    @error("current_password")
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Introduce tu contraseña actual para verificación de
                                        seguridad.</small>
                                </div>

                                <!-- Nueva Contraseña -->
                                <div class="mb-3">
                                    <label for="new_password" class="form-label"><strong>Nueva Contraseña</strong></label>
                                    <input type="password" class="form-control @error("new_password") is-invalid @enderror"
                                        id="new_password" name="new_password" required>
                                    @error("new_password")
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">Mínimo 8 caracteres.</small>
                                </div>

                                <!-- Confirmar Nueva Contraseña -->
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label"><strong>Confirmar Nueva
                                            Contraseña</strong></label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" required>
                                    <small class="form-text text-muted">Debe coincidir con la nueva contraseña.</small>
                                </div>

                                <!-- Nota sobre cambios -->
                                <div class="alert alert-warning" role="alert">
                                    <strong>Importante:</strong> Tu sesión se cerrará después de cambiar la contraseña por
                                    razones de seguridad.
                                </div>

                                <!-- Botones de Acción -->
                                <div class="btn-group-custom">
                                    <button type="submit" class="btn btn-danger">
                                        Cambiar Contraseña
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- 3. VERIFICACIÓN DE EMAIL -->
                        <div class="tab-pane fade" id="verification-pane" role="tabpanel">
                            <h5 class="mb-3">Estado de Verificación de Email</h5>

                            <!-- Estado de Verificación -->
                            @if($usuario->email_verified_at)
                                <div class="verification-badge verified">
                                    <strong>Email Verificado</strong><br>
                                    <small>Tu correo electrónico está completamente verificado y protegido</small><br>
                                    <small style="font-size: 0.75rem; margin-top: 5px; display: block;">Verificado el:
                                        {{ $usuario->email_verified_at->format("d/m/Y H:i") }}</small>
                                </div>
                            @else
                                <div class="verification-badge not-verified">
                                    <strong>Email No Verificado</strong><br>
                                    <small>Tu correo aún no ha sido validado</small>
                                </div>
                            @endif

                            <!-- Información sobre Verificación -->
                            <div class="alert alert-info mb-4" role="alert">
                                <strong>¿Por qué verificar tu email?</strong><br>
                                Verificar tu correo electrónico ayuda a proteger tu cuenta y garantiza que puedas recibir
                                notificaciones importantes.
                            </div>

                            <!-- Acción de Verificación -->
                            @if(!$usuario->email_verified_at)
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title text-warning mb-3">Acción Requerida</h6>
                                        <p class="card-text mb-3">
                                            Tu correo electrónico aún no está verificado. Verifica tu email para aumentar la
                                            seguridad de tu cuenta.
                                        </p>
                                        <form action="{{ route("profile.send-verification") }}" method="POST" class="mb-3">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                Enviar Email de Verificación
                                            </button>
                                        </form>
                                        <small class="form-text text-muted">
                                            Recibirás un email con un enlace de verificación. El enlace caduca en 60 minutos.
                                        </small>
                                    </div>
                                </div>
                            @else
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="card-title text-success mb-3">Todo Correcto</h6>
                                        <p class="card-text mb-2">
                                            Tu correo electrónico <strong>{{ $usuario->email }}</strong> está verificado y
                                            protegido.
                                        </p>
                                        <small class="form-text text-muted">
                                            Si necesitas cambiar tu email, contacta con soporte.
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- 4. ELIMINAR CUENTA -->
                        <div class="tab-pane fade" id="delete-pane" role="tabpanel">
                            <div class="alert alert-danger mb-4" role="alert">
                                <strong>Advertencia Importante</strong><br>
                                Al eliminar tu cuenta, <strong>se borrarán PERMANENTEMENTE</strong> todos tus datos,
                                historial de compras y preferencias.
                                <strong>Esta acción NO se puede deshacer.</strong>
                            </div>

                            <!-- Nota de Advertencia -->
                            @if(session("warning"))
                                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                                    {{ session("warning") }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <!-- Zona de Peligro -->
                            <div class="card border-danger">
                                <div class="card-body">
                                    <h6 class="card-title text-danger mb-3">
                                        Zona de Peligro
                                    </h6>
                                    <p class="card-text mb-3">
                                        Si realmente deseas eliminar tu cuenta, debes confirmar tu contraseña y luego
                                        confirmar la eliminación en una segunda pantalla.
                                    </p>

                                    @if(!session("delete_account_confirmed"))
                                        <!-- Primer paso: Pedir contraseña -->
                                        <form action="{{ route("profile.delete-account") }}" method="POST">
                                            @csrf
                                            <!-- Contraseña Actual -->
                                            <div class="mb-3">
                                                <label for="delete_password" class="form-label"><strong>Contraseña de
                                                        Confirmación</strong></label>
                                                <input type="password"
                                                    class="form-control @error("password") is-invalid @enderror"
                                                    id="delete_password" name="password" required>
                                                @error("password")
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                                <small class="form-text text-muted">Introduce tu contraseña para
                                                    confirmar.</small>
                                            </div>

                                            <!-- Botón de Verificación -->
                                            <button type="submit" class="btn btn-outline-danger">
                                                Verificar Contraseña
                                            </button>
                                        </form>
                                    @else
                                        <!-- Segundo paso: Confirmar eliminación -->
                                        <div class="alert alert-danger mb-3" role="alert">
                                            <strong>Última Confirmación</strong><br>
                                            Estás a punto de eliminar tu cuenta permanentemente. Haz clic en el botón rojo para
                                            confirmar.
                                        </div>

                                        <!-- Botón de Confirmación -->
                                        <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal">
                                            CONFIRMAR ELIMINACIÓN
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Botón de Volver -->
                            <a href="{{ route("catalogo") }}" class="btn btn-secondary mt-3">
                                Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <!-- Modal de confirmación final -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <!-- Título del Modal -->
                    <h1 class="modal-title fs-5" id="confirmDeleteLabel">
                        CONFIRMAR ELIMINACIÓN DE CUENTA
                    </h1>
                    <!-- Botón de Cierre -->
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <!-- Contenido del Modal -->
                <div class="modal-body">
                    <p class="mb-3">
                        <strong>Esta es tu última oportunidad para cambiar de opinión.</strong>
                    </p>
                    <p class="mb-3">
                        Si eliminas tu cuenta:
                    </p>
                    <ul class="list-unstyled ms-3 mb-3">
                        <li class="mb-2">- Se borrarán todos tus datos personales</li>
                        <li class="mb-2">- Se perderá tu historial de compras</li>
                        <li class="mb-2">- No podrás acceder a tu cuenta</li>
                        <li>- Esta acción es irreversible</li>
                    </ul>
                    <p class="text-danger fw-bold mt-4">
                        ¿Realmente deseas continuar?
                    </p>
                </div>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <form action="{{ route("profile.confirm-delete") }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Sí, ELIMINAR MI CUENTA PERMANENTEMENTE
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts después de 30 segundos
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".alert").forEach(function (alert) {
                setTimeout(function () {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 30000);
            });
        });
    </script>
@endsection