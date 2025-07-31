<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function index()
    {
        return view('categories/index');
    }

    public function fetch()
    {
        return $this->response->setJSON($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->model->save($data);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->model->update($id, $data);
        return $this->response->setJSON(['status' => 'updated']);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return $this->response->setJSON(['status' => 'deleted']);
    }

    public function show($id)
    {
        return $this->response->setJSON($this->model->find($id));
    }
}