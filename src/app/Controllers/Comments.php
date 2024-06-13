<?php

namespace App\Controllers;
use CodeIgniter\Database\Exceptions\DataException;

class Comments extends BaseController
{

    public function index(): string
    {
        $commentsModel = new \App\Models\Comments();
        
        if(empty($commentsModel->paginate(3))){
            return view('comments', ["isEmpty"=>true]);
            // dd($commentsModel->paginate(3));
        }else{
            return view('comments', ["comments"=>$commentsModel->paginate(3), 'pager'=>$commentsModel->pager,"isEmpty"=>false]);
        }

    }


    public function sort()
    {
        $data = $this->request->getGet();
        $commentsModel = new \App\Models\Comments();
        if(empty($commentsModel->paginate(3))){
            return view('comments', ["isEmpty"=>true]);
        }else{
            return view('comments', ["comments"=>$commentsModel->orderBy($data["column"], $data["direction"])->paginate(3), 'pager'=>$commentsModel->pager,]);
        }
    }

    public function create(){
        $data = $this->request->getPost();
        $commentsModel = new \App\Models\Comments();
        $data["date"] = date("Y-m-d H:i:s");
        $result = $commentsModel->insert($data);
        
        if(!$result){
            $errors = $commentsModel->errors();
            $errors["id"] = $result;
            return json_encode($errors);
        }else{
            return json_encode(["html"=>view("layouts/comments_list",["comments"=>$commentsModel->orderBy("id", "desc")->paginate(3), 'pager'=>$commentsModel->pager])]);
        }
    }

    public function destroy(){
        $commentsModel = new \App\Models\Comments();
        $id = $this->request->getPost("id");
        $commentsModel->delete($id);

        return json_encode(["html"=>view("layouts/comments_list",["comments"=>$commentsModel->paginate(3), 'pager'=>$commentsModel->pager])]);
    }
}
