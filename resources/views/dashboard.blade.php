@extends('layouts.estilo')

@section('content')
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
              <div class="col-12 col-xl-8 mb-4 mb-xl-0">
              <h3 class="font-weight-bold">
                <i class="fas fa-user-circle"></i> Bienvenido, {{ auth()->user()->name }}!!
              </h3>
              </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                  <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="mdi mdi-calendar"></i> <span id="currentDateTime"></span>
                  </button>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>      
    </div>
  </div>
</div>
<script>
        function updateCurrentDateTime() {
          const now = new Date();
          const formattedDateTime = now.toLocaleString();
          document.getElementById("currentDateTime").textContent = formattedDateTime;
          }

    // Actualiza la hora cada segundo
        setInterval(updateCurrentDateTime, 1000);
    
    // Llama a la función una vez para mostrar la hora inmediatamente
        updateCurrentDateTime();
      </script>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
@endsection
