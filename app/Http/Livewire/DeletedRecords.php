<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class DeletedRecords extends Component
{
    use WithPagination;

    public $table = 'users';
    public $title_modal = 'Registros Eliminados';
    public $columns = [];
    public $selectedAll = false;
    public $selected = [];
    public $selectedRecordId;

    public function render()
    {
        $records = [];
        $this->columns = [];

        switch ($this->table) {
            case 'users':
                $records = DB::table('users')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.id', 'users.name', 'roles.name as role', 'users.updated_at')
                    ->where('roles.name', '!=', 'Driver')
                    ->where('users.deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'name', 'label' => 'Name'],
                    ['key' => 'role', 'label' => 'Role'],
                    ['key' => 'updated_at', 'label' => 'Deleted At'],
                ];
                break;

            case 'drivers':
                $records = DB::table('users')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select('users.id', 'users.name', 'roles.name as role', 'users.updated_at')
                    ->where('roles.name', '=', 'Driver')
                    ->where('users.deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'name', 'label' => 'Nombre'],
                    ['key' => 'role', 'label' => 'Rol'],
                    ['key' => 'updated_at', 'label' => 'Deleted At'],
                ];
                break;

            case 'vehicles':
                $records = DB::table($this->table)
                    ->select('id', 'make', 'model', 'year', 'updated_at')
                    ->where('deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'make', 'label' => 'Marca'],
                    ['key' => 'model', 'label' => 'Modelo'],
                    ['key' => 'year', 'label' => 'Año'],
                    ['key' => 'updated_at', 'label' => 'Deleted'],
                ];
                break;
            case 'facilities':
                $records = DB::table($this->table)
                    ->leftJoin('service_contracts', 'service_contracts.id', '=', 'facilities.service_contract_id')
                    ->select($this->table . '.id', $this->table . '.name', 'company', $this->table . '.updated_at')
                    ->where($this->table . '.deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'name', 'label' => 'Nombre'],
                    ['key' => 'company', 'label' => 'Contrato'],
                    ['key' => 'updated_at', 'label' => 'Eliminado'],
                ];
                break;
            case 'service_contracts':
                $records = DB::table($this->table)
                    ->select('id', 'company', 'updated_at')
                    ->where('deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'company', 'label' => 'Compañía'],
                    ['key' => 'updated_at', 'label' => 'Eliminado'],
                ];
                break;
            case 'patients':
                $records = DB::table($this->table)
                    ->select('id', 'first_name', 'last_name', 'updated_at')
                    ->where('deleted', 1)
                    ->paginate(10);
                $this->columns = [
                    ['key' => 'first_name', 'label' => 'Nombre'],
                    ['key' => 'last_name', 'label' => 'Apellido'],
                    ['key' => 'updated_at', 'label' => 'Eliminado'],
                ];
                break;
            case 'schedulings':
                $records = DB::table($this->table)
                        ->leftJoin('patients', 'patients.id', '=', 'schedulings.patient_id')
                        ->select(
                            $this->table . '.id',
                            DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name"),
                            $this->table . '.updated_at'
                        )
                        ->where($this->table . '.deleted', 1)
                        ->paginate(10);
                        
                $this->columns = [
                    ['key' => 'patient_name', 'label' => 'Paciente'],
                    ['key' => 'updated_at', 'label' => 'Eliminado'],
                ];
                break;
            default:
                $records = DB::table($this->table)
                    ->where('deleted', 1)
                    ->paginate(10);
                break;
        }

        return view('livewire.deleted.deleted-records', [
            'records' => $records,
        ]);
    }

    public function sessionAlert($data)
    {
        session()->flash('alert', $data);
        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function confirmRestore($recordId)
    {
        $this->selectedRecordId = $recordId;
        $this->dispatchBrowserEvent('openModal', ['name' => 'revertModal']);
    }

    public function confirmDelete($recordId)
    {
        $this->selectedRecordId = $recordId;
        $this->dispatchBrowserEvent('openModal', ['name' => 'deleteModal']);
    }

    public function restore()
    {
        if ($this->selectedRecordId) {
            if($this->table == 'drivers'){
                DB::table('users')
                ->where('id', $this->selectedRecordId)
                ->update(['deleted' => 0]);
            }else{
                DB::table($this->table)
                ->where('id', $this->selectedRecordId)
                ->update(['deleted' => 0]);
            }

            $this->sessionAlert([
                'message' => 'Registro restaurado exitosamente.',
                'type' => 'success',
                'icon' => 'check',
            ]);
            
            $this->dispatchBrowserEvent('closeModal', ['name' => 'revertModal']);
            $this->selectedRecordId = null;
        }
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = DB::table($this->table)
                ->where('deleted', 1)
                ->pluck('id')
                ->toArray();
        } else {
            // Si deselecciona el checkbox padre, vacía la selección
            $this->selected = [];
        }
    }

    public function delete()
    {
        if ($this->selectedRecordId) {
            if($this->table == 'drivers'){
                DB::table('users')
                ->where('id', $this->selectedRecordId)
                ->delete();
            }else{
                if($this->table == 'patients'){
                    DB::table('addresses')
                    ->where('patient_id', $this->selectedRecordId)
                    ->delete();
                }
                
                DB::table($this->table)
                ->where('id', $this->selectedRecordId)
                ->delete();
            }

            $this->sessionAlert([
                'message' => 'Registro eliminado exitosamente.',
                'type' => 'success',
                'icon' => 'check',
            ]);

            $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteModal']);
            $this->selectedRecordId = null;
        }
    }
}