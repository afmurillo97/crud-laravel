@extends('layouts.base')

@section('content')

    <!-- Index View -->
    <div class="row">
        <div class="col-12 mt-2">
            <div>
                <h2 class="text-white">CRUD de Tareas</h2>
            </div>
            <div>
                <a href="tasks/create" class="btn btn-primary">Crear tarea</a>
            </div>
        </div>

        @if (Session::get('success'))
            <div class="alert alert-success  mt-2">
                <strong>{{Session::get('success')}}<br>
            </div>
        @endif

        <div class="col-12 mt-4">
            <table class="table table-bordered text-white">
                <tr class="text-secondary">
                    <th>Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>

                @foreach ($tasks as $task)

                    <tr>
                        <td class="fw-bold">{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            {{ $task->due_date }}
                        </td>
                        <td>
                            @if($task->status == 'Pendiente')
                                @php $color = 'warning'; @endphp
                            @elseif($task->status == 'En Progreso')
                                @php $color = 'primary'; @endphp
                            @else
                                @php $color = 'success'; @endphp
                            @endif
                            <span class="badge bg-{{ $color }} fs-6">{{ $task->status }}</span>
                        </td>
                        <td>
                            <!-- Editar con la URL -->
                            <!-- <a href="tasks/{{ $task->id }}/edit" class="btn btn-warning">Editar</a> -->

                            <!-- Editar con modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" title="Editar Tarea">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}" title="Eliminar Tarea">
                                <i class="fas fa-trash"></i>
                            </button>


                        </td>
                    </tr>
                @endforeach

            </table>
            {{ $tasks->links() }}
        </div>
    </div>

    <!-- Edit Task Modal -->
    @foreach ($tasks as $task)
        <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Tarea</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                        <div class="form-group">
                                            <strong>Tarea:</strong>
                                            <input type="text" name="title" class="form-control" placeholder="Tarea" value="{{ $task->title }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                        <div class="form-group">
                                            <strong>Descripción:</strong>
                                            <textarea class="form-control" style="height:150px" name="description" placeholder="Descripción...">{{ $task->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                                        <div class="form-group">
                                            <strong>Fecha límite:</strong>
                                            <input type="date" name="due_date" class="form-control" id="" value={{ $task->due_date }}>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 mt-2">
                                        <div class="form-group">
                                            <strong>Estado (inicial):</strong>
                                            <select name="status" class="form-select" id="">
                                                <option value="">-- Elige el status --</option>
                                                <option value="Pendiente" @selected('Pendiente' == $task->status)>Pendiente</option>
                                                <option value="En progreso" @selected('En Progreso' == $task->status)>En progreso</option>
                                                <option value="Completada" @selected('Completada' == $task->status)>Completada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Delete Task Modal -->
    @foreach ($tasks as $task)
        <div class="modal fade" id="deleteTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar Tarea</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Estás seguro de eliminar esta tarea?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
