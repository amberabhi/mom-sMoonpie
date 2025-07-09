<?php

namespace App\Repositories\Admin\Interfaces;

interface ProductCategoryRepositoryInterface
{
    public function getAllRecords();

    public function getActiveRecords();

    public function getDatatable();

    public function storeRecord($data);

    public function updateRecord($data, $id);

    public function deleteRecord($id);

    public function storeImage($image, $id);
}
