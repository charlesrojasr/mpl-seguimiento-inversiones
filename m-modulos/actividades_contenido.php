 <div class="content-wrapper">

   <div class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6 mb-2">
           <div style=" display: flex;align-items: center;">

             <h1 class="m-0"><?php echo $appModulo; ?></h1>

           </div>
         </div>
         <?php if ($role_id == 1): ?>
          <!--
           <div class="col-sm-6">
             <button type="button" data-toggle="modal" data-target="#addnew" style="margin-left: 30px; margin-right: auto;" class="btn  btn-dark  btn-sm"> <i class="fa-solid fa-plus"></i> AÑADIR NUEVA ACTIVIDAD </button>
           </div>-->
         <?php endif; ?>
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