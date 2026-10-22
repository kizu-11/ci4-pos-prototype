<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        
        // Fetch records directly from MySQL database table
        $data['users'] = $model->findAll();

        return view('users/index', $data);
    }

    public function newForm()
    {
        return view('users/form', [
            'title' => 'Add New User',
            'action' => site_url('users/create'),
            'user' => [],
        ]);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|max_length[50]|is_unique[users.username]',
            'full_name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Add New User',
                'action' => site_url('users/create'),
                'user' => $this->request->getPost(),
            ]);
        }

        $avatar = $this->processAvatar();

        if ($avatar === false) {
            return view('users/form', [
                'title' => 'Add New User',
                'action' => site_url('users/create'),
                'user' => $this->request->getPost(),
            ]);
        }

        (new UserModel())->insert([
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
            'avatar' => $avatar,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('users'))
            ->with('success', 'User account created successfully.');
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        return view('users/form', [
            'title' => 'Edit User',
            'action' => site_url('users/update/' . $id),
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $existing = $model->find($id);

        if ($existing === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'username' => "required|max_length[50]|is_unique[users.username,id,{$id}]",
            'full_name' => 'required|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return view('users/form', [
                'title' => 'Edit User',
                'action' => site_url('users/update/' . $id),
                'user' => array_merge($existing, $this->request->getPost()),
            ]);
        }

        $avatar = $this->processAvatar();

        if ($avatar === false) {
            return view('users/form', [
                'title' => 'Edit User',
                'action' => site_url('users/update/' . $id),
                'user' => array_merge($existing, $this->request->getPost()),
            ]);
        }

        $data = [
            'username' => trim($this->request->getPost('username')),
            'full_name' => trim($this->request->getPost('full_name')),
        ];

        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users'))
            ->with('success', 'User account updated successfully.');
    }

    private function processAvatar(): string|false|null
    {
        $file = $this->request->getFile('avatar');

        if ($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $this->validate([
            'avatar' => 'uploaded[avatar]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|max_size[avatar,2048]',
        ])) {
            return false;
        }

        $temporaryName = $file->getRandomName();
        $temporaryDirectory = WRITEPATH . 'uploads';
        $file->move($temporaryDirectory, $temporaryName);

        $filename = pathinfo($temporaryName, PATHINFO_FILENAME) . '.jpg';
        $avatarDirectory = FCPATH . 'uploads/avatars';

        if (! is_dir($avatarDirectory)) {
            mkdir($avatarDirectory, 0755, true);
        }

        service('image')
            ->withFile($temporaryDirectory . DIRECTORY_SEPARATOR . $temporaryName)
            ->fit(300, 300, 'center')
            ->save($avatarDirectory . DIRECTORY_SEPARATOR . $filename, 80);

        @unlink($temporaryDirectory . DIRECTORY_SEPARATOR . $temporaryName);

        return $filename;
    }
}
