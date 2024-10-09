<?php

namespace App\Http\Controllers;

class CategoriesController extends Controller
{
    //
    public function __construct()
    {

    }

    // Hiển thị danh sách chuyên mục
    public function index()
    {
        return 'Danh sách chuyên mục';
    }

    /**
     * @param $id
     * @return void
     */
    public function getCategory($id)
    {
        return 'Hiển thị chuyên mục ' . $id;
    }

    public function updateCategory($id)
    {

    }

    public function deleteCategory($id)
    {

    }

    public function addCategory()
    {

    }

    public function handleAddCategory()
    {

    }


}
