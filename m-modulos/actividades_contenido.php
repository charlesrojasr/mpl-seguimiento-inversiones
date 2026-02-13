 <div class="content-wrapper">

   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6 mb-2">
           <div style=" display: flex;align-items: center;">

             <h1 class="m-0"><?php echo $appModulo; ?></h1>

           </div>
         </div>
         <div class="col-sm-6">
           
         </div>
       </div>
     </div>
   </div>



   <section class="content">
     <div class="container-fluid">


       <div class="card">
         <div class="card-header">
           <h3 class="card-title">LISTA DE ACTIVIDADES REGISTRADAS</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">


           <?php include 'actividades_table.php'; ?>

         </div>
         <!-- /.card-body -->
       </div>


     </div>
   </section>

 </div>