<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $name, $email, $password;
    public $user_id;

    public function render()
    {
        $data = [
            'users' => User::paginate(15)
        ];
        return view('livewire.users.user-list', $data);
    }
    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        if ($user){
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }
    public function cancel()
    {
        $this->user_id = null;
        $this->resetInputFields();
    }
    public function save()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => ($this->user_id) ? 'nullable' : 'required',
            'user_id' => 'nullable',
        ]);
        if (!empty($validateData['password'])){
            $validateData['password'] = Hash::make($validateData['password']);
        } else {
            unset($validateData['password']);
        }
        $userQuery = User::query();
        if (!empty($validateData['user_id'])){
            $user = $userQuery->find($validateData['user_id']);
            if($user){
                $user->update($validateData);
            }
        } else {
            $userQuery->create($validateData);
        }
        $this->user_id = null;
        session()->flash('message', 'User Created Successfully.');
        $this->resetInputFields();
    }
    public function delete($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        session()->flash('message', 'User Deleted Successfully.');
    }
}
