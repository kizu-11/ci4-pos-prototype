<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class CustomerController extends BaseController
{
    public function index()
    {
        $model = new CustomerModel();
        
        // Fetch records directly from MySQL database table instead of static array
        $data['customers'] = $model->findAll();

        return view('customers/index', $data);
    }

    public function newForm()
    {
        return view('customers/form', [
            'title' => 'Add New Customer',
            'action' => site_url('customers/create'),
            'customer' => [],
        ]);
    }

    public function create()
    {
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'    => 'required|valid_email|max_length[100]',
            'phone'    => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Add New Customer',
                'action' => site_url('customers/create'),
                'customer' => $this->request->getPost(),
            ]);
        }

        (new CustomerModel())->insert([
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer account created successfully.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);

        if ($customer === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        return view('customers/form', [
            'title' => 'Edit Customer',
            'action' => site_url('customers/update/' . $id),
            'customer' => $customer,
        ]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();

        if ($model->find($id) === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        }

        $rules = [
            'full_name' => 'required|max_length[100]',
            'email'    => 'required|valid_email|max_length[100]',
            'phone'    => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return view('customers/form', [
                'title' => 'Edit Customer',
                'action' => site_url('customers/update/' . $id),
                'customer' => array_merge(['id' => $id], $this->request->getPost()),
            ]);
        }

        $model->update($id, [
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ]);

        return redirect()->to(site_url('customers'))
            ->with('success', 'Customer account updated successfully.');
    }
}
