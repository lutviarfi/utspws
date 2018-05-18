<?php

namespace App\Http\Controllers;

use App\Http\Models\Category;
use App\Http\Transformers\TransCategory;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Mockery\Exception;

class ConCategory extends Controller
{
    use Helpers;

    public function index(){
      $a = Category::all();

      return $this->response->collection($a, new TransCategory);
    }

    public function show($id){
      try {
        $a = Category::find($id);
      } catch (Exception $e) {
        return $e;
      }

      if ($a) {
        // code...
        return $this->response->item($a, new TransCategory);
      } else {
        // code...
        return $this->response->errorNotFound('Data Tidak Ditemukan');
      }

    }

    public function store(Request $request){
      // biar yg masuk 1 doang
      $data = $request->only([
        'categoryname',
      ]);

      // buat masuk ke database
      $a = new Category([
        'name' => $data['categoryname']
      ]);

      // insert ke db
      try {
        $a->save();
      } catch (Exception $e) {
        $this->response->error($e,500);
      }

      // kirim response berhasil insert, status code 200
      $this->response->created();
    }

    public function update($id, Request $request){
      try {
        $a = Category::find($id);
      } catch (Exception $e) {
        $this->response->error($e,500);
      }

      if ($a) {
        // code...
        $data = $request->only([
          'category',
        ]);

        $a->fill([
          'name' => $data['category'],
        ]);
        try {
          $a->update();
        } catch (Exception $e) {
          $this->response->error($e,500);
        }
        $this->response->error('',200);
        // return response('Data Berhasil Disimpan');
      } else {
        $this->response->errorNotFound('Data Tidak Ditemukan');
      }
    }

    public function destroy($id){
      try {
        $a = Category::find($id);
      } catch (Exception $e) {
        $this->response->error($e,500);
      }

      if ($a) {
        try {
          $a->delete();
        } catch (Exception $e) {
          $this->response->error($e,500);
        }

        $this->response->noContent();
      } else {
        $this->response->errorNotFound('Data Tidak Ditemukan');
      }
    }
  }