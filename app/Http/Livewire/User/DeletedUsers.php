<?php

namespace App\Http\Livewire\User;

use App\Models\ModelLogUser as LogUser;
use App\Models\ModelUser as user;
use Livewire\Component;
use Livewire\WithPagination;

class DeletedUsers extends Component
{
    public $keyword = '';
    use WithPagination;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $keyword = '%'.$this->keyword.'%';

        $data = [
            
            'users' => User::onlyTrashed()
                                ->where('nama', 'like', $keyword)
                                // ->orWhere('nik', 'like', $keyword)
                                ->orderBy('deleted_at', 'DESC')
                                ->paginate(10),
        ];

        return view('livewire.user.deleted-users', $data)
        ->extends('layouts.app');
    }

    public function restore($id) 
    {
        $userQuery = User::where('id', $id)->onlyTrashed()->first();
        $userQuery->restore();

        LogUser::create([
            'id_user' => $id,
            'data_log' => [
                            'aksi' => 'Restore',
                            'browser' => $_SERVER['HTTP_USER_AGENT'],
                            'edited_by' => session('nama'),
                            'data_lama' =>  [
                                                'nama' => $userQuery['nama'],
                                                'nik' => $userQuery['nik'],
                                                'no_telp' => $userQuery['no_telp'],
                                            ],
                            'data_baru' =>  [],
                            ],
            ]); 
    }
}
