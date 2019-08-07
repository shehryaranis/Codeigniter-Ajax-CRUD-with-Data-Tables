<html>  
 <head>  
   <title><?php echo $title; ?></title>  
    
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
          
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
          <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
          <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> 
   <style>  
           body  
           {  
                margin:0;  
                padding:0;  
                background-color:#f1f1f1;  
           }  
           .box  
           {  
                width:900px;  
                padding:20px;  
                background-color:#fff;  
                border:1px solid #ccc;  
                border-radius:5px;  
                margin-top:10px;  
           }  
      </style>  
 </head>  
 <body>  
      <div class="container box">  
      <!-- alert -->
      <div class="alert alert-success" style="display:none">
          <strong>Success!</strong> This alert box could indicate a successful or positive action.
          </div>
          
          <!-- alert -->
           <h3 align="center"><?php echo $title; ?></h3><br />  
           <div class="table-responsive">  
                <br />  
                <table id="user_data" class="table table-bordered table-striped">  
                     <thead>  
                          <tr>  
                               <th width="10%">ID</th>  
                               <th width="35%">First Name</th>  
                               <th width="35%">Last Name</th>  
                               <th width="10%">Edit</th>  
                               <th width="10%">Delete</th>  
                          </tr>  
                     </thead>  
                </table>  
           </div>  
      </div>  
      <!-- Button trigger modal -->
           

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Fields</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
      
        <input type="text" class="form-control" name="" id="up_firstname">
        <input type="text" class="form-control"  name="" id="up_lastname">
        <input type="hidden" class="form-control"   id="user_id">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"   class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button"  class="btn btn-primary update_btn">Save changes</button>
      </div>
    </div>
  </div>
</div>



          <!-- Datatables Request -->
          <script type="text/javascript" language="javascript" >  
          $(document).ready(function(){  
               var dataTable = $('#user_data').DataTable({  
                    "processing":true,  
                    "serverSide":true, 
                    "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                                   $(nRow).attr('id', 'user_'+aData[0]);
                              },
                    "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                                   $("td:first", nRow).html(iDisplayIndex +1);
                                   return nRow;
                         },
                    "order":[],  
                    "ajax":{  
                         url:"<?php echo base_url() . 'index.php/crud/fetch_user'; ?>",  
                         type:"POST"  
                    },  
                    "columnDefs":[  
                         {  
                              "targets":[0, 1, 2],  
                              "orderable":true,
                              
                              // "createdCell": function (td, cellData, rowData, row, col) {
                              //      // console.log(rowData[0]);
                              //       $(td).addClass('user_' + rowData[0]);
                                    
                              // },
                              
                         },  
                    ],  
               });  
          });  
          </script>  
          <!-- Datatables Request -->

          <!-- Update Script -->
          <script>
               $(document).ready(function () {
          
                    $(document).on('click','.update_user',function () {

                       var first_name =   $('#user_'+this.value).find("td:eq(1)").text();
                       var last_name =    $('#user_'+this.value).find("td:eq(2)").text();
                       var user_id =    $('#user_'+this.value).find("td:eq(0)").text();
                       
                         
                         $('#up_firstname').val(first_name);
                         $('#up_lastname').val(last_name);
                         $('#user_id').val(user_id);
                         
                    //    alert($('.user_'+ this.value));  
                         
                         //ajax request to server.
                         
                         //get user info here from id
                         //fil input boxes to that values
                
                         
                         
                         $('#exampleModal').modal('show');
                    });
                    // $(document).on('click','.update_btn',function(){
                    //      // alert("updated");
                    //      // var First_ = document.getElementById('up_firstname');
                    //      // var last_ = document.getElementById('up_lastname');
                    //      // alert(First_.val());
                    //      $.get("up_firstname")
                         


                    // })
               $(document).on('click','.update_btn', function(){
                         var  url = "<?php echo base_url("index.php/crud/update_field");?>";
                         var first = $('#up_firstname').val();
                         var last = $('#up_lastname').val();
                         var user_id = $('#user_id').val();
                         var mytbl = $("#user_data").DataTable();

                         $.ajax({
                              type: "POST",
                              url: url,
                              data: { id: user_id, first: first , last: last },
                              success: function(data){
                                  if(data == 1){
                                   
                                   $('#exampleModal').modal('hide');
                                   mytbl.ajax.reload();

                                  }
                                   },
                                   error: function(){
                                        alert('failure');
                                   }
                         });
               });
               $(document).on('click','.delete_btn', function(){
                    var url = "<?php echo base_url("index.php/crud/delete_field");?>";
                    var user_id = $(this).attr('id');
                    var mytbl = $("#user_data").DataTable();
                    
                    $.ajax({
                         type: "POST",
                         url: url,
                         data: {id: user_id },
                         success: function(data){
                              console.log(data);
                                  if(data == 1){
                                   
                                   $('.alert-success').show(500);
                                   setTimeout(() => {
                                        $('.alert-success').hide(1000);
                                   }, 2000);
                                   mytbl.ajax.reload();
                                   

                                  }
                                   },
                                   error: function(){
                                        
                         
                                    }
                    });
               });
               });


            
          </script>
          <!-- Update Script -->



          
         
 </body>  
 </html>  
           

          