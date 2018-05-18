<?php
/*
       _       _            ___  __
      / /_  () // /_  <  / _/  \/ __/
      \ \/  \/ / /// /// / / / /_ \/ / / /_ \  
     / / / / / / ,< / ,< / // / // / // /_/ /  
    /_// ////|//||\, ///\__/_/   
                           /__/                        

    Licensed under GNU General Public License v3.0
    http://www.gnu.org/licenses/gpl-3.0.txt
    Written by Snikky1505. Email : hazinokaime@gmail.com
    Follow me on GithHub : https://github.com/Snikky1505
   
    For the brave souls who get this far: You are the chosen ones,
    the valiant knights of programming who toil away, without rest,
    fixing our most awful code. To you, true saviors, kings of men,
 
    I say this: never gonna give you up, never gonna let you down,
    never gonna run around and desert you. Never gonna make you cry,
    never gonna say goodbye. Never gonna tell a lie and hurt you.

*/
namespace App\Http\Controllers;

use App\Http\Models\Book;
use App\Http\Models\Category;
use App\Http\Transformers\TransBook;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Mockery\Exception;

class ConBook extends Controller
{
    use Helpers;

    public function index () {
        $orm = Book::all();

        return $this->response->collection($orm, new TransBook);
    }
    public function show ($id) {
        try {

            $orm = Book::find($id);

        } catch ( Exception $e ) {
            return $e;
        }
        if ( $orm ) {
            return $this->response->item($orm, new TransBook);
        }

        return $this->response->errorNotFound('Data Tidak Ketemu');
    }

    public function destroy ($id) {
        $orm = Book::find($id);
        if ( $orm ) {
            try {
                $orm->delete();
            } catch ( Exception $e ) {
                return $e;
            }

            return response('Data Berhasil Dihapus');
        }

        return $this->response->errorNotFound('Data tidak ketemu');
    }

    public function store (Request $request) {

        //        $book = Book::where('categories_id','=',Category::find($id));

        $data = $request->only([
            'title',
            'category_id',
            'publisdate',
            'author',
            'isbn',
            'publisher'
        ]);

        $idcat = Category::find($data['category_id']);

        if($idcat)
        {
            $insert = new Book([
                'title' => $data['title'],
                'category_id' => $data['category_id'],
                'publisdate' => $data['publisdate'],
                'author' => $data['author'],
                'isbn' => $data['isbn'],
                'publisher' => $data['publisher'],
            ]);

            try {
                $insert->save();
            } catch ( Exception $e ) {
                $this->response->error($e, 500);
            }

            $this->response->created();

            return response('Berhasil Tambah Data Buku');
        }else {
            $this->response->errorNotFound('data kategori tidak ditemukan');
        }
    }

    public function update($id,Request $request)
    {
        try{
            $update = Book::find($id);
        }catch(Exception $e){
            $this->response->error($e,500);
        }
        if($update){
            $data = $request->only([
                'title',
                'category_id',
                'publisdate',
                'author',
                'isbn',
                'publisher'
            ]);

            $idcat = Category::find($data['category_id']);

            if($idcat)
            {
                $update->fill([
                    'title' => $data['title'],
                    'category_id' => $data['category_id'],
                    'publisdate' => $data['publisdate'],
                    'author' => $data['author'],
                    'isbn' => $data['isbn'],
                    'publisher' => $data['publisher']
                    ]);
                try{
                    $update->update();
                }catch (Exception $e){
                    $this->response->error($e,500);
                }
                return response('Data Berhasil di Update');
            }else{
                return response('Data kategori tidak ditemukan');
            }

        }else{
            $this->response->errorNotFound('data tidak berhasil di Update');
        }
    }
}