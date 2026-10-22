<?php

namespace App\Controllers;

use App\Libraries\DemoStore;

class UserController extends BaseController
{
    private function store(): DemoStore { return new DemoStore('users'); }

    public function index() { return view('users/index', ['users' => $this->store()->all()]); }

    public function newForm()
    {
        return view('users/form', ['title' => 'Add New User', 'action' => site_url('users/create'), 'user' => []]);
    }

    public function create()
    {
        if (! $this->validate(['username' => 'required|max_length[50]', 'full_name' => 'required|max_length[100]'])) {
            return $this->form('Add New User', 'users/create', $this->request->getPost());
        }
        $store = $this->store();
        $username = trim($this->request->getPost('username'));
        if ($store->hasValue('username', $username)) {
            session()->setFlashdata('errors', ['This username is already taken.']);
            return $this->form('Add New User', 'users/create', $this->request->getPost());
        }
        $avatar = $this->processAvatar();
        if ($avatar === false) return $this->form('Add New User', 'users/create', $this->request->getPost());
        $store->insert(['username' => $username, 'full_name' => trim($this->request->getPost('full_name')), 'avatar' => $avatar ?? '', 'created_at' => date('Y-m-d H:i:s')]);
        return redirect()->to(site_url('users'))->with('success', 'User account created successfully.');
    }

    public function edit(int $id)
    {
        $user = $this->store()->find($id);
        if ($user === null) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        return view('users/form', ['title' => 'Edit User', 'action' => site_url('users/update/' . $id), 'user' => $user]);
    }

    public function update(int $id)
    {
        $store = $this->store();
        $existing = $store->find($id);
        if ($existing === null) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        $posted = array_merge($existing, $this->request->getPost());
        if (! $this->validate(['username' => 'required|max_length[50]', 'full_name' => 'required|max_length[100]'])) {
            return $this->form('Edit User', 'users/update/' . $id, $posted);
        }
        $username = trim($this->request->getPost('username'));
        if ($store->hasValue('username', $username, $id)) {
            session()->setFlashdata('errors', ['This username is already taken.']);
            return $this->form('Edit User', 'users/update/' . $id, $posted);
        }
        $avatar = $this->processAvatar();
        if ($avatar === false) return $this->form('Edit User', 'users/update/' . $id, $posted);
        $data = ['username' => $username, 'full_name' => trim($this->request->getPost('full_name'))];
        if ($avatar !== null) $data['avatar'] = $avatar;
        $store->update($id, $data);
        return redirect()->to(site_url('users'))->with('success', 'User account updated successfully.');
    }

    private function form(string $title, string $action, array $user)
    {
        return view('users/form', ['title' => $title, 'action' => site_url($action), 'user' => $user]);
    }

    private function processAvatar(): string|false|null
    {
        $file = $this->request->getFile('avatar');
        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) return null;
        if (! $this->validate(['avatar' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]'])) return false;
        $temporaryName = $file->getRandomName();
        $temporaryDirectory = WRITEPATH . 'uploads';
        $file->move($temporaryDirectory, $temporaryName);
        $filename = pathinfo($temporaryName, PATHINFO_FILENAME) . '.jpg';
        $avatarDirectory = FCPATH . 'uploads/avatars';
        if (! is_dir($avatarDirectory)) mkdir($avatarDirectory, 0755, true);
        service('image')->withFile($temporaryDirectory . DIRECTORY_SEPARATOR . $temporaryName)->fit(300, 300, 'center')->save($avatarDirectory . DIRECTORY_SEPARATOR . $filename, 80);
        @unlink($temporaryDirectory . DIRECTORY_SEPARATOR . $temporaryName);
        return $filename;
    }
}
