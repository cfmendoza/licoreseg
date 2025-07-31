@extends('layouts.app')

@section('title', 'Usuarios y Roles | ' . config('app.name'))

@section('content')
<div class="container py-4">
  <h1 class="mb-4 fw-bold text-primary">Gestión de Usuarios, Roles y Permisos</h1>

  {{-- Botón para nuevo usuario --}}
  <div class="mb-4 d-flex justify-content-end">
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary shadow">
      <i class="bi bi-person-plus"></i> Nuevo Usuario
    </a>
  </div>

  <div class="row g-4">
    {{-- Tabla de usuarios --}}
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Lista de Usuarios</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Roles</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $u)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                      @foreach($u->getRoleNames() as $role)
                        <span class="badge bg-secondary">{{ $role }}</span>
                      @endforeach
                    </td>
                    <td>
                      <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <form action="{{ route('usuarios.destroy', $u) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este usuario?')">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center text-muted py-3">No hay usuarios registrados.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Roles y permisos --}}
    <div class="col-lg-4">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
          <h6 class="mb-0 fw-bold">Roles Disponibles</h6>
        </div>
        <div class="card-body">
          @forelse($roles as $role)
            <div class="mb-2">
              <strong class="text-dark">{{ $role->name }}</strong>
              <div>
                @if($role->permissions->isNotEmpty())
                  @foreach($role->permissions as $perm)
                    <span class="badge bg-info text-dark mb-1">{{ $perm->name }}</span>
                  @endforeach
                @else
                  <small class="text-muted">Sin permisos</small>
                @endif
              </div>
            </div>
          @empty
            <p class="text-muted">No hay roles definidos.</p>
          @endforelse
        </div>
      </div>

      <div class="d-grid gap-2">
        <a href="{{ route('roles.index') }}" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-shield-lock"></i> Gestionar Roles
        </a>
        <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-key"></i> Gestionar Permisos
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
