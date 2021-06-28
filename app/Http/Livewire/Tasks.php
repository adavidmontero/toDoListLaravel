<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use App\Models\CheckList;
use Livewire\WithPagination;

class Tasks extends Component
{
    //Usamos el trait para la paginación
    use WithPagination;

    //La variable que contendrá el nombre de la nueva tarea
    public $newTask;

    //La variable que contendrá el id de la lista seleccionada
    public $listId;

    //La variable que contendrá el nombre de la lista seleccionada
    public $listTitle;

    //Reglas de validación para crear una nueva tarea
    protected $rules = [
        'newTask' => 'required|min:4|max:50',
        'listId' => 'required'
    ];

    //Mensajes personalizados para cada una de las reglas de validación
    protected $messages = [
        'newTask.required' => 'El campo tarea es requerido',
        'newTask.min' => 'El campo tarea debe tener al menos 4 caracteres',
        'newTask.max' => 'El campo tarea debe tener máximo 50 caracteres',
        'listId.required' => 'Recuerde que debe seleccionar una lista para agregar esta tarea'
    ];

    //Definición de los escuchadores
    protected $listeners = [
        'listSelected',
        'listRemoved'
    ];

    public function listSelected($listId)
    {
        //Verificamos si no hay lista seleccionada o si la lista seleccionada es diferente
        //Si no deseleccionamos la lista
        if (!$this->listId || $this->listId !== $listId) {
            $this->listId = $listId;
            $this->listTitle = CheckList::find($listId)['title'];
        } else {
            $this->listId = 0;
            $this->listTitle = '';
        }
        /* $this->validate(['listId' => 'required']); */
    }

    //Cuando se elimina una lista el id y nombre de esta son borrados del componente
    public function listRemoved()
    {
        $this->listId = 0;
        $this->listTitle = '';
        /* $this->validate(['listId' => 'required']); */
    }

    public function addTask()
    {
        //Validamos que cumplan con las reglas
        $this->validate($this->rules);

        //Creamos la tarea
        Task::create([
            'name' => $this->newTask,
            'check_list_id' => $this->listId
        ]);

        //Emitimos el evento al componente CheckList de cuando una tarea es creada, eliminada o actualizada
        $this->emitTo('check-lists', 'taskUpdated');

        //Vaciamos las variables
        $this->newTask = '';

        //Enviamos un mensaje al usuario
        session()->flash('message', '¡Tarea agregada correctamente! 😄');
    }
    
    public function updateTask($taskId)
    {
        $task = Task::find($taskId);
        
        $task->update([
            'completed' => !$task['completed']
        ]);

        $this->emitTo('check-lists', 'taskUpdated');
    }

    public function remove($taskId)
    {
        $task = Task::find($taskId);

        $task->delete();

        $this->emitTo('check-lists', 'taskUpdated');

        session()->flash('message', '¡Tarea eliminada exitosamente! 🙂');
    }

    public function render()
    {
        return view('livewire.tasks', [
            'listTitle' => $this->listTitle ? $this->listTitle : '',
            'tasks' => Task::where('check_list_id', $this->listId)->latest()->paginate(5)
        ]);
    }
}
