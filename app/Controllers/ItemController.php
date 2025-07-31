<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\ItemModel;
use App\Models\CategoryModel;

class ItemController extends BaseController
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

    public function fetch()
    {
        $data['items'] = $this->itemModel
            ->select('items.*, categories.name AS category')
            ->join('categories', 'categories.id = items.category_id')
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->itemModel->save($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $data = $this->request->getRawInput();
        $this->itemModel->update($id, $data);

        return $this->response->setJSON(['status' => 'updated']);
    }

    public function delete($id)
    {
        $this->itemModel->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }

    public function getCategories()
    {
        $data = $this->categoryModel->findAll();

        return $this->response->setJSON($data);
    }
}
