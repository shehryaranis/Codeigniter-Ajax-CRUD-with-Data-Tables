<?php  
 defined('BASEPATH') OR exit('No direct script access allowed');  
 class Crud extends CI_Controller {  
      //functions  
      function index(){  
           $data["title"] = "Codeigniter Ajax CRUD with Data Tables and Bootstrap Modals";  
           $this->load->view('crud_view', $data);  
      }  
      
      function fetch_user(){  
           $this->load->model("crud_model");  
           $fetch_data = $this->crud_model->make_datatables();
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = $row->id;  
                $sub_array[] = $row->first_name;  
                $sub_array[] = $row->last_name;  
                $sub_array[] = '<button type="button"  value="'.$row->id.'" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update_user">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete_btn">Delete</button>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                      =>     intval($_POST["draw"]),  
                "recordsTotal"              =>      $this->crud_model->get_all_data(),  
                "recordsFiltered"           =>     $this->crud_model->get_filtered_data(),  
                "data"                      =>     $data  
           );  
           echo json_encode($output);  
      }

      function update_field(){
           $data =[
               'first_name' => $this->input->post('first'),
               'last_name' =>$this->input->post('last'),
           ];
          
          
          $id =   $this->input->post('id');
          $this->db->where('id', $id);
          $this->db->update('my_data',$data);
          if($this->db->affected_rows() > 0){
               echo TRUE;
          }
          else{
          echo FALSE;

          }

         
      }
      function delete_field(){
     
         
           $id = $this->input->post('id');
           $this->db->where('id', $id);
           $this->db->delete('my_data');
           if($this->db->affected_rows() > 0){
               echo TRUE;
          }
          else{
          echo FALSE;

          }
           
          

      }
        
 }  