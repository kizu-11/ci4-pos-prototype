<?php

namespace App\Controllers;

use App\Libraries\DemoStore;

class CustomerController extends BaseController
{
    private function store(): DemoStore { return new DemoStore('customers'); }

    public function index() { return view('customers/index', ['customers' => $this->store()->all()]); }

    public function newForm()
    {
        return view('customers/form', ['title' => 'Add New Customer', 'action' => site_url('customers/create'), 'customer' => []]);
    }

    public function create()
    {
        if (! $this->validate(['full_name' => 'required|max_length[100]', 'email' => 'required|valid_email|max_length[100]', 'phone' => 'permit_empty|max_length[20]'])) {
            return $this->form('Add New Customer', 'customers/create', $this->request->getPost());
        }
        $this->store()->insert([
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to(site_url('customers'))->with('success', 'Customer account created successfully.');
    }

    public function edit(int $id)
    {
        $customer = $this->store()->find($id);
        if ($customer === null) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        return view('customers/form', ['title' => 'Edit Customer', 'action' => site_url('customers/update/' . $id), 'customer' => $customer]);
    }

    public function update(int $id)
    {
        $store = $this->store();
        $existing = $store->find($id);
        if ($existing === null) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Customer not found.');
        if (! $this->validate(['full_name' => 'required|max_length[100]', 'email' => 'required|valid_email|max_length[100]', 'phone' => 'permit_empty|max_length[20]'])) {
            return $this->form('Edit Customer', 'customers/update/' . $id, array_merge($existing, $this->request->getPost()));
        }
        $store->update($id, [
            'full_name' => trim($this->request->getPost('full_name')),
            'email' => trim($this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ]);
        return redirect()->to(site_url('customers'))->with('success', 'Customer account updated successfully.');
    }

    private function form(string $title, string $action, array $customer)
    {
        return view('customers/form', ['title' => $title, 'action' => site_url($action), 'customer' => $customer]);
    }
}
