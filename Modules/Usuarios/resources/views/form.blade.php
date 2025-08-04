@csrf

<div class="mb-3">
  <label for="name" class="form-label">Nombre</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="email" class="form-label">Correo electrónico</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="mb-3">
  <label for="password" class="form-label">Contraseña</label>
  <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
</div>

<div class="mb-3">
  <label for="roles" class="form-label">Roles</label>
  <select name="roles[]" class="form-select" multiple required>
    @foreach($roles as $role)
      <option value="{{ $role->name }}"
        {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>
        {{ ucfirst($role->name) }}
      </option>
    @endforeach
  </select>
</div>

<button type="submit" class="btn btn-primary" >
  <i class="bi bi-save"></i> Guardar
</button>
<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
