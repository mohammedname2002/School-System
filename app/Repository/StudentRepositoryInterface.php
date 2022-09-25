<?php
namespace App\Repository;



interface StudentRepositoryInterface{
    public function Get_Student();

    public function Create_Student();

public function Get_classrooms($id);

    public function Get_Sections($id);
    public function Store_Students($request);
    public function Update_Students($request);

    public function edit_Students($id);
    public function Show_Student($id);
    public function Upload_attachment($request);
    public function Download_attachment($studentsname , $filename);

    public function Delete_Students($request);
    public function Delete_attachment($request);

    }
