<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ItemModel;
use App\Models\CategoryModel;

class Items extends BaseController
{
    protected $itemModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        return view('items/index');
    }

    public function data()
    {
        $items = $this->itemModel
            ->select('items.*, categories.name AS category_name')
            ->join('categories', 'categories.id = items.category_id')
            ->findAll();

        return $this->response->setJSON($items);
    }

    public function categories()
    {
        return $this->response->setJSON($this->categoryModel->findAll());
    }

    public function show($id)
    {
        $item = $this->itemModel->find($id);
        return $this->response->setJSON($item);
    }

    public function save()
    {
        $data = $this->request->getPost();

        if (!empty($data['id'])) {
            $this->itemModel->update($data['id'], $data);
        } else {
            $this->itemModel->insert($data);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $this->itemModel->delete($id);
        return $this->response->setJSON(['status' => 'deleted']);
    }
}